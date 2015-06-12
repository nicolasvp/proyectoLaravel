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
            <li> <a href="{{ route('Administrador.create') }}">Crear Campus</a></li>
            <li><a href="{{ route('Administrador.index') }}">Modificar Campus</a></li>
            <li><a href="">Archivar Campus</a></li>
            <li><a href="{{URL::to('/Administrador/search')}}">Asignar Perfil</a></li>               

       
</li>

</div>

</div>






<div class="col-sm-9" >
  <p> <h2>Perfiles del usuario </h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">


       <div class="form-group">

        <table class="table table-striped">
            <tr> 
              <th>#</th>
              <th>Rut</th>
              <th>Rol</th>
              
            </tr>

            @foreach($datos_usuario as $users)
            
            <tr>
               <td>{{ $users->id}}</td>
               <td>{{ $users->rut}}</td>
               <td>{{ $users->nombre}}</td>
            </tr>
             @endforeach

          </table>


  </div>
                    
</div>
</div>
<p> <h2>Asignar perfil</h2></p>
<div class="panel panel-default">
    <div class="panel-body">
      @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
       <table class="table table-striped">


     <div class="form-group">
   {!! Form::open(['action' => 'AdministradorController@postProfile']) !!}

    <div class="form-group">
    {!! Form::hidden('rut', $rut)!!}
    </div>

    <div class="form-group">
   {!! Form::select('rol_asig', (['0' => 'Selecciona un Perfil'] + $rol_usuario), null, ['class' => 'form-control']) !!}
    </div>

      <div align="center"<th><button type="submit" onclick="return confirm('¿Seguro que desea asignar este perfil?')" class="btn btn-primary ">Asignar perfil</button></th></div>
      {!! Form::close() !!}

      </div>

      </table>

    </div>
</div>


</div>

                    
</div>


      </div>
    </div>

@stop