@extends('layouts/master')



@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">         
            @include('Administrador/menu')  
       

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Selección de Departamento para el Perfil</h2></p>

      @if(Session::has('message'))

           <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">

    @include('Administrador/messages')

       <div class="form-group">
  


 {!! Form::open(['action' => 'Administrador\PerfilController@post_docente', 'method' => 'POST']) !!}


    <div class="form-group">
    {!! Form::select('departamento', (['0' => '-- Seleccionar un departamento --']  +$departamentos), null, ['class' => 'form-control'])!!}
    </div>

    <div class="form-group">
    {!! Form::hidden('rut', $rut)!!}
    </div>

    <div class="form-group">
    {!! Form::hidden('rol', $rol)!!}
    </div>
    
     <div align="center"<th><button type="submit" class="btn btn-primary">Siguiente</button></th></div>


    {!! Form::close() !!}


</div>
</div>
</div>

                    
</div>


      </div>
    </div>

      </div>
    </div>


                    
@stop