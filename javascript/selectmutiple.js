document.addEventListener('DOMContentLoaded', function() {
    const selectElement = document.getElementById('dynamicSelect');
    const newOptionInput = document.getElementById('newOption');
    const addButton = document.getElementById('addButton');
    const newOptionContainer = document.getElementById('newOptionContainer');
    const selectedOptionsList = document.getElementById('selectedOptionsList');
    const form = document.getElementById('optionsForm');
    const selectedOptionsHidden = document.getElementById('selectedOptionsHidden'); // The hidden input field

    let selectedOptions = new Set(); // Use a Set to store unique selected options

    // Function to update the displayed selected options
    function updateSelectedOptions() {
        selectedOptionsList.innerHTML = ''; // Clear the current list
        
        // Loop through selected options and display them
        selectedOptions.forEach(optionValue => {
            const listItem = document.createElement('li');
            listItem.textContent = optionValue;
            listItem.addEventListener('click', function() {
                removeOption(optionValue); // Allow removing option on click
            });
            selectedOptionsList.appendChild(listItem);
        });

        // Update the hidden field with selected options
        updateHiddenField();
    }

    // Remove option from the selected options
    function removeOption(optionValue) {
        selectedOptions.delete(optionValue); // Remove from set
        updateSelectedOptions(); // Update display
    }

    // Toggle option in the selected options
    function toggleOption(optionValue) {
        if (selectedOptions.has(optionValue)) {
            removeOption(optionValue); // If already selected, remove it
        } else {
            selectedOptions.add(optionValue); // If not selected, add it
        }
        updateSelectedOptions(); // Update display
    }

    // Show the input field when "Add a new option..." is selected
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

    // Add new option to the select when the button is clicked
    addButton.addEventListener('click', function() {
        const newOptionValue = newOptionInput.value.trim();
        if (newOptionValue) {
            // Create a new option element
            const newOption = document.createElement('option');
            newOption.value = newOptionValue;
            newOption.textContent = newOptionValue;
            
            // Add the new option to the select element
            selectElement.appendChild(newOption);

            // Automatically add and select the newly added option
            toggleOption(newOptionValue);
            selectElement.value = ''; // Reset the select value

            // Clear the input field and hide it again
            newOptionInput.value = '';
            newOptionContainer.style.display = 'none';

            updateSelectedOptions(); // Update the displayed options
        } else {
            alert('Please enter a valid option.');
        }
    });

    // Function to update the hidden input field with selected options
    function updateHiddenField() {
        selectedOptionsHidden.value = Array.from(selectedOptions).join(','); // Convert Set to comma-separated string
    }

    // Update the hidden input field before form submission
    form.addEventListener('submit', function(event) {
        updateHiddenField(); // Make sure the hidden field is updated before submission
        console.log("Selected options: " + selectedOptionsHidden.value); // Debugging output
    });
});