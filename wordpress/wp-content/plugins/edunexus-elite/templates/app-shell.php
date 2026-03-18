<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$current_user = wp_get_current_user();
$today = date('l, M j, Y');

function ene_get_page_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/?pagename=' . $slug);
}

$dashboard_url  = ene_get_page_url('dashboard');
$profile_url    = ene_get_page_url('profile');
$attendance_url = ene_get_page_url('attendance');
$results_url    = ene_get_page_url('results');
$fees_url       = ene_get_page_url('fees');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduNexus Elite - Dashboard</title>
    <?php wp_head(); ?>
</head>
<body class="ene-elite-app">

    <?php if ( is_page('login') ) : ?>
        <div class="ene-login-container">
            <div class="ene-login-card">
                <div class="ene-logo-center">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#7E5BF2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    <h2>EduNexus Pro</h2>
                </div>
                <p class="login-subtitle">Sign in to your account</p>
                
                <form id="ene-login-form">
                    <div class="pe-form-group">
                        <label>Username</label>
                        <input type="text" name="log" required>
                    </div>
                    <div class="pe-form-group">
                        <label>Password</label>
                        <input type="password" name="pwd" required>
                    </div>
                    <div id="login-message" style="display:none; font-size: 13.5px; margin-bottom: 15px; text-align: center; border-radius: 6px; padding: 10px;"></div>
                    <button type="submit" class="pe-btn-primary" style="width: 100%;">Sign In</button>
                </form>
                
                <div class="login-footer">
                    <small>Powered by EduNexus. Dedicated to Excellence.</small>
                </div>
            </div>
        </div>
    <?php else : ?>

    <div class="ene-wrapper">
        
        <!-- Sidebar Navigation -->
        <aside class="ene-sidebar">
            <div class="ene-logo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#7E5BF2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                <h2>EduNexus Pro</h2>
            </div>
            
            <nav class="ene-nav">
                <ul>
                    <li><a href="<?php echo esc_url($dashboard_url); ?>" class="<?php echo is_page('dashboard') ? 'active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                        Dashboard
                    </a></li>
                    <li><a href="<?php echo esc_url($profile_url); ?>" class="<?php echo is_page('profile') ? 'active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Students
                    </a></li>
                    <li><a href="<?php echo esc_url($profile_url); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Staff
                    </a></li>
                    <li><a href="<?php echo esc_url($dashboard_url); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Classes
                    </a></li>
                    <li><a href="<?php echo esc_url($attendance_url); ?>" class="<?php echo is_page('attendance') ? 'active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        Attendance
                    </a></li>
                    <li><a href="<?php echo esc_url($results_url); ?>" class="<?php echo is_page('results') ? 'active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        Academics
                    </a></li>
                    <li><a href="<?php echo esc_url($fees_url); ?>" class="<?php echo is_page('fees') ? 'active' : ''; ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M7 15h0M2 9.5h20"/></svg>
                        Finance
                    </a></li>
                    <li><a href="<?php echo esc_url($dashboard_url); ?>">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                        Reports
                    </a></li>
                </ul>
                <div class="sidebar-footer">
                    <ul>
                        <li><a href="#">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                            Settings
                        </a></li>
                        <li><a href="#">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                            Help
                        </a></li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="ene-main">
            <!-- Header -->
            <header class="ene-header">
                <div class="header-titles">
                    <h1>Dashboard Overview</h1>
                    <span class="date"><?php echo $today; ?></span>
                </div>
                
                <div class="header-actions">
                    <div class="search-box">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6F7B91" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <input type="text" placeholder="Search">
                    </div>
                    
                    <button class="icon-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </button>
                    
                    <button class="icon-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span class="badge"></span>
                    </button>
                    
                    <div class="user-profile">
                        <img src="<?php echo get_avatar_url($current_user->ID); ?>" alt="Avatar" class="avatar">
                        <div class="user-info">
                            <span class="name">Dr. Eleanor Vance</span>
                            <span class="role">Principal</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="ene-content">
                
                <!-- Top KPI Cards -->
                <div class="kpi-grid">
                    <div class="kpi-card blue-card">
                        <div class="kpi-header">
                            <h3>Total Students</h3>
                            <div class="kpi-icon blue-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            </div>
                        </div>
                        <div class="kpi-body">
                            <div class="value">1,482</div>
                            <div class="trend positive">↗ +3.2%</div>
                        </div>
                    </div>
                    
                    <div class="kpi-card green-card">
                        <div class="kpi-header">
                            <h3>Active Staff</h3>
                            <div class="kpi-icon green-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
                            </div>
                        </div>
                        <div class="kpi-body">
                            <div class="value">115</div>
                            <div class="trend text-green">98% present</div>
                        </div>
                    </div>
                    
                    <div class="kpi-card yellow-card">
                        <div class="kpi-header">
                            <h3>Classes</h3>
                            <div class="kpi-icon yellow-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                        </div>
                        <div class="kpi-body">
                            <div class="value">56</div>
                            <div class="trend text-yellow">8 active this hour</div>
                        </div>
                    </div>
                </div>

                <!-- Middle Charts -->
                <div class="charts-grid">
                    <div class="panel chart-panel enrollment">
                        <div class="panel-header">
                            <h3>Enrollment Trends</h3>
                            <button class="dots">•••</button>
                        </div>
                        <div class="panel-body">
                            <canvas id="enrollmentChart" height="250"></canvas>
                        </div>
                    </div>
                    
                    <div class="panel chart-panel attendance">
                        <div class="panel-header">
                            <h3>Attendance Overview</h3>
                            <button class="dots">•••</button>
                        </div>
                        <div class="panel-body canvas-wrapper">
                            <canvas id="attendanceChart" height="250"></canvas>
                            <div class="attendance-legend">
                                <span><span class="dot green"></span> 94.5%<br><small>Present</small></span>
                                <span><span class="dot red"></span> 3.2%<br><small>Absent</small></span>
                                <span><span class="dot yellow"></span> 2.3%<br><small>Late</small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Sections -->
                <div class="bottom-grid">
                    <div class="panel events-panel">
                        <div class="panel-header">
                            <h3>Upcoming Events</h3>
                            <button class="dots">•••</button>
                        </div>
                        <div class="panel-body">
                            <div class="event-card">
                                <div class="event-info">
                                    <h4>Science Fair</h4>
                                    <span>Nov 5 day</span>
                                </div>
                                <div class="event-date">Nov 5</div>
                            </div>
                            <div class="event-card">
                                <div class="event-info">
                                    <h4>Parent Conf</h4>
                                    <span>Oct. 20, 2024</span>
                                </div>
                                <div class="event-date">Oct 30</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="panel activity-panel">
                        <div class="panel-header">
                            <h3>Recent Activity</h3>
                            <button class="dots">•••</button>
                        </div>
                        <div class="panel-body activity-list">
                            <div class="activity-item">
                                <div class="activity-icon green-bg">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </div>
                                <div class="activity-text">
                                    <h4>Class 10A Attendance</h4>
                                    <span>Attendance marked</span>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon red-bg">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </div>
                                <div class="activity-text">
                                    <h4>New Announcement</h4>
                                    <span>Added by Principal</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    
    <?php endif; ?>

    <?php wp_footer(); ?>
</body>
</html>
