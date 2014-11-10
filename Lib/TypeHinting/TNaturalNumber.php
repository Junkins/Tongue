<?php
App::uses('TongueTypeInterface', 'Tongue.Lib');
App::uses('Validation', 'Utility');

/**
 * TNaturalNumber
 *
 */
class TNaturalNumber implements TongueTypeInterface {

    private $arg;

    public function __construct($arg){
        $this->arg = $arg;
    }

    /**
     * check
     *
     */
    public function check(){
        if (!Validation::naturalNumber($this->arg)) {
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
