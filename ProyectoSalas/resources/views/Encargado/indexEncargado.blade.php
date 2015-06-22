@extends('layouts/master')

@section('welcome')

Gestión de salas - UTEM

@stop


@section('sideBar')



<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-edit" aria-hidden="true"></i><b> Bienvenido Encargado </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                  
                    <ul class="list-group" id="side-menu">
                    
                        
                       <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Encargado</a>

            <li class="list-group-item"> <a href="{{URL::to('/Encargado/cursos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignar Salas</a></li>
            <li class="list-group-item"><a href="{{URL::to('/Encargado/campus')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Modificar Salas</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/Encargado/ingreso')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Ingresar Datos</a></li>             

</li>
</ul>
</div>

</div>


         <div class="col-sm-9">
   <p>                                                    
                        </p>
                        <div class="bs-docs-section">                
<div class="panel panel-default">
<div class="panel-body">
  <div class="form-group">
  <div class="jumbotron">
       @if(Session::has('message'))

          <p class="alert alert-sucess"><b>{{ Session::get('message') }}</b></p>


      @endif
     
    </div>
  </div>

                    
</div>
</div>
</div>

                    
</div>


@stop