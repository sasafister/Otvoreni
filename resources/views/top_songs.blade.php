<ul>
  @foreach($songs as $song)
  <li> 
    <img src="{{ $song['song']->artwork }}" width="100" /> 
    {{ $song['song']->artist }} - {{ $song['song']->name }}
    <strong>{{ $song['played'] }} played</strong>
  </li>
  @endforeach
</ul>