<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BilletRequest;

class BilletController extends Controller
{
  public function index($message='')
  {
    return view('inscription');
  }

  public function register(BilletRequest $request)
  {
    $billet = $request->validated();
    //dd($billet);
    session(['billet'=> $billet['billet']]);
    $message = "Billet enregistré";
    return redirect()->action('ManegeController@index')->with('message',$message);
  }

  public function check(){
    //$billet = session('billet');
    if( null !== session('billet') ){
      return true;
    }else{
      return false;
    }

  }
}
