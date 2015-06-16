@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM


@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-user" aria-hidden="true"></i><b> Bienvenido Administrador </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    
                        <li>
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>
</li>
            <li> <a href="{{URL::to('/Administrador/create')}}">Crear Campus</a></li>
            <li><a href="{{URL::to('/Administrador/')}}">Modificar Campus</a></li>
            <li><a href="{{URL::to('/Administrador/search')}}">Asignar Perfil</a></li>               
            <li><a href="{{URL::to('/Administrador/campus')}}">Archivar Campus</a></li>
            <li><a href="{{URL::to('/Administrador/filed')}}">Campus Archivados</a></li>
       
</li>

</div>

</div>


   <div class="col-sm-9" >
   <p> <h2>Lista de campus archivados</h2></p>

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

            @foreach($filed_campus as $campu)

            <tr>
               <td>{{ $campu->id}}</td>
               <td>{{ $campu->nombre}}</td>
               <td>{{ $campu->direccion}}</td>
               <td>


      {!! Form::open(['action' => ['AdministradorController@post_restore_campus'], 'method' => 'POST']) !!}
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


@stop