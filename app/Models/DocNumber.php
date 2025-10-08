<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocNumber extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getDocCode()
    {
        $new_id = ++$this->last_id;
        return ['code' => $this->prefix . '' . sprintf("%05d", $new_id), 'id' => $new_id];
    }
}
