@extends('layouts/master')

@section('sideBar')




       @include('Administrador/menu')
       


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


          {!! Form::open(['action' => ['Administrador\SalaController@get_searchSala'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Campus,Tipo']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


         {!! Form::open(['action' => 'Administrador\SalaController@get_createSala', 'method' => 'GET']) !!}
   
           <button type="submit" class="btn btn-success">Ingresar sala</button>

          {!! Form::close() !!}
         

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Campus</th>
              <th>Tipo</th>
              <th>Capacidad</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_salas as $sala)

            <tr>
               <td>{{ $sala->id}}</td>
               <td>{{ $sala->nombre}}</td>
               <td>{{ $sala->campus}}</td>
               <td>{{ $sala->tipo_sala}}</td>
               <td>{{ $sala->capacidad}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\SalaController@get_editSala'], 'method' => 'GET']) !!}
                  {!! Form::hidden('sala', $sala->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\SalaController@delete_destroySala'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('sala', $sala->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar esta sala?')" class="btn btn-danger btn-sm ">Eliminar</button>
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