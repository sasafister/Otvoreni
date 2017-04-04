<h1>Test</h1>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>

<script>
$(document).ready(function () {
  var myUrl = 'http://www.otvoreni.hr';
  var proxy = 'https://cors-anywhere.herokuapp.com/';


  function fetchData() {
    $.ajax({
        url: proxy + myUrl,
        complete:function(data){
            artist = $(data.responseText).find(".current-song-artist").text();
            song = $(data.responseText).find(".current-song-track").text();
            art = $(data.responseText).find(".current-song-cover").attr("src");
            played = $(data.responseText).find(".played-before").find('ul').html();
            $.post( 
                "test/store",
                { song: song, artist: artist, art: art, played: played},
                function(data) {
                  // console.log(data)
                }
             );
        }
    })
  }

  fetchData()
  setInterval(fetchData, 1000 * 120 )
});
</script>