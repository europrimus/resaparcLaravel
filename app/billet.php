<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class billet extends Model
{
    //
    public function deconnexion()
    {
          session(['billet'=> null]);
          return "Vous êtes déconecté";;
    }

    public function connexion( $request ){
      $billet = $request->validated();
      session(['billet'=> $billet['billet']]);
      return "Billet enregistré";
    }

    public function check(){
      if( null !== session('billet') ){
        return true;
      }else{
        return false;
      }
    }
}
