<x-admin-layout>

    <div class="row">
        <div class="col-auto">
            <h1>Edit Requestor</h1>
        </div>
        <div class="col text-end d-print-none">
            <a href="{{ route('admin.requestors.show', $requestor->R_ID) }}" class="btn btn-sm btn-secondary">View Requestor</a>
        </div>
    </div>

    <br />

    <h2>{{ $requestor->R_Name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.requestors.update', $requestor->R_ID) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="R_LoginEmail" id="R_LoginEmail" label="Login" :value="old('R_LoginEmail', $requestor->R_LoginEmail)" onkeyup="this.value = this.value.toLowerCase();" />
                <br />

                <x-form.input name="R_Email" id="R_Email" label="Email" :value="old('R_Email', $requestor->R_Email)" />
                <br />

                <x-form.input name="R_SSOID" id="R_SSOID" label="SSOID" :value="old('R_SSOID', $requestor->R_SSOID)" />
                <br />

                <x-form.checkbox name="R_Active" id="R_Active" label="Active" :checked="old('R_Active', $requestor->R_Active)" />
                <br />

                <x-form.checkbox name="R_SuperUser" id="R_SuperUser" label="SuperUser" :checked="old('R_SuperUser', $requestor->R_SuperUser)" />
                <br />

                <x-form.checkbox name="R_ViewRecords" id="R_ViewRecords" label="ViewRecords" :checked="old('R_ViewRecords', $requestor->R_ViewRecords)" />
                <br />

                <x-form.checkbox name="R_NoOrder" id="R_NoOrder" label="NoOrder" :checked="old('R_NoOrder', $requestor->R_NoOrder)" />
                <br />

                <x-form.select name="requestorrole_id" label="Requestor Role" :options="$requestorroles" empty="-" :default="$requestor->requestorrole_id" />
                <br />

                <x-form.select name="websiteconfig_id" label="Website Config" :options="$websiteconfigs" empty="-" :default="$requestor->websiteconfig_id" />
                <br />

                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

    @if ($adminsession['debug'])
        <div class="bg-light small p-2 d-print-none">
            requestor
            @php dump(@$requestor) @endphp
        </div>
    @endif

</x-admin-layout>
