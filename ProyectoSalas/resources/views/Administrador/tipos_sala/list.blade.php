@extends('layouts/master')



@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">
       
           @include('Administrador/menu')
       

  <div class="panel-body">                  
                  
   <div class="row">      

   <div class="col-sm-9" >
   <p> <h2>Lista de Tipos de salas</h2></p>


      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

        {!! Form::open(['action' => ['Administrador\TipoSalaController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
                <div class="form-group">
              {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Nombre']) !!}
              </div>
              <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}

             {!! Form::open(['action' => 'Administrador\TipoSalaController@get_create', 'method' => 'GET']) !!}
   
                <button type="submit" class="btn btn-success">Ingresar</button>

            {!! Form::close() !!}



          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
              <th>Descripción</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_tipos as $tipo)

            <tr>
               <td>{{ $tipo->id}}</td>
               <td>{{ $tipo->nombre}}</td>
               <td>{{ $tipo->descripcion}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\TipoSalaController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $tipo->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\TipoSalaController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $tipo->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este tipo de sala?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_tipos->render() !!}
     
  </div>

                    
</div>
</div>
</div>
</div>
</div>
                    
</div>


      </div>



@stop