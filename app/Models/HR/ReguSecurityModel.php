<?php

namespace App\Models\HR;

use CodeIgniter\Model;

class ReguSecurityModel extends Model
{
    protected $DBGroup = 'ci4hr';
    protected $table      = 'tb_regu_security';
    protected $primaryKey = 'id';

    protected $allowedFields = ['regu', 'nama_1', 'nama_2'];

}