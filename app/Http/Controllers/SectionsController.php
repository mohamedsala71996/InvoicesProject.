<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionsController extends Controller
{
  
    public function __construct()
    {
     $this->middleware('permission:الأقسام');

    }
    
    public function index()
    {
        $sections=sections::get();
        
        return view("sections.sections",compact("sections"));
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
        // $input=$request->all();

        $validated = $request->validate([
            'section_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ],[
            'section_name.required'=>'الاسم مطلوب',
            'section_name.unique'=>'تم اضافة هذا الاسم من قبل',
            'description.required'=>'الوصف مطلوب',
            'section_name.max'=>'الحد الأقصى 255 حرف فقط'

        ]);

        
        $sections = sections::create([
            'section_name' =>  $validated["section_name"],
            'description'=> $validated["description"],
            "Created_by"=>auth()->user()->name,
        ]);
        session()->flash("add","تمت الاضافة بنجاح");


        return  redirect("/sections");

        // $check=sections::where("section_name","=", $input["section_name"])->exists();

        // if ($check) {
        //   session()->Flash("error","القسم مسجل من قبل");
        // return  redirect("/sections");

        // }else{  

        //     sections::create([
        //         "section_name"=>$input["section_name"],
        //         "description"=>$input["description"],
        //         "Created_by"=>auth()->user()->name,

        //     ]);
        // }
        // session()->Flash("add","تم اضافة القسم بنجاح");
        // return  redirect("/sections");



    }

    /**
     * Display the specified resource.
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

 
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // return $request;
        $id=$request->id;
      $this->validate($request,[
            'section_name' => "required|max:255",Rule::unique('sections')->ignore($id),
            'description' => 'required',
        ],[
            'section_name.required'=>'الاسم مطلوب',
            'section_name.unique'=>'تم اضافة هذا الاسم من قبل',
            'description.required'=>'الوصف مطلوب',
            'section_name.max'=>'الحد الأقصى 255 حرف فقط'

        ]);
        
      $update= sections::find($id);
      $update->update(['section_name' => $request->section_name,'description' => $request->description]);  

      session()->flash("edit","تم التعديل بنجاح");

        return redirect()->back(); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
      $id=$request->id;
        $section = sections::find( $id);
 
        $section->delete();
        session()->flash("delete","تم حذف القسم بنجاح");

        return redirect()->back(); 

    }
}
