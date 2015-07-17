@extends('layouts/master')

@section('welcome')
<a class="navbar-brand" href="/administrador">Gestión de Salas UTEM</a>
@stop


@section('sideBar')



 @include('Administrador/menu')

  <div class="col-sm-9">
   <p>                                                    
                        </p>
                        <div class="bs-docs-section">                
<div class="panel panel-default">
<div class="panel-body">
  <div class="form-group">
  <div class="jumbotron">
       @if(Session::has('message'))

          
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
     
    </div>
  </div>

                    
</div>
</div>
</div>

                    
</div>
@stop