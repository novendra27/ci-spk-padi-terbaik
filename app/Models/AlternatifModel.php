<?php

namespace App\Models;

use CodeIgniter\Model;

class AlternatifModel extends Model
{
    protected $table = 'tb_alternatif';
    protected $primaryKey = 'id_alternatif';
    protected $allowedFields = ['nama_alternatif'];
}
