@extends('layouts/master')




@section('sideBar')



@include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Modificar la sala</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


   
      {!! Form::model($datos_sala, ['action' => ['EncargadoController@put_updateSala', $datos_sala], 'method' => 'PUT']) !!}

      <div class="form-group">
       {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>

      <div class="form-group">
        {!! Form::label('capacidad', 'Capacidad') !!}
       {!! Form::text('capacidad', null,['class' => 'form-control', 'placeholder' => 'Ingresa capacidad']) !!}
      </div>

       {!! Form::hidden('id', $id)!!}

      <div align=center><button type="submit" class="btn btn-info">Actualizar</button></div>

      {!! Form::close() !!}


</div>
</div>
</div>

                    
</div>


      </div>
    </div>


<!--
 <script src="http://localhost:8000/js/jquery-1.11.3.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
                 $('.btn').click(function (){
                    alert("kjsdkajsdakj");
                 });
       });
      </script>

-->
                    
@stop