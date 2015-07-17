@extends('layouts/master')



@section('sideBar')



@include('Encargado/top')



   <div class="col-sm-9" >
   <p> <h2>Lista de horarios</h2></p>

      @if(Session::has('message'))

         
          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>

      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
          {!! Form::open(['action' => ['Encargado\HorarioController@get_search'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Curso,Día']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


</form>


          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Curso</th>
              <th>Período</th>
              <th>Hora</th>
              <th>Sala</th>
              <th>Día</th>
              <th></th>
              <th></th>
            </tr>

            
            @foreach($datos_horarios as $horario)

            <tr>
               <td>{{ $horario->horario_id }}</td>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->bloque}}</td>
               <td>{{ $horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{ $horario->dia}}
           <td>
                 {!! Form::open(['action' => ['Encargado\HorarioController@get_edit'], 'method' => 'GET']) !!}
                 {!! Form::hidden('id', $horario->horario_id)!!}
                 <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                 {!! Form::close() !!}

          </td>


           <td>

               {!! Form::open(['action' => ['Encargado\HorarioController@delete_destroy'], 'method' => 'DELETE']) !!}
                {!! Form::hidden('id', $horario->horario_id)!!}
                <button type="submit"  onclick="return confirm('¿Seguro que desea eliminar este horario?')" class="btn btn-danger btn-sm ">Eliminar</button>
                {!! Form::close() !!}

           </td>

            </tr>
             @endforeach

          </table>
          {!! $datos_horarios->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop