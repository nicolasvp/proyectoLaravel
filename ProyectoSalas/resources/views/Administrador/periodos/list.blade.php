@extends('layouts/master')



@section('sideBar')
             
            @include('Administrador/menu')
       

   <div class="col-sm-9" >
   <p> <h2>Lista de Períodos</h2></p>

   <p>
      {!! Form::open(['action' => 'Administrador\PeriodoController@get_create', 'method' => 'GET']) !!}
   
        <button type="submit" class="btn btn-success">Ingresar periodo</button>

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
              <th>Bloque</th>
              <th>Inicio</th>
              <th>Fin</th>
               <th>Editar</th>
              <th>Eliminar</th>
            </tr>

            @foreach($datos_periodos as $periodo)

            <tr>
               <td>{{ $periodo->id}}</td>
               <td>{{ $periodo->bloque}}</td>
               <td>{{ $periodo->inicio}}</td>
               <td>{{ $periodo->fin}}</td>
              <td>
    
                  {!! Form::open(['action' => ['Administrador\PeriodoController@get_edit'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $periodo->id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

              </td>
              <td>
                  {!! Form::open(['action' => ['Administrador\PeriodoController@delete_destroy'], 'method' => 'DELETE']) !!}
                  {!! Form::hidden('id', $periodo->id)!!}
                   <button type="submit" onclick="return confirm('¿Seguro que desea eliminar este período?')" class="btn btn-danger btn-sm ">Eliminar</button>
                  {!! Form::close() !!}


               </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_periodos->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop