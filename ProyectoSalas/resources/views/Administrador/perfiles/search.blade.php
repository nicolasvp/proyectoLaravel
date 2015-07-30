@extends('layouts/master')

@section('sideBar')


 
<div class="panel panel-default" style="margin-top: 40px;">          
          @include('Administrador/menu')
       
  <div class="panel-body">                  
                  
   <div class="row">

<div class="col-sm-9" >
  <p> <h2>Buscar Usuario</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

<<<<<<< HEAD
   @include('Administrador/messages')
   
=======
 
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416
      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>
       
      @endif


{!! Form::open(['action' =>  ['Administrador\PerfilController@get_show'], 'method' => 'GET', 'class' => 'navbar-form navbar-left', 'role' => 'search']) !!}
  <div class="form-group">
    {!! Form::text('rut', null, ['class' => 'form-control', 'placeholder' => 'Ingresa el rut']) !!}
  </div>
  <button type="submit" class="btn btn-default">Buscar</button>
{!! Form::close() !!}


      
</div>

</div>


</div>

                    
</div>

    </div>
      </div>
    </div>

@stop