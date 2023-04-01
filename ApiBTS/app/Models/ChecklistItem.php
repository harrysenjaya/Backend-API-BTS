<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class ChecklistItem extends Model
{
    protected $table = 'checklist_item';
    protected $primaryKey = 'id';
    protected $fillable = ['name','id_checklist'];
    protected $dates = ['created_at', 'updated_at'];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function checklist()
    {
        return $this->belongsTo('App\Models\Checklist', 'id_checklist', 'id');
    }

}
