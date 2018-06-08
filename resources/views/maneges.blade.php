@include('include/head')

<h2>Manège</h2>
<ul>
  @forelse ($maneges as $manege)
    <li>{{ $manege }}</li>
  @empty
    <li>Pas de manège</li>
  @endforelse
</ul>

@include('include/footer')
