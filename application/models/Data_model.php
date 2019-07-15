<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library('encrypt_decrypt');

		/**
		 * Checking if the id_directory is valid and owned by the login user
		 * or it will return the default directory(0).
		 *
		 * @param string $id_directory A string which contain id_directory 
		 *   whose ownership will be checked.
		 *
		 * @return void
		 */
		function dir_validity_check(&$id_directory)
		{
			$ci =& get_instance();
			$ci->db->from('account_data_directory')->where(array('id_user' => $ci->session->id_user, 'id_directory' => $id_directory));
			if($ci->db->count_all_results() < 1){
				$id_directory = '0';
			}
			$ci->db->reset_query();
		}

		/**
		 * Decrypting few data and wrapping it to an array before being returned.
		 * 
		 * @param array A result array that will be fetched.
		 *
		 * @var array $temp_array A temporary array for merging a few sets 
		 *   of data together.
		 * @var binary $iv Get an IV from a particular table row.
		 * @var array $cipher_data Storing a cipher data with the 
		 *   right format to be decrypted. 
		 * @var array $plain_data Storing decrypted data of $cipher_data.
		 *
		 * @return array Contain sets of data that wrapped inside it.
		 */
		function get_dec_acc($result_array)
		{
			$ci =& get_instance();

			/** Preparing a temporary array. */
			$temp_array = array();

			foreach($result_array as $key => $value){
				$iv = $value['salt'];

				$cipher_data = array(
					array('name', $value['name']),
					array('username', $value['username'])
				);
				$plain_data = $ci->encrypt_decrypt->dec($cipher_data, $ci->session->enc_key, $iv);

				/** Append the $plain_data array to the $temp_array array and repeat it for the rest of the loop. */
				array_push($temp_array, $plain_data);

				/** 
				 * Adding [id_adl] and [last_modified] value to the $temp_array.
				 * In order to store the value to the specific array the $key is needed.
				 */
				$temp_array[$key]['id_adl'] = $value['id_adl'];
				$temp_array[$key]['last_modified'] = $value['last_modified'];
			}

			return $temp_array;
		}
	}

	/**
	 * Encrypting then storing the account data to the database.
	 *
	 * @var binary $iv Generating random IV for openssl.
	 * @var array $plain_data Storing a plain data with the 
	 *   right format to be encrypted.
	 * @var array $cipher_data Storing encrypted data of $plain_data.
	 * @var string $id_directory Contain id_directory data that taken 
	 *   from $_POST method and checked the ownership of that particular id_directory
	 * @var array $data Storing array to be inserted to the database.
	 * @var object $query Executing insert query with $data as the data.
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function add()
	{
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));

		$plain_data = array(
			array('name', $this->input->post('accountName')),
			array('site', $this->input->post('accountSite')),
			array('username', $this->input->post('accountUsername')),
			array('password', $this->input->post('accountPassword')),
			array('note', $this->input->post('accountNote'))
		);
		$cipher_data = $this->encrypt_decrypt->enc($plain_data, $this->session->enc_key, $iv);

		$id_directory = $this->input->post('accountDirectory');
		dir_validity_check($id_directory);

		$data = array(
			'id_user' => $this->session->id_user,
			'salt' => $iv,
			'name' => $cipher_data['name'],
			'site' => $cipher_data['site'],
			'username' => $cipher_data['username'],
			'password' => $cipher_data['password'],
			'note' => $cipher_data['note'],
			'last_modified' => date("Y-m-d H:i:s"),
			'id_directory' => $id_directory
		);
		$query = $this->db->insert('account_data_list', $data);
		return $query;
	}

	/**
	 * Returning an array that contain id_directory as a first-dimension's
	 * array key. Inside the first dimension, there are sets of account data 
	 * with id_directory that equal to the first-dimension's array key.
	 *
	 * @param array $id_directory_array Contain sets of [id_directory] 
	 *   and [directory_name] that login user has.
	 *
	 * @var object $query Get the data from the database that 
	 *   owned by the login user and with a particular id_directory.
	 * @var array $acc_col Stand for account_collection. A final set of
	 *   array which contain value that passed from get_dec_acc() function.
	 *
	 * @return array A block of array that contain a first-dimension's array key
	 *   from the id_directory and has the account data inside of it.
	 */
	public function show_all($id_directory_array)
	{
		/** Execute a query for account data that owned by the login user that has no directory (id_directory=0). */
		$query = $this->db->from('account_data_list')
			->order_by('last_modified', 'DESC')
			->where(array('id_user' => $this->session->id_user, 'id_directory' => '0'))
		->get();

		/** The key for this array is hardcoded with 0 because it contain the no directory account data. */
		$acc_col[0] = get_dec_acc($query->result_array());

		/** Foreach-ing the $id_directory_array. */
		foreach($id_directory_array as $value){

			/**
			 * Execute a query for account data that owned by the login user with a specific [id_directory]
			 * that obtained from the fetched $id_directory_array.
			 */
			$query = $this->db->from('account_data_list')
				->order_by('last_modified', 'DESC')
				->where(array('id_user' => $this->session->id_user, 'id_directory' => $value['id_directory']))
			->get();
			
			/** The key for this array is taken from the array $id_directory_array. */
			$acc_col[$value['id_directory']] = get_dec_acc($query->result_array());
		}

		return $acc_col;
	}

	/**
	 * Get and decrypt password with the specific id_adl if the user 
	 * has the ownership of the account data.
	 *
	 * @param string|int $idAcc Contain Account primary key.
	 *
	 * @return string Contain decrypted password or 
	 *   empty string if the user doesn't have the ownership or the query result is empty.
	 */
	public function get_pass($idAcc)
	{
		$query = $this->db->select('password, salt')
			->from('account_data_list')
			->where(array('id_user' => $this->session->id_user, 'id_adl' => $idAcc))
		->get();

		$data = "";
		foreach ($query->result_array() as $value){
			$data = $this->encrypt_decrypt->dec($value['password'], $this->session->enc_key, $value['salt']);
		}
		return $data;
	}

	/**
	 * Get and decrypt account data with the specific id_adl if the user 
	 * has the ownership of the account data.
	 *
	 * @param string|int $idAcc Contain Account primary key.
	 *
	 * @return array Contain decrypted account data for specific id_adl or 
	 *   empty array if the user doesn't have the ownership or the query result is empty.
	 */
	public function get($idAcc)
	{
		$query = $this->db->from('account_data_list')
			->where(array('id_user' => $this->session->id_user, 'id_adl' => $idAcc))
		->get();

		$data = [];
		foreach ($query->result_array() as $key => $value){
			$iv = $value['salt'];
			$cipher = [
				['name', $value['name']],
				['site', $value['site']],
				['username', $value['username']],
				['password', $value['password']],
				['note', $value['note']]
			];
			$data = $this->encrypt_decrypt->dec($cipher, $this->session->enc_key, $iv);
			
			$data['id_adl'] = $value['id_adl'];
			$data['id_directory'] = $value['id_directory'];
			$data['last_modified'] = str_replace(" ", "T", $value['last_modified'])."Z";
			
			dir_validity_check($data['id_directory']);
		}
		return $data;
	}

	/**
	 * Update a specific account data.
	 * It will create a new iv for the specific id_adl then update the account data
	 *   with the new iv. 
	 *
	 * @param string|int $idAcc Contain account primary key.
	 *
	 * @var binary $iv Generating random IV for openssl encryption.
	 * @var array $plain_data Storing a plain data with the 
	 *   right format to be encrypted.
	 * @var array $cipher_data Storing encrypted data of $plain_data.
	 * @var string $id_directory Contain id_directory data that taken 
	 *   from $_POST method and checked the ownership of that particular id_directory.
	 * @var array $data Storing array to be updated to the database.
	 * @var object $query Executing update query with $data as the data.
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function update($idAcc)
	{
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));
		
		$plain_data = [
			['name', $this->input->post('accountName')],
			['site', $this->input->post('accountSite')],
			['username', $this->input->post('accountUsername')],
			['password', $this->input->post('accountPassword')],
			['note', $this->input->post('accountNote')]
		];
		$cipher_data = $this->encrypt_decrypt->enc($plain_data, $this->session->enc_key, $iv);

		$id_directory = $this->input->post('accountDirectory');
		dir_validity_check($id_directory);

		$data = [
			'name' => $cipher_data['name'],
			'site' => $cipher_data['site'],
			'username' => $cipher_data['username'],
			'password' => $cipher_data['password'],
			'note' => $cipher_data['note'],
			'last_modified' => date("Y-m-d H:i:s"),
			'id_directory' => $id_directory,
			'salt' => $iv
		];
		$query = $this->db->update('account_data_list', $data, ['id_user' => $this->session->id_user, 'id_adl' => $idAcc]);
		return $query;
	}

	/**
	 * Right after the directory got deleted, all account data 
	 *   that registered with the directory id should be updated to 0 (Default).
	 *
	 * @param string|int $idDir The directory id that deleted.
	 *
	 * @var array $data Contain directory id equal to 0 (Default).
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function updateBatchDirDefault($idDir)
	{
		$data = [
			'id_directory' => 0
		];
		$query = $this->db->update('account_data_list', $data, ['id_user' => $this->session->id_user, 'id_directory' => $idDir]);

		return $query;
	}

	/**
	 * Delete an account data with the specific id_adl.
	 *
	 * @param string|int $idAcc Contain Account primary key.
	 *
	 * @var object $query Executing delete query.
	 *
	 * @return bool Returning true on success or false on failure.
	 */
	public function delete($idAcc)
	{
		$query = $this->db->delete('account_data_list', ['id_user' => $this->session->id_user, 'id_adl' => $idAcc]);
		return $query;
	}

	/**
	 * Update all account data when the user password changed.
	 * Because the encryption key is changed, the encrypted 
	 *   data must changed as well in order to be able to be decrypted later.
	 * First of all, all the account must be stored as the plain text,
	 *   after that it will be encrypted with new password and new IV one by one.
	 *
	 * @param string|int $idUser Contain User ID.
	 * @param binary $oldPass Contain User old password (Already encrypted in sha1).
	 * @param binary $newPass Contain User new password (Already encrypted in sha1).
	 *
	 * @var object $oldQuery Get the account data that encrypted with old password.
	 * @var binary $iv Contain the IV for openssl decryption.
	 * @var array $cipher_data Storing cipher data with the 
	 *   right format to be decrypted.
	 * @var array $oldData Contain the decrypted old data, account id 
	 *   and the salt incase the salt will be reused.
	 * @var int $i Counter for adding the account id and salt to the $oldData array.
	 * @var binary $newIv Contain new IV for openssl encryption.
	 * @var array $plain_data Storing plain data with the 
	 *   right format to be encrypted.
	 * @var array $data Contain encrypted account data.
	 * @var object $query Executing the update query.
	 *
	 * @return void
	 */
	public function updatePassChange($idUser, $oldPass, $newPass)
	{
		$oldQuery = $this->db->from('account_data_list')
			->where(['id_user' => $idUser])
		->get();

		$oldData = [];
		$i = 0;
		foreach ($oldQuery->result_array() as $value){
			$iv = $value['salt'];

			$cipher_data = [
				['name', $value['name']],
				['site', $value['site']],
				['username', $value['username']],
				['password', $value['password']],
				['note', $value['note']]
			];
			$oldData[$i] = $this->encrypt_decrypt->dec($cipher_data, $oldPass, $iv);
			$oldData[$i]['id_adl'] = $value['id_adl'];
			$oldData[$i]['salt'] = $value['salt'];
			$i++;
		}

		foreach($oldData as $value){
			$newIv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->encrypt_decrypt->enc_method));
			$idAcc = $value['id_adl'];

			$plain_data = [
				['name', $value['name']],
				['site', $value['site']],
				['username', $value['username']],
				['password', $value['password']],
				['note', $value['note']]
			];
			$data = $this->encrypt_decrypt->enc($plain_data, $newPass, $newIv);
			$data['salt'] = $newIv;
			$query = $this->db->update('account_data_list', $data, ['id_user' => $idUser, 'id_adl' => $idAcc]);
		}
	}
}

/* End of file Data_model.php */
/* Location: ./application/models/Data_model.php */