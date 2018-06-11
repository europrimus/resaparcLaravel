<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\billet;
use App\manege;
use App\reservation;

class API extends Controller
{
    public function router(Request $request)
    {
      //dd($request);
      switch ($request->action) {
        case 'connexion':
          return $this->connexion($request->data);
          break;
        case 'deconnexion':
          return $this->deconnexion($request->_token);
          break;
        case 'manege':
          return $this->manege($request->_token,$request->data);
          break;
        case 'reserver':
          return $this->reserver($request->_token,$request->data);
          break;
        case 'reservation':
          return $this->reservation($request->_token,$request->data);
          break;
        case 'annuler':
          return $this->annuler($request->_token,$request->data);
          break;

        default:
        return response()->json([
            'message' => 'Action non reconnu',
            ]);
          break;
      }
    }


    public function connexion( $numBillet ){
      $billetObj = new billet;
      $message = $billetObj->connexion( $numBillet );
      return response()->json([
          'message' => $message,
          '_token' => csrf_token(),
          ]);
    }

    public function deconnexion($_token){
      $billetObj = new billet;
      $message=$billetObj->deconnexion();
      return response()->json([
          'message' => $message,
          ]);
    }

    public function manege($_token){
      $maneges = manege::all()->toArray();
      $message = "Liste des manèges";
      //dd($maneges);
      //return response()->json($maneges);
      return response()->json([
        'message' => $message,
        'manege' => $maneges,
        '_token' => csrf_token(),
        ]);
    }

    public function reserver( $_token, $idManege ){
      $billetObj = new billet;
      if( !$billetObj->check() ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
      }else{
        $resaObj= new reservation;
        $message=$resaObj->set( $idManege , session('billet') );
      }
      return response()->json([
          'message' => $message,
          '_token' => csrf_token(),
          ]);
    }

    public function reservation($_token){
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
          '_token' => csrf_token(),
          ]);
    }

    public function annuler( $_token, $idResa ){
      $resaObj= new reservation;
      $message=$resaObj->delette( $idResa , session('billet') );
      return response()->json([
          'message' => $message,
          '_token' => csrf_token(),
          ]);
    }
}
