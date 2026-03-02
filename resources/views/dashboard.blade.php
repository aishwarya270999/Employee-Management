@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="row">

        <!-- Total Employees Card -->
        <div class="col-md-4">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">

                    <div>
                        <h5>Total Employees</h5>
                        <h2>{{ \App\Models\Employee::count() }}</h2>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('employees.index') }}" 
                           class="btn btn-light btn-sm">
                            View Employees
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Total Addresses Card -->
        <div class="col-md-4">
            <div class="card bg-info text-white shadow h-100">
                <div class="card-body text-center d-flex flex-column justify-content-between">

                    <div>
                        <h5>Total Addresses</h5>
                        <h2>{{ \App\Models\EmployeeAddress::count() }}</h2>
                    </div>

                    <div class="mt-3">
                       <a href="{{ route('addresses.index') }}" 
                        class="btn btn-light btn-sm">
                            View Addresses
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection