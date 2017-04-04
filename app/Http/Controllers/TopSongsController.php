<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;

class TopSongsController extends Controller
{
    public function index() {
      $songs = Song::all();
      
      return $songs;
    }
}
