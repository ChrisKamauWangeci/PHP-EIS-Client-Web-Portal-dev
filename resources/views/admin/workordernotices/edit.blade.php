<x-admin-layout>

    <h1>Edit Workorder Notice</h1>

    <h2>{{ $workordernotice->id }}</h2>
    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post" action="{{ route('admin.workordernotices.update', $workordernotice->id ) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="workorder_id" id="workorder_id" label="workorder_id" :value="old('workorder_id', $workordernotice->workorder_id)" />
                <br />

                <x-form.input name="type" id="type" label="type" :value="old('type', $workordernotice->type)" />
                <br />

                <x-form.input name="user_before" id="user_before" label="user_before" :value="old('user_before', $workordernotice->user_before)" />
                <br />

                <x-form.input name="recipient" id="recipient" label="recipient" :value="old('recipient', $workordernotice->recipient)" />
                <br />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>