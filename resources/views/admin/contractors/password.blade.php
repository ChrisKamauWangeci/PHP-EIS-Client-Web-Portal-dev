<x-admin-layout>

    <h1>Change Password</h1>

    <br />

    <h2>Name: {{ $contractor->C_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.contractors.passwordupdate', $contractor ) }}">
                @csrf
                @method('PATCH')
                <input type="hidden" name="id" value="{{ $contractor->id }}" />

                <x-form.input type="password" name="password" id="password" label="Choose Password" :value="old('password')" required maxlength="15" autocomplete="new-password" />
                <span class="small" id="password_show">show password</span>
                <br />
                <br />

                <x-form.input name="password_confirmation" type="password" id="password_confirmation" label="New Password Confirmation" :value="old('password_confirmation' )" maxlength="15" autocomplete="new-password" required />
                <br />

                <div id="password_helper" class="text-danger small"></div>
                <div id="password_helper_confirm" class="text-danger small"></div>

                <br />

                <x-form.button id="submitbutton">Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    <script src="/js/passwordchange.js"></script>

</x-admin-layout>