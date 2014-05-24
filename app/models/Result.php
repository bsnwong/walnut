<?php
/**
 * Created by PhpStorm.
 * User: bsn
 * Date: 14-5-2
 * Time: 下午11:53
 */
class Result extends Eloquent {
    protected $table = 'Result';
    /*
     |--------------------------------------------------------------
     |Get the question info
     |--------------------------------------------------------------
     * */
    public function question() {
        return $this->belongsTo('Question', 'q_id', 'id');
    }
}
