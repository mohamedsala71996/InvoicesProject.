<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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


    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

      }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'pic' => 'required|mimes:jpeg,jpg,png,pdf|max:1000',
        ]);

        $img_name= $request->pic->getClientOriginalName();
        $invoice_number=invoices::where('id',$id)->first();
        $invoice_number= $invoice_number->invoice_number;
        $invoices_attachments=invoices_attachments::create([
            'file_name'=>$img_name,
            'invoice_number'=> $invoice_number,
            'Created_by'=>auth()->user()->name,
            'invoices_id' =>$id,
        ]);
        $img_name= $request->pic->getClientOriginalName();

        $request->file("pic")->storeAs($invoice_number,$img_name,"photos");
        session()->flash("add","تمت اضافة المرفق بنجاح");

        return redirect()->back();



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $attachment=invoices_attachments::where('id',$id)->first();
        $attachment->delete();
       $file_name= $attachment->file_name;
       $invoice_number= $attachment->invoice_number;
       
        Storage::disk('photos')->delete($invoice_number.'/'.$file_name);

        session()->flash("delete","تم حذف المرفق بنجاح");
         return redirect()->back();

    }

    public function perview($invoice_number,$file_name){


            // $files = Storage::disk('photos')->get($invoice_number.'/'.$file_name);

            $files=public_path("img"."/".$invoice_number.'/'.$file_name);
             return response()->file($files);


    }
    public function download($invoice_number,$file_name){


            // $files = Storage::disk('photos')->get($invoice_number.'/'.$file_name);

            $files=public_path("img"."/".$invoice_number.'/'.$file_name);

             return response()->download($files);


    }


    // public function perview($invoice_number,$filename)
    // {
    //     $filePath = 'img/'.$invoice_number.'/'. $filename;
    
    //     if (Storage::exists($filePath)) {
    //         $fileContents = Storage::get($filePath);
    //         $mimeType = Storage::mimeType($filePath);
    
    //         return response($fileContents, 200)
    //             ->header('Content-Type', $mimeType);
    //     }
    
    //     abort(404, 'File not found');
    // }
}

