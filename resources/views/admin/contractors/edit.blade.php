<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Contractor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.contractors.show', $contractor->id) }}" class="btn btn-sm btn-secondary">View Contractor</a>
        </div>
    </div>

    <br />

    <h2>{{ $contractor->C_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.contractors.update', $contractor->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="C_Email" label="Email" id="C_Email" :value="old('C_Email', $contractor->C_Email)" />
                <br />

                <x-form.input name="C_Cell" label="Cell" id="C_Cell" :value="old('C_Cell', $contractor->C_Cell)" />
                <br />

                <x-form.select name="C_Location" label="Location" :options="Helper::locations()" empty="-" :default="old('C_Location', $contractor->C_Location)" />
                <br />

                @php
                $options = [
                    0 => 'Regular User',
                    1 => 'Admin',
                ];
                @endphp
                <x-form.select name="accesslevel" label="Access Level" :options="$options" :default="$contractor->accesslevel" />

                <br />

                <x-form.checkbox name="C_SysAdmin" label="Is Admin" :checked="$contractor->C_SysAdmin" />

                <x-form.checkbox name="C_Caller" label="Is Caller" :checked="$contractor->C_Caller" />

                <x-form.checkbox name="C_Invoice" label="Is Invoice" :checked="$contractor->C_Invoice" />

                <x-form.checkbox name="access_files" label="Access Files" :checked="$contractor->access_files" />

                <x-form.checkbox name="access_mfa" label="Access MFA" :checked="$contractor->access_mfa" />

                <x-form.checkbox name="is_active" label="Is Active" :checked="$contractor->is_active" />

                <br />

                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select formn-select-sm">
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ $contractor->hasRole($role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />
    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            contractor
            @php unset($contractor->C_Password); @endphp
            @php dump(@$contractor); @endphp
        </div>
    @endif

</x-admin-layout>
