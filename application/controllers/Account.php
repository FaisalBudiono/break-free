<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session_login');
		$this->session_login->login_checker();
	}

	public function index()
	{
		$this->load->model('directory_model');
		$this->load->model('data_model');
		$data['title'] = "Secret Chamber";
		$data['email'] = $this->session->email;
		$data['dir'] = $this->directory_model->get_list();

		$data['acc'] = $this->data_model->show_all($data['dir']);

		/** 
		 * Fetching [last_modified] with [id_adl] as a key and making a
		 * modification so JavaScript knows the time is in UTC format.
		 */
		foreach ($data['acc'] as $value1) {
			foreach ($value1 as $value2) {
				$data['last_modified'][$value2['id_adl']] = str_replace(" ", "T", $value2['last_modified'])."Z";
			}
		}

		$this->load->view("templates/opening", $data);
		$this->load->view('secret-chamber/header', $data);
		$this->load->view('secret-chamber/main', $data);
		$this->load->view('secret-chamber/footer');
		$this->load->view('secret-chamber/modal');
		$this->load->view("templates/needed_js");
		$this->load->view('js/js_start');
		$this->load->view("js/js_main");
		$this->load->view("js/js_lastModified", $data);
		$this->load->view('js/js_end');
		$this->load->view("templates/closing");
	}
}

/* End of file Account.php */
/* Location: ./application/controllers/Account.php */