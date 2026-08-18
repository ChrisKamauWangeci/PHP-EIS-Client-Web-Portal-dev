<x-user-layout title="">

    <h1>Bank Statement</h1>

    <br />

    <table class="table table-hover table-bordered table-sm table-hover w-auto">
        <tr>
            <td>id</td>
            <td>{{ $bankstatement->id }}</td>
        </tr>
        <tr>
            <td>B_Description</td>
            <td>{{ $bankstatement->B_Description }}</td>
        </tr>
        <tr>
            <td>B_IssueDate</td>
            <td>{{ $bankstatement->B_IssueDate }}</td>
        </tr>
        <tr>
            <td>B_Amount</td>
            <td>{{ $bankstatement->B_Amount }}</td>
        </tr>
        <tr>
            <td>B_Hospital</td>
            <td>{{ $bankstatement->B_Hospital }}</td>
        </tr>
        <tr>
            <td>B_Note</td>
            <td>{{ $bankstatement->B_Note }}</td>
        </tr>
        <tr>
            <td>B_IssueBy</td>
            <td>{{ $bankstatement->B_IssueBy }}</td>
        </tr>
        <tr>
            <td>B_IssueOn</td>
            <td>{{ $bankstatement->B_IssueOn }}</td>
        </tr>
    </table>

    <br />
    <br />

</x-user-layout>
