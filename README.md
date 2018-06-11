# **Resaparc** Laravel
## Exercice fullstack avec Laravel : **le retour de resaparc**
- Utilisez le script fourni pour créer une base de données (créez d'abord un utilisateur resaparc)
- Créez un projet Laravel qui utilise cette base, sans Ajax dans un premier temps
- Une fois à l'aise avec Laravel, passez les fonctions essentielles en Ajax (réserver un manège, annuler une réservation, refresh automatique des pages)
- Faîtes des groupes (compo libre) et créez un repo par groupe, je veux des projets fonctionnels, esthétiques, bien commentés pour mardi soir


## Quelques explications sur le script :
- Pour réserver un tour : SELECT reserver_prochain_tour( _id manege_ , _numero billet_ );
- Pour lister les manèges : SELECT * FROM vue_manege;

la vue _vue_manege_ contient tous les champs de la table manège + un champ _fermeture_dans_ représentant le temps restant avant la fermeture du manège en question


Créer un utilisateur PG

    CREATE ROLE resaparc LOGIN
      ENCRYPTED PASSWORD 'vive les licornes!'
      NOSUPERUSER INHERIT NOCREATEDB NOCREATEROLE NOREPLICATION;

## API
l'API est accessible par /api  
Elle attend sur POST un json et renvois un json  
Un échange de token permet de vérifier les transactions

### Les actions
| action       | _token | data              | retour                          |
|:------------|:-------:|:------------------|:--------------------------------|
| connexion   |         |numéro de  billet  | _token                          |
| deconnexion | oui     |                   | message                         |
| manege      | oui     |                   | _token, liste des manèges       |
| reserver    | oui     | id manège         | _token, message                 |
| reservation | oui     |                   | _token, liste des réservations  |
| annuler     | oui     | id réservation    | _token, message                 |

### Exemple de json

      {"reservations":[{"id":34,"horaire":"2018-06-11 10:10:00","id_manege":2,"nom":"Psych\u00e9d\u00e9licorne","duree":"00:10:00","numero_plan":2,"consignes":"Hauteur min. 1m55"}],"message":"","_token":"KS9skWd33922OHYqzlYuvvu1eZIAtNHvRTVMcgYU"}
