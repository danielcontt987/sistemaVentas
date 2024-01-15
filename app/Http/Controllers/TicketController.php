<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    public function ticket($id) 
    {
        $saleDetails = SaleDetails::join('products as p', 'p.id', 'sale_details.product_id')
        ->select('sale_details.*', 'p.name as product')
        ->get();

        $total = $saleDetails->sum('price');
        $array = [
            "saleDetails" => $saleDetails,
            "total" => $total,
        ];
        $pdf = Pdf::loadView('pdf.ticket', $array);
        $pdf->set_paper(array(0,0,250,500));
        return $pdf->stream('ticket.pdf');
    }
}
