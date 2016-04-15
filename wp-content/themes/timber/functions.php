<?php

    //
    // Load WP Config files
    //

    // Theme Options
    include_once 'setup/theme-options/theme-options.php';

    // Helpers
    include_once 'setup/helper-env.php';
    include_once 'setup/helper-rev.php';

    // Post Types
    // include_once 'setup/cpt-heroes.php';

    // Taxonomies
    // include_once 'setup/tax-featured.php';

    // Custom Twig filters
    include_once 'setup/filter-dummy.php';
    include_once 'setup/filter-twitterify.php';

    add_filter('get_twig', 'add_to_twig');

    function add_to_twig($twig) {
        /* this is where you can add your own fuctions to twig */
        $twig->addFilter('dummy', new Twig_Filter_Function('apply_dummy_filter'));
        $twig->addFilter('twitterify', new Twig_Filter_Function('twitterify'));
        return $twig;
    }

    //
    // Wordpress Theme Support Config
    // REMOVAL OF THESE = POTIENTAL LOSS OF DATA
    //

    add_theme_support('post-formats');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');

    // Enable Roots Soil

    add_theme_support('soil-clean-up');
    add_theme_support('soil-relative-urls');
    add_theme_support('soil-disable-trackbacks');
    add_theme_support('soil-nice-search');

    //
    // Add Menus to Timber
    //
    register_nav_menus(array(
        'header' => 'Header Navigation'
    ));

    function header_menus( $data ) {
        $data["header_menus"] = new TimberMenu('header');

        return $data;
    }

    //
    // Global Variables added to timber
    //
    function global_variables( $data ) {
        // First load from theme options
        $data["gv"] = get_theme_mods();
        // Add any others that we want in version control
        $data["gv"]["ga_id"] = "";
        $data["gv"]["fb_app_id"] = "";
        $data["gv"]["gtm_id"] = "";

        return $data;
    }

    //
    // WP Admin Customization
    //

    // Show pages list in DESC order by edit date, not alphabetical
    function set_post_order_in_admin( $wp_query ) {
        global $pagenow;
        if ( is_admin() && 'edit.php' == $pagenow && !isset($_GET['orderby'])) {
            $wp_query->set( 'orderby', 'modified' );
            $wp_query->set( 'order', 'DSC' );
        }
    }
    add_filter('pre_get_posts', 'set_post_order_in_admin' );

    // Don't show WP SEO stuff in post list
    add_filter( 'wpseo_use_page_analysis', '__return_false' );

    // Lower WP SEO Priority so it's at the bottom:
    function lower_wpseo_priority() {
        return 'low';
    }
    add_filter( 'wpseo_metabox_prio', 'lower_wpseo_priority' );

    //
    // Allows upload to Media Library with these file types
    //

    function custom_mime_types($mimes) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
    add_filter('upload_mimes', 'custom_mime_types');

    //
    // Action/Filter Triggers
    //

    add_filter( 'timber_context', 'header_menus' );
    add_filter( 'timber_context', 'global_variables' );

    //
    // Globals
    //
    define('THEME_URL', get_template_directory_uri());
?>
