<?php

namespace lib\ViewHelper;

class BootsForm{

	public static function input($id){
		return FormHelper::input($id, "form-control");
	}

	public static function textarea($id){
		return FormHelper::textarea($id, "form-control");
	}


	public static function wysiwyg($id){
		return FormHelper::wysiwyg($id, "form-control");

	}

	public static function select($id, $options = array()){
		return FormHelper::select($id, "form-control");
	}

}