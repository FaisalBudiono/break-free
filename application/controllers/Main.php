<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session_login');
		$this->session_login->login_checker();
	}

	public function index()
	{
		$data['title'] = "Secret Chamber";
		$data['email'] = $this->session->email;

		$this->load->view("templates/opening", $data);
		$this->load->view('secret-chamber/header', $data);
		$this->load->view('secret-chamber/main');
		$this->load->view('secret-chamber/footer');
		$this->load->view('secret-chamber/modal');
		$this->load->view("templates/needed_js");
		$this->load->view('js/js_start');
		$this->load->view("js/js_main");
		$this->load->view('js/js_loadData');
		$this->load->view("js/js_randomGenerator");
		$this->load->view('js/js_end');
		$this->load->view("templates/closing");
	}
}

/* End of file Main.php */
/* Location: ./application/controllers/Main.php */