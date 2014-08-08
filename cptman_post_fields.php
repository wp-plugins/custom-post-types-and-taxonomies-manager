<?php

abstract class cptman_post_fields extends cptman_fce {
	var $fields = array(
		
		// General
		"slug" => array(
			"type" => "text",
			"title" => "Post type slug.\nMax of 20 characters.\nUppercase and spaces not allowed.",
			"required" => true,
			"maxlength" => 20,
			"pattern" => "[^A-Z\s]+",
			"fieldset" => "General",
			"placeholder" => "Required",
		),
		"description" => array(
			"type" => "text",
			"title" => "Description can be used by the theme.\nNot commonly used.",
			"fieldset" => "General",
		),
		"public" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"value" => true,
			"title" => "Is post type available in admin and on the frontend?\nIt can be still queried via WP_Query regardless.",
			"fieldset" => "General",
		),
		"hierarchical" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"title" => "Allow hierarchical parent / child relations?",
			"fieldset" => "General",
			"hint" => "hierarchical = pages<br/>nonhierarchical = posts",
		),
		
		// Archive
		"has_archive" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"title" => "Has the post type an index / archive page?",
			"fieldset" => "Archive",
		),
		"Archive_custom_slug" => array(
			"type" => "text",
			"value" => "",
			"title" => "Leave empty to use the name or set this to control the page slug.",
			"placeholder" => "Slug by default",
			"fieldset" => "Archive",
			"override" => "has_archive",
		),
		
		// Rewrite
		"rewrite" => array(
			"slug" => array(
				"type" => "text",
				"value" => "",
				"title" => "The slug.",
				"placeholder" => "Slug by default",
				"fieldset" => "Rewrite",
			),
			"with_front" => array(
				"type" => "checkbox",
				"format" => "bool",
				"checked" => "checked",
				"value" => true,
				"title" => "Prepend the \$wp_rewrite->front in the permalink?",
				"fieldset" => "Rewrite",
			),
			"pages" => array(
				"type" => "checkbox",
				"format" => "bool",
				"checked" => "checked",
				"value" => true,
				"title" => "Allow single post pagination via the <!--nextpage--> quicktag?",
				"fieldset" => "Rewrite",
			),
			"feeds" => array(
				"type" => "checkbox",
				"format" => "bool",
				"checked" => "checked",
				"value" => true,
				"title" => "Create feeds for this post type?",
				"fieldset" => "Rewrite",
			),
		),
		
		// Query
		"publicly_queryable" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"value" => true,
			"title" => "Can queries be performed on the frontend?\n\n?post_type={slug}\n?{slug}={single_post_slug}\n?{query_var}={single_post_slug} optional",
			"fieldset" => "Query",
		),
		"query_var" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"title" => "Enables query_var in mentioned in publicly_queryable.",
			"fieldset" => "Query",
		),
		"query_var_string" => array(
			"type" => "text",
			"value" => "",
			"title" => "Leave empty to use the name or set this to control the exact key.",
			"fieldset" => "Query",
			"placeholder" => "Slug by default",
			"override" => "query_var",
		),
		
		// UI
		"show_ui" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Generate admin UI?",
			"fieldset" => "UI",
		),
		"show_in_nav_menus" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Are post type items available for selection in navigation menus?",
			"fieldset" => "UI",
		),
		"show_in_admin_bar" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"title" => "Show New item link in admin bar?",
			"fieldset" => "UI",
		),
		"show_in_menu" => array(
			"type" => "checkbox",
			"format" => "bool",
			"value" => true,
			"checked" => "checked",
			"title" => "Show the post type in admin menu?",
			"fieldset" => "UI",
		),
		"menu_icon" => array(
			"type" => "text",
			"title" => "URI or dashicon name.",
			"placeholder" => "Default post icon",
			"fieldset" => "UI",
		),
		"menu_position" => array(
			"type" => "number",
			"format" => "int",
			"value" => "",
			"title" => "The position in menu.\nAvoid conflict with already taken values!\n\n5 - below Posts\n10 - below Media\n15 - below Links\n20 - below Pages\n25 - below comments\n60 - below first separator\n65 - below Plugins\n70 - below Users\n75 - below Tools\n80 - below Settings\n100 - below second separator",
			"fieldset" => "UI",
		),
		
		// Supports
		"supports" => array(
			array(
				"type" => "checkbox",
				"value" => "title",
				"title" => "Post titles.\n\$post->post_title",
				"checked" => "checked",
				"fieldset" => "Supports",
			),
			array(
				"type" => "checkbox",
				"value" => "editor",
				"title" => "Post content.\n\$post->post_content",
				"checked" => "checked",
				"fieldset" => "Supports",
			),
			array(
				"type" => "checkbox",
				"value" => "author",
				"title" => "Post author.\n\$post->post_author",
				"fieldset" => "Supports",
			),
			array(
				"type" => "checkbox",
				"value" => "excerpt",
				"title" => "Displays excerpt box.",
				"checked" => "checked",
				"fieldset" => "Supports",
			),
			array(
				"type" => "checkbox",
				"value" => "thumbnail",
				"title" => "Featured images.\nTheme must support 'post-thumbnails'.",
				"checked" => "checked",
				"fieldset" => "Supports",
			),
			array(
				"type" => "checkbox",
				"value" => "comments",
				"title" => "Displays comments meta box.",
				"fieldset" => "Supports",
			),
			
			//Supports advanced
			array(
				"type" => "checkbox",
				"value" => "custom-fields",
				"title" => "Displays the Custom Fields meta box.\nPost meta is supported regardless.",
				"checked" => "checked",
				"fieldset" => "Supports advanced",
			),
			array(
				"type" => "checkbox",
				"value" => "page-attributes",
				"title" => "Parent selector and menu_order input box.",
				"checked" => "checked",
				"fieldset" => "Supports advanced",
			),
			array(
				"type" => "checkbox",
				"value" => "post-formats",
				"title" => "Allows post formats.",
				"checked" => "checked",
				"fieldset" => "Supports advanced",
			),
			array(
				"type" => "checkbox",
				"value" => "revisions",
				"title" => "Displays the Revisions meta box.\nIf set, stores post revisions in the database.",
				"checked" => "checked",
				"fieldset" => "Supports advanced",
			),
			array(
				"type" => "checkbox",
				"value" => "trackbacks",
				"title" => "Displays meta box to send trackbacks from the edit post screen.",
				"fieldset" => "Supports advanced",
			),
			array(
				"type" => "checkbox",
				"value" => "publicize",
				"title" => "Jetpack publicize allows to share posts on social media networks automatically when you publish a new post.",
				"checked" => "checked",
				"fieldset" => "Supports",
				"fieldset" => "Supports advanced",
			),
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
				"title" => "Name for one item.",
				"placeholder" => "Name by default",
				"fieldset" => "Labels",
			),
			"menu_name" => array(
				"type" => "text",
				"title" => "Menu text.",
				"placeholder" => "Name by default",
				"fieldset" => "Labels",
			),
			"name_admin_bar" => array(
				"type" => "text",
				"title" => "Add New text on admin bar.",
				"placeholder" => "Singular name or name by default",
				"fieldset" => "Labels",
			),
			"all_items" => array(
				"type" => "text",
				"title" => "All items text in menu.",
				"placeholder" => "Name by default",
				"fieldset" => "Labels",
			),
			"add_new" => array(
				"type" => "text",
				"title" => "Add new text.",
				"placeholder" => "'Add New'",
				"fieldset" => "Labels",
			),
			"add_new_item" => array(
				"type" => "text",
				"title" => "Add new item text.",
				"placeholder" => "'Add New Post' / 'Add New Page'",
				"fieldset" => "Labels",
			),
			"edit_item" => array(
				"type" => "text",
				"title" => "Edit item text.",
				"placeholder" => "'Edit Post' / 'Edit Page'",
				"fieldset" => "Labels",
			),
			"new_item" => array(
				"type" => "text",
				"title" => "New item text.",
				"placeholder" => "'New Post' / 'New Page'",
				"fieldset" => "Labels",
			),
			"view_item" => array(
				"type" => "text",
				"title" => "View item text.",
				"placeholder" => "'View Post' / 'View Page'",
				"fieldset" => "Labels",
			),
			"search_items" => array(
				"type" => "text",
				"title" => "Search items text.",
				"placeholder" => "'Search Posts' / 'Search Pages'",
				"fieldset" => "Labels",
			),
			"not_found" => array(
				"type" => "text",
				"title" => "Not found text.",
				"placeholder" => "'No posts found' / 'No pages found'",
				"fieldset" => "Labels",
			),
			"not_found_in_trash" => array(
				"type" => "text",
				"title" => "Not found in trash text.",
				"placeholder" => "'No posts found in Trash' / 'No pages found in Trash'",
				"fieldset" => "Labels",
			),
			"parent_item_colon" => array(
				"type" => "text",
				"title" => "Parent text.",
				"placeholder" => "'Parent Page'",
				"fieldset" => "Labels",
			),
		),
		
		// Advanced
		"exclude_from_search" => array(
			"type" => "checkbox",
			"format" => "bool",
			"title" => "Exclude from search results?",
			"fieldset" => "Advanced",
		),
		"can_export" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"title" => "Supports this post type import / export?",
			"fieldset" => "Advanced",
		),
		"delete_with_user" => array(
			"type" => "checkbox",
			"format" => "bool",
			"checked" => "checked",
			"title" => "Delete posts when deleting a user who has written posts?",
			"fieldset" => "Advanced",
		),
		"capability_type" => array(
			"type" => "text",
			"title" => "Inherit capabilities from post type. Comma separated array.",
			"fieldset" => "Advanced",
		),
		"map_meta_cap" => array(
			"type" => "hidden",
			"value" => true,
			"format" => "bool",
			"fieldset" => "Advanced",
		),
	);
}
