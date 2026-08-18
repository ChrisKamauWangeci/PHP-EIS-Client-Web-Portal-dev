<x-user-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit EHR Order</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('user.ehrorders.show', $ehrorder->id) }}" class="btn btn-sm btn-secondary">View EHR Orders</a>
        </div>
    </div>

    <br />

    <h2>{{ $ehrorder->id }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('user.ehrorders.update', $ehrorder->id ) }}">
                @csrf
                @method('PATCH')

                <br />

                Service Provider
                <br />
                <strong>{{ $ehrorder->service_provider }}</strong>
                <br />
                <br />

                <x-form.select name="service_provider" label="Service Provider" id="service_provider" :options="Helper::ehrproviders()" empty="-" :default="old('service_provider', $ehrorder->service_provider)" required />
                <br />

                Workorder ID
                <br />
                <strong>{{ $ehrorder->workorder_id }}</strong>
                <br />
                <br />

                <x-form.input name="workorder_id" id="workorder_id" label="Workorder ID" :value="old('workorder_id', $ehrorder->workorder_id)" required />
                <br />


                Company Name
                <br />
                <strong>{{ $ehrorder->company_name }}</strong>
                <br />
                <br />

                <x-form.input name="company_name" id="company_name" label="Company Name" :value="old('company_name', $ehrorder->company_name)" required />
                <br />

                <x-form.input name="first_name" id="first_name" label="First Name" :value="old('first_name', $ehrorder->first_name)" required />
                <br />

                <x-form.input name="middle_name" id="middle_name" label="Middle Name" :value="old('middle_name', $ehrorder->middle_name)" />
                <br />

                <x-form.input name="last_name" id="last_name" label="Last Name" :value="old('last_name', $ehrorder->last_name)" required />
                <br />

                <x-form.input name="social_security_number" id="social_security_number" label="Social Security Number" :value="old('social_security_number', $ehrorder->social_security_number)" />
                <br />

                <x-form.input name="gender" id="gender" label="Gender" :value="old('gender', $ehrorder->gender)" />
                <br />

                <x-form.input type="date" name="birth_date" id="birth_date" label="Birth Date" :value="old('birth_date', $ehrorder->birth_date ? $ehrorder->birth_date->format('Y-m-d') : '')" />
                <br />

                <x-form.input name="email_address" id="email_address" label="Email Address" :value="old('email_address', $ehrorder->email_address)" />
                <br />

                <x-form.input name="home_phone" id="home_phone" label="Home Phone" :value="old('home_phone', $ehrorder->home_phone)" />
                <br />

                <x-form.input name="cell_phone" id="cell_phone" label="Cell Phone" :value="old('cell_phone', $ehrorder->cell_phone)" />
                <br />

                <x-form.input name="address" id="address" label="Address" :value="old('address', $ehrorder->address)" />
                <br />

                <x-form.input name="address_2" id="address_2" label="Address 2" :value="old('address_2', $ehrorder->address_2)" />
                <br />

                <x-form.input name="city" id="city" label="City" :value="old('city', $ehrorder->city)" />
                <br />

                <x-form.input name="state" id="state" label="State" :value="old('state', $ehrorder->state)" />
                <br />

                <x-form.input name="zip_code" id="zip_code" label="Zip Code" :value="old('zip_code', $ehrorder->zip_code)" />
                <br />

                <x-form.input type="date" name="date_of_service_from" id="date_of_service_from" label="Date of Service From" :value="old('date_of_service_from', $ehrorder->date_of_service_from ? $ehrorder->date_of_service_from->format('Y-m-d') : '')" />
                <br />

                <x-form.input name="auth_file_path" id="auth_file_path" label="Auth File Path" :value="old('auth_file_path', $ehrorder->auth_file_path)" />
                <br />

                <x-form.input name="submission_type" id="submission_type" label="Submission Type" :value="old('submission_type', $ehrorder->submission_type)" />
                <br />

                <x-form.input name="status" id="status" label="Status" :value="old('status', $ehrorder->status)" />
                <br />

                <x-form.input name="submitted_at" id="submitted_at" label="Submitted At" :value="old('submitted_at', $ehrorder->submitted_at)" />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-user-layout>