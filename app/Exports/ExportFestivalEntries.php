<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportFestivalEntries implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($entry): array
    {
        $data =  [
            $entry->id,
            $entry->NAME,
            $entry->email,
            $entry->mobile,
            $entry->film_title,
            $entry->film_title_english,
            $entry->LANGUAGE,
            $entry->producer_name,
            $entry->production_company,
            $entry->screener_link,
            // $entry->screener_link,
            '=HYPERLINK("' . $entry->film_link . '", "' . $entry->film_link . '")',
            $entry->PASSWORD,
            $entry->director_name,
        ];
        return $data;
    }

    public function headings(): array
    {
        return [
            'Sr.No',
            'Name',
            'Email',
            'Mobile',
            'Film Title',
            'Film Title English',
            'Language',
            'Producer Name',
            'Production Company',
            'Screener Link',
            'Film Link',
            'Password',
            'Director Name',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'K' => [
                'font' => [
                    'color' => ['rgb' => '0000FF'],
                    'underline' => true,
                ],
            ],
        ];
    }
}
