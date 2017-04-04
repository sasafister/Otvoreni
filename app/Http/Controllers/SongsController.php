<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Song;
use Carbon\Carbon;
use App\TopSongs;

class SongsController extends Controller
{
    public function index() {
      $songs = TopSongs::all();
      $groupSongs = $songs->groupBy('song_id');
      foreach($groupSongs as $song) {
        $result[(string) $song->first()->song] = count($song);
      }
      arsort($result);
      $songs = [];
      foreach($result as $key => $value) {
        $songs[] = ['song' => json_decode($key), 'played' => $value];
      }
      // dd($songs[0]['song']->artist);
      return view('top_songs', compact('songs'));
    }

    public function store() {
      $data = request()->input();

      $played = $data['played'];
      $array = explode("\n", $played);
      $songs = array_filter($array, function($value) { return $value !== ''; });

      $withImg = [];
      foreach ($songs as $item) {
        $withImg[] = preg_replace('/\t+/', '', strip_tags($item, '<img>'));
      }
      $clearArr = array_filter($withImg);
      $songsReset = array_values($clearArr);

      $final = [];
      for($i = 0; $i < (count($songsReset)-2); $i++) {
        $final[] = [
        // strip down img tag, left only src
        substr(substr($songsReset[$i], 10), 0, strpos(substr($songsReset[$i], 10), "\"")),
        $songsReset[$i+1], 
        $songsReset[$i+2]];
        $i = $i + 2;
      }
      $resultArray = [];

      $image = $data['art'];
      if (substr($image, 0, 7) != "http://" && substr($image, 0, 8) != "https://") {
        $image = 'http://www.otvoreni.hr' . $data['art'];
      }

      $song = $resultArray['playing'] = [$data['song'], $data['artist'], $image];
      $resultArray['played'] = $final;

      $songs = Song::all();
      if($song[0] != $songs->last()['name'] && $song[1] != $songs->last()['artist']) {
        Song::create([
          'artist' => $song[1],
          'name' => $song[0],
          'artwork' => $song[2]
        ]);
      }

      $this->saveTopSong();
      $this->updateCount($song);
    }

    private function saveTopSong() {
      $topSongs = TopSongs::all();
      $songs = Song::all();
      if(count($topSongs) === 0 || $topSongs->last()->song_id != $songs->last()->id) {
        TopSongs::create([
          'song_id' => $songs->last()->id,
          'played' => 1,
          'date_played' => Carbon::now() 
        ]);
      } 
    }

    private function updateCount($song) {
      $topSongs = TopSongs::all();
      foreach($topSongs as $topSong) {
        if($song[0] === $topSong->song->name) {
          $topSong->played += 1;
          $topSong->save();
        }

      }
    }
}
