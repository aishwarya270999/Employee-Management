<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    public function getAll($search = null, $sort = 'id', $direction = 'asc')
    {
        return Employee::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate(10);
    }

    public function create(array $data)
    {
        $employee = Employee::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'position' => $data['position'],
            'salary'   => $data['salary'],
        ]);

        foreach ($data['addresses'] as $address) {
            $employee->addresses()->create($address);
        }

        return $employee;
    }

    public function update(Employee $employee, array $data)
    {
        $employee->update([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'position' => $data['position'],
            'salary'   => $data['salary'],
        ]);

        $employee->addresses()->delete();

        foreach ($data['addresses'] as $address) {
            $employee->addresses()->create($address);
        }

        return $employee;
    }

    public function delete(Employee $employee)
    {
        return $employee->delete();
    }
}