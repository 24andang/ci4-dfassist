<?php

namespace App\Models\Users;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = 'tb_jabatan';
    protected $primaryKey = 'jabatan';

    protected $allowedFields = ['jabatan', 'level'];
}
