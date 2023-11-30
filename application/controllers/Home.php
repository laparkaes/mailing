<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		
		$error_msgs = [];
		if (!$data["smtp_host"]) $error_msgs[] = "Insert smtp host.";
		if (!$data["smtp_port"]) $error_msgs[] = "Insert smtp port.";
		if (!$data["smtp_user"]) $error_msgs[] = "Insert sender email.";
		if (!$data["smtp_pass"]) $error_msgs[] = "Insert sender password.";
		if ($error_msgs){
			$this->session->set_flashdata('error_msgs', $error_msgs);
			redirect("/home/sender");
		}
		
		
		
		
		
		
	}
}
