<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetails;
use App\Models\User;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function reportPDF($userId, $reportType, $dateFrom = null, $dateTo = null)  
    {
        $data = [];

        if ($reportType == 0) {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d') . ' 00:00:00';
        }
        
        if ($userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->where('user_id', $userId)
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId);
        $data2 = [
            'data' => $data,
            'reportType' => $reportType, 
            'dateFrom' => $dateFrom, 
            'dateTo' => $dateTo, 
            'user' => $user
        ];

        
        $pdf = Pdf::loadView('pdf.report', $data2);
        return $pdf->stream('reporte-ventas.pdf');
    }
}
