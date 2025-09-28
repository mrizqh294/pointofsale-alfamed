<?php

namespace App\Exports;

use App\Models\Pembelian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PembelianExports implements FromQuery, WithHeadings, ShouldAutoSize, WithStyles
{
   
    use Exportable;

    protected $filters;

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
            $query->whereDate('tb_pembelian.tgl_penjualan', '<=', $this->filters['end_date']);
        }

        return $query;

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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}