<?php

namespace App\Models;

use CodeIgniter\Model;

class LinksModel extends Model
{
    protected $table = 'tb_links';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = ['id', 'url_ori', 'url_short', 'created_at','updated_at'];


    function getUrlShort($url)
    {
        return $this->where(['url_short' => $url])->first();
    }
}
