@extends('layouts/master')

@section('sideBar')


          @include('Administrador/menu')
       
<div class="col-sm-9" >
  <p> <h2>Editar los datos del día: {{ $diaEditable->nombre }}</h2></p>
<div class="bs-docs-section">                
 <div class="panel panel-default">
   <div class="panel-body">
       <div class="form-group">
  
      {!! Form::model($diaEditable, ['action' => ['AdministradorController@put_updateDia', $diaEditable], 'method' => 'PUT']) !!}

        <div class="form-group">
        {!! Form::label('nombre', 'Nombre') !!}
       {!! Form::text('nombre', null,['class' => 'form-control', 'placeholder' => 'Ingresa nombre']) !!}
      </div>


        {!! Form::hidden('id', $id)!!}
    

      <div align=center><button type="submit" class="btn btn-info">Actualizar</button></div>

      {!! Form::close() !!}

  
  </div>

                    
</div>

</div>


</div>

                    
</div>


      </div>
    </div>

@stop