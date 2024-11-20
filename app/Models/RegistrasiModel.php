<?php

namespace App\Models;

use CodeIgniter\Model;

class RegistrasiModel extends Model
{
    protected $DBGroup = 'maklon';
    protected $table = 'registrasi';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tanggal_mou', 'nomor_surat', 'nama_perusahaan', 'user', 'merk', 'akhir_kontrak'
    ];
}
