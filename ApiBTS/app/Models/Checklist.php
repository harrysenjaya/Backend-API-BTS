<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class Checklist extends Model
{
    protected $table = 'checklist';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    protected $dates = ['created_at', 'updated_at'];


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function checklistItem()
    {
        return $this->hasMany('App\Models\ChecklistItem', 'id_checklist', 'id');
    }

}
