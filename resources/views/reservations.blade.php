@include('include/head')
<h2>Reservations</h2>
<ul>
  @foreach ($reservations as $reservation)
    <li>{{ $reservation }}</li>
  @endforeach
</ul>

@include('include/footer')
