<x-admin-layout>

    <h1>Edit Websiteconfig</h1>

    <br />

    <h2>{{ $websiteconfig->name }}</h2>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.websiteconfigs.update', $websiteconfig->id) }}">
                @csrf
                @method('PATCH')

                <x-form.input name="name"
                              id="name"
                              label="name"
                              :value="old('name', $websiteconfig->name)" />
                <br />

                <x-form.checkbox name="show_order"
                                 label="show_order"
                                 :checked="$websiteconfig->show_order" />
                <x-form.checkbox name="show_facilities"
                                 label="show_facilities"
                                 :checked="$websiteconfig->show_facilities" />
                <x-form.checkbox name="show_files"
                                 label="show_files"
                                 :checked="$websiteconfig->show_files" />
                <x-form.checkbox name="show_reports"
                                 label="show_reports"
                                 :checked="$websiteconfig->show_reports" />
                <x-form.checkbox name="show_forms"
                                 label="show_forms"
                                 :checked="$websiteconfig->show_forms" />
                <x-form.checkbox name="show_requestors"
                                 label="show_requestors"
                                 :checked="$websiteconfig->show_requestors" />
                <x-form.checkbox name="show_contactmanager"
                                 label="show_contactmanager"
                                 :checked="$websiteconfig->show_contactmanager" />

                <x-form.checkbox name="workorders_show_all_requestors"
                                 label="workorders_show_all_requestors"
                                 :checked="$websiteconfig->workorders_show_all_requestors" />

                <x-form.checkbox name="workorder_inquiry"
                                 label="workorder_inquiry"
                                 :checked="$websiteconfig->workorder_inquiry" />
                <x-form.checkbox name="workorder_upload_auth"
                                 label="workorder_upload_auth"
                                 :checked="$websiteconfig->workorder_upload_auth" />
                <x-form.checkbox name="workorder_upload_aps"
                                 label="workorder_upload_aps"
                                 :checked="$websiteconfig->workorder_upload_aps" />
                <x-form.checkbox name="workorder_additional_files"
                                 label="workorder_additional_files"
                                 :checked="$websiteconfig->workorder_additional_files" />

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
            websiteconfig
            @php dump(@$websiteconfig) @endphp
        </div>
    @endif

</x-admin-layout>
