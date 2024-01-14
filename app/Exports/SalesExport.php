<?php

namespace App\Exports;

use App\Models\Sale;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class SalesExport implements FromCollection, WithHeadings, WithTitle, WithCustomStartCell, WithStyles
{
    protected $userId, $dateFrom, $dateTo, $reportType;

    function __construct($userId, $reportType, $f1, $f2)
    {
        $this->userId = $userId;
        $this->reportType = $reportType;
        $this->dateFrom = $f1;
        $this->dateTo = $f2;
    } 
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = [];
        if ($this->reportType == 1) {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d') . ' 23:59:59';
        }else {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 23:59:59';
        }

        if ($this->userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.id', 'sales.total', 'sales.items', 'sales.status', 'u.name as user', 'sales.created_at')
                ->where('user_id', $this->userId)
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Define your column headings here
        return [
            'FOLIO',
            'IMPORTE',
            'ITEMS',
            'ESTATUS',
            'USUARIOS',
            'FECHA',
            // Add more columns as needed
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        // Define the title for the Excel sheet
        return 'Reporte de ventas';
    }

    /**
     * @return string
     */
    public function startCell(): string
    {
        // Define the starting cell for the data
        return 'A2';
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        // Define any styles you want to apply to the sheet
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }
}
