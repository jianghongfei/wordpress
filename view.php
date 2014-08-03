<?php
/**
 * Plugin Name: View
 * Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
 * Description: A brief description of the Plugin.
 * Version: 1.0
 * Author: Jiang Hongfei <jiang.hongfei@gmail.com>
 * Author URI: http://URI_Of_The_Plugin_Author
 * License: A "Slug" license name e.g. GPL2
 */

/******************************************************************************
 * widget from http://codex.wordpress.org/Widgets_API
 *****************************************************************************/

/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    function __construct() {
        parent::__construct(
            'foo_widget', // Base ID
            __('Widget Title', 'text_domain'), // Name
            array( 'description' => __( 'A Foo Widget', 'text_domain' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo __( 'Hello, World!', 'text_domain' );
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }
        else {
            $title = __( 'New title', 'text_domain' );
        }
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <?php 
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        return $instance;
    }

} // class Foo_Widget

// register Foo_widget widget
add_action( 'widgets_init', function() {
    register_widget( 'Foo_Widget' );
});


/******************************************************************************
 * admin menu from http://codex.wordpress.org/Administration_Menus
 *****************************************************************************/

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Settings:
    add_options_page(__('Test Settings','menu-test'), __('Test Settings','menu-test'), 'manage_options', 'testsettings', 'mt_settings_page');

    // Add a new submenu under Tools:
    add_management_page( __('Test Tools','menu-test'), __('Test Tools','menu-test'), 'manage_options', 'testtools', 'mt_tools_page');

    // Add a new top-level menu (ill-advised):
    add_menu_page(__('Test Toplevel','menu-test'), __('Test Toplevel','menu-test'), 'manage_options', 'mt-top-level-handle', 'mt_toplevel_page' );

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Test Sublevel','menu-test'), __('Test Sublevel','menu-test'), 'manage_options', 'sub-page', 'mt_sublevel_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', __('Test Sublevel 2','menu-test'), __('Test Sublevel 2','menu-test'), 'manage_options', 'sub-page2', 'mt_sublevel_page2');
}

// mt_settings_page() displays the page content for the Test settings submenu
function mt_settings_page() {
    echo "<h2>" . __( 'Test Settings', 'menu-test' ) . "</h2>";
}

// mt_tools_page() displays the page content for the Test Tools submenu
function mt_tools_page() {
    echo "<h2>" . __( 'Test Tools', 'menu-test' ) . "</h2>";
}

// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {
    echo "<h2>" . __( 'Test Toplevel', 'menu-test' ) . "</h2>";
}

// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    echo "<h2>" . __( 'Test Sublevel', 'menu-test' ) . "</h2>";
}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function mt_sublevel_page2() {
    echo "<h2>" . __( 'Test Sublevel2', 'menu-test' ) . "</h2>";
}

/******************************************************************************
 * customizing admin dashboard:
 * http://code.tutsplus.com/articles/customizing-the-wordpress-admin-the-dashboard--wp-33110
 *****************************************************************************/

// remove unwanted dashboard widgets for relevant users,
// in this case, users other than administrator
function wptutsplus_remove_dashboard_widgets() {
    $user = wp_get_current_user();
    //if ( ! $user->has_cap( 'manage_options' ) ) {
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');//since 3.8
    //}
}
add_action( 'wp_dashboard_setup', 'wptutsplus_remove_dashboard_widgets' );
//Remove  WordPress Welcome Panel
remove_action('welcome_panel', 'wp_welcome_panel');

// Move the 'Right Now' dashboard widget to the right hand side
function wptutsplus_move_dashboard_widget() {
    $user = wp_get_current_user();
    if ( ! $user->has_cap( 'manage_options' ) ) {
        global $wp_meta_boxes;
        $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;
    }
}
add_action( 'wp_dashboard_setup', 'wptutsplus_move_dashboard_widget' );

// add new dashboard widgets
function wptutsplus_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'wptutsplus_dashboard_welcome', 'Welcome', 'wptutsplus_add_welcome_widget' );
    wp_add_dashboard_widget( 'wptutsplus_dashboard_links', 'Useful Links', 'wptutsplus_add_links_widget' );
}
function wptutsplus_add_welcome_widget(){ ?>
 
    This content management system lets you edit the pages and posts on your website.
 
    Your site consists of the following content, which you can access via the menu on the left:
 
    <ul>
        <li><strong>Pages</strong> - static pages which you can edit.</li>
        <li><strong>Posts</strong> - news or blog articles - you can edit these and add more.</li>
        <li><strong>Media</strong> - images and documents which you can upload via the Media menu on the left or within each post or page.</li>
    </ul>
 
    On each editing screen there are instructions to help you add and edit content.
 
<?php }
 
function wptutsplus_add_links_widget() { ?>
 
    Some links to resources which will help you manage your site:
 
    <ul>
        <li><a href="http://wordpress.org">The WordPress Codex</a></li>
        <li><a href="http://easywpguide.com">Easy WP Guide</a></li>
        <li><a href="http://www.wpbeginner.com">WP Beginner</a></li>
    </ul>
<?php }
add_action( 'wp_dashboard_setup', 'wptutsplus_add_dashboard_widgets' );
