@include('include/head')

<h2>Manège</h2>
<ul>
  @forelse ($maneges as $manege)
    <li>
      <details>
        <summary>{{ $manege["nom"] }}
          @if(null !== session('billet') )
            <a href="reserver/{{ $manege['id'] }}">Réserver</a>
          @endif
        </summary>
        <ul>
          <li>Nombre de place : {{ $manege["nb_places_reservables"] }}</li>
          <li>Durée : {{ $manege["duree"] }}</li>
          <li>Ouverture : {{ $manege["heure_ouverture"] }}</li>
          <li>Fermeture : {{ $manege["heure_fermeture"] }}</li>
          <li>Consignes : {{ $manege["consignes"] }}</li>
        </ul>
      </details>
    </li>
  @empty
    <li>Pas de manège</li>
  @endforelse
</ul>

@include('include/footer')
