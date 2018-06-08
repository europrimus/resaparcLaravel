<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Resaparc</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="/css/style.css" rel="stylesheet" type="text/css">

    </head>
  <body>
    <header>
      <h1>Resaparc</h1>
      @if(null !== session('billet') )
        <p>Billet : {{ session('billet') }}
        <a href="/deconexion">deconnexion</a></p>
      @endif
  </header>
  @if( !empty($message) )
    <section>
      <p>{{ $message }}</p>
    </section>
  @endif
  <main>
