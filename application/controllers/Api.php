<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * If the user hasn't logged in yet, it will return http response 401 Unauthorized.
	 */
	public function __construct()
	{
		parent::__construct();
		if(!isset($_SESSION['id_user'])){
			http_response_code(401);
			exit();
		}
	}

	/**
	 * This function only works with GET method.
	 * It will return account data and folder data in JSON format that user has.
	 *
	 * @return void
	 */
	public function loadData()
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			$this->load->model('directory_model');
			$this->load->model('data_model');
			$data['dir'] = $this->directory_model->get_list();

			$data['acc'] = $this->data_model->show_all($data['dir']);

			$data['last_modified'] = [];
			/** 
			 * Fetching [last_modified] with [id_adl] as a key and making a
			 * modification so JavaScript knows the time is in UTC format.
			 */
			foreach ($data['acc'] as $dataList) {
				foreach ($dataList as $value2) {
					$data['last_modified'][$value2['id_adl']] = str_replace(" ", "T", $value2['last_modified'])."Z";
				}
			}

			$dataJson = json_encode($data, JSON_PRETTY_PRINT);
			echo $dataJson;
			http_response_code(200);
		}else{
			http_response_code(405);
		}
	}

	/**
	 * This function work with GET and POST method.
	 * If the request is GET, it will return the modal for changing password.
	 * If the request is POST, it will update user password.
	 * After the user password is updated, all of the data will be reencrypted 
	 *   as well with the new password.
	 *
	 * @return void
	 */
	public function changePass()
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			http_response_code(200);
			$this->load->view('secret-chamber/forms/changePass');
			$this->load->view('js/js_start');
			$this->load->view("js/js_togglePassword");
			$this->load->view("js/js_changePass");
			$this->load->view('js/js_end');
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			/** Check wheather the b_changePass button has been clicked. */
			if($this->input->post('b_changePass')){
				
				$oldPassHashed = hash("sha256", $_POST['oldPass'], TRUE);
				if($oldPassHashed === $_SESSION['enc_key']){

					$this->load->library('global_var_config');
					$this->load->model('user_model');
					$this->load->model('directory_model');
					$this->load->model('data_model');

					$config_sr = [
						[
							'field' => 'oldPass',
							'label' => 'Old Master Password',
							'rules' => 'required|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						],
						[
							'field' => 'newPass',
							'label' => 'Account Site',
							'rules' => 'required|min_length[10]|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						],
						[
							'field' => 'newPassConf',
							'label' => 'Account Username',
							'rules' => 'required|min_length[10]|max_length[50]|matches[newPass]',
							'errors' => $this->global_var_config->error_prompt
						]
					];
					$this->form_validation->set_rules($config_sr);

					/** Check if the form_validation filter is true then execute the lines inside */
					if($this->form_validation->run() == TRUE){
						$newPass = $_POST['newPass'];
						$newPassHashed = hash("sha256", $newPass, TRUE);
						$idUser = $this->session->id_user;
						$query = $this->user_model->changePass($idUser, $newPass);
						$this->directory_model->updatePassChange($idUser, $oldPassHashed, $newPassHashed);
						$this->data_model->updatePassChange($idUser, $oldPassHashed, $newPassHashed);
						
						$this->load->library('session_login');
						$this->session_login->set_user_session($idUser, $newPass, $this->session->email);

						if($query){
							http_response_code(200);
							echo 'success';
						}else{
							http_response_code(500);
						}
					}else{
						http_response_code(400);
					}
				}else{
					http_response_code(200);
					echo 'failed';
				}
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * This function only works with request method POST and 
	 *   will input the new account into database.
	 *
	 * @var array $config_sr Contain form_validation rules, so we only
	 *   need to call it once later on.
	 * @var bool $query Contain true on query success or false on query failure.
	 *
	 * @return void
	 */
	public function addAccount()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->load->library('global_var_config');
			$this->load->model('data_model');

			/** Check wheather the b_add_account button has been clicked. */
			if($this->input->post('b_add_account')){
				$config_sr = [
					[
						'field' => 'accountName',
						'label' => 'Account Name',
						'rules' => 'trim|required|max_length[50]',
						'errors' => $this->global_var_config->error_prompt
					],
					[
						'field' => 'accountSite',
						'label' => 'Account Site',
						'rules' => 'trim|max_length[50]',
						'errors' => $this->global_var_config->error_prompt
					],
					[
						'field' => 'accountUsername',
						'label' => 'Account Username',
						'rules' => 'trim|max_length[50]',
						'errors' => $this->global_var_config->error_prompt
					],
					[
						'field' => 'accountPassword',
						'label' => 'Account Password',
						'rules' => 'max_length[50]',
						'errors' => $this->global_var_config->error_prompt
					]
				];
				$this->form_validation->set_rules($config_sr);

				/** Check if the form_validation filter is true then execute the lines inside */
				if($this->form_validation->run() == TRUE){
					$query = $this->data_model->add();
					if($query){
						http_response_code(201);
					}else{
						http_response_code(500);
					}

				}else{
					http_response_code(400);
				}
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * This function work with GET and POST method.
	 * if the parameter is empty/null it will return http response 400 Bad Request.
	 * If the request is GET, it will return the modal for editting the account data.
	 * If the request is POST, it will update the account data.
	 *
	 * @param int $idAcc Primary key of account id.
	 *
	 * @var array $config_sr Contain form_validation rules, so we only
	 *   need to call it once later on.
	 * @var bool $query Contain true on query success or false on query failure.
	 *
	 * @return void
	 */
	public function updateAccount($idAcc = null)
	{
		if($idAcc != null){
			if($_SERVER['REQUEST_METHOD'] == "GET"){
				$this->load->model('data_model');
				$this->load->model('directory_model');
				$data['dir'] = $this->directory_model->get_list();
				$data['acc'] = $this->data_model->get($idAcc);
				if(!empty($data['acc'])){
					$this->load->view('secret-chamber/forms/edtAccount', $data);
					$this->load->view('js/js_start');
					$this->load->view("js/js_togglePassword");
					$this->load->view('js/js_edtAccount', $data);
					$this->load->view('js/js_end');
					http_response_code(200);
				}else{
					http_response_code(400);
				}

			}elseif($_SERVER['REQUEST_METHOD'] == "POST"){

				$this->load->library('global_var_config');
				$this->load->model('data_model');

				/** Check wheather the b_update_acc button has been clicked. */
				if($this->input->post('b_update_acc')){
					$config_sr = [
						[
							'field' => 'accountName',
							'label' => 'Account Name',
							'rules' => 'trim|required|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						],
						[
							'field' => 'accountSite',
							'label' => 'Account Site',
							'rules' => 'trim|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						],
						[
							'field' => 'accountUsername',
							'label' => 'Account Username',
							'rules' => 'trim|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						],
						[
							'field' => 'accountPassword',
							'label' => 'Account Password',
							'rules' => 'max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						]
					];
					$this->form_validation->set_rules($config_sr);

					/** Check if the form_validation filter is true then execute the lines inside */
					if($this->form_validation->run() == TRUE){
						$query = $this->data_model->update($idAcc);
						if($query){
							http_response_code(201);
						}else{
							http_response_code(500);
						}

					}else{
						http_response_code(400);
					}
				}else{
					http_response_code(400);
				}
			}else{
				http_response_code(405);
			}
		}else{
			http_response_code(400);
		}
	}

	/**
	 * This function only works with GET method.
	 * if the parameter is empty/null it will return http response 400 Bad Request.
	 * Deleting specific account data.
	 *
	 * @param int $idAcc Primary key of account id.
	 *
	 * @return void
	 */
	public function deleteAccount($idAcc = null)
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			if($idAcc != null){
				$this->load->model('data_model');
				$this->data_model->delete($idAcc);
				http_response_code(200);
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * This function only works with request method POST and 
	 * If the request is POST, it will store the directory data into database.
	 *
	 * @var array $config_sr Contain form_validation rules, so we only
	 *   need to call it once later on.
	 * @var bool $query Contain true on query success or false on query failure.
	 *
	 * @return void
	 */
	public function addDirectory()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$this->load->library('global_var_config');
			$this->load->model('directory_model');
			
			if($this->input->post('b_add_directory')){
				$config_sr = array(
					array(
						'field' => 'directoryName',
						'label' => 'Directory Name',
						'rules' => 'trim|required|max_length[50]',
						'errors' => $this->global_var_config->error_prompt
					)
				);
				$this->form_validation->set_rules($config_sr);

				/** Check if the form_validation filter is true then execute the lines inside */
				if($this->form_validation->run() == TRUE){
					$query = $this->directory_model->add();
					if($query){
						http_response_code(201);
					}else{
						http_response_code(500);
					}
				}else{
					http_response_code(400);
				}
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * This function work with GET and POST method.
	 * If the request is GET, it will return the modal for editting the folder data.
	 * If the request is POST, it will update the folder data.
	 *
	 * @param int $idDir Primary key of folder id.
	 *
	 * @var array $config_sr Contain form_validation rules, so we only
	 *   need to call it once later on.
	 * @var bool $query Contain true on query success or false on query failure.
	 *
	 * @return void
	 */
	public function updateDirectory($idDir = null)
	{
		if($idDir != null){
			if($_SERVER['REQUEST_METHOD'] == "GET"){
				$this->load->model('directory_model');
				$data['dir'] = $this->directory_model->get($idDir);
				if(!empty($data['dir'])){
					$this->load->view('secret-chamber/forms/edtDirectory', $data);
					$this->load->view('js/js_start');
					$this->load->view('js/js_edtDirectory', $data);
					$this->load->view('js/js_end');
					http_response_code(200);
				}else{
					http_response_code(400);
				}

			}elseif($_SERVER['REQUEST_METHOD'] == "POST"){

				$this->load->library('global_var_config');
				$this->load->model('directory_model');

				/** Check wheather the b_update_directory button has been clicked. */
				if($this->input->post('b_update_directory')){
					$config_sr = array(
						array(
							'field' => 'directoryName',
							'label' => 'Directory Name',
							'rules' => 'trim|required|max_length[50]',
							'errors' => $this->global_var_config->error_prompt
						)
					);
					$this->form_validation->set_rules($config_sr);

					/** Check if the form_validation filter is true then execute the lines inside */
					if($this->form_validation->run() == TRUE){
						$query = $this->directory_model->update($idDir);
						if($query){
							http_response_code(201);
						}else{
							http_response_code(500);
						}

					}else{
						http_response_code(400);
					}
				}else{
					http_response_code(400);
				}
			}else{
				http_response_code(405);
			}
		}else{
			http_response_code(400);
		}
	}

	/**
	 * This function only works with GET method.
	 * Deleting specific folder data.
	 *
	 * @param int $idDir Primary key of folder id.
	 *
	 * @return void
	 */
	public function deleteDirectory($idDir = null)
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			if($idDir != null){
				$this->load->model('data_model');
				$this->load->model('directory_model');
				
				$queryAcc = $this->data_model->updateBatchDirDefault($idDir);
				if($queryAcc){
					$queryDir = $this->directory_model->delete($idDir);
					if($queryDir){
						http_response_code(200);
					}else{
						http_response_code(102);
					}
				}else{
					http_response_code(500);
				}
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * It will only works with request method GET.
	 * It will display the password that user asked.
	 *
	 * @param int $idAcc Primary key of account id.
	 * 
	 * @return void
	 */
	public function getPass($idAcc = null)
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			if($idAcc != null){
				$this->load->model('data_model');
				echo $this->data_model->get_pass($idAcc);
				http_response_code(200);
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

	/**
	 * It will only works with request method GET.
	 * Modal handler for adding account or directory.
	 *
	 * @param string $event This parameter determines the modal that will be served to the user.
	 *
	 * @return void
	 */
	public function modal($event = null)
	{
		if($_SERVER['REQUEST_METHOD'] == "GET"){
			if($event === "addAccount"){
				$this->load->model('directory_model');
				$data['dir'] = $this->directory_model->get_list();
				$this->load->view('secret-chamber/forms/addAccount', $data);
				$this->load->view('js/js_start');
				$this->load->view("js/js_togglePassword");
				$this->load->view('js/js_addAccount');
				$this->load->view('js/js_end');
				http_response_code(200);
			}elseif($event === "addDirectory"){
				$this->load->view('secret-chamber/forms/addDirectory');
				$this->load->view('js/js_start');
				$this->load->view('js/js_addDirectory');
				$this->load->view('js/js_end');
				http_response_code(200);
			}else{
				http_response_code(400);
			}
		}else{
			http_response_code(405);
		}
	}

}

/* End of file api.php */
/* Location: ./application/controllers/api.php */