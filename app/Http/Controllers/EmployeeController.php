<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of employees.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $employees = Employee::query()
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                             ->orWhere('full_name', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Store a newly created employee.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'employment_type' => 'required|in:Regular,Non-Regular',
            'designation' => 'required|string|max:255',
            'basic_rate' => 'required|numeric|min:0',
            'sss_number' => 'nullable|string|max:50',
            'sss_amount' => 'nullable|numeric|min:0',
            'hdmf_number' => 'nullable|string|max:50',
            'hdmf_amount' => 'nullable|numeric|min:0',
            'philhealth_number' => 'nullable|string|max:50',
            'philhealth_amount' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'pay_schedule' => 'required|in:Weekly,15/30,10/25',
            'allowance' => 'nullable|numeric|min:0',
            'accommodation' => 'nullable|numeric|min:0',
            'load_allowance' => 'nullable|numeric|min:0',
            'travel_allowance' => 'nullable|numeric|min:0',
        ]);

        Employee::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Show the form for editing the specified employee.
     * (For modal: returns JSON data)
     */
    public function edit(Employee $employee)
    {
        return response()->json($employee);
    }

    /**
     * Update the specified employee.
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'employment_type' => 'required|in:Regular,Non-Regular',
            'designation' => 'required|string|max:255',
            'basic_rate' => 'required|numeric|min:0',
            'sss_number' => 'nullable|string|max:50',
            'sss_amount' => 'nullable|numeric|min:0',
            'hdmf_number' => 'nullable|string|max:50',
            'hdmf_amount' => 'nullable|numeric|min:0',
            'philhealth_number' => 'nullable|string|max:50',
            'philhealth_amount' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'pay_schedule' => 'required|in:Weekly,15/30,10/25',
            'allowance' => 'nullable|numeric|min:0',
            'accommodation' => 'nullable|numeric|min:0',
            'load_allowance' => 'nullable|numeric|min:0',
            'travel_allowance' => 'nullable|numeric|min:0',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}