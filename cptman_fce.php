<?php

class cptman_fce
{
	var $parent;
	
	var $type;
	var $title;
	
	var $data;
	var $columns;
	var $hidden;
	
	function run() {
		$this->load_data();
		$this->post();
	}
	
	function load_data() {
		$this->data = $this->parent->get($this->type);
		if(!$this->data) $this->data = array();
	}
	
	function save_data() {
		$this->parent->set($this->type, $this->data);
	}
	
	function filter_args($args) {
		foreach ($args as $key => $value) {
			if (is_array($value)) $args[$key] = $this->filter_args($args[$key]);
			else if($args[$key] === null) unset($args[$key]);
		}
		return $args;
	}
	
	function get_key($key) {
		return $key . "_" . $this->type;
	}
	
	function get($key) {
		return $_GET[$this->get_key($key)];
	}
	
	function is_set($key) {
		return isset($_GET[$this->get_key($key)]);
	}
	
	function link($key, $value="") {
		return $this->parent->link($this->get_key($key), $value);
	}
	
	function button($label, $key, $value="") {
		return $this->parent->button($label, $this->get_key($key), $value);
	}
	
	function get_name($slug) {
		return $this->data[$slug]["labels"]["name"];
	}
	
	function page() {
		if($this->is_set("new")) return $this->new_form();
		if($this->is_set("edit")) return $this->edit_form();
		if($this->is_set("duplicate")) return $this->dup_form();
		if($this->is_set("debug")) return $this->debug();
		
		$table_class = "cptman_" . $this->type . "_table";
		$table = new $table_class($this, $this->columns, $this->data, $this->hidden);
		$table->display();
	}
	
	function new_form() {
		echo "<hr><h2>New " . $this->title . "</h2>";
		new cptman_form($this->parent, $this->fields, $this->link("do_new"));
	}
	
	function edit_form() {
		$slug = $this->get("edit");
		echo "<hr><h2>Edit " . $this->title . " <b>" . $this->get_name($slug) . "</b></h2>";
		new cptman_form($this->parent, $this->fields, $this->link("do_edit", $slug), $this->data[$slug]);
	}
	
	function dup_form() {
		$slug = $this->get("duplicate");
		echo "<hr><h2>Duplicate " . $this->title . " <b>" . $this->get_name($slug) . "</b></h2>";
		new cptman_form($this->parent, $this->fields, $this->link("do_new"), $this->data[$slug]);
	}
	
	function debug() {
		echo "<hr><h2>Debug <b>" . $this->get_name($this->get("debug")) . "</b></h2>";
		echo '<pre class="stuffbox">';
		ob_start();
		var_dump( $this->filter_args( $this->data[$this->get("debug")] ) );
		echo preg_replace("/\s+=>\s+/", " => ", str_replace("=>\n", " =>", ob_get_clean()));
		echo "</pre>";
	}
	
	function post() {
		if($this->is_set("delete") || $this->is_set("do_new") || $this->is_set("do_edit")) {
			if($this->is_set("delete")) unset($this->data[$this->get("delete")]);
			if($_POST)
			{
				if($this->get("do_edit")) $this->data = $this->change_key($this->data, $this->get("do_edit"), $_POST["slug"]);
				
				$this->data[$_POST["slug"]] = $this->save_post($this->fields);
			}
			$this->save_data();
		}
	}
	
	function save_post($fields, $prefix="") {
		$arr = array();
		
		foreach($fields as $key => $field) {
			if(!$field["type"]) {
				$arr = array_merge($arr, array($key => $this->save_post($field, $key)));
				continue;
			}
			
			$val = $prefix ? $_POST[$prefix][$key] : $_POST[$key];
			
			if($field["override"] && $val) $arr[$field["override"]] = $val;
			if($field["flavour"] == "comma_array") $val = explode(",", $val);
			if($field["format"] == "bool") $val = (bool) $val;
			if($field["format"] == "int" && $val !== "") $val = (int) $val;
			if($val === "") $val = null;
			
			$arr[$key] = $val;
		}
		return $arr;
	}
	
	function change_key( $array, $old_key, $new_key) {
		if( ! array_key_exists( $old_key, $array ) || $old_key === $new_key ) return $array;
		
		$keys = array_keys( $array );
		$keys[ array_search( $old_key, $keys ) ] = $new_key;
		
		return array_combine( $keys, $array );
	}
}
