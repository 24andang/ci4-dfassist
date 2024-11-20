<?php

namespace App\Models\HR;

use CodeIgniter\Model;

class JadwalSecurityModel extends Model
{
    protected $DBGroup = 'ci4hr';
    protected $table      = 'tb_jadwal_security';
    protected $primaryKey = 'id';

    protected $allowedFields = ['tanggal', 'regu', 'nama_1', 'nama_2'];
}
