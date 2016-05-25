<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
    public $timestamps = false;

    public function topics(){
        return $this->hasMany(Topic::class);
    }
    public function documents(){
        return $this->hasManyThrough(Document::class, Topic::class);
    }

    public function scopeOfLang($query, $lang_name){
        return $query->where('name', $lang_name)->first();
    }
}