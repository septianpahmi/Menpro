<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RabItem extends Model
{
    protected $fillable = ['rab_id', 'name', 'unit', 'vloume', 'unit_price', 'subtotal'];
    public function rab()
    {
        return $this->belongsTo(Rab::class);
    }
}
