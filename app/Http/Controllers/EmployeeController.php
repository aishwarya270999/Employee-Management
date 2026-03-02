<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use Illuminate\Http\Request;
use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    private $service;

    public function __construct(EmployeeService $service)
    {
        $this->service = $service;
    }

    /**
     * Display listing with search + sorting
     */
    public function index(Request $request)
    {
        $employees = $this->service->getAll(
            $request->search,
            $request->sort ?? 'id',
            $request->direction ?? 'asc'
        );

        return view('employees.index', compact('employees'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store new employee
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        // Employee Fields
        'name'       => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'email'      => ['required','email','unique:employees,email'],
        'position'   => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'salary'     => ['required','numeric','min:1'],

        // Address Fields
        'addresses' => ['required','array','min:1'],

        'addresses.*.address_line' => ['required','string','max:500'],

        'addresses.*.city' => ['required','regex:/^[A-Za-z\s]+$/','max:100'],

        'addresses.*.state' => ['required','regex:/^[A-Za-z\s]+$/','max:100'],

        'addresses.*.zip_code' => ['required','digits:6'],
    ], [

        'name.regex' => 'Name should contain only letters.',
        'position.regex' => 'Position should contain only letters.',
        'addresses.*.city.regex' => 'City should contain only letters.',
        'addresses.*.state.regex' => 'State should contain only letters.',
        'addresses.*.zip_code.digits' => 'Pincode must be exactly 6 digits.',
    ]);

        $this->service->create($validated);

        return redirect()->route('employees.index')
                        ->with('success', 'Employee Created Successfully');
    }
    /**
     * Show single employee
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /**
     * Show edit form
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update employee
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
        'name'       => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'email'      => ['required','email','unique:employees,email,' . $employee->id],
        'position'   => ['required','regex:/^[A-Za-z\s]+$/','max:255'],
        'salary'     => ['required','numeric','min:1'],

        'addresses' => ['required','array','min:1'],

        'addresses.*.address_line' => ['required','string','max:500'],

        'addresses.*.city' => ['required','regex:/^[A-Za-z\s]+$/','max:100'],

        'addresses.*.state' => ['required','regex:/^[A-Za-z\s]+$/','max:100'],

        'addresses.*.zip_code' => ['required','digits:6'],
    ], [

        'name.regex' => 'Name should contain only letters.',
        'position.regex' => 'Position should contain only letters.',
        'addresses.*.city.regex' => 'City should contain only letters.',
        'addresses.*.state.regex' => 'State should contain only letters.',
        'addresses.*.zip_code.digits' => 'Pincode must be exactly 6 digits.',
    ]);

    $this->service->update($employee, $validated);

    return redirect()->route('employees.index')
                     ->with('success', 'Employee Updated Successfully');
}

    /**
     * Delete employee
     */
    public function destroy(Employee $employee)
    {
        $this->service->delete($employee);

        return redirect()->route('employees.index')
                         ->with('success', 'Employee deleted successfully.');
    }

    public function getAddress()
    {
        $addresses = EmployeeAddress::with('employee')
                        ->latest()
                        ->paginate(10);

        return view('addresses.index', compact('addresses'));
    }
}