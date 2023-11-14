<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    
    public function index()
    {

        $invoice_count=invoices::count();
        if( $invoice_count>0){
        $invoice_count1=invoices::where("value_status",1)->count()/$invoice_count*100;
        $invoice_count2=invoices::where("value_status",2)->count()/$invoice_count*100;
        $invoice_count3=invoices::where("value_status",3)->count()/$invoice_count*100;
        $invoice_count11=invoices::where("value_status",1)->sum("Total");
        $invoice_count22=invoices::where("value_status",2)->sum("Total");
        $invoice_count33=invoices::where("value_status",3)->sum("Total");
        $chartjs = app()->chartjs
        ->name('barChartTest')
        ->type('bar')
        ->size(['width' => 400, 'height' => 200])
        ->labels([ " الفواتير","نسبة الفواتير الغير مدفوعة","نسبة الفواتير المدفوعة","نسبة الفواتير المدفوعة جزئيا"])
        ->datasets([
            [
                "label" => "الفواتير",
                'backgroundColor' => ['blue'],
                'data' => ["100"]
            ],
            [
                "label" => "نسبة الفواتير الغير مدفوعة",
                'backgroundColor' => ['red'],
                'data' => [ $invoice_count2 ]
            ],
            [
                "label" => "نسبة الفواتير المدفوعة",
                'backgroundColor' => ['green'],
                'data' => [ $invoice_count1]
            ],
            [
                "label" => "نسبة الفواتير المدفوعة جزئيا",
                'backgroundColor' => ['orange'],
                'data' => [ $invoice_count3]
            ],
        ])
        ->options([]);

        $chartjs2 = app()->chartjs
        ->name('pieChartTest')
        ->type('pie')
        ->size(['width' => 400, 'height' => 200])
        ->labels(["اجمالي الفواتير الغير مدفوعة","اجمالي الفواتير المدفوعة","اجمالي الفواتير المدفوعة جزئيا"])
        ->datasets([
            [
                'backgroundColor' => ['red', 'green','orange'],
                'hoverBackgroundColor' => ['red', 'green','orange'],
                'data' => [$invoice_count11, $invoice_count22,$invoice_count33]
            ]
        ])
        ->options([]);

       return view('dashboard', compact('chartjs','chartjs2'));
        }else{
            $invoice_count1=0;
            $invoice_count2=0;
            $invoice_count3=0;
            $invoice_count11=0;
            $invoice_count22=0;
            $invoice_count33=0;
            $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels([ " الفواتير","نسبة الفواتير الغير مدفوعة","نسبة الفواتير المدفوعة","نسبة الفواتير المدفوعة جزئيا"])
            ->datasets([
                [
                    "label" => "الفواتير",
                    'backgroundColor' => ['blue'],
                    'data' => ["100"]
                ],
                [
                    "label" => "نسبة الفواتير الغير مدفوعة",
                    'backgroundColor' => ['red'],
                    'data' => [ $invoice_count2 ]
                ],
                [
                    "label" => "نسبة الفواتير المدفوعة",
                    'backgroundColor' => ['green'],
                    'data' => [ $invoice_count1]
                ],
                [
                    "label" => "نسبة الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['orange'],
                    'data' => [ $invoice_count3]
                ],
            ])
            ->options([]);
    
            $chartjs2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(["اجمالي الفواتير الغير مدفوعة","اجمالي الفواتير المدفوعة","اجمالي الفواتير المدفوعة جزئيا"])
            ->datasets([
                [
                    'backgroundColor' => ['red', 'green','orange'],
                    'hoverBackgroundColor' => ['red', 'green','orange'],
                    'data' => [$invoice_count11, $invoice_count22,$invoice_count33]
                ]
            ])
            ->options([]);
    
           return view('dashboard', compact('chartjs','chartjs2'));
    


        }
    }
}
