<x-user-layout title="">

    <h1>Company Updates</h1>

    <br />

    {{ $companyupdates->withQueryString()->links() }}

    <div class="table-responsive">
        <table class="table table-sm1 table-hover table-bordered1 w-auto">
            <thead>
                <tr>
                    <th>Name</th>
                    <!-- <th>Created</th> -->
                    <th>Completed Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companyupdates as $companyupdate)
                    <tr>
                        <td>
                            <a href="{{ route('user.companyupdates.show', $companyupdate->id ) }}" class="fw-bold text-primary">{{ $companyupdate->name }}</a>
                        </td>
                        <!-- <td>{{ $companyupdate->created_at->format('M/d/Y') }}</td> -->
                        <td>
                            <div class="float-end">
                                @if($companyupdate->contractor->count() > 0)
                                <small>{{ $companyupdate->contractor->first()->pivot->created_at->format('M/d/Y') }}</small>
                                @endif
                            </div>
                        </td>
                        <td>
                            @if(!$companyupdate->contractor->count())
                            <i class="fa-regular fa-fw fa-clock text-warning fa-beat"></i> Pending
                            @else
                            <i class="fa-solid fa-fw fa-square-check text-success"></i> Acknowledged
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $companyupdates->withQueryString()->links() }}

    <br />

    <br />
    <br />

</x-user-layout>