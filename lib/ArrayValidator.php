<?php

namespace lib;

class ArrayValidator{

    private $data;
    private $errors = [];

    public function __construct($data){

    	$this->data = $data;
    }

    private function getField($field){

    	if(!isset($this->data[$field])){
    		return null;
    	}

    	return $this->data[$field];
    }

	public function isAlpha($field, $errorMsg){
		if (!preg_match('/^[a-zA-Z0-9_]+$/', $this->getField($field))) {
    		$this->errors[$field] = $errorMsg;
  		}
	}

	public function isFloat($field, $errorMsg){
		if (!filter_var($this->getField($field), FILTER_VALIDATE_FLOAT)) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isInt($field, $errorMsg){
		if (!filter_var($this->getField($field), FILTER_VALIDATE_INT)) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isBool($field, $errorMsg){
		if (!filter_var($this->getField($field), FILTER_VALIDATE_BOOLEAN)) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isPresent($field, $errorMsg){
		if (empty($this->getField($field))) {
    		$this->errors[$field] = $errorMsg;
  		}
	}

	public function isEmail($field, $errorMsg){
		if (!filter_var($this->getField($field), FILTER_VALIDATE_EMAIL)) {
			$this->errors[$field] = $errorMsg;
		}
	}

	public function inRange($field, $range, $errorMsg){

		if ($this->getField($field)) {
			$range = explode("..", $range);
			if(($range[0] <= $this->getField($field)) && ($this->getField($field) <= $range[1])){
				$this->errors[$field] = $errorMsg;
			}
		}
	}

	public function isConfirmed($field, $errorMsg = ''){
		$value = $this->getField($field);
		if (empty($value) || ($value != $this->getField($field . '_confirm'))){
			$this->errors[$field] = $errorMsg;
		}
	}

	public function isValid(){
		return empty($this->errors);
	}

	public function getErrors(){
		return $this->errors;
	}
}


