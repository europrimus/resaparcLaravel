<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BilletRequest;
use App\billet;

class BilletController extends Controller
{
  public function index(Request $message)
  {
    return view('inscription')->with('message',$message->message);
  }

  public function deconexion()
  {
    $billetObj = new billet;
    $message=$billetObj->deconnexion();
    return view('inscription')->with('message',$message);
  }

  public function register(BilletRequest $request)
  {
    $billetObj = new billet;
    $message = $billetObj->connexion( $request );
    return redirect()->action('ManegeController@index')->with('message',$message);
  }

}
