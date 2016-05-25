<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model {
    protected $fillable = ['name'];

    public $timestamps = false;

    public function documents(){
        return $this->belongsToMany(Document::class);
    }
}