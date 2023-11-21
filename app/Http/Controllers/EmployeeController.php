<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use App\Helpers\General\CollectionHelper;

class EmployeeController extends Controller
{
    /*
        Variable 
        
        Request:

        Response:
        allEmployee: [User]
    */
    public function index() {
        //TODO: Adjust render page
        return Inertia::render('Employee/index',[
            'allEmployee' => CollectionHelper::paginate(User::all(), 25)
        ]);
    }

    /*
        Variable 
        
        Request:

        Response:
        employee: User
    */

    public function edit(User $employee) {
        //TODO: adjust page render
        return Inertia::render('Employee/Edit/index',[
            'employee' => $employee
        ]);
    }

    /*
        Variable 
        
        Request:
        name: String
        email: String
        address: String
        dob: Date

        Response:

    */
    public function update(User $employee) {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'address' => 'required',
            'dob' => 'required',
        ]);

        $employee->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'address' => $request['address'],
            'dob' => $request['dob'],
        ]);

        return redirect()->route('employee.index')->with('successMessage', 'Admin/Karyawan berhasil di ubah!!');
    }

    public function destroy(User $employee) {
        if($employee->role->name != 'employee') {
            return redirect()->route('employee.index')->with('errorMessage', 'Pengguna yang ingin di ubah bukan karyawan!!');
        }
        $employee->delete();
        return redirect()->route('employee.index')->with('successMessage', 'Admin/Karyawan berhasil di hapus!!');
    }
}
