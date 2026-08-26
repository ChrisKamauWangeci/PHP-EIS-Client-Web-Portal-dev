<div class="row">
    <div class="col-sm-6">
        <x-form.textarea name="H_Note"
                         label="Caller Instructions"
                         :value="old('H_Note', $hospital->H_Note)"
                         :rows="8" />
        <br />
        <x-form.textarea name="H_NoteDriver"
                         label="Driver Instructions"
                         :value="old('H_NoteDriver', $hospital->H_NoteDriver)"
                         :rows="8" />
        <br />
        <x-form.textarea name="H_NoteUploader"
                         label="Uploader Notes"
                         :value="old('H_NoteUploader', $hospital->H_NoteUploader)"
                         :rows="8" />
        <br />
    </div>
    <div class="col-sm-6">
        <x-form.textarea name="H_NoteBilling"
                         label="Billing Notes"
                         :value="old('H_NoteBilling', $hospital->H_NoteBilling)"
                         :rows="8" />
        <br />
        <x-form.textarea name="H_Note2"
                         label="Notes"
                         :value="old('H_Note2', $hospital->H_Note2)"
                         :rows="8" />
        <br />
    </div>
</div>
