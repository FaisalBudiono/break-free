<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Global_var_config
	{
		public function __construct()
		{
			/** @var array Customizing error prompt when form_validation ran and it failed. */
			$this->error_prompt = array(
				'required' => 'Please fill out {field} field.',
				'is_unique' => 'Your {field} has been registered.',
				'valid_email' => 'Your {field} format is not valid.',
				'min_length' => '{field} must have at least {param} characters.',
				'max_length' => '{field} can\'t be more than {param} characters.',
				'matches' => 'Your Password and Password Confirmation didn\'t match.'
			);
		}
	}
?>