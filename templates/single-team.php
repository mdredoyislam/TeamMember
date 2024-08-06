<?php
    get_header();
    $title = get_the_title();
    $content = get_the_content();
    $image = get_the_post_thumbnail(get_the_ID(), 'thumbnail');
    $team_position = get_post_meta(get_the_ID(), 'team_member_position', true);
?>
<div class="team-member single-page">
    <div class="team-content">
        <div class="team-image"><?php echo $image; ?></div>
        <h2> <?php echo $title; ?></h2>
        <p><?php echo $content; ?></p>
        <p><?php echo $team_position; ?></p>
    </div>
</div>
<?php get_footer(); ?>