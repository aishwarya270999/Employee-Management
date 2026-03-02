@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>{{ $employee->name }} - Address Details</h4>
        </div>

        <div class="card-body">
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Position:</strong> {{ $employee->position }}</p>
            <p><strong>Salary:</strong> ₹ {{ number_format($employee->salary) }}</p>

            <hr>

            <h5>Addresses</h5>

            @foreach($employee->addresses as $address)
                <div class="card mb-2">
                    <div class="card-body">
                        {{ $address->address_line }},
                        {{ $address->city }},
                        {{ $address->state }} -
                        {{ $address->zip_code }}
                    </div>
                </div>
            @endforeach

            <a href="{{ route('employees.index') }}" class="btn btn-secondary mt-3">
                Back
            </a>
        </div>
    </div>
</div>

@endsection