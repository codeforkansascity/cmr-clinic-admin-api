<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChargeExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $dataQuery = null;

    public function __construct($dataQuery)
    {
        $this->dataQuery = $dataQuery;
    }

    public function query()
    {
        return $this->dataQuery;
    }

    ///////////////////////////////////////////////////////////////////////////

    // Add a line of column headings to the top
    public function headings(): array
    {
        return [
                        'id',
                        'conviction_id',
                        'charge',
                        'citation',
                        'conviction_class_type',
                        'conviction_charge_type',
                        'sentence',
                        'convicted_text',
                        'eligible_text',
                        'please_expunge_text',
                        'to_print',
                        'notes',
                        'convicted',
                        'eligible',
                        'please_expunge',
                    ];
    }

    // Map/format each field that's being exported
    // NOTE: to use raw values from SELECT (without having to manually specify
    // each column), comment out this function/"WithMapping" above
    public function map($charge): array
    {
        return [

                        $charge->id,
                        $charge->conviction_id,
                        $charge->charge,
                        $charge->citation,
                        $charge->conviction_class_type,
                        $charge->conviction_charge_type,
                        $charge->sentence,
                        $charge->convicted_text,
                        $charge->eligible_text,
                        $charge->please_expunge_text,
                        $charge->to_print,
                        $charge->notes,
                        $charge->convicted,
                        $charge->eligible,
                        $charge->please_expunge,
                    ];
    }
}
