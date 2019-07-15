<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Checking verify login validity and return the id_user 
	 * if login validity is accepted.
	 *
	 * @var object $query Execute the query to look for an email.
	 * @var object $query Inserting query with $data as the data.
	 * @var array $row Get the data from $query query.
	 *
	 * @return string|null Get the user ID or null if login validity is denied.
	 */
	public function login(){
		$query = $this->db->get_where('user', array('email' => $this->input->post('email')));
		$row = $query->row_array();

		if(password_verify($this->input->post('password'), $row['password'])){
			return $row['id_user'];
		}
	}

	/**
	 * Inserting the data to the database.
	 *
	 * @var array $hash_option A config array of processing cost for hashing.
	 * @var string $hashed_password Hashing password using bcrypt hashing algorithm.
	 * @var array $data Storing array to be inputted into database.
	 * @var object $query Inserting query with $data as the data.
	 *
	 * @return boolean Returning true if the query success or false if query failed.
	 */
	public function register(){
		$hash_option = array(
			'cost' => 13
		);
		$hashed_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT, $hash_option);
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $hashed_password
		);
		$query = $this->db->insert('user', $data);
		return $query;
	}

	public function changePass($idUser, $newPass){
		$hash_option = array(
			'cost' => 13
		);
		$hashed_password = password_hash($newPass, PASSWORD_BCRYPT, $hash_option);

		$data = array(
			'password' => $hashed_password
		);
		$query = $this->db->update('user', $data, ['id_user' => $idUser]);

		return $query;
	}
}

/* End of file Login.php */
/* Location: ./application/models/Login.php */