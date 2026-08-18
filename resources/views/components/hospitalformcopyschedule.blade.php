@php
    $options = [
        '6:00:00 AM' => '6:00:00 AM',
        '6:30:00 AM' => '6:30:00 AM',
        '7:00:00 AM' => '7:00:00 AM',
        '7:30:00 AM' => '7:30:00 AM',
        '8:00:00 AM' => '8:00:00 AM',
        '8:30:00 AM' => '8:30:00 AM',
        '9:00:00 AM' => '9:00:00 AM',
        '9:30:00 AM' => '9:30:00 AM',
        '10:00:00 AM' => '10:00:00 AM',
        '10:30:00 AM' => '10:30:00 AM',
        '11:00:00 AM' => '11:00:00 AM',
        '11:30:00 AM' => '11:30:00 AM',
        '12:00:00 PM' => '12:00:00 PM',
        '12:30:00 PM' => '12:30:00 PM',
        '1:00:00 PM' => '1:00:00 PM',
        '1:30:00 PM' => '1:30:00 PM',
        '2:00:00 PM' => '2:00:00 PM',
        '2:30:00 PM' => '2:30:00 PM',
        '3:00:00 PM' => '3:00:00 PM',
        '3:30:00 PM' => '3:30:00 PM',
        '4:00:00 PM' => '4:00:00 PM',
        '4:30:00 PM' => '4:30:00 PM',
        '5:00:00 PM' => '5:00:00 PM',
        '5:30:00 PM' => '5:30:00 PM',
        '6:00:00 PM' => '6:00:00 PM',
    ];
@endphp

<script>
    function copyvalues() {
        document.getElementById("H_TueFrom").value = document.getElementById("H_MonFrom").value;
        document.getElementById("H_WedFrom").value = document.getElementById("H_MonFrom").value;
        document.getElementById("H_ThuFrom").value = document.getElementById("H_MonFrom").value;
        document.getElementById("H_FriFrom").value = document.getElementById("H_MonFrom").value;

        document.getElementById("H_TueTo").value = document.getElementById("H_MonTo").value;
        document.getElementById("H_WedTo").value = document.getElementById("H_MonTo").value;
        document.getElementById("H_ThuTo").value = document.getElementById("H_MonTo").value;
        document.getElementById("H_FriTo").value = document.getElementById("H_MonTo").value;

        document.getElementById("H_TueFrom2").value = document.getElementById("H_MonFrom2").value;
        document.getElementById("H_WedFrom2").value = document.getElementById("H_MonFrom2").value;
        document.getElementById("H_ThuFrom2").value = document.getElementById("H_MonFrom2").value;
        document.getElementById("H_FriFrom2").value = document.getElementById("H_MonFrom2").value;

        document.getElementById("H_TueTo2").value = document.getElementById("H_MonTo2").value;
        document.getElementById("H_WedTo2").value = document.getElementById("H_MonTo2").value;
        document.getElementById("H_ThuTo2").value = document.getElementById("H_MonTo2").value;
        document.getElementById("H_FriTo2").value = document.getElementById("H_MonTo2").value;
    }
</script>

<h4>Copy Schedule</h4>

<table cellpadding="5">
    <tr>
        <td><x-form.select name="H_MonFrom" label="H_MonFrom" id="H_MonFrom" :options="$options" empty="-" :default="$hospital->H_MonFrom" /></td>
        <td><x-form.select name="H_MonTo" label="H_MonTo" id="H_MonTo" :options="$options" empty="-" :default="$hospital->H_MonTo" /></td>
        <td><x-form.select name="H_MonFrom2" label="H_MonFrom2" id="H_MonFrom2" :options="$options" empty="-" :default="$hospital->H_MonFrom2" /></td>
        <td><x-form.select name="H_MonTo2" label="H_MonTo2" id="H_MonTo2" :options="$options" empty="-" :default="$hospital->H_MonTo2" /></td>
    </tr>
    <tr>
        <td><x-form.select name="H_TueFrom" label="H_TueFrom" id="H_TueFrom" :options="$options" empty="-" :default="$hospital->H_TueFrom" /></td>
        <td><x-form.select name="H_TueTo" label="H_TueTo" id="H_TueTo" :options="$options" empty="-" :default="$hospital->H_TueTo" /></td>
        <td><x-form.select name="H_TueFrom2" label="H_TueFrom2" id="H_TueFrom2" :options="$options" empty="-" :default="$hospital->H_TueFrom2" /></td>
        <td><x-form.select name="H_TueTo2" label="H_TueTo2" id="H_TueTo2" :options="$options" empty="-" :default="$hospital->H_TueTo2" /></td>
    </tr>
    <tr>
        <td><x-form.select name="H_WedFrom" label="H_WedFrom" id="H_WedFrom" :options="$options" empty="-" :default="$hospital->H_WedFrom" /></td>
        <td><x-form.select name="H_WedTo" label="H_WedTo" id="H_WedTo" :options="$options" empty="-" :default="$hospital->H_WedTo" /></td>
        <td><x-form.select name="H_WedFrom2" label="H_WedFrom2" id="H_WedFrom2" :options="$options" empty="-" :default="$hospital->H_WedFrom2" /></td>
        <td><x-form.select name="H_WedTo2" label="H_WedTo2" id="H_WedTo2" :options="$options" empty="-" :default="$hospital->H_WedTo2" /></td>
    </tr>
    <tr>
        <td><x-form.select name="H_ThuFrom" label="H_ThuFrom" id="H_ThuFrom" :options="$options" empty="-" :default="$hospital->H_ThuFrom" /></td>
        <td><x-form.select name="H_ThuTo" label="H_ThuTo" id="H_ThuTo" :options="$options" empty="-" :default="$hospital->H_ThuTo" /></td>
        <td><x-form.select name="H_ThuFrom2" label="H_ThuFrom2" id="H_ThuFrom2" :options="$options" empty="-" :default="$hospital->H_ThuFrom2" /></td>
        <td><x-form.select name="H_ThuTo2" label="H_ThuTo2" id="H_ThuTo2" :options="$options" empty="-" :default="$hospital->H_ThuTo2" /></td>
    </tr>
    <tr>
        <td><x-form.select name="H_FriFrom" label="H_FriFrom" id="H_FriFrom" :options="$options" empty="-" :default="$hospital->H_FriFrom" /></td>
        <td><x-form.select name="H_FriTo" label="H_FriTo" id="H_FriTo" :options="$options" empty="-" :default="$hospital->H_FriTo" /></td>
        <td><x-form.select name="H_FriFrom2" label="H_FriFrom2" id="H_FriFrom2" :options="$options" empty="-" :default="$hospital->H_FriFrom2" /></td>
        <td><x-form.select name="H_FriTo2" label="H_FriTo2" id="H_FriTo2" :options="$options" empty="-" :default="$hospital->H_FriTo2" /></td>
    </tr>
</table>

<button type="button" class="btn btn-xs btn-success" onclick="copyvalues()">copy monday to other days</button>
