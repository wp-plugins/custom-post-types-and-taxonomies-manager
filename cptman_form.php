<?php

class cptman_form
{
	var $parent;
	var $data;

	function __construct($parent, $fields, $action, $data=array()) {
		$this->parent = $parent;
		$this->data = $data;
		
		$fields = $this->walk_fields_recursively("prepare", $fields);
		$fields = $this->walk_fields("input", $fields);
		
		echo '<form method="post" action="' . $action . '">';
		echo '<input type="submit" class="button-primary">';
		$this->fieldset($fields);
		echo '<input type="submit" class="button-primary">';
		echo '</form>';
		
	}
	
	function fieldset($arr) {
		foreach($arr as $key => $val) {
			ksort($val);
			echo '<fieldset class="stuffbox">';
			echo '<legend>' . $key . '</legend>';
			echo join("", $val);
			echo '</fieldset>';
		}
	}
	
	function prepare($field, $key, $prefix) {
		if($field["type"] == "post_type_array")
		{
			$arr = array();
			
			global $wp_post_types;
			foreach($wp_post_types as $slug => $post_type)
			{
				if(!$post_type->public) continue;
				
				$arr[] = array_merge($field, array("type" => "checkbox", "value" => $slug, "label"=> __($post_type->label)));
			}
			
			$field = $arr;
		}
		
		return $field;
	}
	
	function input($field, $key, $prefix, $arr) {
		$text = $key;
		if(is_numeric($text)) $text = $field["value"];
		if($field["label"]) $text = $field["label"];
		$text = ucfirst(str_replace(array("_", "-"), " ", $text));
		
		$r = '<label title="' . $field["title"] . '">';
		
		switch($field["type"]) {
			case "checkbox":
				$r.= $this->get_input($prefix, $key, $field, array("type" => "hidden", "value" => "0"));
				$r.= $this->get_input($prefix, $key, $field);
				$r.= " " . $text;
				break;
			case "text":
			case "number":
				$r.= $text . " ";
				$r.= $this->get_input($prefix, $key, $field);
				break;
			case "hidden":
				$r.= $this->get_input($prefix, $key, $field);
				break;
			default:
				$r.= "<b>" . $field["type"] . "</b>";
		}
		if($field["hint"]) $r.='<div style="display: inline-block; vertical-align: middle; padding-left: 2em;">' . $field["hint"] . '</div>';
		
		$r.= '</label>';
		
		$fs = $field["fieldset"];
		if(!isset($arr[$fs])) $arr[$fs] = array();
		if(isset($field["order"])) $arr[$fs][$field["order"]] = $r; else $arr[$fs][] = $r;
		
		return $arr;
	}
	
	function get_input($prefix, $key, $field, $override=array()) {
		$field["name"] = $prefix ? $prefix . "[" . $key . "]" : $key;
		
		$data_val = $prefix ? $this->data[$prefix][$key] : $this->data[$key];
		
		if($data_val !== null)
		{
			if($field["type"] == "checkbox")
			{
				if($data_val) $field["checked"] = "checked";
				else unset($field["checked"]);
			}
			else
			{
				$field["value"] = $data_val;
			}
		}
		
		if($field["flavour"] == "comma_array") $field["value"] = join(",", (array)$field["value"]);
		if($field["placeholder"]) {
			$field["placeholder"] = preg_replace_callback("/'([^']+)'/", function($match) { return __($match[1]); }, $field["placeholder"]);
		}
		
		foreach($override as $k => $v) $field[$k] = $v;
		
		$r= '<input';
		foreach($field as $k=>$v) $r.= " " . $k . '="' . str_replace('"', '\"', $v) . '"';
		$r.='>';
		
		return $r;
	}
	
	function walk_fields_recursively($callback, $fields, $prefix = "") {
		foreach($fields as $key => $field) {
			if(!$field["type"])
			{
				$fields[$key] = $this->walk_fields_recursively($callback, $field, $key);
				continue;
			}
			
			$fields[$key] = $this->$callback($field, $key, $prefix);
		}
		
		return $fields;
	}
	
	function walk_fields($callback, $fields, $prefix = "", $arr=array()) {
		foreach($fields as $key => $field) {
			if(!$field["type"])
			{
				$arr = $this->walk_fields($callback, $field, $key, $arr);
				continue;
			}
			
			$arr = $this->$callback($field, $key, $prefix, $arr);
		}
		
		return $arr;
	}
}
