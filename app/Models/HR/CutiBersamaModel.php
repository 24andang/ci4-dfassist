<?php

namespace App\Models\HR;

use CodeIgniter\Model;
use App\Controllers;

class CutiBersamaModel extends Model
{
    protected $DBGroup = 'ci4hr';
    protected $table      = 'cuti_bersama';
    protected $primaryKey = 'id';

    protected $allowedFields = ['tanggal', 'keterangan', 'tanggal_awal'];

    public function getCutiBersama()
    {
        return $this->select('tanggal')->findAll(); // Mengambil semua tanggal cuti bersama
    }
}
