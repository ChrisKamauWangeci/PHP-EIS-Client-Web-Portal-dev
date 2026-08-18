<x-app-layout title="">

    <h1>Admin Login</h1>

    <div class="row">
        <div class="col-11 col-sm-6 col-md-5 col-lg-4">

            <form method="post" action="{{ route('authadmin.in') }}">
                @csrf

                <x-form.input name="C_Name" label="Name" :value="old('C_Name')"  maxlength="50" required />

                <br />

                <x-form.input name="C_Password" label="Password" type="password" maxlength="50" required />

                <br />

                <x-form.button>Submit</x-form.button>

            </form>

            @if($errors->any())
            <div class="py-4 text-danger">{{$errors->first()}}</div>
            @endif

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    <small>IP Address: {{ request()->ip() }}</small>

</x-app-layout>