<?php

namespace App\Models;

use CodeIgniter\Model;

class SuratCutiModel extends Model
{
    protected $table = 'surat_cuti';
    protected $primaryKey = 'id_cuti';

    protected $allowedFields = [
        'nama',
        'periode_cuti',
        'awal_cuti',
        'akhir_cuti',
        'jumlah_cuti',
        'jatah_cuti',
        'sisa_cuti',
        'approval1',
        'approval2',
        'approval3',
        'periode_cuti_id'
    ];

    protected $DBGroup = 'hr';

    public function getLatestPeriod()
    {
        return $this->db->table('periode_cuti')
            ->select('*')
            ->orderBy('tahun_periode', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();
    }

    public function getRemainingLeave($userName, $periodId)
    {
        return $this->db->table('surat_cuti')
            ->select('sisa_cuti')
            ->where('nama', $userName)
            ->where('periode_cuti_id', $periodId)
            ->orderBy('id_cuti', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();
    }
}
