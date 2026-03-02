@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 text-center">Employee Management</h2>

        <!-- Search -->
        <form method="GET" class="mb-3 d-flex gap-2">

            <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                placeholder="Search by name, email or position">

            <button type="submit" class="btn btn-primary">
                Search
            </button>

            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                Reset
            </a>

        </form>

        <!-- Add Button -->
        <div class="mb-3 text-end">
            <a href="{{ route('employees.create') }}" class="btn btn-success">
                Add Employee
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <!-- <thead class="table-dark">
                    <tr>
                        <th>
                            <a href="?sort=name&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                Name
                            </a>
                        </th>
                        <th>Email</th>
                        <th>
                            <a href="?sort=department&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                Department
                            </a>
                        </th>
                        <th>
                            <a href="?sort=salary&direction={{ request('direction') == 'asc' ? 'desc' : 'asc' }}" class="text-white text-decoration-none">
                                Salary
                            </a>
                        </th>
                        <th width="180px">Actions</th>
                    </tr>
                </thead> -->
                <thead>
                    <tr>
                        <th>
                            <a
                                href="{{ route('employees.index', ['sort' => 'id', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                ID
                            </a>
                        </th>

                        <th>
                            <a
                                href="{{ route('employees.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                Name
                            </a>
                        </th>

                        <th>
                            <a
                                href="{{ route('employees.index', ['sort' => 'email', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">
                                Email
                            </a>
                        </th>

                        <th>Position</th>
                        <th>Salary</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{ $employee->id }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->position }}</td>
                            <td>₹ {{ number_format($employee->salary) }}</td>
                            <td>
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No Employees Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $employees->withQueryString()->links() }}
        </div>

    </div>
@endsection
