<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\General\CollectionHelper;
use App\Rules\PhoneNumber;

class CustomerController extends Controller
{
    /*
        Variable 
        
        Request:

        Response:
        allCustomer: [Customer]
    */
    public function index() {
        $request = request();
        $customerResult = self::getCustomerByName($request['name']);
        return Inertia::render('Customer/index',[
            'allCustomer' => CollectionHelper::paginate($customerResult, 25)
        ]);
    }

    /*
        Variable 
        
        Request:
        name: String (nullable)

        Response:
        customerResult
    */
    public function searchCustomerByNameUsingAPIBasedRequest() {
        $request = request();
        $customerResult = self::getCustomerByName($request['name']);
        return response()->json([
            'customerResult' => $customerResult
        ]);
    }


    /*
        Variable 

        Response:

    */
    public function create() {
        return Inertia::render('Customer/Add/index',[]);
    }

    /*
        Variable 
        
        Request:
        email: String
        name: String
        phone_number: String
        dob: String

        Response:
        successMessage: FlashMessage
    */
    public function store() {
        self::saveCustomer(request());
        return redirect()->route('customer.index')->with('successMessage', 'Pelanggan berhasil di simpan !!');
    }

     /*
        Variable 
        
        Request: String
        email: String
        name: String
        phone_number: String
        dob: String

        Response:
        isSuccess: Boolean
        customerId: Int
        customerName: String
    */
    public function storeUsingAPIBasedRequest() {
        $customer = self::saveCustomer(request());
        return response()->json([
            'isSuccess' => true,
            'customerId' => $customer->id,
            'customerName' => $customer->name
        ]);
    }

    private function saveCustomer($request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email',
            'phone_number' => ['required', 'numeric','unique:customers,phone_number', 'digits_between:7,15', new PhoneNumber],
            'dob' => 'required',
        ]);

        return Customer::getAndSaveNewCustomerInstance(
            $request['email'],
            $request['name'],
            $request['phone_number'],
            $request['dob']
        );
    }

    /*
        Variable 

        Response:
        customer: Customer
    */
    public function edit(Customer $customer) {
        //TODO: adjust render page
        return Inertia::render('Customer/Edit/index',[
            'customer' => $customer
        ]);
    }

    /*
        Variable 
        
        Request: String
        email: String
        name: String
        phone_number: String
        dob: String

        Response:

    */
    public function update(Customer $customer) {
        $request = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone_number' => 'required',
            'dob' => 'required',
        ]);
        
        $customer->updateCustomer(
            $request['email'],
            $request['name'],
            $request['phone_number'],
            $request['dob']
        );

        return redirect()->route('customer.index', $customer->id)->with('successMessage', 'Pelanggan berhasil di ubah!!');
    }


    /*
        Variable 
        
        Response:

    */
    public function destroy(Customer $customer) {
        $customer->delete();
        
        return redirect()->route('customer.index')->with('successMessage', 'Pelanggan berhasil di hapus!!');
    }

    private function getCustomerByName($name) {
        $customerResult = Customer::all();
        if($name) {
            $customerResult = Customer::getCustomerByName($name);
        }
        return $customerResult;
    }
}
