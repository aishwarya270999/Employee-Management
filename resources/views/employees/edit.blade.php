@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">Edit Employee</h4>
            </div>

            <div class="card-body">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Employee Details --}}
                    <div class="row">

                        {{-- Name --}}
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ old('name', $employee->name) }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee name"
                                pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Enter employee email"
                                required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Position --}}
                        <div class="col-md-6 mb-3">
                            <label>Position</label>
                            <input type="text" name="position" value="{{ old('position', $employee->position) }}"
                                class="form-control @error('position') is-invalid @enderror" placeholder="Enter position"
                                pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Salary --}}
                        <div class="col-md-6 mb-3">
                            <label>Salary</label>
                            <input type="number" name="salary" value="{{ old('salary', $employee->salary) }}"
                                class="form-control @error('salary') is-invalid @enderror" placeholder="Enter salary"
                                min="1" required>
                            @error('salary')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <hr>
                    <h5 class="mb-3">Employee Addresses</h5>

                    <div id="address-container">

                        @php
                            $addresses = old('addresses', $employee->addresses->toArray());
                        @endphp

                        @foreach ($addresses as $key => $address)
                            <div class="address-block border rounded p-3 mb-3 bg-light">
                                <div class="row">

                                    {{-- Address Line --}}
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="addresses[{{ $key }}][address_line]"
                                            value="{{ old('addresses.' . $key . '.address_line', $address['address_line'] ?? '') }}"
                                            class="form-control @error('addresses.' . $key . '.address_line') is-invalid @enderror"
                                            placeholder="Address Line">
                                        @error('addresses.' . $key . '.address_line')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- City --}}
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="addresses[{{ $key }}][city]"
                                            value="{{ old('addresses.' . $key . '.city', $address['city'] ?? '') }}"
                                            class="form-control @error('addresses.' . $key . '.city') is-invalid @enderror"
                                            placeholder="City"pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                                        @error('addresses.' . $key . '.city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- State --}}
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="addresses[{{ $key }}][state]"
                                            value="{{ old('addresses.' . $key . '.state', $address['state'] ?? '') }}"
                                            class="form-control @error('addresses.' . $key . '.state') is-invalid @enderror"
                                            placeholder="State" pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                                        @error('addresses.' . $key . '.state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Zip Code --}}
                                    <div class="col-md-6 mb-2">
                                        <input type="text" name="addresses[{{ $key }}][zip_code]"
                                            value="{{ old('addresses.' . $key . '.zip_code', $address['zip_code'] ?? '') }}"
                                            class="form-control @error('addresses.' . $key . '.zip_code') is-invalid @enderror"
                                            placeholder="Zip Code" maxlength="6"
                                            title="Enter exactly 6 digit pincode" required>
                                        @error('addresses.' . $key . '.zip_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Remove Button --}}
                                    <div class="col-12 text-end">
                                        <button type="button" class="btn btn-danger btn-sm remove-address">
                                            Remove
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- Add More --}}
                    <button type="button" id="add-more" class="btn btn-info btn-sm mb-3">
                        + Add More Address
                    </button>

                    {{-- Buttons --}}
                    <div class="text-end">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-warning">Update Employee</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            let index = {{ count(old('addresses', $employee->addresses)) }};

            $('#add-more').click(function() {

                let html = `
        <div class="address-block border rounded p-3 mb-3 bg-light">
            <div class="row">

                <div class="col-md-6 mb-2">
                    <input type="text" name="addresses[${index}][address_line]"
                        class="form-control" placeholder="Address Line">
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text" name="addresses[${index}][city]"
                        class="form-control" placeholder="City" pattern="[A-Za-z\s]+"
                            title="Only letters allowed"
                            required>
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text" name="addresses[${index}][state]"
                        class="form-control" placeholder="State" pattern="[A-Za-z\s]+"
                     title="Only letters allowed"
                     required>
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text" name="addresses[${index}][zip_code]"
                        class="form-control" placeholder="Zip Code" 
                     maxlength="6"
                     title="Enter exactly 6 digit pincode"
                     required>
                </div>

                <div class="col-12 text-end">
                    <button type="button" class="btn btn-danger btn-sm remove-address">
                        Remove
                    </button>
                </div>

            </div>
        </div>
        `;

                $('#address-container').append(html);
                index++;
            });

            $(document).on('click', '.remove-address', function() {
                $(this).closest('.address-block').remove();
            });

        });
    </script>
@endsection
