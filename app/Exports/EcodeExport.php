<?php

namespace App\Exports;

use App\Models\EcodeWarehouse;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class EcodeExport extends DefaultValueBinder implements FromView, WithCustomValueBinder
{
    protected $lot;
    protected $campaign_id;
    public function __construct(string $lot, string $campaign_id)
    {
        $this->lot = $lot;
        $this->campaign_id = $campaign_id;
    }
    public function view(): View
    {
        if ($this->lot !== 'all') {
            list($date_lot, $number_lot) = explode('-', $this->lot);
        }
        if (isset($date_lot) && isset($number_lot)) {
            $data = EcodeWarehouse::where(['campaign_id' => $this->campaign_id, 'date_lot' => $date_lot, 'number_lot' => $number_lot])->get();
        } else {
            $data = EcodeWarehouse::where(['campaign_id' => $this->campaign_id])->get();
        }

        return view('exports.ecode', [
            'content' => $data
        ]);
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
