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
    
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Crear Campus</b></h3></td>
      <td>             
                     {!! Form::open(['action' => 'AdministradorController@get_create', 'method' => 'GET']) !!}


                  <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                    {!! Form::close() !!}

      </td>
     
    </tr>
    <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Lista de Campus</b></h3></td>
      <td>                     {!! Form::open(['action' => 'AdministradorController@get_campusList', 'method' => 'GET']) !!}


                    <button type="submit" class="btn btn-primary btn-sm ">Ingresar</button>
                      {!! Form::close() !!}
          
      </td>
      
    </tr>
        <tr>
     
      <td><h3><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i><b> Campus archivados</b></h3></td>
      <td>                     {!! Form::open(['action' => 'AdministradorController@get_filed', 'method' => 'GET']) !!}


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



                 
@stop