<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductAjaxController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = Product::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a data-id="'.$row->id.'" id="editProduct" class="edit btn btn-primary btn-sm">Edit</a>';
                           $btn = $btn.' <a data-id="'.$row->id.'" id="deleteProduct" class="btn btn-danger btn-sm">Delete</a>';
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('productAjax');
    }
    public function store(Request $request)
    {
        Product::updateOrCreate(
            ['id' => $request->product_id],
            [
                'name' => $request->name,
                'detail' => $request->detail
            ]
        ); 
        return response()->json(['success'=>'Product saved successfully.']);
    }
    public function edit($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }
    public function destroy($id)
    {
        Product::find($id)->delete();
        return response()->json(['success'=>'Product deleted successfully.']);
    }
}
