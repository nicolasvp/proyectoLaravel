@extends('layouts/master')

@section('sideBar')



            @include('Administrador/menu')
       

   <div class="col-sm-9" >
 
   <p> <h2>Lista de dias</h2></p>

         <p>
                         {!! Form::open(['action' => 'Administrador\DiaController@get_create', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar día</button>

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

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Nombre</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_dias as $dia)

            <tr>
               <td>{{ $dia->id}}</td>
               <td>{{ $dia->nombre}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\DiaController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $dia->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\DiaController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $dia->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este día?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_dias->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop