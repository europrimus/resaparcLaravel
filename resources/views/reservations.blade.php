@include('include/head')
<h2>Reservations</h2>

<ul>
  @forelse ($reservations as $reservation)
    <li>{{ $reservation }}</li>
  @empty
    <li>Pas de reservation</li>
  @endforelse
</ul>

@include('include/footer')
