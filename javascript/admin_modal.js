const modal = document.getElementById('courseModal');
const openBtn = document.getElementById('openCourseBtn');
const closeBtn = document.querySelector('.closeBtn');

// Open modal and set applicant_id in hidden field
openBtn.addEventListener('click', function() {

  // Open the modal
  modal.style.display = 'flex';
});

// Close modal when 'x' is clicked
closeBtn.addEventListener('click', function() {
  modal.style.display = 'none';
});

// Close modal when clicked outside of the modal content
window.addEventListener('click', function(event) {
  if (event.target === modal) {
    modal.style.display = 'none';
  }
});