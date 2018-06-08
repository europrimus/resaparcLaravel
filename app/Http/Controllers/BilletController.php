<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BilletRequest;

class BilletController extends Controller
{
  public function index(Request $message)
  {
    return view('inscription')->with('message',$message->message);
  }

  public function deconexion()
  {
    session(['billet'=> null]);
    $message="Vous êtes déconecté";
    return view('inscription')->with('message',$message);
  }

  public function register(BilletRequest $request)
  {
    $billet = $request->validated();
    session(['billet'=> $billet['billet']]);
    $message = "Billet enregistré";
    return redirect()->action('ManegeController@index')->with('message',$message);
  }

  public function check(){
    if( null !== session('billet') ){
      return true;
    }else{
      return false;
    }

  }
}
