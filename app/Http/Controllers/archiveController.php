<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use Illuminate\Http\Request;

class archiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * trnsform invoices to archive
     */
    public function update(Request $request, $id)
    {
        $invoice = invoices::find($id);
        $invoices_details = invoices_details::where("invoices_id",$id)->get();
      $attachment=invoices_attachments::where('invoices_id',$id)->get();


      foreach($invoices_details as  $invoices_detail){

        $invoices_detail->delete();

      }
      foreach($attachment as  $attachments){

        $attachments->delete();

      }
       
        $invoice->delete();


        session()->flash("archive","تمت أرشفة الفاتورة");

        return redirect("invoices");

    }

    /**
     * trnsform invoices from archive (restore)
     */
    public function destroy( $id)
    {
        $invoice = invoices::where("id",$id)->onlyTrashed()->first();
        $invoices_details = invoices_details::where("invoices_id",$id)->onlyTrashed()->get();
      $attachment=invoices_attachments::where('invoices_id',$id)->onlyTrashed()->get();

    //    $file_name= $attachment->file_name;
    //    $invoice_number= $attachment->invoice_number;
       
        // Storage::disk('photos')->deleteDirectory($invoice_number);

        
      foreach($invoices_details as  $invoices_detail){

        $invoices_detail->restore();

      }
      foreach($attachment as  $attachments){

        $attachments->restore();

      }
       

        $invoice->restore();


        session()->flash("unarchive","تم النقل بنجاح");

        return redirect()->back();        
    }
}
