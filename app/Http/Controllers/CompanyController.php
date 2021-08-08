<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    public function index(Request $request)
    { 
        if ($request->ajax()) {
            $users = Company::latest()->get();

            return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                $btn = '<a id="EditCompany"  data-id="'.$user->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                $btn = $btn.' <a id="deleteCompany"  data-id="'.$user->id.'" class="btn btn-danger btn-sm">Delete</a>';
                    return $btn;
            })
            ->make(true);
        }
        return view('company');
    }
    public function store(Request $request)
    {
        Company::updateOrCreate(
            ['id' => $request->company_id],
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );
        return response()->json(['success'=>'Product saved successfully.']);
    }
    public function edit(Company $company)
    {
        $product = $company;
        return response()->json($product);
    }
    public function destroy(Company $company)
    {
        $company->delete();
       return response()->json(['success'=>'Product deleted successfully.']);
    }
}
