@extends('layouts/master')

@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
           @include('Administrador/menu')
       

  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Seleccione una opción</h2></p>

      @if(Session::has('message'))

          <div class="alert alert-dismissible alert-success">
           <strong>{{ Session::get('message') }}</strong>
          </div>
       


      @endif
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">


          <table class="table table-striped table-hover ">
  <thead>
    <tr>
      
      <th> </th>
      <th> </th>
    
    </tr>
  </thead>
  <tbody>
    <tr>
<<<<<<< HEAD
          <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Lista de Salas</b></h3></td>
      <td>                     {!! Form::open(['action' => 'Administrador\SalaController@get_salasList', 'method' => 'GET']) !!}


                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
          
      </td>

     
    </tr>

        <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Asignar Salas</b></h3></td>
      <td>             
                     {!! Form::open(['action' => 'Administrador\SalaController@get_cursos', 'method' => 'GET']) !!}
=======
    
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Asignar Salas</b></h3></td>
      <td>             
                     {!! Form::open(['action' => 'Administrador\SalaController@get_cursos', 'method' => 'GET']) !!}


                  <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                    {!! Form::close() !!}

      </td>
     
    </tr>

        <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Lista de Salas</b></h3></td>
      <td>                     {!! Form::open(['action' => 'Administrador\SalaController@get_salasList', 'method' => 'GET']) !!}
>>>>>>> d54c8fa948ab220500fe59fd7e40157631c5a416


                  <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                    {!! Form::close() !!}

      </td>
      
    </tr>

     <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Tipos de Salas</b></h3></td>
      <td>                     {!! Form::open(['action' => 'Administrador\TipoSalaController@getIndex', 'method' => 'GET']) !!}


                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
          
      </td>
    </tr>


    <tr>
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Lista de Horarios</b></h3></td>
      <td>                     {!! Form::open(['action' => 'Administrador\SalaController@get_horarios', 'method' => 'GET']) !!}


                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
          
      </td>
      
    </tr>
    
     

  </tbody>
</table> 


  </div>
</div>



</div>

</div>


</div>
</div>
</div>

                    
</div>



                 
@stop