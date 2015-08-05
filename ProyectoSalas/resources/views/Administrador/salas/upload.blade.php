@extends('layouts/master')




@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">

@include('Administrador/menu')


  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de ID de Campus y Tipos de salas</h2></p>

      @if(Session::has('message'))

        
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif



<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  


 {!! Form::open(['action' => 'Administrador\SalaController@post_upload','files'=>true]) !!}

 <p> <h2>Campus</h2></p>
        <table class="table table-striped">
            <tr> 
              <th>ID</th>
              <th>Nombre</th>
            </tr>

            @foreach($campus as $camp)

            <tr>
               <td>{{ $camp->id}}</td>
               <td>{{ $camp->nombre}}</td>
            </tr>
             @endforeach

        </table>   

 <p> <h2>Tipos de Salas</h2></p>

        <table class="table table-striped">
            <tr> 
              <th>ID</th>
              <th>Nombre</th>
            </tr>

            @foreach($tipos as $tipo)

            <tr>
               <td>{{ $tipo->id}}</td>
               <td>{{ $tipo->nombre}}</td>
            </tr>
             @endforeach

        </table>   
    
 
<div class="form-group">
        <div class="panel-body">
          
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            
            <div class="form-group">
              <label class="col-md-4 control-label">Seleccione el archivo con las salas.</label>
              <div class="col-md-6">
                <input type="file" class="form-control" name="file" >
              </div>
            </div>
        </div>
 </div>

     <div align="center"<th><button type="submit" class="btn btn-success">Subir Salas</button></th></div>

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