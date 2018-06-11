<?php

namespace App\Http\Controllers;

use App\reservation;
use Illuminate\Http\Request;
use App\manege;
use App\billet;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($message='')
    {
      $billetObj = new billet;
      if( !$billetObj->check() ){
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
      $billetObj = new billet;
      if( !$billetObj->check() ){
        $message = "Vous devez entrer votre numéro de billet pour réserver";
        return redirect()->action('BilletController@index', [ 'message'=>$message ] );
      }

    $resaObj= new reservation;
    $message=$resaObj->set( $id , session('billet') );
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
      $message=$resaObj->delette($id , session('billet') );
      return $this->index($message);
    }
}
