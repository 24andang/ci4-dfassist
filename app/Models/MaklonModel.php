<?php

namespace App\Models;

use CodeIgniter\Model;

class MaklonModel extends Model
{
    protected $DBGroup = 'tests';
    protected $table      = 'tabel_registrasi';
    protected $allowedFields = ['tgl_mou', 'no_surat', 'nama_perusahaan'];
}
