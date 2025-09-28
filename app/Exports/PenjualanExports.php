<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenjualanExports implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
{
   
    use Exportable;

    protected $filters;

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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}