<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model {
    protected $fillable = ['name', 'text'];

    public function topic(){
        return $this->belongsTo(Topic::class);
    }
    public function words(){
        return $this->belongsToMany(Word::class)->withPivot('tf');
    }
    public function scopeVerified($query){
        return $query->where('verified', true);
    }
    public function delete() {
        // TODO утилита удаления не используемых слов
//        $this->words()->delete();
        $this->words()->detach();
        return parent::delete();
    }
}