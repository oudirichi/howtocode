<?php

$views='views';
$controllers='controllers';

include_once "views/HtmlHelper.php";
include_once "views/ViewBlock.php";

class Helper{

		public $html;
		public $Blocks;
		public $model;

		 public function __construct()
		  {
		    $this->html = new HtmlHelper();
			$this->Blocks = new ViewBlock();
		  }
}
