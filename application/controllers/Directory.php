<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directory extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		
	}

	/**
	 * Add_directory handler function that call the view 
	 * for add_directory page  and pass directory data to the database.
	 *
	 * @var string $data['title'] Variable contain the page title.
	 * @var array $config_sr Contain form_validation rules, so we only
	 * need to call it once later on.
	 *
	 * @return void
	 */
	public function add_directory()
	{
		$this->load->library('session_login');
		$this->session_login->login_checker();

		$this->load->library('global_var_config');
		$this->load->model('directory_model');
		$data['title'] = 'Add New Directory';

		/** Check wheather the b_add_directory button has been clicked. */
		if($this->input->post('b_add_directory')){
			$config_sr = array(
				array(
					'field' => 'directory-name',
					'label' => 'Directory Name',
					'rules' => 'required',
					'errors' => $this->global_var_config->error_prompt
				)
			);
			$this->form_validation->set_rules($config_sr);

			/** Check if the form_validation filter is true then execute the lines inside */
			if($this->form_validation->run() == TRUE){
				echo $this->directory_model->add();
			}

		}

		$this->load->view("templates/opening", $data);
		$this->load->view("dummy/add_directory");
		$this->load->view("templates/needed_js");
		$this->load->view("templates/closing");
	}

}

/* End of file Directory.php */
/* Location: ./application/controllers/Directory.php */