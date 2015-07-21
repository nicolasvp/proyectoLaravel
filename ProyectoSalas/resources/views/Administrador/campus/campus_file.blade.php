@extends('layouts/master')


@section('sideBar')



    @include('Administrador/menu')
       


   <div class="col-sm-9" >
   <p> <h2>Lista de campus para archivar</h2></p>

      @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">

          <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Campus</th>
              <th>Dirección</th>
              <th>Acción</th>
            </tr>

            @foreach($campus as $campu)

            <tr>
               <td>{{ $campu->id}}</td>
               <td>{{ $campu->nombre}}</td>
               <td>{{ $campu->direccion}}</td>
               <td>
      {!! Form::open(['action' => ['Administrador\CampusController@delete_campus'], 'method' => 'DELETE']) !!}
      {!! Form::hidden('id', $campu->id)!!}
       <button type="submit" onclick="return confirm('¿Seguro que desea archivar este campus?')" class="btn btn-danger btn-sm">Archivar</button>
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