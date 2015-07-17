@extends('layouts/master')



@section('sideBar')



@include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Lista de salas</h2></p>


      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

        
          {!! Form::open(['action' => ['Encargado\SalaController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Campus,Tipo,Nombre']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Campus</th>
              <th>Tipo</th>
              <th>Nombre</th>
              <th>Capacidad</th>
              <th>Descripción</th>
              <th></th>
              <th></th>
            </tr>

            
            @foreach($datos_salas as $sala)

            <tr>
               <td>{{ $sala->id }}</td>
               <td>{{ $sala->campus}}
               <td>{{ $sala->tipo}}</td>
               <td>{{ $sala->nombre}}</td>
               <td>{{ $sala->capacidad}}</td>
               <td>{{ $sala->descripcion}}</td>


          <td>
                 {!! Form::open(['action' => ['Encargado\SalaController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id_sala', $sala->id)!!}
                 <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                 {!! Form::close() !!}

          </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_salas->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop