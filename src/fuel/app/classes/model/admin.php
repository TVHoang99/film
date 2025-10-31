<?php
class Model_Admin extends \Orm\Model
{
	protected static $_properties = [
		'id' => ['data_type' => 'int', 'auto_increment' => true],
		'adminname' => [
			'data_type' => 'varchar',
			'validation' => ['required', 'max_length' => [50]],
		],
		'email' => [
			'data_type' => 'varchar',
			'validation' => ['required', 'valid_email', 'max_length' => [100]],
		],
		'password' => [
			'data_type' => 'varchar',
			'validation' => ['required', 'max_length' => [255]],
		],
		'salt' => [
			'data_type' => 'varchar',
			'validation' => ['required', 'max_length' => [255]],
		],
		'first_name' => [
			'data_type' => 'varchar',
			'validation' => ['max_length' => [50]],
			'null' => true,
		],
		'last_name' => [
			'data_type' => 'varchar',
			'validation' => ['max_length' => [50]],
			'null' => true,
		],
		'last_login' => [
			'data_type' => 'datetime',
			'default' => null,
		],
		'created_at' => [
			'data_type' => 'datetime',
		],
		'updated_at' => [
			'data_type' => 'datetime',
			'null' => true,
		],
	];

	protected static $_observers = [
		'Orm\Observer_Self' => [
			'events' => ['before_save'],
			'method' => '_update_last_login',
		],
		'Orm\Observer_CreatedAt' => [
			'events' => ['before_insert'],
			'property' => 'created_at',
			// 'mysql_timestamp' => true,
		],
		'Orm\Observer_UpdatedAt' => [
			'events' => ['before_update'],
			'property' => 'updated_at',
			// 'mysql_timestamp' => true,
		],
	];


	protected static $_table_name = 'admins';

	protected static $_primary_key = ['id'];

	/**
	 * Update last_login before saving
	 */
	public function update_last_login()
	{
		// Kiểm tra session dựa trên admin_id
		if (\Session::get('admin_id') && $this->id == \Session::get('admin_id')) {
			$this->last_login = date('Y-m-d H:i:s'); // Ensure datetime format
		}
	}

	/**
	 * Validate login credentials using email
	 */
	public static function validate_login($email, $password)
	{
		$admin = static::query()->where('email', $email)->get_one();
		if ($admin && self::verify_password($password, $admin->password, $admin->salt)) {
			$admin->last_login = date('Y-m-d H:i:s');
			$admin->save();
			return $admin;
		}
		return false;
	}

	/**
	 * Verify password with stored hash and salt
	 */
	public static function verify_password($password, $hashed_password, $salt)
	{
		return hash('sha256', $password . $salt) === $hashed_password;
	}

	/**
	 * Hash password with salt
	 */
	public static function hash_password($password, $salt)
	{
		return hash('sha256', $password . $salt);
	}
}
