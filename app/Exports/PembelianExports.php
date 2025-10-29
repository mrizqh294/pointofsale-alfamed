<?php

namespace App\Exports;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
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

class PembelianExports implements FromQuery, WithHeadings, WithColumnFormatting, WithCustomStartCell, WithEvents, ShouldAutoSize, WithStyles, WithMapping
{
   
    use Exportable;

    protected $filters;
    protected $totalPembelian;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Pembelian::from('tb_pembelian')
            ->join('tb_pengguna', 'tb_pembelian.id_pengguna', '=', 'tb_pengguna.id_pengguna')
            ->join('tb_supplier', 'tb_pembelian.id_supplier', '=', 'tb_supplier.id_supplier')
            ->join('tb_detail_pembelian', 'tb_pembelian.id_pembelian', '=', 'tb_detail_pembelian.id_pembelian')
            ->join('tb_obat', 'tb_detail_pembelian.id_obat', '=', 'tb_obat.id_obat')
            ->select(
                'tb_pembelian.tgl_pembelian',
                'tb_pengguna.nama as nama_pengguna',
                'tb_supplier.nama as nama_supplier',
                'tb_obat.nama as nama_obat',
                'tb_detail_pembelian.jumlah_obat',
                'tb_detail_pembelian.subtotal_pembelian',
            );
        
            
        if (!empty($this->filters['key'])) {
            $query->where('tb_pengguna.nama', $this->filters['key'])
                ->orWhere('tb_supplier.nama', $this->filters['key']);
        }
        if(!empty($this->filters['start_date']) && !empty($this->filters['end_date']))
        {
            $query->whereBetween('tb_pembelian.tgl_pembelian', [$this->filters['start_date'], $this->filters['end_date']]);
        } else if (!empty($this->filters['start_date'])){
            $query->whereDate('tb_pembelian.tgl_pembelian', '>=', $this->filters['start_date']);
        } else if (!empty($this->filters['end_date'])){
            $query->whereDate('tb_pembelian.tgl_pembelian', '<=', $this->filters['end_date']);
        }

        return $query;

    }

    public function map($row): array
    {
        return [
            Date::PHPToExcel(Carbon::parse($row->tgl_pembelian)),
            $row->nama_pengguna,
            $row->nama_supplier,
            $row->nama_obat,
            $row->jumlah_obat,
            $row->subtotal_pembelian,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Pembelian',
            'Pencatat',
            'Supplier',
            'Nama Obat',
            'Jumlah Obat',
            'Sub total',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
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
                    $title = "Laporan Pembelian Periode {$startDate} sd {$endDate}";
                    $dataCount = DetailPembelian::from('tb_detail_pembelian')
                        ->join('tb_pembelian', 'tb_detail_pembelian.id_pembelian', '=', 'tb_pembelian.id_pembelian')
                        ->whereBetween('tb_pembelian.tgl_pembelian', [$this->filters['start_date'], $this->filters['end_date']])->count();
                        $this->totalPembelian = Pembelian::whereBetween('tgl_pembelian', [$this->filters['start_date'], $this->filters['end_date']])->sum('total_pembelian');

                } else if (!empty($this->filters['start_date'])){

                    $startDate = Carbon::parse($this->filters['start_date'])->format('d-m-y');
                    $title = "Laporan Pembelian Mulai Tanggal {$startDate}";
                    $dataCount = DetailPembelian::from('tb_detail_pembelian')
                        ->join('tb_pembelian', 'tb_detail_pembelian.id_pembelian', '=', 'tb_pembelian.id_pembelian')
                        ->whereDate('tb_pembelian.tgl_pembelian','>=', $this->filters['start_date'])->count();
                    $this->totalPembelian = Pembelian::whereDate('tgl_pembelian', '>=', $this->filters['start_date'])->sum('total_pembelian');

                } else if (!empty($this->filters['end_date'])){

                    $endDate = Carbon::parse($this->filters['end_date'])->format('d-m-y');
                    $title = "Laporan Pembelian Sebelum Tanggal {$endDate}";
                    $dataCount = DetailPembelian::from('tb_detail_pembelian')
                        ->join('tb_pembelian', 'tb_detail_pembelian.id_pembelian', '=', 'tb_pembelian.id_pembelian')
                        ->whereDate('tb_pembelian.tgl_pembelian','<=', $this->filters['end_date'])->count();
                    $this->totalPembelian = Pembelian::whereDate('tgl_pembelian', '<=', $this->filters['end_date']) ->sum('total_pembelian');
                        
                } else {
                    $title = "Laporan Pembelian Keseluruhan";
                    $dataCount = DetailPembelian::from('tb_detail_pembelian')
                        ->join('tb_pembelian', 'tb_detail_pembelian.id_pembelian', '=', 'tb_pembelian.id_pembelian')
                        ->count();
                    $this->totalPembelian = Pembelian::sum('total_pembelian');
                }

                //Judul di atas tabel
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', $title);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');


                $rowTotal = $dataCount + 4;

                // Tambah total di bawah tabel
                $sheet->setCellValue("E{$rowTotal}", 'Total Pembelian:');
                $sheet->setCellValue("F{$rowTotal}", $this->totalPembelian);
                $sheet->getStyle("E{$rowTotal}:E{$rowTotal}")->getFont()->setBold(true);

                // Tambahkan border pada tabel (kecuali judul)
                $range = "A3:F" . ($rowTotal-1);
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
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => ['font' => ['bold' => true]]
        ];
    }
}