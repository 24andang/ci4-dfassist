<?php

namespace App\Models;

use CodeIgniter\Model;

class PeriodeCutiModel extends Model
{
    protected $table = 'periode_cuti';
    protected $primaryKey = 'id_periode';

    protected $allowedFields = ['tahun_periode', 'jatah_cuti'];

    // Tambahkan ini untuk memastikan model menggunakan database hr
    protected $DBGroup = 'hr';
}
