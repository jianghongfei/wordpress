<?php // H5 custom functions

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once dirname( __FILE__ ) . '/class-tgm-plugin-activation.php';

// default content width
if (!isset($content_width)) $content_width = 960;



// theme support: feed links
add_theme_support('automatic-feed-links');

// theme support: post thumbnails
add_theme_support('post-thumbnails');

// add theme support: custom headers
add_theme_support('custom-header');

// add theme support: custom backgrounds
add_theme_support('custom-background');



// enable widgetized sidebars
if (function_exists('register_sidebar')) {
    register_sidebar(array(
                'name'=> __('Widgets Sidebar', 'h5'),
                'id' => 'widgets_sidebar',
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
                ));
}



// enqueue javascript
if (!function_exists('h5_add_scripts')) {
    function h5_add_scripts() {
        if (is_singular() && comments_open() && (get_option('thread_comments') == 1)) { 
            wp_enqueue_script('comment-reply');
        }
    }
    add_action('wp_enqueue_scripts', 'h5_add_scripts');
}

// register required plugins
if (!function_exists('theme_register_required_plugins')) {
    function theme_register_required_plugins() {
        $plugins = array(
                array(
                    'name'               => 'View CMS', // The plugin name.
                    'slug'               => 'view_cms', // The plugin slug (typically the folder name).
                    'source'             => get_stylesheet_directory() . '/lib/plugins/view_cms.zip', // The plugin source.
                    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
                    'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
                    'force_activation'   => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
                    'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
                    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
                ),
                    
                
                // This is an example of how to include a plugin from the WordPress Plugin Repository.
                array(
                    'name'      => 'Polylang',
                    'slug'      => 'polylang',
                    'required'  => true,
                ),
        );

        /**
         * Array of configuration settings. Amend each line as needed.
         * If you want the default strings to be available under your own theme domain,
         * leave the strings uncommented.
         * Some of the strings are added into a sprintf, so see the comments at the
         * end of each line for what each argument will be.
         */
        $config = array(
                'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
                'default_path' => '',                      // Default absolute path to pre-packaged plugins.
                'menu'         => 'tgmpa-install-plugins', // Menu slug.
                'has_notices'  => true,                    // Show admin notices or not.
                'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
                'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
                'is_automatic' => false,                   // Automatically activate plugins after installation or not.
                'message'      => '',                      // Message to output right before the plugins table.
                'strings'      => array(
                    'page_title'                      => __( 'Install Required Plugins', 'tgmpa' ),
                    'menu_title'                      => __( 'Install Plugins', 'tgmpa' ),
                    'installing'                      => __( 'Installing Plugin: %s', 'tgmpa' ), // %s = plugin name.
                    'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
                    'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'tgmpa' ), // %1$s = plugin name(s).
                    'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'tgmpa' ), // %1$s = plugin name(s).
                    'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'tgmpa' ),
                    'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'tgmpa' ),
                    'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
                    'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
                    'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
                    'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
                    )
                    );

        tgmpa( $plugins, $config );
    }

    add_action('tgmpa_register', 'theme_register_required_plugins');
}
