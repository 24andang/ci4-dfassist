<?php

namespace App\Models\HR;

use CodeIgniter\Model;

class HakCutiModel extends Model
{
    protected $table = 'hak_cuti';
    protected $primaryKey = 'id_hc';

    protected $allowedFields = ['periode', 'jatah_cuti', 'jatah_security', 'jatah_karyawn_baru'];

    // Tambahkan ini untuk memastikan model menggunakan database hr
    protected $DBGroup = 'ci4hr';
}
