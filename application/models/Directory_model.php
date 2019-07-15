<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directory_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt_decrypt');
	}

	/**
	 * Encrypting then storing the directory data to the database.
	 *
	 * @var binary $iv Generating random IV for openssl.
	 * @var binary $dir_name Encrypting directory name.
	 * @var array $data Storing array to be inputted into database.
	 * @var object $query Executing insert query with $data as the data.
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function add()
	{
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));
		$dir_name = $this->encrypt_decrypt->enc(strtoupper($this->input->post('directoryName')), $this->session->enc_key, $iv);

		$data = array(
			'id_user' => $this->session->id_user,
			'salt' => $iv,
			'directory_name' => $dir_name
		);
		$query = $this->db->insert('account_data_directory', $data);
		return $query;
	}

	/**
	 * Getting directory name from database that owned by 
	 * the login user and decrypting it.
	 *
	 * @var object $query Executing a query to get account directory 
	 *   that owned by the login user.
	 *
	 * @return array Contain ID directory and decrypted directory name.
	 */
	public function get_list()
	{
		$this->db->select('id_directory, salt, directory_name');
		$query = $this->db->get_where('account_data_directory', array('id_user' => $this->session->id_user));

		$data = array();

		/** Decrypting data.*/ 
		$i = 0;
		foreach ($query->result_array() as $value){
			$data[$i]['id_directory'] = $value['id_directory'];
			$data[$i]['directory_name'] = $this->encrypt_decrypt->dec($value['directory_name'], $this->session->enc_key, $value['salt']);
			$i++;
		}
		return $data;
	}

	/**
	 * Get decrypted directory data from specific ID.
	 * 
	 * @param string|int $idDir The directory ID that the data want to be retrieved.
	 *
	 * @var object $query Executing query to retrieve data.
	 * @var array $data Contain decrypted directory data.
	 *
	 * @return array Contain decrypted directory data.
	 */
	public function get($idDir)
	{
		$query = $this->db->select('salt, directory_name')
			->from('account_data_directory')
			->where(['id_user' => $this->session->id_user, 'id_directory' => $idDir])
		->get();

		$data = [];
		foreach ($query->result_array() as $key => $value) {
			$data['id_directory'] = $idDir;
			$data['directory_name'] = $this->encrypt_decrypt->dec($value['directory_name'], $this->session->enc_key, $value['salt']);
		}
		return $data;
	}

	/**
	 * Update a specific Directory data.
	 * It will create a new iv for the specific id_directory then update the directory data
	 *   with the new iv. 
	 *
	 * @param string|int $idDir Contain directory primary key.
	 *
	 * @var binary $iv Generating random IV for openssl encryption.
	 * @var array $plain_data Storing plain data with the 
	 *   right format to be encrypted.
	 * @var array $cipher_data Storing encrypted data of $plain_data.
	 * @var string $id_directory Contain id_directory data that taken 
	 *   from $_POST method and checked the ownership of that particular id_directory.
	 * @var array $data Storing array to be updated to the database.
	 * @var object $query Executing update query with $data as the data.
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function update($idDir)
	{
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));
		$dir_name = $this->encrypt_decrypt->enc(strtoupper($this->input->post('directoryName')), $this->session->enc_key, $iv);

		$data = [
			'salt' => $iv,
			'directory_name' => $dir_name
		];
		$query = $this->db->update('account_data_directory', $data, ['id_user' => $this->session->id_user, 'id_directory' => $idDir]);

		return $query;
	}

	/**
	 * Deleting directory with the specific ID.
	 *
	 * @param string|int $idDir Contain directory id that want to be deleted.
	 *
	 * @var object $query Execute the query deletion.
	 *
	 * @return Returning true on success or false on failure.
	 */
	public function delete($idDir)
	{
		$query = $this->db->delete('account_data_directory', ['id_user' => $this->session->id_user, 'id_directory' => $idDir]);
		return $query;
	}

	/**
	 * Update all directory data when the user password changed.
	 * Because the encryption key is changed, the encrypted 
	 *   data must changed as well in order to be able to be decrypted later.
	 * First of all, all the directory must be stored as the plain text,
	 *   after that it will be encrypted with new password and new IV one by one.
	 *
	 * @param string|int $idUser Contain User ID.
	 * @param binary $oldPass Contain User old password (Already encrypted in sha1).
	 * @param binary $newPass Contain User new password (Already encrypted in sha1).
	 *
	 * @var object $oldQuery Get the directory data that encrypted with old password.
	 * @var binary $iv Contain the IV for openssl decryption.
	 * @var array $cipher_data Storing cipher data with the 
	 *   right format to be decrypted.
	 * @var array $oldData Contain the decrypted old data, directory id 
	 *   and the salt incase the salt will be reused.
	 * @var int $i Counter for adding the directory id and salt to the $oldData array.
	 * @var binary $newIv Contain new IV for openssl encryption.
	 * @var array $plain_data Storing plain data with the 
	 *   right format to be encrypted.
	 * @var array $data Contain encrypted directory data.
	 * @var object $query Executing the update query.
	 *
	 * @return void
	 */
	public function updatePassChange($idUser, $oldPass, $newPass)
	{
		$oldQuery = $this->db->from('account_data_directory')
			->where(['id_user' => $idUser])
		->get();

		$oldData = [];
		$i = 0;
		foreach ($oldQuery->result_array() as $value){
			$iv = $value['salt'];

			$cipher_data = [
				['directory_name', $value['directory_name']]
			];
			$oldData[$i] = $this->encrypt_decrypt->dec($cipher_data, $oldPass, $iv);
			$oldData[$i]['id_directory'] = $value['id_directory'];
			$oldData[$i]['salt'] = $value['salt'];
			$i++;
		}

		foreach($oldData as $value){
			$newIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));
			$idDir = $value['id_directory'];

			$plain_data = [
				['directory_name', $value['directory_name']]
			];
			$data = $this->encrypt_decrypt->enc($plain_data, $newPass, $newIv);
			$data['salt'] = $newIv;
			$query = $this->db->update('account_data_directory', $data, ['id_user' => $idUser, 'id_directory' => $idDir]);
		}
	}
}

/* End of file Directory_model.php */
/* Location: ./application/models/Directory_model.php */