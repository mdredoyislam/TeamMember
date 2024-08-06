<?php
add_action( 'init', function() {
	register_taxonomy( 'member-type', array(
	0 => 'team_member',
    ), array(
        'labels' => array(
            'name' => 'Member Type',
            'singular_name' => 'Member Type',
            'menu_name' => 'Member Type',
            'all_items' => 'All Member Type',
            'edit_item' => 'Edit Member Type',
            'view_item' => 'View Member Type',
            'update_item' => 'Update Member Type',
            'add_new_item' => 'Add New Member Type',
            'new_item_name' => 'New Member Type Name',
            'search_items' => 'Search Member Type',
            'popular_items' => 'Popular Member Type',
            'separate_items_with_commas' => 'Separate member type with commas',
            'add_or_remove_items' => 'Add or remove member type',
            'choose_from_most_used' => 'Choose from the most used member type',
            'not_found' => 'No member type found',
            'no_terms' => 'No member type',
            'items_list_navigation' => 'Member Type list navigation',
            'items_list' => 'Member Type list',
            'back_to_items' => '← Go to member type',
            'item_link' => 'Member Type Link',
            'item_link_description' => 'A link to a member type',
        ),
        'public' => true,
        'hierarchical' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'show_tagcloud' => false,
        'show_admin_column' => true,
        'sort' => true,
    ) );
} );

add_action( 'init', function() {
	register_post_type( 'team_member', array(
        'labels' => array(
            'name' => 'Team Member',
            'singular_name' => 'Team Member',
            'menu_name' => 'Team Member',
            'all_items' => 'All Team Member',
            'edit_item' => 'Edit Team Member',
            'view_item' => 'View Team Member',
            'view_items' => 'View Team Member',
            'add_new_item' => 'Add New Member',
            'add_new' => 'Add New Member',
            'new_item' => 'New Team Member',
            'parent_item_colon' => 'Parent Team Member:',
            'search_items' => 'Search Team Member',
            'not_found' => 'No team member found',
            'not_found_in_trash' => 'No team member found in Trash',
            'archives' => 'Team Member Archives',
            'attributes' => 'Team Member Attributes',
            'featured_image' => 'Profile Image',
            'set_featured_image' => 'Set Profile Image',
            'remove_featured_image' => 'Remove Profile Image',
            'use_featured_image' => 'Use Profile Image',
            'insert_into_item' => 'Insert into team member',
            'uploaded_to_this_item' => 'Uploaded to this team member',
            'filter_items_list' => 'Filter team member list',
            'filter_by_date' => 'Filter team member by date',
            'items_list_navigation' => 'Team Member list navigation',
            'items_list' => 'Team Member list',
            'item_published' => 'Team Member published.',
            'item_published_privately' => 'Team Member published privately.',
            'item_reverted_to_draft' => 'Team Member reverted to draft.',
            'item_scheduled' => 'Team Member scheduled.',
            'item_updated' => 'Team Member updated.',
            'item_link' => 'Team Member Link',
            'item_link_description' => 'A link to a team member.',
        ),
        'public' => true,
        'exclude_from_search' => true,
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-buddicons-buddypress-logo',
        'supports' => array(
            0 => 'title',
            1 => 'editor',
            2 => 'thumbnail',
        ),
        'delete_with_user' => false,
    ) );
} );

add_filter( 'enter_title_here', function( $default, $post ) {
	switch ( $post->post_type ) {
		case 'team_member':
			return 'Name';
	}
	return $default;
}, 10, 2 );