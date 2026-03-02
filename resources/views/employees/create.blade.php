@extends('layouts.app')

@section('content')

    <div class="container mt-4">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Add New Employee</h4>
            </div>

            <div class="card-body">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

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

                <form action="{{ route('employees.store') }}" method="POST">
                    @csrf

                    <!-- Employee Details -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Enter employee name"
                                pattern="[A-Za-z\s]+" title="Only letters allowed" required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Enter employee email"
                                required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position</label>
                            <input type="text" name="position" value="{{ old('position') }}"
                                class="form-control @error('position') is-invalid @enderror" placeholder="Enter position"
                                pattern="[A-Za-z\s]+" title="Only letters allowed" required>

                            @error('position')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Salary</label>
                            <input type="number" name="salary" value="{{ old('salary') }}"
                                class="form-control @error('salary') is-invalid @enderror" placeholder="Enter salary"
                                min="1" required>

                            @error('salary')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h5 class="mb-3">Employee Addresses</h5>

                    <!-- Address Container -->
                    <div id="address-container">

                        <div class="address-block border rounded p-3 mb-3 bg-light">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" name="addresses[0][address_line]" class="form-control"
                                        placeholder="Address Line" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <input type="text" name="addresses[0][city]" class="form-control" placeholder="City"
                                        pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <input type="text" name="addresses[0][state]" class="form-control"
                                        placeholder="State" pattern="[A-Za-z\s]+" title="Only letters allowed" required>
                                </div>

                                <div class="col-md-6 mb-2">
                                    <input type="text" name="addresses[0][zip_code]" class="form-control"
                                        placeholder="Zip Code" pattern="\d{6}" maxlength="6"
                                        title="Enter exactly 6 digit pincode" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Add More Button -->
                    <div class="mb-3">
                        <button type="button" id="add-more" class="btn btn-info btn-sm">
                            + Add More Address
                        </button>
                    </div>

                    <!-- Buttons -->
                    <div class="text-end">
                        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <button type="submit" class="btn btn-success">
                            Save Employee
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            let index = 1;

            $('#add-more').click(function() {

                let html = `
        <div class="address-block border rounded p-3 mb-3 bg-light">
            <div class="row">
                <div class="col-md-6 mb-2">
                    <input type="text"
                        name="addresses[${index}][address_line]"
                        class="form-control"
                        placeholder="Address Line"
                        required>
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text"
    name="addresses[${index}][city]"
    class="form-control"
    placeholder="City"
    pattern="[A-Za-z\s]+"
    title="Only letters allowed"
    required>
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text"
    name="addresses[${index}][state]"
    class="form-control"
    placeholder="State"
    pattern="[A-Za-z\s]+"
    title="Only letters allowed"
    required>
                </div>

                <div class="col-md-6 mb-2">
                    <input type="text"
    name="addresses[${index}][zip_code]"
    class="form-control"
    placeholder="Zip Code"
    pattern="\d{6}"
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

            // Remove address
            $(document).on('click', '.remove-address', function() {
                $(this).closest('.address-block').remove();
            });

        });

        // Allow only letters for specific fields
        $(document).on('input', 'input[name="name"], input[name="position"], input[name*="[city]"], input[name*="[state]"]',
            function() {
                this.value = this.value.replace(/[^A-Za-z\s]/g, '');
            });

        // Allow only numbers for salary & pincode
        $(document).on('input', 'input[name="salary"], input[name*="[zip_code]"]', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endsection
