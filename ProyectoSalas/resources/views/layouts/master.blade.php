<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>@yield('title','Sistema de Salas :: Universidad Tecnológica Metropolitana')</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
   <!-- <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> -->

    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>




	</head>
	<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">

        <div class="navbar-header">
          
        <img alt="25x25" src="/images/utem2.png" height="40px">
         @yield('welcome','<a class="navbar-brand" href="#">Gestión de Salas UTEM</a>')

        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="/logout">@yield('session','Cerrar Sesión')</a></li>
          </ul>
        </div>
      </div>
    </nav>


    @yield('sideBar')

    
		<div id="footer">
    <footer>© Sistema de Salas UTEM - 2015</footer>
    </div>
	
	</body>
</html>