<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class reservation extends Model
{
    protected $table = 'reservation';
    public $timestamps = false;
    protected $fillable = ['numero_billet','horaire','id_manege'];

    public function manege()
      {
          return $this->hasOne('App\manege');
      }

    public function get( $billet ){
      $reservations = DB::table('reservation')
            ->join('manege', 'reservation.id_manege', '=', 'manege.id')
            ->where('numero_billet', '=', $billet )
            ->where('horaire', '>=', now() )
            ->orderBy('horaire', 'desc')
            ->select('reservation.id','horaire', 'id_manege', 'nom', 'duree', 'numero_plan', 'consignes')
            ->get();
    return $reservations;
    }

    public function set( $idManege , $billet ){
      if(empty($idManege)){
        return "Vous devez choisir un manège pour réserver";
      }
      $retour = DB::select('SELECT reserver_prochain_tour( :id_manege , :numero_billet );',
        [ "id_manege" => $idManege, "numero_billet" => $billet ] );
      //dd($r);
      //verifier le résultat
      if($retour){
        $message = "Réservation prise en compte";
      }else{
        $message = "Erreur: Réservation non prise en compte";
      }
      return $message;
    }

    public function delette($id ,$billet ){
      $retour = DB::table('reservation')
            ->where('numero_billet', '=', $billet )
            ->where('id', '=', $id )
            ->delete();
      //verifier le résultat
      if($retour){
        $message = "Réservation annulé";
      }else{
        $message = "Erreur: Impossible d'annuler la réservation";
      }
      return $message;
    }
}
