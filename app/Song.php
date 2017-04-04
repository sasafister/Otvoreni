<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model {
    protected $fillable = ['name', 'artist', 'artwork'];
    public static function test() {
      dd('here');
    }
}
