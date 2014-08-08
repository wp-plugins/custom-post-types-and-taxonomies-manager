<?php

require_once "cptman_tax_table.php";
require_once "cptman_tax_fields.php";

class cptman_tax extends cptman_tax_fields
{
	var $columns = array(
		"slug" => "",
		"object_type" => "Post types",
	);
	
	function __construct($parent) {
		$this->parent = $parent;
		$this->type = "tax";
		$this->title = "taxonomy";
		$this->run();
		
		add_action( 'init', array($this, 'register_taxonomies' ));
		add_filter( 'post_class', array($this, 'add_post_class'), 10, 3 );
	}
	
	function register_taxonomies() {
		foreach($this->data as $slug => $args) {
			register_taxonomy($slug, $args["object_type"], $this->filter_args($args));
		}
	}
	
    function add_post_class($classes, $class, $ID) {
        $taxonomies = array();
		
		foreach($this->data as $slug => $args) if($args["post_class"]) $taxonomies[] = $slug;

        $terms = get_the_terms( $ID, $taxonomies );
		
		if($terms) foreach ( $terms as $term ) {
			$args = $this->data[$term->taxonomy];
			
			$cat = ( $args["hierarchical"] ? "category-" : "tag-" ) . $term->taxonomy;
			if ( ! in_array( $cat, $classes ) ) $classes[] = $cat;
			
			$cat_value = $term->taxonomy . "-" . $term->slug;
			if ( ! in_array( $cat_value, $classes ) ) $classes[] = $cat_value;
		}

        return $classes;
    }
}
