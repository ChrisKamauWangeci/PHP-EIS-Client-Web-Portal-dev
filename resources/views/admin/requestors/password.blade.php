<x-admin-layout>

    <h1>Change Password</h1>

    <br />

    <h2>Name: {{ $requestor->R_Name }}</h2>
    <h3>Company: {{ $requestor->R_Company }}</h3>
    <h4>Login: {{ $requestor->R_LoginEmail }}</h4>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.requestors.passwordupdate', $requestor) }}">
                @csrf
                @method('PATCH')
                <input type="hidden"
                       name="R_ID"
                       value="{{ $requestor->R_ID }}" />

                <x-form.input type="password"
                              name="password"
                              id="password"
                              label="Choose Password"
                              :value="old('password')"
                              required
                              maxlength="20"
                              autocomplete="new-password" />
                <span class="small"
                      id="password_show">show password</span>
                <br />
                <br />

                <x-form.input type="password"
                              name="password_confirmation"
                              id="password_confirmation"
                              label="New Password Confirmation"
                              :value="old('password_confirmation')"
                              maxlength="20"
                              autocomplete="new-password"
                              required />
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

    <script src="/js/passwordchange.js"></script>

</x-admin-layout>
