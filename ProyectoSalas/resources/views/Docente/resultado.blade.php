@extends('layouts/master')



@section('sideBar')


@include('Docente/top')

 <div class="col-sm-9" >
   <p> <h2>Resultado de la consulta</h2></p>

            
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

            @foreach($resultados as $result)

            <tr>
               <td>{{ $result->nombre}}</td>
               <td>{{ $result->sala}}</td>
               <td>{{ $result->inicio}} - {{$result->fin}}</td>
               <td>{{ $result->dia}}</td>
            </tr>

             @endforeach

          </table>
          {!! $resultados->render() !!}
     
  </div>

                    
</div>
</div>
</div>

                    
</div>


      </div>
    </div>


@stop

	