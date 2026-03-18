<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Creates DB schema on activation
 */
function ene_elite_create_db_schema() {
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    // ene_students
    $sql_students = "CREATE TABLE {$wpdb->prefix}ene_students (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned DEFAULT 0,
        admission_no varchar(50) NOT NULL,
        first_name varchar(50) NOT NULL,
        last_name varchar(50) NOT NULL,
        dob date NOT NULL,
        gender varchar(10) NOT NULL,
        blood_group varchar(5) DEFAULT '',
        religion varchar(50) DEFAULT '',
        email varchar(100) DEFAULT '',
        phone varchar(20) DEFAULT '',
        address text DEFAULT '',
        class_id bigint(20) unsigned NOT NULL,
        section_id bigint(20) unsigned NOT NULL,
        parent_id bigint(20) unsigned DEFAULT 0,
        kinship_id bigint(20) unsigned DEFAULT 0,
        status varchar(20) DEFAULT 'active',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY admission_no (admission_no),
        KEY class_id (class_id),
        KEY section_id (section_id)
    ) $charset_collate;";

    // ene_staff
    $sql_staff = "CREATE TABLE {$wpdb->prefix}ene_staff (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned DEFAULT 0,
        employee_id varchar(50) NOT NULL,
        first_name varchar(50) NOT NULL,
        last_name varchar(50) NOT NULL,
        role varchar(50) NOT NULL,
        department varchar(50) DEFAULT '',
        designation varchar(50) DEFAULT '',
        email varchar(100) DEFAULT '',
        phone varchar(20) DEFAULT '',
        basic_salary decimal(10,2) DEFAULT '0.00',
        joining_date date NOT NULL,
        status varchar(20) DEFAULT 'active',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY employee_id (employee_id)
    ) $charset_collate;";

    // ene_classes
    $sql_classes = "CREATE TABLE {$wpdb->prefix}ene_classes (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        section varchar(10) NOT NULL,
        teacher_id bigint(20) unsigned DEFAULT 0,
        tuition_fee decimal(10,2) DEFAULT '0.00',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // ene_fees (Invoices)
    $sql_fees = "CREATE TABLE {$wpdb->prefix}ene_fees (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        student_id bigint(20) unsigned NOT NULL,
        invoice_no varchar(50) NOT NULL,
        title varchar(100) NOT NULL,
        amount decimal(10,2) NOT NULL,
        discount decimal(10,2) DEFAULT '0.00',
        fine decimal(10,2) DEFAULT '0.00',
        total decimal(10,2) NOT NULL,
        paid_amount decimal(10,2) DEFAULT '0.00',
        status varchar(20) DEFAULT 'unpaid',
        due_date date NOT NULL,
        payment_date date DEFAULT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY invoice_no (invoice_no),
        KEY student_id (student_id)
    ) $charset_collate;";

    // ene_attendance
    $sql_attendance = "CREATE TABLE {$wpdb->prefix}ene_attendance (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        user_id bigint(20) unsigned NOT NULL,
        user_type ENUM('student', 'staff') NOT NULL,
        date date NOT NULL,
        status ENUM('present', 'absent', 'late', 'half_day') NOT NULL,
        remarks varchar(255) DEFAULT '',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        UNIQUE KEY date_user (date, user_id, user_type),
        KEY user_id (user_id)
    ) $charset_collate;";

    // ene_exams
    $sql_exams = "CREATE TABLE {$wpdb->prefix}ene_exams (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        term varchar(50) NOT NULL,
        start_date date NOT NULL,
        end_date date NOT NULL,
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    // ene_marks
    $sql_marks = "CREATE TABLE {$wpdb->prefix}ene_marks (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        exam_id bigint(20) unsigned NOT NULL,
        student_id bigint(20) unsigned NOT NULL,
        subject_id bigint(20) unsigned NOT NULL,
        marks_obtained decimal(5,2) NOT NULL,
        total_marks decimal(5,2) NOT NULL,
        grade varchar(5) DEFAULT '',
        gpa decimal(3,2) DEFAULT '0.00',
        remarks varchar(255) DEFAULT '',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY exam_id (exam_id),
        KEY student_id (student_id),
        KEY subject_id (subject_id)
    ) $charset_collate;";

    // ene_expenses
    $sql_expenses = "CREATE TABLE {$wpdb->prefix}ene_expenses (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        title varchar(100) NOT NULL,
        category varchar(50) NOT NULL,
        amount decimal(10,2) NOT NULL,
        expense_date date NOT NULL,
        reference_no varchar(50) DEFAULT '',
        attachment text DEFAULT '',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    dbDelta( $sql_students );
    dbDelta( $sql_staff );
    dbDelta( $sql_classes );
    dbDelta( $sql_fees );
    dbDelta( $sql_attendance );
    dbDelta( $sql_exams );
    dbDelta( $sql_marks );
    dbDelta( $sql_expenses );
}

/* Designed and Developed by Zain Babar */
