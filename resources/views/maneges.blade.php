@include('include/head')
<h2>Manège</h2>
<ul>
  @foreach ($maneges as $manege)
    <li>{{ $manege }}</li>
  @endforeach
</ul>

@include('include/footer')
