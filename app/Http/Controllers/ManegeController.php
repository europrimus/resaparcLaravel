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
    public function index()
    {
      $maneges = manege::all();
      return view('maneges')->with('maneges',$maneges);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\manege  $manege
     * @return \Illuminate\Http\Response
     */
    public function show(manege $manege)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\manege  $manege
     * @return \Illuminate\Http\Response
     */
    public function edit(manege $manege)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\manege  $manege
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, manege $manege)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\manege  $manege
     * @return \Illuminate\Http\Response
     */
    public function destroy(manege $manege)
    {
        //
    }
}
