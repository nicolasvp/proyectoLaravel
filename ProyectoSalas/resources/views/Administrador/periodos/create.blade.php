@extends('layouts/master')


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
         
            @include('Administrador/menu')
            
     <div class="panel-body">                  
                  
   <div class="row">    

         <div class="col-sm-9" >
                            <p>
                         {!! Form::open(['action' => 'Administrador\PeriodoController@get_upload', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-info pull-right">Subir archivo</button>

                         {!! Form::close() !!}
         </p>

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif

   <p> <h2>Ingrese los datos para el período</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
        @include('Administrador/messages')
       <div class="form-group">
  
      {!! Form::open(['action' => ['Administrador\PeriodoController@post_store'], 'method' => 'POST']) !!}


     <div class="form-group">
  
        <table class="table table-striped">
        <tr>
        <td><p>Bloque</p></td>
        <td> {!! Form::text('bloque', null,[ 'placeholder' => 'Ejemplo: I']) !!}</td>
        <td><p>Inicio</p></td>
        <td> <input type="time" name="inicio" required></td>
        <td><p>Término</p></td>
        <td><input type="time" name="fin" required></td>
        </tr>

         </table>


      <div align=center><button type="submit" class="btn btn-success">Aceptar</button></div>

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