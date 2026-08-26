<x-app-layout title="">

    <script>
        function passwordValidate(password) {

            var help = '';
            var password_helper = document.getElementById("password_helper");
            var password_confirm = document.getElementById("passwordconfirm").value;
            var password_helper_confirm = document.getElementById("password_helper_confirm");

            if (password.length == 0) {
                password_helper.innerHTML = '';
                password_helper_confirm.innerHTML = '';
                document.getElementById("submitbutton").disabled = true;
                return;
            }

            if (password.length < 8) {
                help = 'Password minimum 8 characters<br />';
            }

            if (!new RegExp("[a-z]").test(password)) {
                help += 'At least one lowercase letter<br />';
            }
            if (!new RegExp("[A-Z]").test(password)) {
                help += 'At least one uppercase letter<br />';
            }
            if (!new RegExp("[0-9]").test(password)) {
                help += 'At least one number<br />';
            }
            if (!new RegExp("[!@#\$%&*\?]").test(password)) {
                help += 'At least one special characters !@#$%&*? <br />';
            }

            if (password.match(/[^a-zA-Z0-9!@#\$%&*\?]$/)) {
                help += 'Only use letters numbers and !@#$%&*? characters<br />';
            }

            if (password_confirm == password) {
                password_helper_confirm.innerHTML = '';
            }
            if (password_confirm != password) {
                password_helper_confirm.innerHTML = 'Password and Password Confirm do not match';
            }

            if (help != '') {
                document.getElementById("submitbutton").disabled = true;
            } else {
                document.getElementById("submitbutton").disabled = false;
            }

            password_helper.innerHTML = help;

        }

        function passwordConfirm(password_confirm) {

            var password_confirm_help = '';
            var password = document.getElementById("C_Password").value;

            var noError = document.getElementById('password_helper').innerHTML === '';

            var password_helper = document.getElementById("password_helper");
            var password_helper_confirm = document.getElementById("password_helper_confirm");

            if (password_confirm.length == 0) {
                password_helper_confirm.innerHTML = '';
                document.getElementById("submitbutton").disabled = true;
                return;
            }

            if (password_confirm != password) {
                password_confirm_help = 'Password and Password Confirm do not match';
                document.getElementById("submitbutton").disabled = true;
            }

            if (password_confirm == password) {
                password_confirm_help = '';
            }

            if (noError && password_confirm_help == '') {
                document.getElementById("submitbutton").disabled = false;
            }

            password_helper_confirm.innerHTML = password_confirm_help;

        }

        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById("submitbutton").disabled = true;

            const eyeBtn = document.getElementById('eye_btn');
            eyeBtn.style.cursor = 'pointer';
            eyeBtn.classList.add('input-password-hide');
            eyeBtn.addEventListener('click', function() {
                document.getElementById('C_Password').setAttribute('type', 'text');
                document.getElementById('passwordconfirm').setAttribute('type', 'text');
            });

        });
    </script>

    <br />

    <div class="row">
        <div class="col-lg-5 col-md-7 col-sm-9">

            <h3>Password Reset</h3>

            Email: {{ $passwordreset->email }}

            <form method="post"
                  action="{{ route('passwordresets.update', $passwordreset->id) }}">
                @method('PUT')
                @csrf
                <input type="hidden"
                       name="token"
                       value="{{ $passwordreset->token }}">

                <br />

                <x-form.input name="C_Password"
                              label="Password"
                              id="C_Password"
                              type="password"
                              required
                              maxlength="13"
                              onkeyup="passwordValidate(this.value)" />
                <span class="small"
                      id="eye_btn">show password</span>

                <br />
                <br />

                <x-form.input name="passwordconfirm"
                              label="Password Confirm"
                              id="passwordconfirm"
                              type="password"
                              required
                              maxlength="13"
                              onkeyup="passwordConfirm(this.value)" />

                <br />

                <div id="password_helper"
                     class="text-danger small"></div>
                <div id="password_helper_confirm"
                     class="text-danger small"></div>

                <br />

                <x-form.button id="submitbutton">Submit</x-form.button>

            </form>

        </div>
    </div>

    <br />
    <br />

    <br />
    <br />

</x-app-layout>
