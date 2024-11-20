<?php

namespace App\Models\Info;

use CodeIgniter\Model;

class LogbookModel extends Model
{
    protected $DBGroup = 'db_log_book';
    protected $table      = 'tb_log';
    protected $primaryKey = 'id';

    protected $useTimestamps = true;

    protected $allowedFields = ['pengambil'];
    protected $updatedField  = 'keluar';
}
