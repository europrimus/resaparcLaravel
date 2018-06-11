// on récupère la validation du billet
jQuery("#inscription form").submit( inscription )

let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// fait les requetes vers le serveur
// plus utilisé
function requete(json){
  console.warn("requete");
  console.log(json);
  jQuery.post( "/api", json , router, "json");
  //jQuery.post( "/api", json , router);
}

// traite les retours serveurs
function router(json){
  console.warn("router");
  console.log(json);
}


//
function inscription(event){
  event.preventDefault();
  console.warn("inscription");
  let billet = jQuery("#billet")[0].value;
  console.log( "billet",billet );
  let json = { billet: billet, _token: CSRF_TOKEN };
  jQuery.post( "/api/connexion", json , router, "json");
}
