<?php

namespace App\Http\Controllers;

use App\reservation;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use App\manege;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($message='')
    {
      if(null === session('billet') ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
        return redirect()->action('BilletController@index', [ 'message'=>$message ] );
      }

      $resaObj= new reservation;
      $reservations=$resaObj->get( session('billet') );
      return view('reservations')
        ->with('reservations',$reservations)
        ->with("message",$message);
      }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
      if(null === session('billet') ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
        return redirect()->action('BilletController@index', [ 'message'=>$message ] );
      }

    $resaObj= new reservation;
    $retour=$resaObj->set( $id , session('billet') );
    if($retour){
      $message = "Réservation prise en compte";
    }else{
      $message = "Erreur: Réservation non prise en compte";
    }
    return $this->index($message);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $resaObj= new reservation;
      $retour=$resaObj->delette($id , session('billet') );
      if($retour){
        $message = "Réservation annulé";
      }else{
        $message = "Erreur: Impossible d'annuler la réservation";
      }
      return $this->index($message);
    }
}
