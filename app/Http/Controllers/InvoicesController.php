<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\User;
use App\Models\invoices_attachments;
use App\Models\invoices_details;
use App\Models\sections;
use App\Notifications\invoiceAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Exports\invoicesExport;
use App\Notifications\invoicesNotifications;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
         $this->middleware('permission:أرشيف الفواتير|الفواتير الغير مدفوعة|الفواتير المدفوعة جزئيا|الفواتير المدفوعة|قائمة الفواتير|الفواتير');


    }
    public function index()
    {
        $invoices = invoices::get();

        return view("invoices.invoices", compact("invoices"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $sections = sections::get();

        return view("invoices.add_invoices", compact("sections"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $invoices = invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'sections_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'tax_rate' => $request->Rate_VAT,
            'tax_value' => $request->Value_VAT,
            'Total' => $request->Total,
            'Status' => "غير مدفوعة",
            'value_status' => 2,
            'note' => $request->note,
            'created_by' => auth()->user()->name,
        ]);

        $invoice_id = invoices::latest()->first()->id;
        $invoice_number = invoices::latest()->first()->invoice_number;

        $invoices_details = invoices_details::create([
            'invoices_id' =>  $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => "غير مدفوعة",
            'Value_Status' => 2,
            'note' => $request->note,
            'created_by' => auth()->user()->name,
        ]);


        if ($request->hasFile("pic")) {

            $validated = $request->validate([
                'pic' => 'required|mimes:jpeg,jpg,png,pdf|max:1000',
            ]);

            $file_name = $request->file("pic")->getClientOriginalName();

            $invoices_attachments = invoices_attachments::create([
                'file_name' => $file_name,
                'invoice_number' => $request->invoice_number,
                'created_by' => auth()->user()->name,
                'invoices_id' => $invoice_id,
            ]);

            $img_name = $request->pic->getClientOriginalName();

            $request->file("pic")->storeAs($request->invoice_number, $img_name, "photos");
            // $request->pic->move(public_path("attatments/".$request->invoice_number, $img_name));
            $users = User::first();
            // $users_db = User::where("id","!=",auth()->user()->id)->get();
            $users_db = User::whereNotIn('id',[auth()->user()->id])->get();
            $user_name=auth()->user()->name;

            Notification::send($users, new invoiceAdd($invoice_id));

            Notification::send($users_db, new invoicesNotifications($invoice_id,$user_name,$invoice_number));

            session()->flash("add", "تمت اضافة الفاتورة بنجاح");

            return redirect()->back();
        }
    }


    public function show(invoices $invoices)
    {
        //
    }


    public function edit($id)
    {
        $invoices = invoices::find($id);
        $sections = sections::get();

        return view("invoices.edit_invoices", compact("invoices", "sections"));
    }


    public function update(Request $request, $id)
    {
        $invoices = invoices::where("id", $id);
        $attachments = invoices_attachments::where("invoices_id", $id);
        $attachments->update([
            "invoice_number" => $request->invoice_number
        ]);
        $attachments = invoices_details::where("invoices_id", $id);
        $attachments->update([
            "invoice_number" => $request->invoice_number
        ]);
        $invoices->update([
            "invoice_number" => $request->invoice_number,
            "due_date" => $request->Due_date,
            "product" => $request->product,
            "sections_id" => $request->Section,
            "Amount_collection" => $request->Amount_collection,
            "Amount_Commission" => $request->Amount_Commission,
            "discount" => $request->Discount,
            "tax_rate" => $request->Rate_VAT,
            "tax_value" => $request->Value_VAT,
            "Total" => $request->Total,
            "note" => $request->note,
        ]);
        session()->flash("update", "تم التحديث بنجاح");

        return redirect("invoices");
    }

    public function destroy(Request $request, $id)
    {

        if ($request->itemId == 1) {
            $invoice = invoices::find($id);
            // $invoices_details = invoices_details::where("invoices_id",$id)->first();
            $attachment = invoices_attachments::where('invoices_id', $id)->first();

            $file_name = $attachment->file_name;
            $invoice_number = $attachment->invoice_number;

            Storage::disk('photos')->deleteDirectory($invoice_number);
            // $attachment->delete();
            // $invoices_details->delete();
            $invoice->forcedelete();


            session()->flash("delete", "تم الحذف نهائيا بنجاح");

            return redirect("invoices");
        } else {
            $invoice = invoices::onlyTrashed()->where("id", $id)->first();
            $invoices_details = invoices_details::onlyTrashed()->where("invoices_id", $id)->first();
            $attachment = invoices_attachments::onlyTrashed()->where('invoices_id', $id)->first();

            $file_name = $attachment->file_name;
            $invoice_number = $attachment->invoice_number;

            Storage::disk('photos')->deleteDirectory($invoice_number);
            $attachment->forceDelete();
            $invoices_details->forceDelete();
            $invoice->forceDelete();


            session()->flash("delete", " تم الحذف نهائيا بنجاح من الأرشيف");

            return redirect("invoices");
        }
    }


    public function getdata($id)
    {

        $data = DB::table('products')->where('sections_id', $id)->pluck("product_name", "id");
        return json_encode($data);
    }

    public function paid_invoces()
    {

        $invoices = invoices::where("value_status", 1)->get();

        return view("invoices.paid_invoices", compact("invoices"));
    }
    public function unpaid_invoces()
    {

        $invoices = invoices::where("value_status", 2)->get();

        return view("invoices.unpaid_invoices", compact("invoices"));
    }
    public function partially()
    {

        $invoices = invoices::where("value_status", 3)->get();

        return view("invoices.partially_paid", compact("invoices"));
    }
    public function get_archive()
    {

        $invoices = invoices::onlyTrashed()->get();

        return view("invoices.archive", compact("invoices"));
    }
    public function print($id)
    {

        $invoices = invoices::find($id);

        return view("invoices.print_invoice", compact("invoices"));
    }

    public function export() 
    {

        return Excel::download(new invoicesExport, 'invoices.xlsx');
    }
    public function markAsRead() 
    {
        $user=auth()->user();

        if($user->unreadNotifications ){

            foreach ($user->unreadNotifications as $notification) {
                $notification->markAsRead();
                return redirect()->back();

            }

        }
        return redirect()->back();

    }
    public function markAsOneRead($id,$invoice_id) 
    {
        
        $user=auth()->user();


        $user->unreadNotifications->where("id",$id)->markAsRead();
    //    $id_invoice= $user->unreadNotifications->where("id",$id)->data["invoice_id"];

        return redirect("details/$invoice_id");


    }

    

}
