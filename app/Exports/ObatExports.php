<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatExports implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{

    public function collection()
    {
        return Obat::select(
            'nama',
            'stok',
            'harga_beli',
            'harga_jual'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama Obat',
            'Stok',
            'Harga Beli',
            'Harga jual'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}
