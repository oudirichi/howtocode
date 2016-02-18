<?php

/**
*
*/
namespace lib;

class Str
{

	/**
	 * return random string
	 * @param  [int] $length number of letter
	 * @return [string] 	 random string
	 */
 	static function random($length){
    	$alphabet = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
  	}

 	/**
	 * remove prefix from string
	 * @param  [string] $text   text with/without prefix to remove
	 * @param  [string] $prefix prefix to remove
	 * @return [string]         return textwithout prefix
	 */
	static function remove_prefix($text, $prefix) {
		if(0 === strpos($text, $prefix))
			$class = str_replace($prefix,'', $text);
		    //$text = substr($text, strlen($prefix)).'';
		return $text;
	}
}