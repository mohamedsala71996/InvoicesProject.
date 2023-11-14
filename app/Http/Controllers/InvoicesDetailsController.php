<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use Illuminate\Http\Request;

class InvoicesDetailsController extends Controller
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
       

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoice=invoices::find($id);
        $invoices_attachments=invoices_attachments::where("invoices_id",$id)->get();
        $invoices_details=invoices_details::where("invoices_id",$id)->get();

        return view("invoices.Invoices_Details",compact("invoice","invoices_details","invoices_attachments"));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $invoices=invoices::find($id);
        $sections=sections::get();

        return view("invoices.edit_status",compact("invoices","sections"));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        // return $request;
        $invoices=invoices::find($id);
        // $status=($request->value_status==1) ? "مدفوعة" ($request->value_status==2): "غير مدفوعة": "غير مدفوعة جزئيا" ;
        if ($request->value_status==1) {
            $status="مدفوعة";
        }elseif ($request->value_status==2) {
            $status="غير مدفوعة";

        }else{
            $status="مدفوعة جزئيا";

        }
        invoices_details::create([
            "invoice_number"=>$request->invoice_number,
            "invoices_id"=>$id,
            "product"=>$invoices->product,
            "Section"=>$invoices->sections_id,
            "Status"=> $status,
            "Value_Status"=>$request->value_status,
            "Payment_Date"=>$request->Payment_Date,
            "note"=>$request->note,
            "created_by"=>auth()->user()->name
        ]);

      $invoices= invoices::where('id',$id)->update([
        "Status"=> $status,
        "Value_Status"=>$request->value_status,
        ]);


        session()->flash("status","تم تغيير الحالة بنجاح");
         return redirect("invoices");



    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }
}
