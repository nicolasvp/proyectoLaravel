@extends('layouts/master')




@section('sideBar')


<div class="panel panel-default" style="margin-top: 40px;">

@include('Encargado/top')
  <div class="panel-body">                  
                  
   <div class="row">

   <div class="col-sm-9" >
   <p> <h2>Asignación y modificación de salas</h2></p>

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
    
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Asignar Sala</b></h3></td>
      <td>             
                     {!! Form::open(['action' => 'Encargado\SalaController@get_curso', 'method' => 'GET']) !!}

                  <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                    {!! Form::close() !!}

      </td>
     
    </tr>
    <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Modificar Sala</b></h3></td>
      <td>                     {!! Form::open(['action' => 'Encargado\SalaController@get_salas', 'method' => 'GET']) !!}

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