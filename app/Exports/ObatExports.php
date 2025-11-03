<?php

namespace App\Exports;

use App\Models\Obat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ObatExports implements FromCollection, WithHeadings, WithStyles, WithCustomStartCell, ShouldAutoSize, WithEvents
{
    protected $totalStok = 0;

    public function collection()
    {
        return Obat::select(
            'nama',
            'harga_beli',
            'harga_jual',
            'stok'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Nama Obat',
            'Harga Beli',
            'Harga jual',
            'Stok'
        ];
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                //Judul
                $company = "Apotek Alfamed";
                $title = "Laporan Stok Obat";
                $sheet->mergeCells('A1:D1');
                $sheet->mergeCells('A2:D2');
                $sheet->setCellValue('A1', $company);
                $sheet->setCellValue('A2', $title);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A3')->getFont()->setBold(true);
                $sheet->getStyle('A1:D4')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A4:D4')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('6AFFC2');

                $dataCount = Obat::count();

                $this->totalStok = Obat::sum('stok');
                
                $rowTotal = $dataCount + 5;

                //total Stok
                $sheet->setCellValue("C{$rowTotal}", 'Total Stok:');
                $sheet->setCellValue("D{$rowTotal}", $this->totalStok);
                $sheet->getStyle("C{$rowTotal}:D{$rowTotal}")->getFont()->setBold(true);

                // border pada tabel
                $range = "A4:D" . ($rowTotal-1);
                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            4 => ['font' => ['bold' => true]]
        ];
    }
}
