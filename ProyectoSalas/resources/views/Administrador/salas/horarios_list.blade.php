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

                    <ul class="list-group" id="side-menu">
                    
                        
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Administrador</a>


           
           @include('Administrador/menu')
       
</li>
</ul>
</div>

</div>



   <div class="col-sm-9" >
   <p> <h2>Lista de horarios</h2></p>

             <p>
                         {!! Form::open(['action' => 'AdministradorController@get_cursosList', 'method' => 'GET']) !!}
   
                          <button type="submit" class="btn btn-primary btn-sm">Ingresar horario</button>

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
          {!! Form::open(['action' => ['AdministradorController@get_searchHorario'], 'method' => 'GET','class' => 'navbar-form navbar-left pull-right','role' => 'search']) !!}
            <div class="form-group">
          {!! Form::text('name',null,['class' => 'form-control','placeholder' => 'Curso,Docente']) !!}
          </div>
          <button type="submit" class="btn btn-info">Buscar</button>
          {!! Form::close() !!}


</form>


          <table class="table table-striped">
            <tr> 
              <th>Curso</th>
              <th>Docente</th>
              <th>Hora</th>
              <th>Sala</th>
              <th>Día</th>
              <th></th>
            </tr>

            
            @foreach($datos_horarios as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->nombres}} {{$horario->apellidos}}</td>
               <td>{{ $horario->inicio}} - {{ $horario->fin}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{ $horario->dia}}</td>

     <td>
                 {!! Form::open(['action' => ['AdministradorController@get_editHorario'], 'method' => 'GET']) !!}
                  {!! Form::hidden('id', $horario->horario_id)!!}
                   <button type="submit"  class="btn btn-primary btn-sm">Editar</button>
                  {!! Form::close() !!}

     </td>


      <td>

       {!! Form::open(['action' => ['AdministradorController@delete_destroyHorario'], 'method' => 'DELETE']) !!}
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