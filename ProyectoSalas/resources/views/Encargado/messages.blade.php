    @if ($errors->any())
<div class="alert alert-danger" role="alert">
<p>Corrija los siguientes errores por favor</p>
<ul>
  @foreach($errors->all() as $error)
    <li>{{ $error }}</li>

  @endforeach
</ul>
</div>
@endif