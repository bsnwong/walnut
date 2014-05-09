<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'User';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
    protected $hidden = array('password');
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */

	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}
    /*
     |---------------------------------------------------------
     |check if email exists
     |---------------------------------------------------------
     * */
    public function scopeEmailExists($query, $email) {
        return $query->where('email', '=', $email);
    }
    /*
     |---------------------------------------------------------
     |check if password valid
     |---------------------------------------------------------
     * */
    public function scopePasswordValid($query, $password) {
        return $query->where('password', '=', $password);
    }
    /*
     |---------------------------------------------------------
     |Return the organization info
     |---------------------------------------------------------
     * */
//    public function org() {
//        return $this->belongsToManny('Organization');
//    }



}