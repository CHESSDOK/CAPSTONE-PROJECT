
            document.addEventListener('DOMContentLoaded', function() {
                // Event listener for opening the interview modal
                document.querySelectorAll('.openFormBtn').forEach(button => {
                    button.addEventListener('click', function() {
                        const applicantId = this.getAttribute('data-applicant-id');
                        const jobId = this.getAttribute('data-job-id');
        
                        // Set the applicant ID and job ID in the modal form
                        document.getElementById('applicantId').value = applicantId;
                        document.getElementById('jobid').value = jobId;
        
                        // Display the modal
                        document.getElementById('formModal').style.display = 'block';
                    });
                });
        
                // Close modal logic
                const closeBtn = document.querySelector('.closeBtn');
                closeBtn.addEventListener('click', function() {
                    document.getElementById('formModal').style.display = 'none';
                });
        
                // Close modal when clicking outside of modal content
                window.onclick = function(event) {
                    const modal = document.getElementById('formModal');
                    if (event.target === modal) {
                        modal.style.display = 'none';
                    }
                };
                });