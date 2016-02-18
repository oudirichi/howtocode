<?php

function input($id){

	$value = isset($_POST[$id]) ? $_POST[$id] : '';
	return '<input type="text" class="form-control" id="'.$id.'" name="'.$id.'" value="' .$value.'">';
	//return "<input type='text' class='form-control' id='$id' name='$id' value='$value'>";

}

function textarea($id){

	$value = isset($_POST[$id]) ? $_POST[$id] : '';
	//return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
	return "<textarea type='text' class='form-control' id='".$id."' name='".$id."'>$value</textarea>";

}


function wysiwyg($id){

	$value = isset($_POST[$id]) ? $_POST[$id] : '';
	//return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
	return "<textarea type='text' class='form-control' id='".$id."' name='".$id."'>$value</textarea>";

}
/*function wysiwyg($content,$id,$name){

	$value = isset($_POST[$content]) ? $_POST[$content] : '';
	//return "<textarea type='text' class='form-control' id='$id' name='$id'>$value</textarea>";
	return "<textarea type='text' class='form-control' id='".$id."' name='".$name."'>$value</textarea>";

}*/
/*
*1.
*recoit de work_edit pour mettre les données dans un seclect avec option
*/
function select($id, $options = array()){
	$return = "<select class='form-control' id='$id' name='$id'>";
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