<?php
		session_start();
		
		$MSJ=@$_GET["msj"];
		if($MSJ==4){
				$SetPaisSuite=0;
				session_unset();
				session_destroy();
		}
		
		if (!isset($_SESSION['ARMS_SETP'])) {
				$SetPaisSuite=0;
				session_unset();
				session_destroy();
		} else {
				$db=$_SESSION['ARMS_SPSDB'];
				$bdu=$_SESSION['ARMS_SPSBDU'];
				$bdp=$_SESSION['ARMS_SPSBDP'];
				$SetPaisSuite=1;
		}


include("headerhtml.inc"); 
?>
<script src="jsa/jquery-2.1.3.min.js"></script>
<script src="jsa/sweetalert-dev.js"></script>
<link rel="stylesheet" href="jsa/sweetalert.css">

<?php
		if($SetPaisSuite==1){ $OnLoad="onLoad='ActivarSPS();' ";}
?>

</head>
<body <?=@$OnLoad?>>

<div id="acceso">
<?php if($MSJ!=3) {?>
	<div id="acceso-top"></div>
    <form name="form1" method="post" action="valida.php">
    <div id="acceso-user"> <input name="CUENTA" type="text" size="20" /> </div>
    <div id="acceso-pass"> <input type="password" name="CLAVE" size="20" /> </div>
    <div id="acceso-login"> <input type="submit" name="ENTRAR" value="INICIAR SESI&Oacute;N">  </div>
    <div id="acceso-bottom"></div>
   </form>
<?php } else {?>
	<div id="acceso-top"></div>
    <form name="form1" method="post" action="SetPaisSuite.php">
    <div id="acceso-user"> <input name="CUENTA" type="text" size="20" /> </div>
    <div id="acceso-pass"> <input type="password" name="CLAVE" size="20" /> </div>
    <div id="acceso-login"> <input type="submit" name="ENTRAR" value="INICIAR SESI&Oacute;N">  </div>
    <div id="acceso-bottom"></div>
   </form>
<?php } ?> 
<script> document.form1.CUENTA.focus(); </script>

</div> <!-- acceso-->

<?php include("SetPaisWin.php"); ?>
</body>
</html>

<?php if($MSJ==2 or $MSJ==1){?>
	<script>
		$(document).ready(function(){
		swal({
			title: "Los datos ingresados no son correctos\nPor favor, vuelva a intentarlo",
			text: "Si no recuerda sus datos por favor cont\xE1ctese con el Administrador.",
			timer: 6000,
			showConfirmButton: true,
			confirmButtonColor: "#7A2A9C"
				});
		});
	</script>
<?php } ?>
<?php if($MSJ==3){?>
	<script>
		$(document).ready(function(){
		swal({
			title: "El Sistema a\xFAn requiere de datos de configuraci\xF3n para que sea operativo (Seleccionar Pa\xEDs)",
			text: "Por favor cont\xE1ctese con el Administrador. Si usted es el Administrador, por favor vuelva a ingresar sus datos de acceso",
			timer: 6000,
			showConfirmButton: true,
			confirmButtonColor: "#7A2A9C"
				});
		});
	</script>
<?php } ?>
<?php if($MSJ==4){?>
	<script>
		$(document).ready(function(){
		swal({
			title: "Se ha configurado el Sistema con los par\xE1metros seleccionados",
			text: "Por favor, vuelva a ingresar sus datos de acceso",
			timer: 6000,
			showConfirmButton: true,
			confirmButtonColor: "#7A2A9C"
				});
		});
	</script>
<?php } ?>