<?php

abstract class cptman_tax_fields extends cptman_fce {
	var $fields = array(
		
		// General
		"slug" => array(
			"type" => "text",
			"title" => "Taxonomy slug.\nMax of 32 characters.\nUppercase and spaces not allowed.",
			"required" => true,
			"maxlength" => 32,
			"pattern" => "[^A-Z\s]+",
			"fieldset" => "General",
			"placeholder" => "Required",
		),
		"public" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"value" => true,
			"title" => "Is the taxonomy publicly queryable?",
			"fieldset" => "General",
		),
		"hierarchical" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"value" => true,
			"title" => "Allow hierarchical parent / child relations?",
			"fieldset" => "General",
			"hint" => "hierarchical = categories<br/>nonhierarchical = tags",
		),
		
		// Post types
		"object_type" => array(
			"type" => "post_type_array",
			"title" => "Attach to this post type.",
			"fieldset" => "Attach to post type",
		),
		
		// UI
		"show_ui" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Generate standard UI for managing this taxonomy?",
			"fieldset" => "UI",
		),
		"show_in_nav_menus" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Is taxonomy available for selection in navigation menus?",
			"fieldset" => "UI",
		),
		"show_tagcloud" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"title" => "Allow tag cloud widget?",
			"fieldset" => "UI",
		),
		"show_admin_column" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Show taxonomy column in table of posts?",
			"fieldset" => "UI",
		),
		
		// Labels
		"labels" => array(
			"name" => array(
				"type" => "text",
				"title" => "General name.\nUsually plural.",
				"fieldset" => "General",
				"placeholder" => "Required",
				"required" => "required",
				"order" => -1,
				"autofocus" => "autofocus",
			),
			"singular_name" => array(
				"type" => "text",
				"title" => "Name of one item.",
				"placeholder" => "Name by default",
				"fieldset" => "Labels",
			),
			"menu_name" => array(
				"type" => "text",
				"title" => "Menu text.",
				"placeholder" => "Name by default",
				"fieldset" => "Labels",
			),
			"all_items" => array(
				"type" => "text",
				"title" => "All items text.",
				"placeholder" => "'All Tags' / 'All Categories'",
				"fieldset" => "Labels",
			),
			"edit_item" => array(
				"type" => "text",
				"title" => "Edit item text.",
				"placeholder" => "'Edit Tag' / 'Edit Category'",
				"fieldset" => "Labels",
			),
			"view_item" => array(
				"type" => "text",
				"title" => "View item text.",
				"placeholder" => "'View Tag' / 'View Category'",
				"fieldset" => "Labels",
			),
			"update_item" => array(
				"type" => "text",
				"title" => "Update item text.",
				"placeholder" => "'Update Tag' / 'Update Category'",
				"fieldset" => "Labels",
			),
			"add_new_item" => array(
				"type" => "text",
				"title" => "Add new item text.",
				"placeholder" => "'Add New Tag' / 'Add New Category'",
				"fieldset" => "Labels",
			),
			"new_item_name" => array(
				"type" => "text",
				"title" => "New item name text.",
				"placeholder" => "'New Tag Name' / 'New Category Name'",
				"fieldset" => "Labels",
			),
			"search_items" => array(
				"type" => "text",
				"title" => "Search items text.",
				"placeholder" => "'Search Tags' / 'Search Categories' ",
				"fieldset" => "Labels",
			),
			"parent_item" => array(
				"type" => "text",
				"title" => "Parent item text.",
				"placeholder" => "'Parent Category'",
				"fieldset" => "Category labels",
			),
			"parent_item_colon" => array(
				"type" => "text",
				"title" => "Parent item text with colon.",
				"placeholder" => "'Parent Category:'",
				"fieldset" => "Category labels",
			),
			"popular_items" => array(
				"type" => "text",
				"title" => "Popular items text.",
				"placeholder" => "'Popular Tags'",
				"fieldset" => "Tags labels",
			),
			"separate_items_with_commas" => array(
				"type" => "text",
				"title" => "Separate items with commas text.\nUsed in the taxonomy meta box.",
				"placeholder" => "'Separate tags with commas'",
				"fieldset" => "Tags labels",
			),
			"add_or_remove_items" => array(
				"type" => "text",
				"title" => "Add or remove items text.\nAlso used in the meta box when JavaScript is disabled.",
				"placeholder" => "'Add or remove tags'",
				"fieldset" => "Tags labels",
			),
			"choose_from_most_used" => array(
				"type" => "text",
				"title" => "Choose from most used text.\nUsed in the taxonomy meta box.",
				"placeholder" => "'Choose from the most used tags'",
				"fieldset" => "Tags labels",
			),
			"not_found" => array(
				"type" => "text",
				"title" => "Text displayed via clicking 'Choose from the most used tags' in the taxonomy meta box when no tags are available.",
				"placeholder" => "'No tags found.'",
				"fieldset" => "Tags labels",
			),
		),
		
		// Query
		"query_var" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"title" => "Can be queries performed on the frontend?\n\n?{name}={tax_value}",
			"fieldset" => "Query",
		),
		"query_var_slug" => array(
			"type" => "text",
			"value" => "",
			"title" => "Leave empty to use the name or set this to control the exact key.",
			"fieldset" => "Query",
			"placeholder" => "Slug by default",
			"override" => "query_var",
		),
		
		// Advanced
		"post_class" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"title" => "Add category|tag-{slug} and {slug}-{tax_value_slug} to the post class.",
			"fieldset" => "Advanced",
		),
		"sort" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"title" => "Should taxonomy remember the order in which terms are added to objects?",
			"fieldset" => "Advanced",
			"label" => "Remember sort",
		),
		"capabilities" => array(
			"type" => "text",
			"title" => "Inherit capabilities from specific post type. Comma separated array.",
			"fieldset" => "Advanced",
			"flavour" => "comma_array",
		),
	);
}
