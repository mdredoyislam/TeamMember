<?php

    //Education Post Custom Columns
    function team_team_member_columns( $columns ){

        unset($columns['date']);
        $columns['title'] = __('Name', 'teammember');
        $columns['position'] = __('Member Position', 'teammember');
        $columns['profileimage'] = __('Profile Image', 'teammember');
        $columns['date'] = __('Date', 'teammember');

        return $columns;
    }
    add_filter('manage_team_member_posts_columns', 'team_team_member_columns');

    function team_team_member_columns_data($column, $post_id){

        if('position' == $column){

            echo get_post_meta($post_id, 'team_member_position', true);

        }else if('profileimage' == $column){

            //echo get_post_meta($post_id, 'name_of_company', true);
            $thumbnail = get_the_post_thumbnail($post_id, array(100,100), array('class'=>'profile-image'));
            echo $thumbnail;

        }

    }
    add_action('manage_team_member_posts_custom_column', 'team_team_member_columns_data', 10, 2);