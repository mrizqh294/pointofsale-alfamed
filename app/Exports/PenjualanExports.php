<?php

namespace App\Exports;

use App\Models\DetailPenjualan;
use App\Models\Penjualan;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\FromQuery;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill as StyleFill;

class PenjualanExports implements FromQuery, WithHeadings, WithColumnFormatting, WithCustomStartCell, WithEvents, ShouldAutoSize, WithStyles, WithMapping
{
   
    use Exportable;

    protected $filters;
    protected $totalPenjualan;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Penjualan::from('tb_penjualan')
            ->join('tb_pengguna', 'tb_penjualan.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->join('tb_detail_penjualan', 'tb_penjualan.id_penjualan', '=', 'tb_detail_penjualan.id_penjualan')
            ->join('tb_obat', 'tb_detail_penjualan.id_obat', '=', 'tb_obat.id_obat')
            ->select(
                'tb_penjualan.tgl_penjualan',
                'tb_pengguna.nama as nama_pengguna',
                'tb_obat.nama as nama_obat',
                'tb_detail_penjualan.jumlah_obat',
                'tb_detail_penjualan.subtotal_penjualan',
            );
        
            
        if (!empty($this->filters['key'])) {
            $query->where('tb_pengguna.nama', $this->filters['key']);
        }
        if(!empty($this->filters['start_date']) && !empty($this->filters['end_date']))
        {
            $query->whereBetween('tb_penjualan.tgl_penjualan', [$this->filters['start_date'], $this->filters['end_date']]);
        } else if (!empty($this->filters['start_date'])){
            $query->whereDate('tb_penjualan.tgl_penjualan', '>=', $this->filters['start_date']);
        } else if (!empty($this->filters['end_date'])){
            $query->whereDate('tb_penjualan.tgl_penjualan', '<=', $this->filters['end_date']);
        }

        return $query;

    }

    public function map($row): array
    {
        return [
            Date::PHPToExcel(Carbon::parse($row->tgl_penjualan)),
            $row->nama_pengguna,
            $row->nama_obat,
            $row->jumlah_obat,
            $row->subtotal_penjualan,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Penjualan',
            'Pencatat',
            'Nama Obat',
            'Jumlah Obat',
            'Sub total',
        ];
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                if(!empty($this->filters['start_date']) && !empty($this->filters['end_date']))
                {

                    $startDate = Carbon::parse($this->filters['start_date'])->format('d-m-y');
                    $endDate = Carbon::parse($this->filters['end_date'])->format('d-m-y');
                    $periode = "Periode {$startDate} sd {$endDate}";
                    $dataCount = DetailPenjualan::from('tb_detail_penjualan')
                        ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
                        ->whereBetween('tb_penjualan.tgl_penjualan', [$this->filters['start_date'], $this->filters['end_date']])->count();
                    $this->totalPenjualan = Penjualan::whereBetween('tgl_penjualan', [$this->filters['start_date'], $this->filters['end_date']])->sum('total_penjualan');

                } else if (!empty($this->filters['start_date'])){

                    $startDate = Carbon::parse($this->filters['start_date'])->format('d-m-y');
                    $periode = "Mulai Tanggal {$startDate}";
                    $dataCount = DetailPenjualan::from('tb_detail_penjualan')
                        ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
                        ->whereDate('tb_penjualan.tgl_penjualan','>=', $this->filters['start_date'])->count();
                    $this->totalPenjualan = Penjualan::whereDate('tgl_penjualan', '>=', $this->filters['start_date'])->sum('total_penjualan');

                } else if (!empty($this->filters['end_date'])){
                    
                    $endDate = Carbon::parse($this->filters['end_date'])->format('d-m-y');
                    $periode = "Sebelum Tanggal {$endDate}";
                    $dataCount = DetailPenjualan::from('tb_detail_penjualan')
                        ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
                        ->whereDate('tb_penjualan.tgl_penjualan','<=', $this->filters['end_date'])->count();
                    $this->totalPenjualan = Penjualan::whereDate('tgl_penjualan', '<=', $this->filters['end_date'])->sum('total_penjualan');
                        
                } else {
                    $periode = "Keseluruhan";
                    $dataCount = DetailPenjualan::from('tb_detail_penjualan')
                        ->join('tb_penjualan', 'tb_detail_penjualan.id_penjualan', '=', 'tb_penjualan.id_penjualan')
                        ->count();
                    $this->totalPenjualan = Penjualan::sum('total_penjualan');
                }


                //Judul
                $company = "Apotek Alfamed";
                $title = "Laporan Penjualan";
                $sheet->mergeCells('A1:E1');
                $sheet->mergeCells('A2:E2');
                $sheet->mergeCells('A3:E3');
                $sheet->setCellValue('A1', $company);
                $sheet->setCellValue('A2', $title);
                $sheet->setCellValue('A3', $periode);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A3')->getFont()->setBold(true);
                $sheet->getStyle('A1:E5')->getAlignment()->setHorizontal('center');
                $sheet->getStyle('A5:E5')->getFill()->setFillType(StyleFill::FILL_SOLID)->getStartColor()->setARGB('6AFFC2');
                

                $rowTotal = $dataCount + 6;

                //total
                $sheet->setCellValue("D{$rowTotal}", 'Total Penjualan:');
                $sheet->setCellValue("E{$rowTotal}", $this->totalPenjualan);
                $sheet->getStyle("D{$rowTotal}:D{$rowTotal}")->getFont()->setBold(true);

                // border pada tabel
                $range = "A5:E" . ($rowTotal-1);
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

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            5 => ['font' => ['bold' => true]]
        ];
    }
}