<?php
/**
 * Tonguetypeinterface
 *
 */
interface TongueTypeInterface {
    /**
     * __construct
     * set $this->arg
     *
     * @param $arg
     */
    public function __construct($arg);

    /**
     * check
     * check $this->arg format
     *
     */
    public function check();

    /**
     * __toString
     * return $this->arg
     *
     * @return String $this->arg
     */
    public function __toString();
}
