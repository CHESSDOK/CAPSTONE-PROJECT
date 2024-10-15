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

             initializeDynamic2Select();
         }
     });
 });

 function initializeDynamic2Select() {
    const selectElement = document.getElementById('dynamicSelect');
    const newOptionInput = document.getElementById('newOption');
    const addButton = document.getElementById('addButton');
    const newOptionContainer = document.getElementById('newOptionContainer');
    const selectedOptionsList = document.getElementById('selectedOptionsList');
    const form = document.getElementById('optionsForm');
    const selectedOptionsHidden = document.getElementById('selectedOptionsHidden');

    let selectedOptions = new Set(); // Use a Set to store unique selected options

    function updateSelectedOptions() {
        selectedOptionsList.innerHTML = ''; // Clear the current list
        selectedOptions.forEach(optionValue => {
            const listItem = document.createElement('li');
            listItem.textContent = optionValue;
            listItem.addEventListener('click', function() {
                removeOption(optionValue); // Allow removing option on click
            });
            selectedOptionsList.appendChild(listItem);
        });
        updateHiddenField();
    }

    function removeOption(optionValue) {
        selectedOptions.delete(optionValue); // Remove from set
        updateSelectedOptions(); // Update display
    }

    function toggleOption(optionValue) {
        if (selectedOptions.has(optionValue)) {
            removeOption(optionValue); // If already selected, remove it
        } else {
            selectedOptions.add(optionValue); // If not selected, add it
        }
        updateSelectedOptions(); // Update display
    }

    selectElement.addEventListener('change', function() {
        const selectedValue = selectElement.value;
        if (selectedValue === 'add') {
            newOptionContainer.style.display = 'block';
            newOptionInput.focus(); // Focus on the input field
        } else {
            newOptionContainer.style.display = 'none';
            toggleOption(selectedValue); // Toggle the selection state of the option
            selectElement.value = ''; // Reset the select value
        }
    });

    addButton.addEventListener('click', function() {
        const newOptionValue = newOptionInput.value.trim();
        if (newOptionValue) {
            const newOption = document.createElement('option');
            newOption.value = newOptionValue;
            newOption.textContent = newOptionValue;
            selectElement.appendChild(newOption);
            toggleOption(newOptionValue);
            selectElement.value = ''; // Reset the select value
            newOptionInput.value = '';
            newOptionContainer.style.display = 'none';
            updateSelectedOptions();
        } else {
            alert('Please enter a valid option.');
        }
    });

    function updateHiddenField() {
        selectedOptionsHidden.value = Array.from(selectedOptions).join(','); // Convert Set to comma-separated string
    }

    form.addEventListener('submit', function(event) {
        updateHiddenField(); // Update the hidden field before submission
    });
}

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
