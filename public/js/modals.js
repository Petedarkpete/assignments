$(document).ready(function() {
    $('.open-student-modal').on('click', function() {
        const parentId = $(this).data('parent-id');
        const studentCardsContainer = $('#studentCards');
        const loadingState = $('#loadingState');
        const emptyState = $('#emptyState');

        // Clear previous content
        studentCardsContainer.find('.student-card:not(#studentCardTemplate)').remove();
        emptyState.hide();

        // Show loading state
        loadingState.show();

        // Fetch student data (replace with your actual endpoint)
        $.ajax({
            url: `/parents/${parentId}/students`, // Adjust URL as needed
            method: 'GET',
            success: function(response) {
                loadingState.hide();

                if (response.students && response.students.length > 0) {
                    populateStudentCards(response.students);
                } else {
                    emptyState.show();
                }
            },
            error: function(xhr, status, error) {
                loadingState.hide();
                console.error('Error fetching student data:', error);

                // Show error state or empty state
                emptyState.find('h5').text('Error Loading Students');
                emptyState.find('p').text('There was an error loading student information. Please try again.');
                emptyState.show();
            }
        });
    });

    function populateStudentCards(students) {
        const template = document.getElementById('studentCardTemplate');
        const container = document.getElementById('studentCards');

        students.forEach((student, index) => {
            // Clone the template
            const card = template.cloneNode(true);
            card.style.display = 'block';
            card.id = `studentCard_${student.id}`;

            // Add staggered animation delay
            card.style.animationDelay = `${index * 0.1}s`;

            // Populate student data
            card.querySelector('#studentName').textContent = student.name || 'Unknown Student';
            card.querySelector('#studentClass').textContent = student.class || 'Not Assigned';
            card.querySelector('#studentTeacher').textContent = student.teacher || 'Not Assigned';

            // Handle assignments with progress bar
            const assignmentsSpan = card.querySelector('#studentAssignments');
            const progressBar = card.querySelector('#assignmentProgress');

            if (student.assignments_completed && student.total_assignments) {
                const completed = student.assignments_completed;
                const total = student.total_assignments;
                const percentage = (completed / total) * 100;

                assignmentsSpan.textContent = `${completed}/${total} completed`;
                progressBar.style.width = `${percentage}%`;

                // Change color based on progress
                if (percentage >= 80) {
                    progressBar.style.background = 'linear-gradient(90deg, #28a745, #20c997)';
                } else if (percentage >= 60) {
                    progressBar.style.background = 'linear-gradient(90deg, #ffc107, #fd7e14)';
                } else {
                    progressBar.style.background = 'linear-gradient(90deg, #dc3545, #c82333)';
                }
            } else {
                assignmentsSpan.textContent = student.assignments || 'No data';
                progressBar.style.width = '0%';
            }

            // Handle performance field
            const performanceSpan = card.querySelector('#studentPerformance');
            if (student.performance) {
                performanceSpan.textContent = student.performance;

                // Color code performance
                const performance = student.performance.toLowerCase();
                if (performance.includes('excellent') || performance.includes('outstanding')) {
                    performanceSpan.style.background = 'linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(32, 201, 151, 0.2) 100%)';
                    performanceSpan.style.borderLeftColor = '#28a745';
                } else if (performance.includes('good') || performance.includes('satisfactory')) {
                    performanceSpan.style.background = 'linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(253, 126, 20, 0.2) 100%)';
                    performanceSpan.style.borderLeftColor = '#ffc107';
                } else if (performance.includes('needs improvement') || performance.includes('poor')) {
                    performanceSpan.style.background = 'linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(200, 35, 51, 0.2) 100%)';
                    performanceSpan.style.borderLeftColor = '#dc3545';
                }
            } else {
                performanceSpan.textContent = 'Not Available';
            }

            // Append to container
            container.appendChild(card);
        });
    }

    // Add smooth scroll for modal body when there are many students
    $('#studentModal').on('shown.bs.modal', function() {
        const modalBody = $(this).find('.modal-body');
        if (modalBody[0].scrollHeight > modalBody[0].clientHeight) {
            modalBody.css('scrollbar-width', 'thin');
        }
    });

    // Reset modal state when closed
    $('#studentModal').on('hidden.bs.modal', function() {
        $('#studentCards').find('.student-card:not(#studentCardTemplate)').remove();
        $('#loadingState').hide();
        $('#emptyState').hide();
    });
});
