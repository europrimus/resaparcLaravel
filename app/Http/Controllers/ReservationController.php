<?php

namespace App\Http\Controllers;

use App\reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

      $reservations = DB::table('reservation')
            ->join('manege', 'reservation.id_manege', '=', 'manege.id')
            ->where('numero_billet', '=', session('billet') )
            ->select('reservation.id','horaire', 'id_manege', 'nom', 'duree', 'numero_plan', 'consignes')
            ->get();
      //dd($reservations);
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

    $r = DB::select('SELECT reserver_prochain_tour( :id_manege , :numero_billet );',
     [ "id_manege" => $id, "numero_billet" => session('billet') ]);
    $message = "Réservation prise en compte";
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
      DB::table('reservation')
            ->where('numero_billet', '=', session('billet') )
            ->where('id', '=', $id )
            ->delete();
      $message = "Réservation annulé";
      return $this->index($message);
    }
}
