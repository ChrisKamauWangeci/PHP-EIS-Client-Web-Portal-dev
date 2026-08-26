<x-admin-layout title="">

    <h1>Requestor Login Stats</h1>

    <br />

    <h1>IP Address Most Used</h1>

    <div class="table-responsive">
        <table class="table table-sm table-hover table-bordered w-auto">
            <thead>
                <tr>
                    <th>ip_address</th>
                    <th>count</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logins as $login)
                    <tr>
                        <td><a
                               href="{{ route('admin.logins.index', ['ip_address' => $login->ip_address]) }}">{{ $login->ip_address }}</a>
                        </td>
                        <td>{{ $login->counter }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-admin-layout>
