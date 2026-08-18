const passwordInput = document.getElementById('password');
const passwordConfirmationInput = document.getElementById('password_confirmation');
const passwordHelper = document.getElementById('password_helper');
const passwordHelperConfirm = document.getElementById('password_helper_confirm');
const submitButton = document.getElementById('submitbutton');
const passwordShow = document.getElementById('password_show');

function passwordValidate(password) {
    let help = '';
    const password_confirmation = passwordConfirmationInput ? passwordConfirmationInput.value : '';

    if (!passwordHelper || !passwordHelperConfirm || !submitButton) return;

    if (password.length === 0) {
        passwordHelper.innerHTML = '';
        passwordHelperConfirm.innerHTML = '';
        submitButton.disabled = true;
        return;
    }

    if (password.length < 8) {
        help = 'Password minimum 8 characters<br />';
    }
    if (!/[a-z]/.test(password)) {
        help += 'At least one lowercase letter<br />';
    }
    if (!/[A-Z]/.test(password)) {
        help += 'At least one uppercase letter<br />';
    }
    if (!/[0-9]/.test(password)) {
        help += 'At least one number<br />';
    }
    if (!/[!@#\$%&*\?]/.test(password)) {
        help += 'At least one special characters !@#$%&*? <br />';
    }
    if (/[^a-zA-Z0-9!@#\$%&*\?]/.test(password)) {
        help += 'Only use letters numbers and !@#$%&*? characters<br />';
    }

    if (password_confirmation === password) {
        passwordHelperConfirm.innerHTML = '';
    } else {
        passwordHelperConfirm.innerHTML = 'Password and Confirm Password do not match';
    }

    submitButton.disabled = help !== '';
    passwordHelper.innerHTML = help;
}

function passwordConfirm(password_confirmation) {
    let password_confirmation_help = '';
    const password = passwordInput ? passwordInput.value : '';
    const noError = passwordHelper && passwordHelper.innerHTML === '';

    if (!passwordHelper || !passwordHelperConfirm || !submitButton) return;

    if (password_confirmation.length === 0) {
        passwordHelperConfirm.innerHTML = '';
        submitButton.disabled = true;
        return;
    }

    if (password_confirmation !== password) {
        password_confirmation_help = 'Password and Confirm Password do not match';
        submitButton.disabled = true;
    } else {
        password_confirmation_help = '';
    }

    if (noError && password_confirmation_help === '') {
        submitButton.disabled = false;
    }

    passwordHelperConfirm.innerHTML = password_confirmation_help;
}

document.addEventListener('DOMContentLoaded', function() {
    if (submitButton) submitButton.disabled = true;

    if (passwordShow && passwordInput) {
        passwordShow.style.cursor = 'pointer';
        passwordShow.classList.add('input-password-hide');
        passwordShow.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordShow.textContent = 'hide password';
            } else {
                passwordInput.type = 'password';
                passwordShow.textContent = 'show password';
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('keyup', function() {
            passwordValidate(this.value);
        });
    }
    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener('keyup', function() {
            passwordConfirm(this.value);
        });
    }
});
