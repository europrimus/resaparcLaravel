@include('include/head')

@if(null === session('billet') )
  <h2>Billet SVP ?</h2>
  <form method="post"  action="/">
    @csrf
    <label for="billet" >Billet:</label>
    <input type="text" id="billet" name="billet" placeholder="N° billet" value="{{ old('billet') }}" size="8"
    class="{{ ($errors->has('billet')) ? "erreur" :'' }}">
    <p class="erreur">{{ $errors->first('billet') }}</p>

  </form>
@else
  <p>Billet déjà enregistré<br>
    <a href="/deconexion">ce déconnecter</a>
  </p>
@endif

@include('include/footer')
