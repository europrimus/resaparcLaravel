<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Resaparc</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/style.css" rel="stylesheet" type="text/css">

    </head>
  <body>
    <header>
      <h1>Resaparc</h1>
      <div class="BilletOK">
        <p>Billet : <span id="numBillet"></span>
        <button value="deconnexion">deconnexion</button></p>
      </div>
  </header>
  <main>
  <p id="message"></p>


<section id="inscription" class="">
  <div class="BilletPasOK">
    <h2>Billet SVP ?</h2>
    <form>
      <label for="billet" >Billet:</label>
      <input type="text" id="billet" name="billet" placeholder="N° billet" value="" size="8"
      class="">
      <p id="erreurBillet" class="erreur"></p>
      <button value="connexion">Connexion</button>
    </form>
  </div>
  <div class="BilletOK">
    <p>Billet déjà enregistré<br>
      <a href="/deconexion">ce déconnecter</a>
    </p>
  </div>
</section>

<section id="manege" class="cacher">
  <h2>Manège</h2>
  <ul>
      <li class="manege">
        <details id="manege_id">
          <summary><span class="manege_nom"></span>
              <button class="reserver">Réserver</button>
          </summary>
          <ul>
            <li>Nombre de place : <span class="manege_places_reservables"></span></li>
            <li>Durée : <span class="manege_duree"></span></li>
            <li>Ouverture : <span class="manege_heure_ouverture"></span></li>
            <li>Fermeture : <span class="manege_heure_fermeture"></span></li>
            <li>Consignes : <span class="manege_consignes"></span></li>
          </ul>
        </details>
      </li>

      <li class="pasManege">
        Pas de manège
      </li>

  </ul>
</section>

<section id="reservations" class="cacher">
  <h2>Réservation</h2>
  <ul>
      <li class="reservations">
        <details id="reservation_id">
          <summary><span class="reservation_nom"></span>  à <span class="reservation_horaire"></span>
            <button value="annuler">Annuler</button></summary>
          <ul>
            <li>Durée : <span class="reservation_duree"></span></li>
            <li>Consignes : <span class="reservation_consignes"></span></li>
            <li>Voir plan : <span class="reservation_numero_plan"></span></li>
          </ul>
        </details>
      </li>

      <li class="pasReservations">
        Pas de reservation
      </li>

  </ul>
</section>

  </main>
  <footer>
    <nav>
      <div class="bouttonGauche">
          <button value="reservation">Reservations</button>
          <button value="inscription">Inscription</button>
      </div>
      <div>
        <button value="manege">Manège</button>
      </div>
    </nav>
  </footer>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/mobi.js"></script>
  </body>
  </html>
