<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections=sections::get();
        $products=product::get();

        
        return view("products.products",compact("sections","products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|unique:products|max:255',
            'description' => 'required',
        ],[
            'product_name.required'=>'الاسم مطلوب',
            'product_name.unique'=>'تم اضافة هذا الاسم من قبل',
            'description.required'=>'الوصف مطلوب',
            'product_name.max'=>'الحد الأقصى 255 حرف فقط'

        ]);

        
        $products = product::create([
            'product_name' =>$request->product_name,
            'sections_id' => $request->section_id,
            'description'=>$request->description,
            "Created_by"=>auth()->user()->name,
        ]);
        session()->flash("add","تمت الاضافة بنجاح");


        return  redirect("/products");

    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // return $request;die;

        $section_id=sections::where("section_name","=",$request->sections_name)->first();
        $id_section= $section_id->id;

        $id=$request->id;
        $this->validate($request,[
              'product_name' => "required|max:255",Rule::unique('products')->ignore($id),
              'description' => 'required',
          ],[
              'product_name.required'=>'الاسم مطلوب',
              'product_name.unique'=>'تم اضافة هذا الاسم من قبل',
              'description.required'=>'الوصف مطلوب',
              'product_name.max'=>'الحد الأقصى 255 حرف فقط'
  
          ]);
          
        $update= product::find($id);
        $update->update(['product_name' => $request->product_name,'sections_id' => $id_section,'description' => $request->description]);  
  
        session()->flash("edit","تم التعديل بنجاح");
  
          return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $product = product::find( $id);
 
        $product->delete();
        session()->flash("delete","تم حذف المنتج بنجاح");

        return redirect()->back(); 
    }
}
