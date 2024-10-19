<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;


class CasesExportSheet implements FromCollection,WithHeadings,WithTitle
{
    

    public $data;
    public $header;
    public $title;
    public function __construct($data,$header,$title)
    {
       $this->data = $data;
       $this->header = $header;
       $this->title = $title;
    }
    public function collection()
    {
        ini_set('memory_limit', '1024M');
        return $collection = collect($this->data);;
    }
    public function headings(): array
    {
        return $this->header;
    }

    public function title(): string
    {
        return $this->title;
    }


}