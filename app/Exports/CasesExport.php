<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\CasesExportSheet;

class CasesExport implements WithMultipleSheets
{
    use Exportable;

    public $data;
   // public $header;
    public function __construct($data)
    {
       $this->data = $data;
      
    }
   /*  public function collection()
    {
        return $collection = collect($this->data);;
    }
    public function headings(): array
    {
        return $this->header;
    } */

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->data as $key => $data) {
            $sheets[] = new CasesExportSheet($data['data'], $data["header"],$data["title"]);
        }
        /* for ($th = 1; $month <= 12; $month++) {
            $sheets[] = new InvoicesPerMonthSheet($this->year, $month);
        } */

        return $sheets;
    }
}