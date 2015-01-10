<?php
/**
* Plugin Name: Custom post types and taxonomies manager
* Author URI: http://pravdomil.cz
*/

require_once "cptman_fce.php";
require_once "cptman_form.php";
require_once "cptman_post.php";
require_once "cptman_tax.php";

class cptman
{
	var $capability = 'manage_options';
	var $slug = 'cptman';
	var $menu_title = 'Post types';
	
	var $post;
	var $tax;
	
	function __construct() {
		$this->post = new cptman_post($this);
		$this->tax = new cptman_tax($this);
		
		add_action( 'admin_menu', array($this, "menu"));
	}
	
	function menu() {
		add_menu_page($this->title, $this->menu_title, $this->capability, $this->slug, array($this, "page"));
	}
	
	function page() {
		if ( !current_user_can( $this->capability ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		$this->html();
		
		echo'<table><tr><td>';
		
		echo '<h1><a href="' . $this->self() . '">Post types</a></h1>';
		$this->post->page();
		echo'</td><td>';
		
		echo '<h1><a href="' . $this->self() . '">Taxonomies</a></h1>';
		$this->tax->page();
		echo'</td></tr></table>';
	}
	
	function get($key) {
		return get_option($slug . "_" . $key);
	}
	
	function set($key, $value) {
		return update_option($slug . "_" . $key, $value);
	}
	
	function html() {
?>
<style type="text/css">
#wpbody-content > table { width: 100%; border-spacing: 1em; }
#wpbody-content > table > tbody > tr > td { width: 50%; vertical-align: top; }
#wpbody-content label { display: inline-block; width: 50%; min-height: 30px; padding: 4px 0; box-sizing: border-box; }
#wpbody-content fieldset { margin: 8px 0 !important; padding: 8px 10px !important; }
#wpbody-content legend { font-weight: bold; }
#wpbody-content form .button-primary { width: 100%; }
#wpbody-content pre { line-height: 1.2; padding: 8px 10px; font-size: 12px; }
#wpbody-content .column-slug { width: 50%; }
#wpbody-content .column-supports { width: 50%; }
</style>
<?php
	}
	
	function button($label, $key, $value="") {
		return '<a class="button" href="' . $this->link($key, $value) . '">' . $label . '</a>';
	}
		
	function link($key, $value="") {
		return add_query_arg(array($key => $value), $this->self());
	}
	
	function self() {
		return get_admin_url() . "admin.php?page=" . $this->slug;
	}
}

new cptman();
