<?php
App::uses('TongueTypeInterface', 'Tongue.Lib');
/**
 * TNumeric
 *
 */
class TNumeric implements TongueTypeInterface {

    private $arg;

    public function __construct($arg){
        $this->arg = $arg;
    }

    /**
     * check
     *
     */
    public function check(){
        if (!is_numeric($this->arg)) {
            throw new InternalErrorException();
        }
    }

    /**
     * __toString
     *
     */
    public function __toString(){
        return $this->arg;
    }

}
