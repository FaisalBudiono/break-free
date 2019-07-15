<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Session_login{
	public function __construct(){
		$this->ci =& get_instance();
	}
	
	/**
	 * Redirecting user to the login page, if user hasn't login but
	 *   trying to access the secret-chamber page. 
	 *
	 * Redirecting user to the secret-chamber page. if user already login
	 *   but trying to access the landing controller.
	 *
	 * IF YOU WANTED TO USE THIS METHOD IN THE LANDING CONTROLLER,
	 *   PLEASE GIVE [true] IN THE METHOD PARAMETER.
	 *   e.g.	login_checker(true)
	 * This parameter has been built for bypassing error in the [landing/login] 
	 *   controller, so the infinite redirect won't happen.
	 *
	 * There are 4 posibilities with logic-gate(AND), the condition consist of:
	 *   [1][User hasn't login, WITHOUT bypass]		[3][User has login, WITHOUT bypass]
	 *   [2][User hasn't login, WITH bypass]		[4][User has login, WITH bypass]
	 * 
	 * [1] 		It will be redirected to login page.
	 * [2][3]	It will return nothing.
	 * [4]		It will be redirected to secret-chamber page.
	 *
	 * If you want to comprehend the concept, you can make the visualization of this logic gate.
	 *
	 * @param boolean $bypass Filter for landing controller.
	 *
	 * @return void
	 */
	public function login_checker($bypass=false){
		if(is_null($this->ci->session->id_user) && $bypass===false){
			redirect(site_url('login'));
		}elseif(!is_null($this->ci->session->id_user) && $bypass===true){
			redirect(site_url('secret-chamber'));
		}else{
			return;
		}
	}

	/**
	 * Set value for id_user and enc_key session.
	 *
	 * @param string $id_user Contain user ID for id_user session.
	 * @param string $enc_key Contain plain password for enc_key session.
	 * @param string $email_user Contain user email for email session.
	 *
	 * @var binary $hashed_key Hashing the encryption key in SHA1, 
	 *   then stored it in session.
	 *
	 * @return void
	 */
	public function set_user_session($id_user, $enc_key, $email_user){
		$hashed_key = hash("sha256", $enc_key, TRUE);
		$this->ci->session->id_user = $id_user;
		$this->ci->session->enc_key = $hashed_key;
		$this->ci->session->email = $email_user;
		session_write_close();
	}

}

/* End of file Login_checker.php */
/* Location: ./application/libraries/Login_checker.php */
