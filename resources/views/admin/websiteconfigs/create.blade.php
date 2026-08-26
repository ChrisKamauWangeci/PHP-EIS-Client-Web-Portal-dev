<x-admin-layout>

    <h1>Create Websiteconfig</h1>

    <br />

    <div class="row">
        <div class="col-sm-6">

            <form method="post"
                  action="{{ route('admin.websiteconfigs.store') }}">
                @csrf

                <x-form.input name="name"
                              id="name"
                              label="Name"
                              :value="old('name')"
                              required />
                <br />

                <x-form.checkbox name="show_order"
                                 label="show_order"
                                 :checked="old('show_order')" />
                <x-form.checkbox name="show_facilities"
                                 label="show_facilities"
                                 :checked="old('show_facilities')" />
                <x-form.checkbox name="show_files"
                                 label="show_files"
                                 :checked="old('show_files')" />
                <x-form.checkbox name="show_reports"
                                 label="show_reports"
                                 :checked="old('show_reports')" />
                <x-form.checkbox name="show_forms"
                                 label="show_forms"
                                 :checked="old('show_forms')" />
                <x-form.checkbox name="show_requestors"
                                 label="show_requestors"
                                 :checked="old('show_requestors')" />
                <x-form.checkbox name="show_contactmanager"
                                 label="show_contactmanager"
                                 :checked="old('show_contactmanager')" />

                <x-form.checkbox name="workorders_show_all_requestors"
                                 label="workorders_show_all_requestors"
                                 :checked="old('workorders_show_all_requestors')" />

                <x-form.checkbox name="workorder_inquiry"
                                 label="workorder_inquiry"
                                 :checked="old('workorder_inquiry')" />
                <x-form.checkbox name="workorder_upload_auth"
                                 label="workorder_upload_auth"
                                 :checked="old('workorder_upload_auth')" />
                <x-form.checkbox name="workorder_upload_aps"
                                 label="workorder_upload_aps"
                                 :checked="old('workorder_upload_aps')" />
                <x-form.checkbox name="workorder_additional_files"
                                 label="workorder_additional_files"
                                 :checked="old('workorder_additional_files')" />

                <br />
                <br />

                <x-form.button>Submit</x-form.button>
            </form>

        </div>
    </div>

    <br />
    <br />

</x-admin-layout>
