<?php
/*
Plugin Name: Team Member
Plugin URI: https://redoyit.com/
Description: Team Member Plugin
Version: 1.0
Requires at least: 5.8
Requires PHP: 5.6.20
Author: Md. Redoy Islam
Author URI: https://redoyit.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: teammember
Domain Path: /languages
*/

//Plugin Assets Diroctory
define('TEAM_ASSETS_DIR', plugin_dir_url(__FILE__).'assets/');
define('TEAM_ASSETS_PUBLIC_DIR', TEAM_ASSETS_DIR.'public/');
define('TEAM_ASSETS_PUBLIC_JS_DIR', TEAM_ASSETS_PUBLIC_DIR.'js/');
define('TEAM_ASSETS_PUBLIC_CSS_DIR', TEAM_ASSETS_PUBLIC_DIR.'css/');
define('TEAM_ASSETS_PUBLIC_IMG_DIR', TEAM_ASSETS_PUBLIC_DIR.'images/');
define('TEAM_ASSETS_ADMIN_DIR', TEAM_ASSETS_DIR.'admin/');
define('TEAM_ASSETS_ADMIN_JS_DIR', TEAM_ASSETS_ADMIN_DIR.'js/');
define('TEAM_ASSETS_ADMIN_CSS_DIR', TEAM_ASSETS_ADMIN_DIR.'css/');
define('TEAM_ASSETS_ADMIN_IMG_DIR', TEAM_ASSETS_ADMIN_DIR.'images/');
define('TEAM_VERSION', time());

class TeamMember{
    private $version;
    function __construct(){
        $this->version = time();
        add_action('plugin_loaded', array($this, 'load_textdomain'));
        add_action('wp_enqueue_scripts', array($this, 'load_front_assets'));
        add_action('admin_enqueue_scripts', array($this, 'load_admin_assets'));
        add_action('admin_menu', array($this, 'team_add_metabox'));
        add_action('save_post', array($this, 'team_save_metabox'));
    }

    function load_textdomain(){
        load_plugin_textdomain('teammember', false, dirname(__FILE__) . '/languages');
    }

    function load_admin_assets(){
        $admin_css_files = array(
            'admin-style-main' => array('path'=>TEAM_ASSETS_ADMIN_CSS_DIR.'admin-style.css'),
        );
        foreach($admin_css_files as $handle=>$fileinfo){
            wp_enqueue_style($handle, $fileinfo['path'], $this->version);
        }
    }
    function load_front_assets(){

        $css_files = array(
            'style-main' => array('path'=>TEAM_ASSETS_PUBLIC_CSS_DIR.'style-main.css'),
        );
        foreach($css_files as $handle=>$fileinfo){
            wp_enqueue_style($handle, $fileinfo['path'], $this->version);
        }

        $js_files = array(
            'team-main-script' => array('path'=>TEAM_ASSETS_PUBLIC_JS_DIR.'main-script.js', 'dep'=> array('jquery')),
        );
        foreach($js_files as $handle=>$fileinfo){
            wp_enqueue_script($handle, $fileinfo['path'], $fileinfo['dep'], $this->version, true);
        }

    }

    private function is_secured($nonce_field, $action, $post_id){
        
        $nonce = isset($_POST[$nonce_field])? $_POST[$nonce_field]:'';
        if($nonce==''){
            return false;
        }
        if(!wp_verify_nonce($nonce, $action)){
            return false;
        }
        if(!current_user_can('edit_post', $post_id)){
            return false;
        }
        if(wp_is_post_autosave($post_id)){
            return false;
        }
        if(wp_is_post_revision($post_id)){
            return false;
        }
        return true;
    }

    function team_save_metabox($post_id){

        if(! $this->is_secured('team_member_position_field', 'team_member_position', $post_id)){
            return $post_id;
        }
        $team_position = isset($_POST['team_member_position'])? $_POST['team_member_position']:'';

        if($team_position==''){
            return $post_id;
        }

        $team_position = sanitize_text_field($team_position);

        update_post_meta( $post_id, 'team_member_position', $team_position);

    }
    function team_add_metabox(){
        add_meta_box('team_post_location', 
        __('Team Extra Info', 'ourmetabox'),
            array($this, 'team_display_metabox'),
            'team_member',
            'normal',
            'default'
        );

        $page_title = __('Documentation', 'teammember');
        $menu_title = __('Documentation', 'teammember');
        $capability = 'manage_options';
        $slug = 'teammember';
        $callback = array($this, 'teammember_settings_content');
        add_submenu_page('edit.php?post_type=team_member', $page_title, $menu_title, $capability, $slug, $callback);
    }

    function teammember_settings_content(){
        require_once plugin_dir_path(__FILE__)."inc/team-shortcode-doc.php";
    }

    function team_display_metabox($post){

        $team_position = get_post_meta($post->ID, 'team_member_position', true);

        $team_label = __('Team Member Position', 'ourmetabox');
        wp_nonce_field('team_member_position', 'team_member_position_field'); 

        $metabox_html = <<<EOD
            <p>
                <label class="member-label" for="team_member_position">{$team_label}</label>
                <input class="member-position" type="text" name="team_member_position" id="team_member_position" value="{$team_position}" />
            </p>
        EOD;

        echo $metabox_html;
    }


}
new TeamMember();


require_once plugin_dir_path(__FILE__)."inc/post-type.php";
require_once plugin_dir_path(__FILE__)."shortcode/shortcode.php";
require_once plugin_dir_path(__FILE__)."inc/manage-column.php";


function single_team_template($file){
    global $post;
    
    if('team_member' == $post->post_type){
        $file_path = plugin_dir_path(__FILE__).'templates/single-team.php';
        $file = $file_path;
    }
    return $file;
}
add_filter('single_template', 'single_team_template');
