<?php

namespace Qualifier\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    protected $fillable = ['name'];

    public $timestamps = false;

    public function language(){
        return $this->belongsTo(Language::class);
    }

    public function documents(){
        return $this->hasMany(Document::class);
    }
    public function words(){
        $words = null;
        $this->with(['documents.words' => function ($query) use(&$words){
            $words = $query->get()->unique();
        }])->get();
        return $words;
    }
    public static function getAll(){
        return self::with('documents.words')->get();
    }
}