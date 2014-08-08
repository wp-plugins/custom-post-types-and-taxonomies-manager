<?php

require_once "cptman_post_table.php";
require_once "cptman_post_fields.php";

class cptman_post extends cptman_post_fields
{
	var $columns = array(
		"slug" => "",
		"supports" => "Supports",
	);
	
	function __construct($parent) {
		$this->parent = $parent;
		$this->type = "post";
		$this->title = "post type";
		$this->run();
		
		add_action( 'init', array($this, 'register_post_types' ));
	}
	
	function register_post_types() {
		foreach($this->data as $name => $args) {
			register_post_type($name, $this->filter_args($args));
		}
	}
}
