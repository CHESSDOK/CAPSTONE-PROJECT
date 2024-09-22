const employmentStatus = document.getElementById('employment-status');
        const subDropdown = document.getElementById('sub-dropdown');
        const employmentType = document.getElementById('employment-type');
        const additionalInput = document.getElementById('additional-input');

        employmentStatus.addEventListener('change', function() {
            const value = this.value;

            if (value === 'employed') {
                subDropdown.style.display = 'block';
                employmentType.innerHTML = `
                    <option value="">Select</option>
                    <option value="wage">Wage Employed</option>
                    <option value="self">Self Employed</option>
                `;
                additionalInput.style.display = 'none'; // Hide additional input
            } else if (value === 'unemployed') {
                subDropdown.style.display = 'block';
                employmentType.innerHTML = `
                    <option value="">Select</option>
                    <option value="fresh_grad" class="unemployed-option">New Entrant/Fresh Graduate</option>
                    <option value="f_contract" class="unemployed-option">Finished Contract</option>
                    <option value="resigned" class="unemployed-option">Resigned</option>
                    <option value="retired" class="unemployed-option">Retired</option>
                    <option value="local" class="unemployed-option">Terminated/Laidoff (local)</option>
                    <option value="abroad" class="unemployed-option">Terminated/Laidoff (abroad)</option>
                    <option value="others" class="unemployed-option">Others, specify</option>
                `;
                additionalInput.style.display = 'none'; // Hide additional input initially
            } else {
                subDropdown.style.display = 'none';
                employmentType.innerHTML = '<option value="">Select</option>'; // Reset sub-dropdown
                additionalInput.style.display = 'none'; // Hide additional input
            }
        });

        employmentType.addEventListener('change', function() {
            const selectedValue = this.value;

            if (selectedValue === 'abroad' || selectedValue === 'others') {
                additionalInput.style.display = 'block'; // Show additional input
            } else {
                additionalInput.style.display = 'none'; // Hide additional input
            }
        });
// Disability input handling
const disabilitySelect = document.getElementById('pwd');
        const disabilityInput = document.getElementById('disability-input');

        disabilitySelect.addEventListener('change', function() {
            const disabilityValue = this.value;

            if (disabilityValue === 'Others') {
                disabilityInput.style.display = 'block'; // Show disability input
            } else {
                disabilityInput.style.display = 'none'; // Hide disability input
            }
        });
                 // Handling 'Are you actively looking for work?'
         const activelyLookingSelect = document.getElementById('actively-looking');
         const activelyLookingInput = document.getElementById('actively-looking-input');

         activelyLookingSelect.addEventListener('change', function() {
           const value = this.value;
           if (value === 'Yes') {
             activelyLookingInput.style.display = 'block'; // Show input
           } else {
             activelyLookingInput.style.display = 'none'; // Hide input
           }
         });
     
         // Handling 'Willing to work immediately?'
         const willingToWorkSelect = document.getElementById('willing-to-work');
         const willingToWorkInput = document.getElementById('willing-to-work-input');
     
         willingToWorkSelect.addEventListener('change', function() {
           const value = this.value;
           if (value === 'No') {
             willingToWorkInput.style.display = 'block'; // Show input
           } else {
             willingToWorkInput.style.display = 'none'; // Hide input
           }
         });

        // Hide sub-dropdown on page load if no selection
        window.onload = function() {
            subDropdown.style.display = 'none';
            additionalInput.style.display = 'none'; // Hide additional 
            disabilityInput.style.display = 'none'; // Hide disability input
            activelyLookingInput.style.display = 'none';
            willingToWorkInput.style.display = 'none';
        };