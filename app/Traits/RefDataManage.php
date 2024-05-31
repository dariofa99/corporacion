<?php
namespace App\Traits;

use App\Models\ReferenceData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * 
 */
trait RefDataManage
{
    public function getDataVal($ref_id, $ref_option)
    {
        $ref_data = $this->aditional_data()
            ->where([
                'reference_data_id' => $ref_id,
                'reference_data_option_id' => $ref_option
            ])->first();

        if ($ref_data) {
            return $ref_data;
        }
        return false;
    }

    public function getReferences($section, $category)
    {
        $ref_data = ReferenceData::where([
                'section' => $section,
                'categories' => $category,
                "table"=>$this->getTable()
            ])->get();

         if ($ref_data) {
            return $ref_data;
        }
        return new Collection();
    }
}