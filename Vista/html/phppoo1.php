<!DOCTYPE html>
<html lang="en">
<head>
  <title>Mi Proyecto</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <script src="../bootstrap/js/bootstrap.min.js"></script>

 
</head>
<body>


<div class="container">
<header>
<?php include_once 'header.php'; ?>
</header>

      <div class="container">
      <div class="row">
        
<?php include_once 'menulateral.php'; ?>	
				
  <div class="col-sm-10 col-md-10">
   <div class="panel panel-default">
   <!-- contenedor del titulo-->
   <div class="panel-heading">
    <h3 class="panel-title">EJERCICIOS DE PRACTICA PHP</h3>
   </div>
    <!-- contenedor de descripcion ejercicios-->
   <div class="panel-body">
   <p style="color:#DCA430">Ejercicios para practicas de vectores y Matrices</p>
    <!-- contenedor menu de ejercicios-->
   <p><ul class="nav nav-tabs">
  <li class="active"><a href="#">Clases y Métodos</a></li>
  <li><a href="phppoo2.php">Constructor</a></li>
  <!--<li><a href="estrucontrol3.php">Estructura for</a></li>-->
  </ul></p>
			  
			   <!-- Contenedor ejercicio-->
              <div class="alert alert-success">
			   <div class="row">
			   <div class="col-sm-12 col-md-12">
			   <form name="areat" action="../../controlador/ejercicio1.php">
			   <table class="table">
			   <tr><td colspan="2" style="color:#000000">Confeccionar una clase llamada carro. Definir un atributo donde se almacene su marca. Luego definir dos métodos, uno que cargue la marca desde una caja de texto y otro que la imprima mediante un botón de esta manera: “La marca del carro es: -Marca digitada-”.
</td></tr>
			  <tr><td align="right">Marca Vehiculo</td><td><input name="v1" type="text" placeholder="dato 1"></td></tr>
              <tr><td align="right"></td><td><input name="v2" type="submit" value="Procesar"></td></tr>
              <tr><td align="right">Resultado</td><td><input name="altura" type="text" value="<?php if (isset($_REQUEST['area']))  /* pregunta si la variable tiene un dato asignado */ {  echo $_REQUEST['dato'];  }?>" disabled="disabled" placeholder="Resultado"></td></tr>
              
			   
			   </table>
			   </form>
			   </div>
			  
            </div>
          </div>
        </div>
      </div>
    </div>
      
</div>

</body>
</html>
