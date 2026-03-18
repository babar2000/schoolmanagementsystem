/*
 * EduNexus Elite Scripts
 * Initializes Chart.js and interactive dashboard elements.
 */

jQuery(document).ready(function($) {

    // --- ENROLLMENT TRENDS LINE CHART ---
    const ctxEnrollment = document.getElementById('enrollmentChart');
    if (ctxEnrollment) {
        
        // Create Gradient for Line Fill
        const gradient = ctxEnrollment.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(0, 210, 255, 0.4)');
        gradient.addColorStop(1, 'rgba(0, 210, 255, 0.01)');

        new Chart(ctxEnrollment, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [{
                    label: 'Enrollment',
                    data: [65, 690, 165, 138, 193, 1482, 288, 233, 178, 532],
                    borderColor: '#00D2FF',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#00D2FF',
                    pointBorderColor: '#FFFFFF',
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Smooth curves
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1C2033',
                        titleColor: '#8E9BB0',
                        bodyColor: '#FFFFFF',
                        borderColor: '#2D334D',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        yAlign: 'bottom'
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { color: '#8E9BB0', font: { size: 12 } }
                    },
                    y: {
                        grid: { color: '#2D334D', drawBorder: false },
                        ticks: { 
                            color: '#8E9BB0', 
                            font: { size: 12 },
                            stepSize: 50,
                            callback: function(value) { return value; }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // --- ATTENDANCE OVERVIEW DOUGHNUT CHART ---
    const ctxAttendance = document.getElementById('attendanceChart');
    if (ctxAttendance) {
        new Chart(ctxAttendance, {
            type: 'doughnut',
            data: {
                labels: ['Present', 'Absent', 'Late'],
                datasets: [{
                    data: [94.5, 3.2, 2.3],
                    backgroundColor: [
                        '#2BE796', // Green
                        '#F43F5E', // Red
                        '#F5C549'  // Yellow
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%', // Make it thin
                plugins: {
                    legend: { display: false }, // Legend is custom HTML
                    tooltip: {
                        backgroundColor: '#1C2033',
                        bodyColor: '#FFFFFF',
                        callbacks: {
                            label: function(context) {
                                return ' ' + context.label + ': ' + context.raw + '%';
                            }
                        }
                    }
                }
            }
        });
    }

    // --- LOGIN FORM SUBMISSION ---
    $('#ene-login-form').on('submit', function(e) {
        e.preventDefault();
        const $btn = $(this).find('button[type="submit"]');
        const $msg = $('#login-message');
        
        $btn.text('Authenticating...').prop('disabled', true);
        $msg.hide();
        
        const data = {
            action: 'ene_elite_login',
            nonce: eneEliteSettings.nonce,
            log: $('input[name="log"]').val(),
            pwd: $('input[name="pwd"]').val()
        };
        
        $.post(eneEliteSettings.ajaxurl, data, function(response) {
            if (response.success) {
                $msg.css({background: 'rgba(43,231,150,0.15)', color: '#2BE796'}).html('✅ ' + response.data.message).fadeIn();
                setTimeout(() => {
                    window.location.href = eneEliteSettings.dashboard;
                }, 1000);
            } else {
                $msg.css({background: 'rgba(244,63,94,0.15)', color: '#F43F5E'}).html('❌ ' + response.data.message).fadeIn();
                $btn.text('Sign In').prop('disabled', false);
            }
        }).fail(function() {
            $msg.css({background: 'rgba(244,63,94,0.15)', color: '#F43F5E'}).html('❌ A server error occurred.').fadeIn();
            $btn.text('Sign In').prop('disabled', false);
        });
    });

});
