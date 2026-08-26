<x-admin-layout title="">

    <h1>Requestor Login Attempts Stats</h1>

    <br />

    <h1>IP Address Most Used</h1>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>IP Address</th>
                    <th>Count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loginattempts as $loginattempt)
                    <tr>
                        <td><a
                               href="{{ route('admin.loginattempts.index', ['ip_address' => $loginattempt->ip_address]) }}">{{ $loginattempt->ip_address }}</a>
                        </td>
                        <td>{{ $loginattempt->counter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
