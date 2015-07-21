@extends('layouts/master')




@section('sideBar')



 @include('Administrador/menu')
       

    <div class="col-sm-9" >
   <p> <h2>Lista de campus</h2></p>

    <p>
                         {!! Form::open(['action' => 'Administrador\CampusController@get_create', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar campus</button>

                         {!! Form::close() !!}
         </p>


      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>
       


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
        
          {!! Form::open(['action' => ['Administrador\CampusController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre,Rut Encargado']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Rut Encargado</th>
              <th>Editar</th>
              <th>Eliminar</th>
              <th>Archivar</th>
            </tr>

            @foreach($campus as $campu)

            <tr>
               <td>{{ $campu->id}}</td>
               <td>{{ $campu->nombre}}</td>
               <td>{{ $campu->direccion}}</td>
               <td>{{ $campu->rut_encargado}}
               <td>
    
                  {!! Form::open(['action' => ['Administrador\CampusController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $campu->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\CampusController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $campu->id)!!}
                   <button type="submit"  onclick="return confirm('¿Seguro que desea eliminar este campus?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>
               <td>
                  {!! Form::open(['action' => ['Administrador\CampusController@delete_campus'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $campu->id)!!}
                   <button type="submit"  onclick="return confirm('¿Seguro que desea archivar este campus?')" class="btn btn-success btn-sm ">Archivar</button>
                  {!! Form::close() !!}
               </td>
            </tr>
             @endforeach

          </table>
          {!! $campus->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop