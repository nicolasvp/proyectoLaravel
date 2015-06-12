

<div id="wrapper">
      <div class="container" style="width: 400px;">
        <div class="panel panel-default" style="margin-top: 100px;">
        <div class="panel-heading">
        <form class="form-signin" method="post" action="/">

        <h2 class="form-signin-heading" style="font-size:25px;">Inicio de sesión</h2>

</div>
<div class="panel-body">  
        <input name="rut" type="text" class="form-control" placeholder="Rut" id="rut" style="margin-top:10px;" required rut>
        <input name="password" type="password" class="form-control" placeholder="Contrase&#xF1;a" style="margin-top: 10px;" required>
        </br>

        @if (Session::has('login_errors'))
                    <b class="text-danger" >Usuario o contraseña incorrecto/a.</b>
        @endif

        <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top: 10px;"><i class="fa fa-user fa-fw"></i>Iniciar sesión</button>
      </form>
     <!-- <script src="http://localhost:8000/js/jquery.Rut.min.js"></script>
      <script type="text/javascript">
      jQuery(document).ready(function($) {
        $("#rut").Rut();
       });
      </script>-->
     </div>
  </div>


