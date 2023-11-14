<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    
    public function index(){


        return view("reports.reports");

    }
    public function get_invoice_number(Request $request){


       $invoice_number=$request->search;

      $invoice=invoices::where("invoice_number", $invoice_number)->first();


      return view("reports.reports",compact("invoice"));

       

    }
    public function get_invoices(Request $request){


        // return $request->value_status;

        if ($request->value_status==1||$request->value_status==2||$request->value_status==3 && $request->date1=='' and $request->date2=='') {

            $status=$request->value_status;

            $invoices=invoices::where("value_status", $status)->get();
      
      
           return view("reports.reports",compact("invoices","status"));
      
            
        }elseif($request->value_status==4 && $request->date1=='' && $request->date2=='') {

            // return "hhhhhhhh";
             $invoices=invoices::get();

            $status=$request->value_status;
            return view("reports.reports",compact("invoices","status"));


        }elseif($request->value_status==4) {

            $date1=$request->date1;
            $date2=$request->date2;
            $invoices=invoices::whereBetween('invoice_Date',[$date1, $date2])->get();

            return view("reports.reports",compact("invoices","date1","date2"));


        }else{
            

            $status=$request->value_status;
            $date1=$request->date1;
            $date2=$request->date2;

            $invoices=invoices::whereBetween('invoice_Date',[$date1, $date2])->where("value_status",$status)->get();

            return view("reports.reports",compact("invoices","date1","date2","status"));


        }

       

    }


    public function section_report()
    {

       $sections=sections::get();
        
        return view("reports.section_reports",compact("sections"));
    }

    public function show_table(Request $request)
    {



        if ($request->Section && $request->product!=1 && $request->date1=='' && $request->date2=='') {
           
        $invoices=invoices::where("sections_id",$request->Section)->where("product",$request->product)->get();
        $sections=sections::get();

        return view("reports.section_reports",compact("invoices","sections"));

        }elseif($request->Section && $request->product!=1 && $request->date1 && $request->date2){

            $date1=$request->date1;
            $date2=$request->date2;
            $invoices=invoices::whereBetween("invoice_Date",[$date1,$date2])->where("sections_id",$request->Section)->where("product",$request->product)->get();
            $sections=sections::get();
    
            return view("reports.section_reports",compact("invoices","sections"));


        }elseif($request->Section && $request->product==1 && $request->date1 && $request->date2){


            $date1=$request->date1;
            $date2=$request->date2;
            $invoices=invoices::whereBetween("invoice_Date",[$date1,$date2])->where("sections_id",$request->Section)->get();
            $sections=sections::get();
    
            return view("reports.section_reports",compact("invoices","sections"));


        }elseif($request->Section && $request->product==1 && $request->date1=="" && $request->date2==""){

            $date1=$request->date1;
            $date2=$request->date2;
            $invoices=invoices::where("sections_id",$request->Section)->get();
            $sections=sections::get();
    
            return view("reports.section_reports",compact("invoices","sections"));

        }    
        
    }

 

    


    
}
