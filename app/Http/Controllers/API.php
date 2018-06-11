<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\billet;
use App\manege;
use App\reservation;
use App\Http\Requests\BilletRequest;

class API extends Controller
{

    public function connexion(BilletRequest $request ){
      $billetObj = new billet;
      $message = $billetObj->connexion( $request );
      return response()->json([
          'message' => $message,
          ]);
    }

    public function deconnexion(){
      $billetObj = new billet;
      $message=$billetObj->deconnexion();
      return response()->json([
          'message' => $message,
          ]);
    }

    public function manege(){
      $maneges = manege::all()->toArray();
      $message = "Liste des manèges";
      //dd($maneges);
      //return response()->json($maneges);
      return response()->json([
        'message' => $message,
        'manege' => $maneges,
        ]);
    }

    public function reserver( $idManege ){
      $billetObj = new billet;
      if( !$billetObj->check() ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
      }else{
        $resaObj= new reservation;
        $message=$resaObj->set( $idManege , session('billet') );
      }
      return response()->json([
          'message' => $message,
          ]);
    }

    public function reservation(){
      $billetObj = new billet;
      if( !$billetObj->check() ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
        $reservations =[];
      }else{
        $message='';
        $resaObj= new reservation;
        $reservations=$resaObj->get( session('billet') );
      }
      return response()->json([
          'reservations' => $reservations,
          'message' => $message,
          ]);
    }

    public function annuler( $idResa ){
      $resaObj= new reservation;
      $message=$resaObj->delette( $idResa , session('billet') );
      return response()->json([
          'message' => $message,
          ]);
    }
}
