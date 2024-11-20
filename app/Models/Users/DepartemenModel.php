<?php

namespace App\Models\Users;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table = 'tb_departemen';
    protected $primaryKey = 'departemen';
    protected $allowedFields = ['departemen'];

    public function getDepartments()
    {
        return $this->findAll();
    }
}
