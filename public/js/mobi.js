// on récupère la validation du billet
jQuery("#inscription form").submit( inscription )

// fait les requetes vers le serveur
function requete(json){
  console.warn("requete");
  console.log(json);
  //jQuery.post( "/api", json , router, "json");
  jQuery.post( "/api", json , router);
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
  let json = JSON.stringify( { action: "connexion", data: billet } );
  requete(json);
}
