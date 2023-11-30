<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('general_model','gm');
	}

	public function index(){
		
		$data = [
			"main" => "home",
		];
		$this->load->view('layout', $data);
	}
	
	public function sender(){
		
		$data = [
			"main" => "sender",
		];
		$this->load->view('layout', $data);
	}
	
	public function add_sender(){
		$data = $this->input->post();
		
		$success_msgs = $error_msgs = [];
		if (!$data["smtp_host"]) $error_msgs[] = "Insert smtp host.";
		if (!$data["smtp_port"]) $error_msgs[] = "Insert smtp port.";
		if (!$data["smtp_user"]) $error_msgs[] = "Insert sender email.";
		if (!$data["smtp_pass"]) $error_msgs[] = "Insert sender password.";
		
		if ($error_msgs) $this->session->set_flashdata('error_msgs', $error_msgs);
		else{
			$sender = $this->gm->unique("sender", "smtp_user", $data["smtp_user"]);
			if ($sender){
				$sender_id = $sender->sender_id;
				$this->gm->update("sender", ["sender_id" => $sender_id], $data);
			}else $sender_id = $this->gm->insert("sender", $data);
			
			//sending test mail
			$result = $this->send_test_email($sender_id); print_r($result);
			if ($result["type"]){
				$success_msgs[] = $result["msg"];
				
			}else{
				$error_msgs[] = $result["msg"];
			}
		}
		
		$msgs = ["success_msgs" => $success_msgs, "error_msgs" => $error_msgs];
		$this->session->set_flashdata('msgs', $msgs);
		
		redirect("/home/sender");
	}
	
	public function send_test_email($sender_id){
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
			
			$this->email->initialize($config); // 이메일 설정을 초기화합니다.
			$this->email->from($sender->smtp_user, $sender->smtp_user); // 발송자 이름
			$this->email->to('laparkaes@gmail.com'); // 수신자 이메일 주소
			$this->email->subject('Testing mail from Mailing Sys'); // 이메일 제목
			$this->email->message('<div style="color:red;">Testing mail from Mailing Sys</div>'); // 이메일 내용
			
			// 이메일을 발송합니다.
			if ($this->email->send()){
				$result["type"] = true;
				$result["msg"] = "Email sent to laparkaes@gmail.com";
			}else $result["msg"] = "Error ocurred sending email.";
		}else $result["type"] = "No sender record.";
		
		return $result;
	}
}
