const form = document.getElementById('form');
        
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const submitButton = document.getElementById('submitbutton');

        const emailError = document.getElementById('emailerror');
        const passwordError = document.getElementById('passworderror');
        
        emailField.onkeyup = () => {
            if(emailField.value.trim() === '') {
                emailError.textContent = 'Email is required';
            } else {
                emailError.textContent = '';
            }
        };
        emailField.onkeypress = (event) => {
            if(event.key === ' ') {
                event.preventDefault();
                emailError.textContent = 'Spaces not allowed';
            } else {
                emailError.textContent = '';
            }
        };   
        
        form.addEventListener('login', (event) => {
            event.preventDefault();
            let isValid = true;

            // Reset errors
            emailError.textContent = '';
            passwordError.textContent = '';
            
            // Validate email
            if (emailField.value.trim() === '') {
                emailError.textContent = 'Please enter student email.';
                isValid = false;
            }

            // Validate Password
            if (passwordField.value.trim() === '') {
                passwordError.textContent = 'Please enter student password.';
                isValid = false;
            }
    
            // If the form is valid
            if (isValid) {
                form.reset();
            }
        });