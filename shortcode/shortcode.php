<?php
function team_shortcode_list($arguments){
    // Shortcode attributes with defaults
    $defaults = array(
        'number'    => 3,
        'img_pos'   => 'top', // 'top' or 'bottom'
        'see_all'   => 'true'
    );
    $attributes = shortcode_atts( $defaults, $arguments, 'team_members');
    // Query to fetch team members
    $team_args = array(
        'post_type'      => 'team_member',
        'posts_per_page' => $attributes['number'],
    );
    $teamQuery = new WP_Query($team_args);

    // Start output buffering
    ob_start();

    if ($teamQuery->have_posts()) {

        echo '<div class="team-members">';

        while ($teamQuery->have_posts()) {
            $teamQuery->the_post();
            $title = get_the_title();
            $content = get_the_content();
            $image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
            $team_position = get_post_meta(get_the_ID(), 'team_member_position', true);
            $permalink = get_the_permalink();

            // Template based on img_pos attribute
            if ($attributes['img_pos'] === 'bottom') {
                echo '<div class="team-member">
                        <div class="team-content">
                            <h2><a href="'.$permalink.'">' . $title . '</a></h2>
                            <p>' . $content . '</p>
                            <p>' . $team_position . '</p>
                        </div>
                        <div class="team-image"> <a href="'.$permalink.'">' . $image . '</a></div>
                        </div>';
            } else {
                echo '<div class="team-member">
                        <div class="team-image"> <a href="'.$permalink.'">' . $image . '</a></div>
                        <div class="team-content">
                            <h2><a href="'.$permalink.'">' . $title . '</a></h2>
                            <p>' . $content . '</p>
                            <p>' . $team_position . '</p>
                        </div>
                        </div>';
            }
        }

        echo '</div>';
        // Display 'See All' button if see_all attribute is true
        if ($attributes['see_all'] === 'true') {
            echo '<div class="see-all-button"><a href="' . get_post_type_archive_link('team-member') . '">See All Team Members</a></div>';
        }
        
    } else {
        echo '<p>No team members found.</p>';
    }
    // Reset post data
    wp_reset_postdata();

    // Return the output buffer content
    return ob_get_clean();
}
add_shortcode('team_members','team_shortcode_list');

//[team_members number="5" img_pos="bottom" see_all="false"]