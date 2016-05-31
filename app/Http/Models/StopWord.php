<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class StopWord extends Model {
    protected $fillable = ['name'];

    public $timestamps = false;

    public function language(){
        return $this->belongsTo(Language::class);
    }
}