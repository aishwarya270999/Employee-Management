@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h4>All Employee Addresses</h4>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm">
            Back to Employees
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Sr.No</th>
                        <th>Employee Name</th>
                        <th>Address Line</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($addresses as $address)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $address->employee->name ?? 'N/A' }}</td>
                            <td>{{ $address->address_line }}</td>
                            <td>{{ $address->city }}</td>
                            <td>{{ $address->state }}</td>
                            <td>{{ $address->zip_code }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No addresses found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            <div class="mt-3">
                {{ $addresses->links() }}
            </div>

        </div>
    </div>

</div>

@endsection