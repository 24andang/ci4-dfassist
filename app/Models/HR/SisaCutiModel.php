<?php

namespace App\Models\HR;

use CodeIgniter\Model;

class SisaCutiModel extends Model
{
    protected $DBGroup = 'ci4hr';
    protected $table      = 'tb_sisa_cuti';
    protected $primaryKey = 'id_sisa_cuti';

    protected $allowedFields = ['nik', 'nama', 'periode', 'sisa_cuti', 'jabatan', 'departemen', 'tgl_join'];

    public function getSisaCutiData()
    {
        $builder = $this->db->table($this->table);
        $builder->select('periode, sisa_cuti');
        $builder->where('nik', session()->get('nik')); // Mengambil data berdasarkan nik dari session
        $query = $builder->get();

        $sisaCutiData = [];
        foreach ($query->getResult() as $row) {
            $sisaCutiData[$row->periode] = $row->sisa_cuti;
        }

        return $sisaCutiData;
    }
}
