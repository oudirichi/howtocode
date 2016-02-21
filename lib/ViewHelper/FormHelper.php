<?php

namespace lib\ViewHelper;

class FormHelper{

	public static function input($id, $class=""){

		$value = isset($_POST[$id]) ? $_POST[$id] : '';
		if ($value=='') {
			$value = isset($_SESSION['POST'][$id]) ? $_SESSION['POST'][$id] : '';
		}
		return '<input type="text" class="'.$class.'" id="'.$id.'" name="'.$id.'" value="' .$value.'">';
		//return "<input type='text' class='form-control' id='$id' name='$id' value='$value'>";

	}

	public static function textarea($id, $class=""){

		$value = isset($_POST[$id]) ? $_POST[$id] : '';
		if ($value=='') {
			$value = isset($_SESSION['POST'][$id]) ? $_SESSION['POST'][$id] : '';
		}
		//return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
		return "<textarea type='text' class='".$class."' id='".$id."' name='".$id."'>$value</textarea>";

	}


	public static function wysiwyg($id, $class=""){

		$value = isset($_POST[$id]) ? $_POST[$id] : '';
		//return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
		return "<textarea type='text' class='".$class."' id='".$id."' name='".$id."'>$value</textarea>";

	}

	public static function select($id, $options = array()){
		$return = "<select class='".$class."' id='$id' name='$id'>";
		foreach ($options as $k => $v) {
			$selected = '';
			if(isset( $_POST[$id]) && $k == $_POST[$id]){
				$selected = ' selected="selected"';
			}
			$return .="<option value='$k' $selected>$v</option>";
		}
		$return .= '</select>';
		return $return;
	}

}