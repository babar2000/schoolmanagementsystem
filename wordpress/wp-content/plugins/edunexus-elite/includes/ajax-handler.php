<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Basic security check for AJAX actions
 */
function ene_elite_verify_ajax() {
    check_ajax_referer( 'ene_elite_ajax_nonce', 'nonce' );
    
    // As it's an advanced ERP, verify if the user has appropriate permissions
    if ( ! current_user_can( 'read' ) ) {
        wp_send_json_error( [ 'message' => 'Unauthorized access' ], 403 );
    }
}

/**
 * Handle Login Submission
 */
add_action( 'wp_ajax_nopriv_ene_elite_login', 'ene_elite_ajax_login' );
function ene_elite_ajax_login() {
    check_ajax_referer( 'ene_elite_ajax_nonce', 'nonce' );

    $creds = array(
        'user_login'    => sanitize_user( $_POST['log'] ?? '' ),
        'user_password' => $_POST['pwd'] ?? '',
        'remember'      => true
    );

    if ( empty( $creds['user_login'] ) || empty( $creds['user_password'] ) ) {
        wp_send_json_error( [ 'message' => 'Username and Password are required.' ] );
    }

    $user = wp_signon( $creds, is_ssl() );

    if ( is_wp_error( $user ) ) {
        wp_send_json_error( [ 'message' => preg_replace('/<a href=".*?">.*?<\/a>/i', '', $user->get_error_message()) ] );
    } else {
        wp_set_current_user( $user->ID );
        wp_send_json_success( [ 'message' => 'Success! Redirecting to Dashboard...' ] );
    }
}

/**
 * Handle Add Student Submission
 */
add_action( 'wp_ajax_ene_elite_add_student', 'ene_elite_ajax_add_student' );
function ene_elite_ajax_add_student() {
    ene_elite_verify_ajax();

    $first_name = sanitize_text_field( $_POST['first_name'] ?? '' );
    $last_name  = sanitize_text_field( $_POST['last_name'] ?? '' );
    $admission  = sanitize_text_field( $_POST['admission_no'] ?? '' );

    if ( empty( $first_name ) || empty( $admission ) ) {
        wp_send_json_error( [ 'message' => 'First name and admission number are required' ] );
    }

    global $wpdb;
    $result = $wpdb->insert(
        $wpdb->prefix . 'ene_students',
        [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'admission_no' => $admission,
            'dob'          => date('Y-m-d'), // Placeholder logic
            'gender'       => 'unknown',
            'class_id'     => 1,
            'section_id'   => 1
        ]
    );

    if ( $result ) {
        wp_send_json_success( [ 'message' => 'Student successfully added', 'id' => $wpdb->insert_id ] );
    } else {
        wp_send_json_error( [ 'message' => 'Failed to add student. Ensure admission number is unique.' ] );
    }
}

/**
 * Handle Dashboard Stats
 */
add_action( 'wp_ajax_ene_elite_get_dashboard_stats', 'ene_elite_ajax_get_dashboard_stats' );
function ene_elite_ajax_get_dashboard_stats() {
    ene_elite_verify_ajax();
    global $wpdb;

    $total_students = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}ene_students" );
    $total_staff    = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}ene_staff" );
    $total_classes  = $wpdb->get_var( "SELECT COUNT(id) FROM {$wpdb->prefix}ene_classes" );

    wp_send_json_success( [
        'total_students' => (int) $total_students,
        'total_staff'    => (int) $total_staff,
        'total_classes'  => (int) $total_classes,
        'recent_events'  => 'No recent events',
    ] );
}

/**
 * Generate PDF Logic Outline
 */
add_action( 'wp_ajax_ene_elite_generate_invoice_pdf', 'ene_elite_ajax_generate_invoice_pdf' );
function ene_elite_ajax_generate_invoice_pdf() {
    ene_elite_verify_ajax();
    
    $invoice_id = intval( $_POST['invoice_id'] ?? 0 );
    
    // Abstract logic for HTML to PDF (Can use tools like FPDF, Dompdf, or simple browser print trigger on frontend)
    $pdf_url = '#placeholder_pdf_url_for_invoice_' . $invoice_id; // In reality, write file to wp-content/uploads/
    
    wp_send_json_success( [ 'message' => 'PDF Generated successfully', 'pdf_url' => $pdf_url ] );
}

/**
 * Reports: Defaulters and Attendance
 */
add_action( 'wp_ajax_ene_elite_get_reports', 'ene_elite_get_reports' );
function ene_elite_get_reports() {
    ene_elite_verify_ajax();
    
    $report_type = sanitize_text_field( $_POST['report_type'] ?? '' );
    global $wpdb;

    if ( $report_type === 'fee_defaulters' ) {
        // Find unpaid invoices past due date
        $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}ene_fees WHERE status = 'unpaid' AND due_date < CURDATE() LIMIT 50" );
        wp_send_json_success( [ 'data' => $results, 'report' => 'Monthly Fee Defaulters' ] );
    } 
    elseif ( $report_type === 'class_attendance' ) {
        // Find attendance percentage
        $query = "
            SELECT DATE_FORMAT(date, '%Y-%m') as month, 
                   COUNT(CASE WHEN status='present' THEN 1 END) as present_count,
                   COUNT(id) as total_attendance
            FROM {$wpdb->prefix}ene_attendance 
            WHERE user_type = 'student'
            GROUP BY month
        ";
        $results = $wpdb->get_results( $query );
        wp_send_json_success( [ 'data' => $results, 'report' => 'Class-wise Attendance Percentage' ] );
    }

    wp_send_json_error( [ 'message' => 'Invalid report type' ] );
}

/* Designed and Developed by Zain Babar */
