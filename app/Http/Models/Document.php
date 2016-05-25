<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {
    protected $fillable = ['name', 'text'];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }
    public function words(){
        return $this->belongsToMany(Word::class);
    }
    public function scopeVerified($query){
        return $query->where('verified', true);
    }
    public function delete() {
        $this->words()->delete();
        $this->words()->detach();
        return parent::delete();
    }
}