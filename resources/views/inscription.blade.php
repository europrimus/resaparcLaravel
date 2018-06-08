@include('include/head')
<h2>Billet SVP ?</h2>
<form method="post"  action="/">
  @csrf
  <label for="billet" >Billet:</label>
  <input type="number" id="billet" name="billet" placeholder="N° billet" value="{{ old('billet') }}" size="8">
  <p>{{ $errors->first('billet') }}</p>
</form>

@include('include/footer')
