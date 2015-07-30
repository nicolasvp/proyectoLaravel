@extends('layouts/master')



@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">


    @include('Administrador/menu')

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Lista de campus archivados</h2></p>

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
              <th>Campus</th>
              <th>Dirección</th>
              <th>Acción</th>
            </tr>

            @foreach($filed_campus as $campu)

            <tr>
               <td>{{ $campu->id}}</td>
               <td>{{ $campu->nombre}}</td>
               <td>{{ $campu->direccion}}</td>
               <td>


      {!! Form::open(['action' => ['Administrador\CampusController@post_restore_campus'], 'method' => 'POST']) !!}
      {!! Form::hidden('id', $campu->id)!!}
       <button type="submit"  class="btn btn-success">Recuperar</button>
      {!! Form::close() !!}
               </td>
            </tr>
             @endforeach

          </table>
          {!! $filed_campus->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


      </div>

@stop