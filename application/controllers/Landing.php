<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Landing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session_login');
		$this->session_login->login_checker(true);
	}

	/**
	 * Displaying default landing page for user who hasn't login yet.
	 *
	 * @var string $data['title'] Containing the page title.
	 * @var string $data['loginInfoMessage'] Containing the info message for login modal.
	 * @var string $data['registerInfoMessage'] Containing the info message for register modal.
	 * @var string $js['run'] Containing jquery that will be execute in the view.
	 *
	 * @return void
	 */
	public function index()
	{
		$data['title'] = "Break Free. Only one password, that's what you only need.";
		$data['loginInfoMessage'] = '';
		$data['registerInfoMessage'] = '';
		$js['run'] = '';

		$this->load->view("templates/opening", $data);
		$this->load->view("landing/landing", $data);
		$this->load->view("landing/register", $data);
		$this->load->view("landing/login" ,$data);
		$this->load->view("templates/needed_js");
		$this->load->view('js/js_start');
		$this->load->view("js/js_landing", $js);
		$this->load->view("js/js_togglePassword");
		$this->load->view('js/js_end');
		$this->load->view("templates/closing");
	}

	/**
	 * Login handler function that call the view for login page and processing
	 * login verification.
	 *
	 * @var string $data['title'] Containing the page title.
	 * @var string $data['loginInfoMessage'] Containing the info message for login modal.
	 * @var string $data['registerInfoMessage'] Containing the info message for register modal.
	 * @var string $js['run'] Containing jquery that will be execute in the view.
	 *
	 * @return void
	 */
	public function login()
	{
		$this->load->model('user_model');
		$this->load->library('global_var_config');

		$data['title'] = "login";
		$data['loginInfoMessage'] = '';
		$data['registerInfoMessage'] = '';
		$js['run'] = '$(\'#btnLogin\').click();';

		/**	Check wheather the b_login button has been clicked.	*/
		if($this->input->post('b_login')){
			$config_sr = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required',
					'errors' => $this->global_var_config->error_prompt
				),
				array(
					'field' => 'password',
					'label' => 'Password',
					'rules' => 'required',
					'errors' => $this->global_var_config->error_prompt
				)
			);
			$this->form_validation->set_rules($config_sr);

			/** Check if the form_validation filter is true then execute the lines inside */
			if($this->form_validation->run() == TRUE){
				$login_verif =  $this->user_model->login();
				
				if($login_verif){
					$this->session_login->set_user_session($login_verif, $this->input->post('password'), $this->input->post('email'));
					
					/** Redirect to user home page. */
					redirect(site_url('secret-chamber'));
				}else{
					/** Login denied handler. */
					$data['loginInfoMessage'] = '<div class="col-12 text-info">
						<hr class="mt-0 mb-2">
						<h5><i class="fas fa-info-circle"></i> Either your email or password is incorrect.</h5>
						<hr class="mt-2 mb-3">
					</div>';
				}
			}
		}

		$this->load->view("templates/opening", $data);
		$this->load->view("landing/landing", $data);
		$this->load->view("landing/register", $data);
		$this->load->view("landing/login" ,$data);
		$this->load->view("templates/needed_js");
		$this->load->view('js/js_start');
		$this->load->view("js/js_landing", $js);
		$this->load->view("js/js_togglePassword");
		$this->load->view('js/js_end');
		$this->load->view("templates/closing");
	}

	/**
	 * Register handler function that call the view for register page and
	 * pass user data to the database.
	 *
	 * @var string $data['title'] Containing the page title.
	 * @var string $data['loginInfoMessage'] Containing the info message for login modal.
	 * @var string $data['registerInfoMessage'] Containing the info message for register modal.
	 * @var string $js['run'] Containing jquery that will be execute in the view.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->load->model('user_model');
		$this->load->library('global_var_config');

		$data['title'] = "Break Free. Only one password, that's what you only need.";
		$data['loginInfoMessage'] = '';
		$data['registerInfoMessage'] = '';
		$js['run'] = '$(\'#btnRegister\').click();';
		
		// Check whether the b_register button has been clicked. 
		if($this->input->post('b_register')){
			$config_sr = array(
				array(
					'field' => 'email',
					'label' => 'Email',
					'rules' => 'trim|required|is_unique[user.email]|valid_email|max_length[50]',
					'errors' => $this->global_var_config->error_prompt
				),
				array(
					'field' => 'password',
					'label' => 'Master Password',
					'rules' => 'required|min_length[10]|max_length[50]',
					'errors' => $this->global_var_config->error_prompt
				),
				array(
					'field' => 'reenter-password',
					'label' => 'Re-enter Master Password',
					'rules' => 'required|matches[password]',
					'errors' => $this->global_var_config->error_prompt
				)
			);
			$this->form_validation->set_rules($config_sr);

			// Check if the form_validation filter is true then execute the lines inside. 
			if($this->form_validation->run() == TRUE){
				$query = $this->user_model->register();

				if($query){
					$data['loginInfoMessage'] = '<div class="col-12 text-success">
						<hr class="mt-0 mb-2">
						<h5><i class="far fa-check-circle"></i> Your account successfully registered.</h5>
						<hr class="mt-2 mb-3">
					</div>';
					$js['run'] = '$(\'#btnLogin\').click();';
				}else{
					$data['registerInfoMessage'] = '<div class="col-12 mb-3">
						<h5 class="bg-warning px-2 py-3 mx-2"><i class="fas fa-exclamation-triangle"></i> Error when establishing connection to the server. Please try again after refreshing the page.</h5>
					</div>';
				}
			}
		}
		$this->load->view("templates/opening", $data);
		$this->load->view("landing/landing", $data);
		$this->load->view("landing/register", $data);
		$this->load->view("landing/login" ,$data);
		$this->load->view("templates/needed_js");
		$this->load->view('js/js_start');
		$this->load->view("js/js_landing", $js);
		$this->load->view("js/js_togglePassword");
		$this->load->view('js/js_end');
		$this->load->view("templates/closing");
	}

}

/* End of file landing.php */
/* Location: ./application/controllers/landing.php */