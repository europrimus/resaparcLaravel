</main>
<footer>
  <nav>
    <div>
      @if(null !== session('billet') )
        <a href="/reservation">Reservations</a>
      @else
        <a href="/">Inscription</a>
      @endif
    </div>
    <div>
      <a href="/manege">Manège</a>
    </div>
  </nav>
</footer>
</body>
</html>
