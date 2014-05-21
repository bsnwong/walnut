<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-2
 * Time: 下午11:52
 */
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Question extends Eloquent {
    protected $table = 'Question';

    public function result() {
        return $this->hasMany('q_id', 'id');
    }

}
