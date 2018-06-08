@include('include/head')
<h2>Reservations</h2>

<ul>
  <!--'id','horaire', 'id_manege', 'nom', 'duree', 'numero_plan', 'consignes'-->
  @forelse ($reservations as $reservation)
    <li>
      <details>
        <summary>{{ $reservation->nom }}  à {{ $reservation->horaire }}
          <a href="/reservation/{{ $reservation->id }}/annuler">Annuler</a></summary>
        <ul>
          <li>Durée : {{ $reservation->duree }}</li>
          <li>Consignes : {{ $reservation->consignes }}</li>
          <li>Voir plan : {{ $reservation->numero_plan }}</li>
        </ul>
      </details>
    </li>
  @empty
    <li>Pas de reservation</li>
  @endforelse
</ul>

@include('include/footer')
