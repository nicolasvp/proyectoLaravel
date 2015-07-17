@section('welcome')
<a class="navbar-brand" href="/encargado">Gestión de Salas UTEM</a>
@stop

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

            <li class="list-group-item"> <a href="{{URL::to('/encargado/salas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Salas</a></li>
            <li class="list-group-item"> <a href="{{URL::to('/encargado/cursos')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Cursos</a></li>       
            <li class="list-group-item"><a href="{{URL::to('/encargado/asignaturas')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Asignaturas</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/encargado/estudiantes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Estudiantes</a></li> 
            <li class="list-group-item"><a href="{{URL::to('/encargado/docentes')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Docentes</a></li>  
            <li class="list-group-item"><a href="{{URL::to('/encargado/horarios')}}"><i class="glyphicon glyphicon-menu-right" aria-hidden="true"></i>Lista de horarios</a></li>
</li>
</ul>
</div>

</div>