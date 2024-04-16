<?php

namespace App\Exports;

use App\Models\Ecode;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class EcodeExport extends DefaultValueBinder implements FromView, WithCustomValueBinder
{
    protected $date_lot;
    protected $number_lot;
    public function __construct(string $date_lot, string $number_lot)
    {
        $this->date_lot = $date_lot;
        $this->number_lot = $number_lot;
    }
    public function view(): View
    {

        return view('exports.ecode', [
            'content' => Ecode::where(['date_lot' => $this->date_lot, 'number_lot' => $this->number_lot])->get()
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
