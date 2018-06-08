<?php

namespace App\Http\Controllers;

use App\manege;
use Illuminate\Http\Request;

class ManegeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($message='')
    {
      $maneges = manege::all();
      return view('maneges')->with('maneges',$maneges)->with("message",$message);
    }

}
