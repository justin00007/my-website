            const form = document.getElementById('registrationForm');
            const nameField = document.getElementById('name');
            const emailField = document.getElementById('email');
            const phoneField = document.getElementById('phone');
            const classField = document.getElementById('class');
            const regnumField = document.getElementById('regnum');
            const passwordField = document.getElementById('password');
            const genderField = document.getElementById('gender');
            const termsCheckbox = document.getElementById('terms');
            const submitButton = document.getElementById('submitbutton');

            const nameError = document.getElementById('nameerror');
            const emailError = document.getElementById('emailerror');
            const phoneError = document.getElementById('phoneerror');
            const classError = document.getElementById('classerror');
            const regnumError = document.getElementById('regnumerror');
            const passwordError = document.getElementById('passworderror');
            const genderError = document.getElementById('gendererror');
            const termsError = document.getElementById('termserror');
            
            submitButton.disabled = true;

            // Enable or disable the submit button based on the checkbox
            termsCheckbox.addEventListener('change', () => {
                submitButton.disabled = !termsCheckbox.checked;
            });
        
            form.addEventListener('submit', (event) => {
                event.preventDefault(); // Prevent default submission
                let isValid = true;

                // Reset all error messages
                nameError.textContent = '';
                emailError.textContent = '';
                phoneError.textContent = '';
                classError.textContent = '';
                regnumError.textContent = '';
                passwordError.textContent = '';
                genderError.textContent = '';
                termsError.textContent = '';

                // Validate Full Name
                if (nameField.value.trim() === '') {
                    nameError.textContent = 'Name is required.';
                    isValid = false;
                }

                // Validate Email
                const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                if (!emailPattern.test(emailField.value.trim())) {
                    emailError.textContent = 'Enter a valid email.';
                    isValid = false;
                }

                // Validate Phone
                if (!/^\d{10}$/.test(phoneField.value.trim())) {
                    phoneError.textContent = 'Enter a valid 10-digit phone number.';
                    isValid = false;
                }

                // Validate Class
                if (classField.value.trim() === '') {
                    classError.textContent = 'Class is required.';
                    isValid = false;
                }

                // Validate Registration Number
                if (regnumField.value.trim() === '') {
                    regnumError.textContent = 'Registration number is required.';
                    isValid = false;
                }

                // Validate Password
                if (passwordField.value.trim().length < 8) {
                    passwordError.textContent = 'Password must be at least 8 characters.';
                    isValid = false;
                }

                // Validate Gender
                if (genderField.value === '') {
                    genderError.textContent = 'Select a gender.';
                    isValid = false;
                }

                // Validate Terms and Conditions
                if (!termsCheckbox.checked) {
                    termsError.textContent = 'You must agree to the terms and conditions.';
                    isValid = false;
                    
                }
                
                // If valid, submit the form
                if (isValid) {
                    
                    submitButton.disable=false;
                    form.submit();
                }
                
            });