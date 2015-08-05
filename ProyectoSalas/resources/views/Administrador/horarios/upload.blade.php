@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

@include('Administrador/menu')


  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Selección de Fecha de Inicio y Término</h2></p>

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
  


 {!! Form::open(['action' => 'Administrador\HorarioController@post_upload','files'=>true]) !!}


        <table class="table table-striped">
        <tr>
        <td><p>Fecha de inicio</p></td>
        <td>{!! Form::date('inicio', \Carbon\Carbon::now()) !!}</td>
        <td><p>Fecha de término</p></td>
        <td>{!! Form::date('termino', \Carbon\Carbon::now()) !!}</td>
        </tr>

         </table>

      <p> <h2>Selección de días</h2></p>
          <table class="table table-striped">
            <tr> 
              <th>   <div class="form-group">Lunes  {!! Form::checkbox('lunes', '1' ) !!}</div></th>
              <th><div class="form-group">Martes  {!! Form::checkbox('martes', '2' ) !!}</div></th>
              <th>     <div class="form-group">Miércoles  {!! Form::checkbox('miercoles', '3' ) !!}</div></th>
              <th><div class="form-group">Jueves  {!! Form::checkbox('jueves', '4' ) !!}</div></th>
              <th>   <div class="form-group">Viernes  {!! Form::checkbox('viernes', '5' ) !!}</div></th>
               <th>   <div class="form-group">Sábado  {!! Form::checkbox('sabado', '6' ) !!}</div></th>
            </tr>
     

          </table>
<div class="form-group">
        <div class="panel-body">
          
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
              <label class="col-md-4 control-label">Seleccione el archivo con los horarios</label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
              </div>
            </div>
        </div>
 </div>

     <div align="center"<th><button type="submit" class="btn btn-success">Subir Horarios</button></th></div>

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