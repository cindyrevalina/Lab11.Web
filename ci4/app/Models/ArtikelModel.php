<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikels';
    protected $primaryKey = 'id';
    protected $allowedFields = ['judul', 'slug', 'isi'];
    protected $useTimestamps = true;
}