<?php
/**
 * Plugin Name: EduNexus Elite
 * Description: Advanced Native School Management ERP featuring Glassmorphism UI, Zero-Refresh AJAX, and comprehensive modules for students, academics, finance, and operations.
 * Version: 1.0.0
 * Author: Zain Babar
 * Text Domain: EduNexus-pro
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'EDUNEXUS_ELITE_VERSION', '1.0.0' );
define( 'EDUNEXUS_ELITE_DIR', plugin_dir_path( __FILE__ ) );
define( 'EDUNEXUS_ELITE_URL', plugin_dir_url( __FILE__ ) );

// Include necessary files
require_once EDUNEXUS_ELITE_DIR . 'includes/schema.php';
require_once EDUNEXUS_ELITE_DIR . 'includes/ajax-handler.php';

// Activation Hook
register_activation_hook( __FILE__, 'ene_elite_activate_plugin' );
function ene_elite_activate_plugin() {
    // Create DB Schema
    ene_elite_create_db_schema();
    
    // Auto-create dashboard pages
    ene_elite_create_app_pages();
    
    flush_rewrite_rules();
}

/**
 * Programmatically create app pages
 */
function ene_elite_create_app_pages() {
    $pages = [
        'dashboard'  => [ 'title' => 'EduNexus Elite', 'content' => '[EduNexus_main_app]' ],
        'fees'       => [ 'title' => 'Fees Management', 'content' => '[EduNexus_main_app]' ],
        'attendance' => [ 'title' => 'Attendance Management', 'content' => '[EduNexus_main_app]' ],
        'results'    => [ 'title' => 'Academic Results', 'content' => '[EduNexus_main_app]' ],
        'profile'    => [ 'title' => 'User Profile', 'content' => '[EduNexus_main_app]' ],
        'login'      => [ 'title' => 'EduNexus Login', 'content' => '[EduNexus_main_app]' ],
    ];

    foreach ( $pages as $slug => $data ) {
        $page_check = get_page_by_path( $slug );
        if ( ! isset( $page_check->ID ) ) {
            $new_page = array(
                'post_type'    => 'page',
                'post_title'   => $data['title'],
                'post_content' => $data['content'],
                'post_status'  => 'publish',
                'post_author'  => 1,
                'post_name'    => $slug
            );
            wp_insert_post( $new_page );
        } else {
            // Update title if it doesn't match
            if ( $page_check->post_title !== $data['title'] ) {
                wp_update_post( array(
                    'ID'         => $page_check->ID,
                    'post_title' => $data['title']
                ) );
            }
        }
    }
}

// Template Redirect to bypass theme for app pages
add_action( 'template_redirect', 'ene_elite_load_app_shell' );
function ene_elite_load_app_shell() {
    $dashboard_pages = [ 'dashboard', 'fees', 'attendance', 'results', 'profile', 'login' ];
    
    if ( is_page( $dashboard_pages ) || is_front_page() ) {
        
        // Auth check: If attempting to access dashboard pages while logged out, redirect to login
        if ( ! is_user_logged_in() && ! is_page( 'login' ) ) {
            wp_safe_redirect( get_permalink( get_page_by_path( 'login' ) ) ?: home_url('/?pagename=login') );
            exit;
        }

        // Auth check: If accessing login while ALREADY logged in, redirect to dashboard
        if ( is_user_logged_in() && is_page( 'login' ) ) {
            wp_safe_redirect( home_url( '/' ) );
            exit;
        }

        $app_shell = EDUNEXUS_ELITE_DIR . 'templates/app-shell.php';
        if ( file_exists( $app_shell ) ) {
            include $app_shell;
            exit;
        }
    }
}

// Add to WP Admin Menu
add_action( 'admin_menu', 'ene_elite_add_admin_menu' );
function ene_elite_add_admin_menu() {
    add_menu_page(
        'EduNexus Elite',
        'EduNexus Elite',
        'read', // Changed to read so all logged-in roles can see it, though in a real app you'd specify custom capabilities
        'edunexus-elite',
        'ene_elite_admin_menu_redirect',
        'dashicons-welcome-learn-more',
        30
    );
}

function ene_elite_admin_menu_redirect() {
    echo '<script>window.location.replace("' . home_url('/dashboard') . '");</script>';
    exit;
}

// Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'ene_elite_enqueue_assets' );
function ene_elite_enqueue_assets() {
    $dashboard_pages = [ 'dashboard', 'fees', 'attendance', 'results', 'profile', 'login' ];
    if ( is_page( $dashboard_pages ) || is_front_page() ) {
        wp_enqueue_style( 'ene-elite-google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null );
        wp_enqueue_style( 'ene-elite-style', EDUNEXUS_ELITE_URL . 'assets/css/style.css', array(), EDUNEXUS_ELITE_VERSION );
        wp_enqueue_script( 'chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), '4.0', true );
        wp_enqueue_script( 'ene-elite-script', EDUNEXUS_ELITE_URL . 'assets/js/app.js', array( 'jquery', 'chart-js' ), EDUNEXUS_ELITE_VERSION, true );
        
        wp_localize_script( 'ene-elite-script', 'eneEliteSettings', array(
            'ajaxurl'   => admin_url( 'admin-ajax.php' ),
            'nonce'     => wp_create_nonce( 'ene_elite_ajax_nonce' ),
            'dashboard' => home_url( '/' )
        ) );
    }
}

// Shortcode handling (fallback, though template_redirect will technically bypass the content rendering if it takes over fully)
add_shortcode( 'EduNexus_main_app', 'ene_elite_main_app_shortcode' );
function ene_elite_main_app_shortcode() {
    return '<!-- EduNexus App Root -->';
}

/* Designed and Developed by Zain Babar */
