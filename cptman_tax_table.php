<?php
if(!class_exists('WP_List_Table')) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class cptman_tax_table extends WP_List_Table
{
	var $parent;
	var $columns;
	var $data;
	var $hidden;
	
	function __construct($parent, $columns, $data, $hidden) {
		$this->parent = $parent;
		$this->columns = (array)$columns;
		$this->data = (array)$data;
		$this->hidden = (array)$hidden;
		
		$this->_args = array();
		$this->_column_headers = array($this->get_columns(), $this->get_hidden_columns(), $this->get_sortable_columns());
		$this->items = (array)$data;
	}
	
	function prepare_items() {
		return;
	}
	
	function extra_tablenav( $which ) {
		echo $this->parent->button("New taxonomy", "new");
	}
	
	function get_columns() {
		return $this->columns;
	}

	function get_hidden_columns() {
		return $this->hidden;
	}

	function get_sortable_columns() {	
		return array();
	}
	
	function column_default($item, $key)
	{
		$val = $item[$key];
		switch($key) {
			case 'slug':
				$items = array();
				
				$items[] = $item["hierarchical"] ? "categories" : "tags";
				$items[] = $item["public"] ? "public" : "private";
				$items[] = $item["show_ui"] ? "with UI" : "no UI";
				if($item["query_var"]) $items[] = $item["query_var"] === true ? "query_var" : "query_var: " . $item["query_var"];
				
				return	'<a href="' . $this->parent->link("edit", $val) . '" title="Edit ' . $val . '" class="button-primary">' . $this->parent->get_name($val) . '</a> '.
						'<div style="float: right"><a href="' . $this->parent->link("duplicate", $val) . '" class="button">Duplicate</a> '.
						'<a href="' . $this->parent->link("delete", $val) . '" class="button">Delete</a> '.
						'<a href="' . $this->parent->link("debug", $val) . '" class="button">Debug</a></div>'.
						'<br/>' . ucfirst(implode(", ", $items));
				break;
			case 'object_type':
				global $wp_post_types;
				$arr = array();
				foreach($val as $pol) {
					if($pol == "0" || !$pol) continue;
					$label = $wp_post_types[$pol]->label;
					if($label) $arr[] = $label;
				}
				return implode(", ", $arr);
				break;
			default:
				return print_r($val, true);
		}
	}
}
