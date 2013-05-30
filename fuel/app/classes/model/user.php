<?php
use Orm\Model;

class Model_User extends Model
{
	protected static $_properties = array(
		'id',
		'username',
		'password',
		'group',
		'email',
		'last_login',
		'login_hash',
		'ip',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('password', 'Password', 'required|max_length[255]');
		$val->add_field('group', 'Group', 'required|valid_string[numeric]');
		$val->add_field('email', 'Email', 'required|valid_email|max_length[255]');
		$val->add_field('last_login', 'Last Login', 'required|max_length[255]');
		$val->add_field('login_hash', 'Login Hash', 'required|max_length[255]');
		$val->add_field('ip', 'Ip', 'required|max_length[255]');

		return $val;
	}
	
	#1
	public static function register(Fieldset $form)
    {
    	$form->add('username', 'Username:')->add_rule('required');
	    $form->add('password', 'Choose Password:', array('type'=>'password'))->add_rule('required');
	    $form->add('password2', 'Re-type Password:', array('type' => 'password'))->add_rule('required');
	    $form->add('email', 'E-mail:')->add_rule('required')->add_rule('valid_email');
	    $form->add('submit', ' ', array('type'=>'submit', 'value' => 'Register'));
	    return $form;
    }

}
