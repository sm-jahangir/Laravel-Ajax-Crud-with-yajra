<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {  
        if ($request->ajax()) {
            $data = Customer::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a id="EditCustomer"  data-id="'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                           $btn = $btn.' <a id="deleteCustomer"  data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('customer');
    }
    public function store(Request $request)
    {
        Customer::updateOrCreate(
            ['id' => $request->customer_id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'religion' => $request->religion,
            ]
        ); 
        return response()->json(['success'=>'Product saved successfully.']);
    }
    public function edit(Customer $customer)
    {
        $product = $customer;
        return response()->json($product);
    }
    public function destroy(Customer $customer)
    {
         $customer->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
