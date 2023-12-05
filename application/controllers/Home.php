<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		set_time_limit(0);
		$this->load->model('general_model','gm');
	}

	public function index(){
		$email_lists = $this->gm->all("email_list", [["list", "asc"]]);
		foreach($email_lists as $l) $l->qty = $this->gm->qty("email", ["list_id" => $l->list_id]);
		
		$data = [
			"senders" => $this->gm->all("sender", [["title", "asc"]]),
			"contents" => $this->gm->all("content", [["title", "asc"]]),
			"email_lists" => $email_lists,
			"main" => "home",
		];
		$this->load->view('layout', $data);
	}
	
	public function send_email(){
		$result = ["type" => "error", "msg" => null, "email" => null];
		
		$sender = $this->gm->unique("sender", "sender_id", $this->input->post("sender_id"));
		$content = $this->gm->unique("content", "content_id", $this->input->post("content_id"));
		$email_list = $this->gm->unique("email_list", "list_id", $this->input->post("list_id"));
		
		$msg = "";
		if (!$sender) $msg .= "Select sender.";
		if (!$content) $msg .= "Select content.";
		if (!$email_list) $msg .= "Select email list.";
		
		if ($msg) $result["msg"] = $msg;
		else{
			$w = ["list_id" => $email_list->list_id];
			$orders = [["last_sent_at", "asc"]];
			$email = $this->gm->filter("email", $w, null, null, $orders, 1, 0);
			if ($email){
				$email = $email[0];
				$content_email = $this->load->view('contents/'.$content->filename, "", true);
				
				$this->load->library('email');
				$config = [
					'protocol' => $sender->protocol, // 이메일 전송 방법 (smtp, mail, sendmail)
					'smtp_host' => $sender->smtp_host, // SMTP 호스트 주소
					'smtp_port' => $sender->smtp_port, // SMTP 포트 번호
					'smtp_user' => $sender->smtp_user, // 발송자 이메일 계정
					'smtp_pass' => $sender->smtp_pass, // 발송자 이메일 계정 비밀번호
					'smtp_crypto' => $sender->smtp_crypto, // 암호화
					'mailtype' => "html", // 이메일 타입 (text 또는 html)
					'charset' => "utf-8", // 문자셋
					'wordwrap' => true, // 자동 줄바꿈 사용 여부
					'crlf' => "\r\n", // 줄바꿈 문자
					'newline' => "\r\n", // 줄바꿈 문자
				];
				
				$this->email->initialize($config); // 이메일 설정을 초기화합니다.
				$this->email->from($sender->smtp_user, $sender->title); // 발송자 이름
				$this->email->to($email->email); // 수신자 이메일 주소
				$this->email->subject($content->title); // 이메일 제목
				$this->email->message($content_email); // 이메일 내용
				$this->email->send(); // 이메일을 발송
				
				$this->gm->update("email", ["email_id" => $email->email_id], ["last_sent_at" => date("Y-m-d H:i:s")]);
				
				$result["type"] = "success";
				$result["email"] = $email->email;
			}else $result["msg"] = "No email record.";
			
			header('Content-Type: application/json');
			echo json_encode($result);
		}
	}
	
	private function paging($page, $qty){
		$pages = [];
		if ($qty){
			$last = floor($qty / 500); if ($qty % 500) $last++;
			if (3 < $page) $pages[] = [1, "<<", ""];
			if (3 < $page) $pages[] = [$page-3, "...", ""];
			if (2 < $page) $pages[] = [$page-2, $page-2, ""];
			if (1 < $page) $pages[] = [$page-1, $page-1, ""];
			$pages[] = [$page, $page, "active"];
			if ($page+1 <= $last) $pages[] = [$page+1, $page+1, ""];
			if ($page+2 <= $last) $pages[] = [$page+2, $page+2, ""];
			if ($page+3 <= $last) $pages[] = [$page+3, "...", ""];
			if ($page+3 <= $last) $pages[] = [$last, ">>", ""];
		}
		
		return $pages;
	}
	
	/* sender start */
	public function sender(){
		$data = [
			"senders" => $this->gm->all("sender", [["title", "asc"]]),
			"main" => "sender",
		];
		$this->load->view('layout', $data);
	}
	
	public function add_sender(){
		$data = $this->input->post();
		
		$success_msgs = $error_msgs = [];
		if (!$data["smtp_host"]) $error_msgs[] = "Smtp host is required.";
		if (!$data["smtp_port"]) $error_msgs[] = "Smtp port is required.";
		if (!$data["smtp_user"]) $error_msgs[] = "Sender email is required.";
		if (!$data["smtp_pass"]) $error_msgs[] = "Sender password is required.";
		
		if ($error_msgs) $this->session->set_flashdata('error_msgs', $error_msgs);
		else{
			$sender = $this->gm->unique("sender", "smtp_user", $data["smtp_user"]);
			if ($sender){
				$sender_id = $sender->sender_id;
				$this->gm->update("sender", ["sender_id" => $sender_id], $data);
				$success_msgs[] = "Sender has been updated.";
			}else{
				$sender_id = $this->gm->insert("sender", $data);
				$success_msgs[] = "Sender has been inserted.";
			}
			
			//sending test mail
			$result = $this->send_test_email($sender_id); print_r($result);
			if ($result["type"]) $success_msgs[] = $result["msg"];
			else $error_msgs[] = $result["msg"];
		}
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/sender");
	}
	
	public function exec_send_test_email($sender_id){
		$result = $this->send_test_email($sender_id);
		echo $result["msg"];
	}
	
	public function send_test_email($sender_id, $content = ""){
		$result = ["type" => false, "msg" => null];
		
		if (!$sender_id) $sender_id = $this->input->post("sender_id");
		
		$sender = $this->gm->unique("sender", "sender_id", $sender_id);
		if ($sender){
			$this->load->library('email');
			$config = [
				'protocol' => $sender->protocol, // 이메일 전송 방법 (smtp, mail, sendmail)
				'smtp_host' => $sender->smtp_host, // SMTP 호스트 주소
				'smtp_port' => $sender->smtp_port, // SMTP 포트 번호
				'smtp_user' => $sender->smtp_user, // 발송자 이메일 계정
				'smtp_pass' => $sender->smtp_pass, // 발송자 이메일 계정 비밀번호
				'smtp_crypto' => $sender->smtp_crypto, // 암호화
				'mailtype' => "html", // 이메일 타입 (text 또는 html)
				'charset' => "utf-8", // 문자셋
				'wordwrap' => true, // 자동 줄바꿈 사용 여부
				'crlf' => "\r\n", // 줄바꿈 문자
				'newline' => "\r\n", // 줄바꿈 문자
			];
			
			if (!$content) $content = '<div style="color:red;">Testing mail from Mailing Sys</div>';
			
			$this->email->initialize($config); // 이메일 설정을 초기화합니다.
			$this->email->from($sender->smtp_user, $sender->smtp_user); // 발송자 이름
			$this->email->to('laparkaes@gmail.com'); // 수신자 이메일 주소
			$this->email->subject('Testing mail from Mailing Sys'); // 이메일 제목
			$this->email->message($content); // 이메일 내용
			
			// 이메일을 발송합니다.
			/*
			if ($this->email->send()){
				$result["type"] = true;
				$result["msg"] = "Email sent to laparkaes@gmail.com";
			}else $result["msg"] = "Error ocurred sending email.";
			*/
			$this->email->send();
			$result["type"] = true;
			$result["msg"] = "Email sent to laparkaes@gmail.com";
		}else $result["type"] = "No sender record.";
		
		return $result;
	}

	public function delete_sender($sender_id){
		$success_msgs = $error_msgs = [];
		
		if ($this->gm->delete("sender", ["sender_id" => $sender_id])) $success_msgs[] = "Sender deleted!!";
		else $error_msgs[] = "Error!! Try again.";
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/sender");
	}
	/* sender end */
	
	/* content start */
	public function content(){
		$data = [
			"contents" => $this->gm->all("content", [["title", "asc"]]),
			"main" => "content",
		];
		$this->load->view('layout', $data);
	}
	
	public function add_content(){
		$data = $this->input->post();
		
		$success_msgs = $error_msgs = [];
		if (!$data["title"]) $error_msgs[] = "Title is required.";
		if (!$data["filename"]) $error_msgs[] = "File name is required.";
		
		if ($error_msgs) $this->session->set_flashdata('error_msgs', $error_msgs);
		else{
			$content = $this->gm->unique("content", "title", $data["title"]);
			if ($content){
				$content_id = $content->content_id;
				$this->gm->update("content", ["content_id" => $content_id], $data);
				$success_msgs[] = "Content has been updated.";
			}else{
				$content_id = $this->gm->insert("content", $data);
				$success_msgs[] = "Content has been inserted.";
			}
		}
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/content");
	}
	
	public function view_content($content_id){
		$content = $this->gm->unique("content", "content_id", $content_id);
		if ($content) $this->load->view('contents/'.$content->filename);
		else echo "Content record error!!";
	}
	
	public function send_content_sample($content_id){
		$content = $this->gm->unique("content", "content_id", $content_id);
		if ($content){
			$sender = $this->gm->filter("sender", [], null, null, [], 1, 0);
			if ($sender){
				$result = $this->send_test_email($sender[0]->sender_id, $this->load->view('contents/'.$content->filename, "", true));
				echo $result["msg"];
			}else echo "No sender record exists!!";
		}else echo "Content record error!!";
	}
	
	public function delete_content($content_id){
		$success_msgs = $error_msgs = [];
		
		if ($this->gm->delete("content", ["content_id" => $content_id])) $success_msgs[] = "Content record deleted!!";
		else $error_msgs[] = "Error!! Try again.";
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/content");
	}
	/* content end */
	
	/* email db start */
	public function email_db(){
		$email_lists = $this->gm->all("email_list", [["list", "asc"]]);
		foreach($email_lists as $l) $l->qty = $this->gm->qty("email", ["list_id" => $l->list_id]);
		
		$data = [
			"email_lists" => $email_lists,
			"main" => "email_db",
		];
		$this->load->view('layout', $data);
	}
	
	public function add_emails(){
		$list_id = $this->input->post("list_id");
		$list = $this->input->post("list");
		$emails = $this->input->post("emails");
		
		$success_msgs = $error_msgs = [];
		if (!$list_id) if (!$list) $error_msgs[] = "List selection or name is required.";
		if (!$emails) $error_msgs[] = "Emails is required.";
		
		if (!$error_msgs){
			if (!$list_id){
				$list_rec = $this->gm->unique("email_list", "list", $list);
				if ($list_rec) $list_id = $list_rec->list_id;
				else $list_id = $this->gm->insert("email_list", ["list" => $list]);
			}
			
			$insert_qty = 0;
			$emails = explode(",", $emails);
			foreach($emails as $i => $e){
				$email = trim($e);
				if ($email) if (filter_var($email, FILTER_VALIDATE_EMAIL)){
					$data = ["list_id" => $list_id, "email" => $email];
					if (!$this->gm->filter("email", ["list_id" => $list_id, "email" => $email])){
						$this->gm->insert("email", $data);
						$insert_qty++;
					}
				}	
			}
			
			$success_msgs[] = number_format($insert_qty)." emails has been inserted to database.";
		}
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/email_db");
	}
	
	public function delete_emails(){
		$emails = $this->input->post("emails");
		
		$success_msgs = $error_msgs = [];
		if (!$emails) $error_msgs[] = "Emails is required.";
		
		if (!$error_msgs){
			$emails = explode(",", $emails);
		
			$list = [];
			foreach($emails as $e) if (trim($e)) $list[] = trim($e);
			
			if ($list) $this->gm->delete_w_in("email", ["field" => "email", "values" => $list]);
			$success_msgs[] = "Emails has been deletes from database.";
		}
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/email_db");
	}
	
	public function view_emails($list_id){
		$page = $this->input->get("p");
		if (!$page) $page = 1;
		
		$f = ["list_id" => $list_id];
		$qty = $this->gm->qty("email", $f);
		
		$data = [
			"page" => $page,
			"email_list" => $this->gm->unique("email_list", "list_id", $list_id),
			"emails" => $this->gm->filter("email", $f, null, null, [["email", "asc"]], 500, 500*($page-1)),
			"total" => $qty,
			"paging" => $this->paging($page, $qty),
			"main" => "view_emails",
		];
		$this->load->view('layout', $data);
	}
	
	public function delete_email_list($list_id){
		$success_msgs = $error_msgs = [];
		
		if (!$this->gm->filter("email", ["list_id" => $list_id])){
			if ($this->gm->delete("email_list", ["list_id" => $list_id])) $success_msgs[] = "List deleted!!";
			else $error_msgs[] = "Error!! Try again.";
		}else $error_msgs[] = "List with email cannot delete.";
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/email_db");
	}
	
	public function delete_email($list_id, $email_id){
		$success_msgs = $error_msgs = [];
		
		if ($this->gm->delete("email", ["email_id" => $email_id])) $success_msgs[] = "Email deleted!!";
		else $error_msgs[] = "Error!! Try again.";
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/view_emails/".$list_id);
	}
	/* email db end */
}
