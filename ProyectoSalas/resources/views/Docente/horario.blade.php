@extends('layouts/master')

@section('welcome')

 Gestión de salas - UTEM 

@stop


@section('sideBar')

<div class="panel panel-default" style="margin-top: 40px;">
                        <div class="panel-heading">
                            

                            <h2><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i><b> Bienvenido Docente </b></h2> 

                        </div>
                        <div class="panel-body">                  
                  
                        <div class="row">
                          <div class="col-sm-3">
                                          
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                    
                        <li>
                      <a class="list-group-item active"><i class="glyphicon glyphicon-list" aria-hidden="true"></i> Menú Docente</a>
</li>
            <li> <a href="{{URL::to('/Docente/horario')}}">Horario</a></li>
             <li><a href="{{URL::to('/Docente/consulta')}}">Consultar</a></li>            

</li>

</div>

</div>


 <div class="col-sm-9" >
   <p> <h2>Tus cursos</h2></p>

            
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
              
              <th>Nombre</th>
              <th>Sala</th>
              <th>Hora</th>
               <th>Día</th>
              
            </tr>

            @foreach($datos_horario as $horario)

            <tr>
               <td>{{ $horario->nombre}}</td>
               <td>{{ $horario->sala}}</td>
               <td>{{$horario->inicio}} - {{$horario->fin}}</td>
               <td>{{ $horario->dia}}</td>
            </tr>

             @endforeach

          </table>
          {!! $datos_horario->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop

	