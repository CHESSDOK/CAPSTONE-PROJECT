 //update job
 const jobupdateModal = document.getElementById('jobupdateModal');
 const thridcloseModuleBtn = document.querySelector('.thirdclosBtn');

 // Open profile modal and load data via AJAX
 $(document).on('click', '#openUpdateBtn', function(e) {
     e.preventDefault();
     const jobId = $(this).data('job-id');
     
     $.ajax({
         url: '../../html/adminpage/job_details.php',
         method: 'GET',
         data: { job_id: jobId },
         success: function(response) {
             $('#updatejobdetail').html(response);
             jobupdateModal.style.display = 'flex';
         }
     });
 });

 // Close profile modal when 'x' is clicked
 thridcloseModuleBtn.addEventListener('click', function() {
    jobupdateModal.style.display = 'none';
 });

 // Close profile modal when clicking outside the modal content
 window.addEventListener('click', function(event) {
     if (event.target === jobupdateModal) {
        jobupdateModal.style.display = 'none';
     }
 });
