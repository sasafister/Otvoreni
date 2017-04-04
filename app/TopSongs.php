<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Song;

class TopSongs extends Model
{
    protected $fillable = ['song_id', 'played', 'date_played'];

    public function song() {
      return $this->belongsTo(Song::class);
    }
}
