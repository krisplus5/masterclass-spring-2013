<?php

class Model_Exception extends Exception
{
    public function __construct($message = null, $code = 0, Exception $previous = null) {
		$message = 'UPVOTE: ' . $message;
        parent::__construct($message, $code, $previous);
    }
}
