
<?php include("session.inc");?>
<?php include("headerhtml.inc");?>
<?php
	$PAGINA=1127;

	$LIST=@$_GET["LIST"];
	$NEO=@$_GET["NEO"];
	$ACT=@$_GET["ACT"];
	
	if ($NEO=="" and $ACT=="") {
		 $LIST=1;
	}
	
	$ACT_FIC=@$_GET["ACT_FIC"];
	$ACT_NVA=@$_GET["ACT_NVA"];
	$ACT_MDA=@$_GET["ACT_MDA"];
	if(empty($ACT_NVA) and empty($ACT_MDA)){ $ACT_FIC=1;}

	$FILTRO_MODOPERA="";
	$FMODOPERA=@$_POST["FMODOPERA"];
	if (empty($FMODOPERA)) { $FMODOPERA=@$_GET["FMODOPERA"] ;}
	if (empty($FMODOPERA)) { $FMODOPERA=999 ;}
	if ($FMODOPERA!=999) {
		if ($FMODOPERA!=600) {
				$FILTRO_MODOPERA=" AND ID_MODOPERA=".$FMODOPERA;
		} else {
				$FILTRO_MODOPERA=" AND ID_MODOPERA=0";
		}
	}

	$FILTRO_NEGOCIO="";
	$FNEGOCI=@$_POST["FNEGOCI"];
	if (empty($FNEGOCI)) { $FNEGOCI=@$_GET["FNEGOCI"] ;}
	if (empty($FNEGOCI)) { $FNEGOCI=999 ;}
	if ($FNEGOCI!=999) {
		$FILTRO_NEGOCIO=" AND COD_NEGOCIO=".$FNEGOCI;
	}
		
	$FILTRO_TIENDA="";
	$FTIENDA=@$_POST["FTIENDA"];
	if (empty($FTIENDA)) { $FTIENDA=@$_GET["FTIENDA"] ;}
	if (empty($FTIENDA)) { $FTIENDA=0 ;}
	if ($FTIENDA!=0) {
		$FILTRO_TIENDA=" AND COD_TIENDA=".$FTIENDA ;
	}
		

	$FILTRO_ESTADO="";
	$FESTADO=@$_POST["FESTADO"];
	if (empty($FESTADO)) { $FESTADO=@$_GET["FESTADO"] ;}
	if (empty($FESTADO)) { $FESTADO=0 ;}
	if ($FESTADO==1) {$FILTRO_ESTADO=" AND REG_ESTADO=1 "; }
	if ($FESTADO==2) {$FILTRO_ESTADO=" AND REG_ESTADO=0 "; }

	$FILTRO_NOMB="";
	$BOPERA=trim(strtoupper(@$_POST["BOPERA"]));
	if (empty($BOPERA)) { $BOPERA=trim(strtoupper(@$_GET["BOPERA"])) ;}
	$BOPCION=@$_POST["BOPCION"];
	if (empty($BOPCION)) { $BOPCION=@$_GET["BOPCION"];}
	if (empty($BOPCION)) { $BOPCION=2;}
	if ($BOPCION==1) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND (UPPER(dbo.TRIM(NOMBRE)) Like '%".strtoupper($BOPERA)."%' OR UPPER(dbo.TRIM(APELLIDO_P)) Like '%".strtoupper($BOPERA)."%' OR UPPER(dbo.TRIM(APELLIDO_M)) Like '%".strtoupper($BOPERA)."%')"; }
	} 
	if ($BOPCION==2) {
			if ($BOPERA<>"") {$FILTRO_NOMB=" AND CC_OPERADOR Like '%".strtoupper($BOPERA)."%' "; }
	} 
	
	
?>

<?php if ($LIST<>1) {?>
<script language="JavaScript">
function validaingreso(theForm){
	
		if (theForm.CC_OPERADOR.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.CC_OPERADOR.focus();
			return false;
		}

		if (theForm.NOMBRE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMBRE.focus();
			return false;
		}

		if (theForm.APELLIDO_P.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.APELLIDO_P.focus();
			return false;
		}

		if (theForm.APELLIDO_M.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.APELLIDO_M.focus();
			return false;
		}

		if (theForm.DIA_NAC.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DIA_NAC.focus();
			return false;
		}
		
		if (theForm.ANO_NAC.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ANO_NAC.focus();
			return false;
		}
						
						if (!ValidarFecha(theForm.DIA_NAC.value+"-"+theForm.MES_NAC.value+"-"+theForm.ANO_NAC.value)){
							alert("FECHA NO VALIDA.");
							theForm.DIA_NAC.focus();
							return false;
							}
					
						if (!calcular_edad(theForm.DIA_NAC.value, theForm.MES_NAC.value, theForm.ANO_NAC.value)){
							alert("CONFIRME LA FECHA DE NACIMIENTO, LA EDAD DEBE SER ENTRE LOS 18 Y LOS 99 A\xd1OS.");
							theForm.ANO_NAC.focus();
							return false;
							}
						
		if (theForm.NOMB_ACE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMB_ACE.focus();
			return false;
		}
		if (theForm.INI_ACE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.INI_ACE.focus();
			return false;
		}
		var str=$("#INI_ACE").val();
		if (str.length<=2){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.INI_ACE.focus();
			return false;
		}
		
		if (theForm.COD_NEGOCIO.value == 999){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_NEGOCIO.focus();
			return false;
		}

		if (theForm.COD_TIENDA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_TIENDA.focus();
			return false;
		}

		if (theForm.INGRESAR.value != ""){

			var aceptaEntrar = window.confirm("Se ejecutar\xe1 el registro, \xbfest\xe1 seguro?");
				if (aceptaEntrar) 
				{
					document.forms.theForm.submit();
				}  else  
				{
					return false;
				}
	}

} //validaingreso(theForm)


var normalize = (function() {
  var from = "����������������������������������������������",
      to   = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
      mapping = {};
 
  for(var i = 0, j = from.length; i < j; i++ )
      mapping[ from.charAt( i ) ] = to.charAt( i );
 
  return function( str ) {
      var ret = [];
      for( var i = 0, j = str.length; i < j; i++ ) {
          var c = str.charAt( i );
          if( mapping.hasOwnProperty( str.charAt( i ) ) )
              ret.push( mapping[ c ] );
          else
              ret.push( c );
      }
      return ret.join( '' );
  }
 
})();
$(document).ready(function(e) {
    ArmaNombACE(document.forms.forming);
});

function ArmaNombACE(theForm)
{
	 if ((theForm.NOMBRE.value !='') && (theForm.APELLIDO_P.value !='') && (theForm.APELLIDO_M.value !=''))
	 {
		var nombre=theForm.NOMBRE.value;
		var apellido_p=theForm.APELLIDO_P.value;
		var apellido_m=theForm.APELLIDO_M.value;
	    var valor=nombre+ ' ' +apellido_p+ ' ' +apellido_m ;
		var NombACE = valor.toUpperCase() ;
		theForm.NOMB_ACE.value=normalize(NombACE.substring(0, 20));
		var iniciales=nombre.substr(0,1)+apellido_p.substr(0,1)+apellido_m.substr(0,1);
		iniciales=iniciales.toUpperCase();
		$("#INI_ACE").val(iniciales);
	 }
	 if ((theForm.NOMBRE.value =='') && (theForm.APELLIDO_P.value =='') && (theForm.APELLIDO_M.value ==''))
	 {
	 	theForm.NOMB_ACE.value= "" ;
		theForm.INI_ACE.value= "" ;
	 }
}
</script>
<?php }?>
</head>

<body>

<?php include("encabezado.php");?>
<?php include("titulo_menu.php");?>
<table width="100%" height="100%">
<tr>
<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 
<td >
<?php
if ($MSJE==1) {$ELMSJ="Registro actualizado";} 
if ($MSJE==2) {$ELMSJ="C&eacute;dula de  Ciudadan&iacute;a de Operador ya registrada, verifique";}
if ($MSJE==3) {$ELMSJ="Registro realizado";}
if ($MSJE==4) {$ELMSJ="Registro eliminado";}
if ($MSJE==5) {$ELMSJ="Registrado Nivel de Autorizaci&oacute;n";}
if ($MSJE <> "") {
?>
<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ?></a></div>
<?php }?>



        <table width="100%">
        <tr><td>
        <h2><?php echo $LAPAGINA?></h2>

		<?php if ($LIST==1) { ?>
        <table width="100%" id="Filtro">
          <tr>
            <td>
                <form action="reg_operador.php" method="post" name="frmbuscar" id="frmbuscar">

                        <select name="FMODOPERA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="999">Tipo Operador</option>
                                    <option value="600">NO ASIGNADO</option>
                                    <?php 
									$SQLFILTRO="SELECT * FROM OP_MODOPERA WHERE EST_MODOPERA=1 ORDER BY ID_MODOPERA ASC";
									$RS = sqlsrv_query($conn, $SQLFILTRO);
									//oci_execute($RS);
									while ($row = sqlsrv_fetch_array($RS)) {
										$FLTID_MODOPERA = $row['ID_MODOPERA'];
										$FLTDES_MODOPERA = $row['DES_MODOPERA'];
                                     ?>
                                    <option value="<?php echo $FLTID_MODOPERA ?>" <?php  if ($FLTID_MODOPERA==$FMODOPERA) { echo "SELECTED";}?>><?php echo $FLTDES_MODOPERA ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>
                        <select name="FNEGOCI" onChange="document.forms.frmbuscar.submit();">
                                    <option value="999">Negocio</option>
                                    <?php 
									$SQLFILTRO="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO<>0 ORDER BY DES_NEGOCIO ASC";
									$RS = sqlsrv_query($maestra, $SQLFILTRO);
									//oci_execute($RS);
									while ($row = sqlsrv_fetch_array($RS)) {
										$FLTCOD_NEGOCIO = $row['COD_NEGOCIO'];
										$FLTDES_NEGOCIO = $row['DES_NEGOCIO'];
                                     ?>
                                    <option value="<?php echo $FLTCOD_NEGOCIO ?>" <?php  if ($FLTCOD_NEGOCIO==$FNEGOCI) { echo "SELECTED";}?>><?php echo $FLTDES_NEGOCIO ?></option>
                                    <?php 
									}

                                     ?>
                                    </select>
                         <?php  if ($FNEGOCI!=999) { ?>
                        <select name="FTIENDA" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Local</option>
                                    <?php 
									$SQLFILTRO="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$FNEGOCI.") ORDER BY DES_CLAVE ASC";
									$RS = sqlsrv_query($maestra, $SQLFILTRO);
									//oci_execute($RS);
									while ($row = sqlsrv_fetch_array($RS)) {
										$FLTDES_TIENDA = $row['DES_TIENDA'];
										$FDES_CLAVE = $row['DES_CLAVE'];
										$FDES_CLAVE_F=substr("000".$FDES_CLAVE, -3); 
                                     ?>
                                    <option value="<?php echo $FDES_CLAVE ?>" <?php  if ($FDES_CLAVE==$FTIENDA) { echo "SELECTED";}?>><?php echo $FDES_CLAVE_F." - ".$FLTDES_TIENDA ?></option>
                                    <?php 
									}
                                     ?>
                                    </select>
                           <?php } ?>

                        <select style="clear:left" name="FESTADO" onChange="document.forms.frmbuscar.submit();">
                                    <option value="0">Estado</option>
                                    <option value="1" <?php  if ($FESTADO==1) { echo "SELECTED";}?>>Activo</option>
                                    <option value="2" <?php  if ($FESTADO==2) { echo "SELECTED";}?>>Bloqueado</option>
                                    </select>

                           <input name="BOPERA" type="text" id="BOPERA" size="12" value="<?php echo $BOPERA ?>">
                           <input type="radio" name="BOPCION" value="2" <?php if($BOPCION==2) {?> checked <?php }?>>
                           <label for="BOPCION2">Cuenta</label>
                           <input type="radio" name="BOPCION" value="1"  <?php if($BOPCION==1) {?> checked <?php }?>>
                           <label for="BOPCION1">Nombre</label>
                           <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar">
                           <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="javascript:pagina('reg_operador.php')">

                </form>
              </td>
              </tr>
              </table>
<?php } //LIST=1 ?>

                <table style="margin:10px 20px; ">
                <tr>
                <td>
                
                
<?php
if ($LIST==1) {
?>
                
                
                <?php
				$CONSULTA="SELECT COUNT(ID_OPERADOR) AS CUENTA FROM OP_OPERADOR WHERE ID_OPERADOR<>0 ".$FILTRO_MODOPERA.$FILTRO_NEGOCIO.$FILTRO_TIENDA.$FILTRO_ESTADO.$FILTRO_NOMB ;
				$RS = sqlsrv_query($conn, $CONSULTA);
				
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$TOTALREG = $row['CUENTA'];
					$NUMTPAG = round($TOTALREG/$CTP,0);
					$RESTO=$TOTALREG%$CTP;
					$CUANTORESTO=round($RESTO/$CTP, 0);
					if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
					$NUMPAG = round($LSUP/$CTP,0);
					if ($NUMTPAG==0) {
						$NUMTPAG=1;
						}
				}

				//$SQLCLTE="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM OP_OPERADOR  WHERE ID_OPERADOR<>0  ".$FILTRO_MODOPERA.$FILTRO_NEGOCIO.$FILTRO_TIENDA.$FILTRO_ESTADO.$FILTRO_NOMB." ORDER BY APELLIDO_P ASC, APELLIDO_M ASC, NOMBRE ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

				$SQLCLTE= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY APELLIDO_P ASC, APELLIDO_M ASC, NOMBRE ASC) ROWNUMBER FROM OP_OPERADOR WHERE ID_OPERADOR<>0  ".$FILTRO_MODOPERA.$FILTRO_NEGOCIO.$FILTRO_TIENDA.$FILTRO_ESTADO.$FILTRO_NOMB.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";

				$RS = sqlsrv_query($conn, $SQLCLTE);
				//oci_execute($RS);

               ?>
                <table id="Listado">
                <tr>
                    <th>Nombre Operador</th>
                    <th>Negocio/ Tienda</th>
                    <th>Nombre de Sistema<br>Cuenta Sistema</th>
                    <th>Tipo Operador</th>
                    <th colspan="2">Estado</th>
                    <th>Registrado por</th>
                </tr>
                <?php
				while ($row = sqlsrv_fetch_array($RS)){
                        $NOMBRE = $row['NOMBRE'];
                        $APELLIDO_P = $row['APELLIDO_P'];
                        $APELLIDO_M = $row['APELLIDO_M'];
						$OPERADOR=$NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M;
                        $CC_OPERADOR = $row['CC_OPERADOR'];

                        $ID_OPERADOR = $row['ID_OPERADOR'];
                        $NOMB_ACE = $row['NOMB_ACE'];

                        $DES_CLAVE = $row['COD_TIENDA'];
                        $COD_NEGOCIO = $row['COD_NEGOCIO'];

						$S2="SELECT * FROM MN_TIENDA WHERE DES_CLAVE=".$DES_CLAVE;
						$RS2 = sqlsrv_query($maestra, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_TIENDA = $row2['DES_TIENDA'];
							$FLTDES_CLAVE = $row2['DES_CLAVE'];
							$FLTDES_CLAVE=substr("000".$FLTDES_CLAVE, -3); 
						}	
						$S2="SELECT DES_NEGOCIO FROM MN_NEGOCIO WHERE COD_NEGOCIO=".$COD_NEGOCIO;
						$RS2 = sqlsrv_query($maestra, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_NEGOCIO = $row2['DES_NEGOCIO'];
						}	


                        $REG_ESTADO = $row['REG_ESTADO'];
						if ($REG_ESTADO==0) {
							$ELESTADO="Bloqueado"; 
							$TDESTADO="#F44336";
							}
						if ($REG_ESTADO==1) {
							$ELESTADO="Activo"; 
							$TDESTADO="#4CAF50";
							}
						
                        $STR_ESTADO = $row['STR_ESTADO'];
						
						$TDPROCESO =$TDESTADO;
						
                        $ID_MODOPERA = $row['ID_MODOPERA'];
						$S2="SELECT * FROM OP_MODOPERA WHERE ID_MODOPERA=".$ID_MODOPERA;
						$RS2 = sqlsrv_query($conn, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$DES_MODOPERA = $row2['DES_MODOPERA'];
						} else {
							$DES_MODOPERA = "NO ASIGNADO";
						}

                        $IDREG = $row['IDREG'];
                        $FECHA = $row['FECHA'];
						$S2="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$IDREG;
						$RS2 = sqlsrv_query($maestra, $S2);
						//oci_execute($RS2);
						if ($row2 = sqlsrv_fetch_array($RS2)) {
							$QUIENFUE = $row2['NOMBRE'];
						}	

						if($BOPCION==1) {
								$OPERADOR=str_replace(strtoupper($BOPERA),'<span style="background-color:#FFF9C4;">'.strtoupper($BOPERA).'</span>', strtoupper($OPERADOR)); 
						}

						if($BOPCION==2) {
								$CC_OPERADOR=str_replace($BOPERA,'<span style="background-color:#FFF9C4;">'.$BOPERA.'</span>', $CC_OPERADOR); 
						}

               ?>
                <tr>
                    <?php if($SESPUBLICA==1) { ?>
                    <td><a href="reg_operador.php?ACT=<?php echo $ID_OPERADOR?>"><?php echo $OPERADOR?></a></td>
                    <?php } else {?>
                     <td><?php echo $OPERADOR?></td>
                    <?php } ?>
                    <td><?php echo $DES_NEGOCIO?><BR><?php echo $FLTDES_CLAVE." - ".$DES_TIENDA?></td>
                    <td><?php echo $NOMB_ACE?><br><span style="font-size:14pt"><?php echo $CC_OPERADOR?></span></td>
                    <td><?php echo $DES_MODOPERA?></td>
                    <td style="background-color:<?php echo $TDESTADO?>; color:#FFF"><?php echo $ELESTADO?></td>
                    <td style="background-color:<?php echo $TDPROCESO?>; color:#FFF"><?php echo $PROCESADO?></td>
                    <td><?php echo $QUIENFUE.", ".date_format($FECHA,"d-m-Y")?></td>
                </tr>
                <?php
				}
				?>
                <tr>
                    <td colspan="7" nowrap style="background-color:transparent">
                    <?php
                    if ($LINF>=$CTP+1) {
						$ATRAS=$LINF-$CTP;
						$FILA_ANT=$LSUP-$CTP;
                   ?>
                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('reg_operador.php?LSUP=<?php echo $FILA_ANT?>&LINF=<?php echo $ATRAS?>&FNEGOCI=<?php echo $FNEGOCI?>&FTIENDA=<?php echo $FTIENDA?>&FESTADO=<?php echo $FESTADO?>&BOPCION=<?php echo $BOPCION?>&BOPERA=<?php echo $BOPERA?>&FMODOPERA=<?php echo $FMODOPERA?>');">
                    <?php
                    }
                    if ($LSUP<=$TOTALREG) {
						$ADELANTE=$LSUP+1;
						$FILA_POS=$LSUP+$CTP;
                   ?>
                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('reg_operador.php?LSUP=<?php echo $FILA_POS?>&LINF=<?php echo $ADELANTE?>&FNEGOCI=<?php echo $FNEGOCI?>&FTIENDA=<?php echo $FTIENDA?>&FESTADO=<?php echo $FESTADO?>&BOPCION=<?php echo $BOPCION?>&BOPERA=<?php echo $BOPERA?>&FMODOPERA=<?php echo $FMODOPERA?>');">
                    <?php }?>
                    <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                    </td>
                </tr>
                </table>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>
               
               
                <?php
                if ($NEO==1) {
				
						$CC=@$_GET["CC"];
						$C1=@$_GET["C1"];
						$C2=@$_GET["C2"];
						$C3=@$_GET["C3"];
						$C4=@$_GET["C4"];
						$C5=@$_GET["C5"];
						$C6=@$_GET["C6"];
						$C7=@$_GET["C7"];
						$C8=@$_GET["C8"];
						$C9=@$_GET["C9"];
						$C10=@$_GET["C10"];

				?>
                <table id="forma-registro">
                        <form action="reg_operador_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="CC_OPERADOR">Cuenta Operador</label></td>
                            <td><input name="CC_OPERADOR" type="text" size="8" maxlength="8"  onKeyPress="return acceptNum(event);" value="<?php echo $CC;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="NOMBRE">Nombre </label></td>
                            <td><input name="NOMBRE" type="text" size="20" maxlength="200" onChange="ArmaNombACE(this.form);"  value="<?php echo $C1;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="APELLIDO_P">Apellido Paterno </label></td>
                            <td><input name="APELLIDO_P" type="text" size="20" maxlength="200" onChange="ArmaNombACE(this.form);" value="<?php echo $C2;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="APELLIDO_M">Apellido Materno </label></td>
                            <td><input name="APELLIDO_M" type="text" size="20" maxlength="200" onChange="ArmaNombACE(this.form);" value="<?php echo $C3;?>"> </td>
                        </tr>
                        <tr>
                        	<td><label for="FECHA_NAC" >Fecha Nacimiento <BR>(d&iacute;a-mes-a&ntilde;o)</label></td>
                            <td>
                                    <input style="float:left; display:inline; margin:6px 0 0 6px" name="DIA_NAC" type="text"  id="DIA_NAC" size="1" maxlength="2" onKeyPress="return acceptNum(event);"  value="<?php echo $C4;?>">
                                    <select style="float:left; display:inline; margin:6px 0 0 0" name="MES_NAC"  id="MES_NAC">
                                            <option value="1" <?php if($C5==1){ echo "SELECTED";}?>>Enero</option>
                                            <option value="2" <?php if($C5==2){ echo "SELECTED";}?>>Febrero</option>
                                            <option value="3" <?php if($C5==3){ echo "SELECTED";}?>>Marzo</option>
                                            <option value="4" <?php if($C5==4){ echo "SELECTED";}?>>Abril</option>
                                            <option value="5" <?php if($C5==5){ echo "SELECTED";}?>>Mayo</option>
                                            <option value="6" <?php if($C5==6){ echo "SELECTED";}?>>Junio</option>
                                            <option value="7" <?php if($C5==7){ echo "SELECTED";}?>>Julio</option>
                                            <option value="8" <?php if($C5==8){ echo "SELECTED";}?>>Agosto</option>
                                            <option value="9" <?php if($C5==9){ echo "SELECTED";}?>>Septiembre</option>
                                            <option value="10" <?php if($C5==10){ echo "SELECTED";}?>>Octubre</option>
                                            <option value="11" <?php if($C5==11){ echo "SELECTED";}?>>Noviembre</option>
                                            <option value="12" <?php if($C5==2){ echo "SELECTED";}?>>Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0" name="ANO_NAC" type="text"  id="ANO_NAC"  size="4" maxlength="4"  onKeyPress="return acceptNum(event);" value="<?php echo $C6;?>">
                            </td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                            <td><label for="NOMB_ACE">Nombre sugerido<br>(en Sistema ACE)</label></td>
                            <td><input name="NOMB_ACE" type="text" size="22" maxlength="20"  value="<?php echo $C7;?>"></td>
                        </tr>
                         <tr style="background-color:#FFF3E0">
                            <td><label for="NOMB_ACE">Iniciales sugeridas<br>(en Sistema ACE)</label></td>
                            <td><input name="INI_ACE" id="INI_ACE" type="text" size="22" maxlength="3"  value="<?php echo $C10;?>"></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td><label for="COD_NEGOCIO">Negocio </label></td>
                           <td><select name="COD_NEGOCIO"  onChange="CargaTienda(this.value, this.form.name, 'COD_TIENDA')">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO<>0 ORDER BY DES_NEGOCIO ASC";
                                $RS1 = sqlsrv_query($maestra, $S1);
                                //oci_execute($RS1);
                                while ($row1 = sqlsrv_fetch_array($RS1)) {
                                    $COD_NEGOCIO2 = $row1['COD_NEGOCIO'];
                                    $DES_NEGOCIO = $row1['DES_NEGOCIO'];
                            ?>
                            <option value="<?php echo $COD_NEGOCIO2?>" <?php if($C8==$COD_NEGOCIO2){ echo "SELECTED";}?>><?php echo $DES_NEGOCIO?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td><label for="COD_TIENDA">Local asignado </label></td>
                           <td><select id="COD_TIENDA" name="COD_TIENDA">
                           <option value="0">SELECCIONAR</option>
                            <?php
								if(!empty($C8)){
									$S1="SELECT * FROM MN_TIENDA WHERE COD_NEGOCIO=".$C8." ORDER BY DES_CLAVE ASC";
									$RS1 = sqlsrv_query($maestra, $S1);
									//oci_execute($RS1);
									while ($row1 = sqlsrv_fetch_array($RS1)) {
										$DES_TIENDA = $row1['DES_TIENDA'];
										$FDES_CLAVE = $row1['DES_CLAVE'];
										$FDES_CLAVE_F=substr("000".$FDES_CLAVE, -3); 
                            ?>
                            <option value="<?php echo $FDES_CLAVE?>" <?php if($C9==$FDES_CLAVE){ echo "SELECTED";}?>><?php echo $FDES_CLAVE_F." - ".$DES_TIENDA?></option>
                            <?php
									}
								}
                            ?>
                            </select></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td><label for="ID_MODOPERA">Aplicar Modelo Operador</label></td>
                           <td><select id="ID_MODOPERA" name="ID_MODOPERA">
                           <option value="0">SELECCIONAR</option>
                            <?php
									$S1="SELECT * FROM OP_MODOPERA WHERE EST_MODOPERA=1 ORDER BY ID_MODOPERA ASC";
									$RS1 = sqlsrv_query($conn, $S1);
									//oci_execute($RS1);
									while ($row1 = sqlsrv_fetch_array($RS1)) {
										$ID_MODOPERA = $row1['ID_MODOPERA'];
										$DES_MODOPERA = $row1['DES_MODOPERA'];
                            ?>
                            <option value="<?php echo $ID_MODOPERA?>"><?php echo $DES_MODOPERA?></option>
                            <?php
									}
                            ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Registrar">
                            <input name="NEO" type="hidden" value="1">
                            <input name="LIMPIAR" type="reset" value="Limpiar">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('reg_operador.php')"></td>
                        </tr>
                        </form>
                </table>
<?php
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>
			<?php  if ($ACT<>"") { 
				$ANO_NAC = "";
				$MES_NAC = "";
				$DIA_NAC = "";
				$S="SELECT * FROM OP_OPERADOR WHERE ID_OPERADOR=".$ACT;
				$RS = sqlsrv_query($conn, $S);
				//oci_execute($RS);
				if ($row = sqlsrv_fetch_array($RS)) {
					$ID_OPERADOR = $row['ID_OPERADOR'];
					$CC_OPERADOR = $row['CC_OPERADOR'];
					$NOMBRE = $row['NOMBRE'];
					$APELLIDO_P = $row['APELLIDO_P'];
					$APELLIDO_M = $row['APELLIDO_M'];
					$DES_CLAVE = $row['COD_TIENDA'];
					$COD_NEGOCIO = $row['COD_NEGOCIO'];
					$NOMB_ACE = $row['NOMB_ACE'];
					$FECHA_NAC = $row['FECHA_NAC'];
							//$FECHA_NAC = strtotime($FECHA_NAC);

							$ANO_NAC = date_format($FECHA_NAC,"Y");
							$MES_NAC = date_format($FECHA_NAC,"m");
							$DIA_NAC = date_format($FECHA_NAC,"d");
							
					$REG_ESTADO = $row['REG_ESTADO'];
							if ($REG_ESTADO==0) {
								$ELESTADO="Bloqueado"; 
								$TDESTADO="#F44336";
								}
							if ($REG_ESTADO==1) {
								$ELESTADO="Activo"; 
								$TDESTADO="#4CAF50";
								}
					$NVA_GRUPO = $row['NVA_GRUPO'];
					$NVA_USUARIO = $row['NVA_USUARIO'];
					$NIVEL_AUT = $row['NIVEL_AUT'];
					$ID_MODOPERA = $row['ID_MODOPERA'];
					$INICIALES_OP = $row['INICIALES_OP'];
				}

			if($ACT_FIC==1){ // FICHA OPERADOR
               ?>
                <p class="speech" style="color:<?php echo $TDESTADO?>"><?php echo $ELESTADO?></p>
                <h3>Data Operador: <?php echo $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M?></h3>
                <table id="forma-registro">
                        <form action="reg_operador_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                        <tr>
                            <td><label for="CC_OPERADOR">C&oacute;digo Operador</label></td>
                            <td><input name="CC_OPERADOR" type="text" size="8" maxlength="8"  onKeyPress="return acceptNum(event);" value="<?php echo $CC_OPERADOR;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="NOMBRE">Nombre </label></td>
                            <td><input name="NOMBRE" type="text" size="20" maxlength="200" onChange="ArmaNombACE();"  value="<?php echo $NOMBRE;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="APELLIDO_P">Apellido Paterno </label></td>
                            <td><input name="APELLIDO_P" type="text" size="20" maxlength="200" onChange="ArmaNombACE();" value="<?php echo $APELLIDO_P;?>"> </td>
                        </tr>
                        <tr>
                            <td><label for="APELLIDO_M">Apellido Materno </label></td>
                            <td><input name="APELLIDO_M" type="text" size="20" maxlength="200" onChange="ArmaNombACE();" value="<?php echo $APELLIDO_M;?>"> </td>
                        </tr>
                        <tr>
                        	<td><label for="FECHA_NAC">Fecha Nacimiento <BR>(d&iacute;a-mes-a&ntilde;o)</label></td>
                            <td>
                                    <input style="float:left; display:inline; margin:6px 0 0 6px" name="DIA_NAC" type="text"  id="DIA_NAC" size="1" maxlength="2" onKeyPress="return acceptNum(event);"  value="<?php echo $DIA_NAC;?>">
                                    <select style="float:left; display:inline; margin:6px 0 0 0"  name="MES_NAC"  id="MES_NAC">
                                            <option value="1" <?php if($MES_NAC==1){ echo "SELECTED";}?>>Enero</option>
                                            <option value="2" <?php if($MES_NAC==2){ echo "SELECTED";}?>>Febrero</option>
                                            <option value="3" <?php if($MES_NAC==3){ echo "SELECTED";}?>>Marzo</option>
                                            <option value="4" <?php if($MES_NAC==4){ echo "SELECTED";}?>>Abril</option>
                                            <option value="5" <?php if($MES_NAC==5){ echo "SELECTED";}?>>Mayo</option>
                                            <option value="6" <?php if($MES_NAC==6){ echo "SELECTED";}?>>Junio</option>
                                            <option value="7" <?php if($MES_NAC==7){ echo "SELECTED";}?>>Julio</option>
                                            <option value="8" <?php if($MES_NAC==8){ echo "SELECTED";}?>>Agosto</option>
                                            <option value="9" <?php if($MES_NAC==9){ echo "SELECTED";}?>>Septiembre</option>
                                            <option value="10" <?php if($MES_NAC==10){ echo "SELECTED";}?>>Octubre</option>
                                            <option value="11" <?php if($MES_NAC==11){ echo "SELECTED";}?>>Noviembre</option>
                                            <option value="12" <?php if($MES_NAC==12){ echo "SELECTED";}?>>Diciembre</option>
                                    </select>
                                    <input style="float:left; display:inline; margin:6px 0 0 0"  name="ANO_NAC" type="text"  id="ANO_NAC"  size="4" maxlength="4"  onKeyPress="return acceptNum(event);" value="<?php echo $ANO_NAC;?>">
                            </td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                            <td><label for="NOMB_ACE" style="margin-top:0">Nombre sugerido<br>(en Sistema ACE)</label></td>
                            <td><input name="NOMB_ACE" type="text" size="22" maxlength="20"  value="<?php echo $NOMB_ACE;?>"></td>
                        </tr>
                         <tr style="background-color:#FFF3E0">
                            <td><label for="INI_ACE">Iniciales sugeridas<br>(en Sistema ACE)</label></td>
                            <td><input name="INI_ACE" id="INI_ACE" type="text" size="22" maxlength="3"  value="<?php echo $INICIALES_OP;?>"></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td><label for="COD_NEGOCIO">Negocio </label></td>
                           <td><select name="COD_NEGOCIO"  onChange="CargaTienda(this.value, this.form.name, 'COD_TIENDA')">
                            <option value="0">SELECCIONAR</option>
                            <?php
                                $S1="SELECT * FROM MN_NEGOCIO WHERE COD_NEGOCIO<>0 ORDER BY DES_NEGOCIO ASC";
                                $RS1 = sqlsrv_query($maestra, $S1);
                                //oci_execute($RS1);
                                while ($row1 = sqlsrv_fetch_array($RS1)) {
                                    $COD_NEGOCIO2 = $row1['COD_NEGOCIO'];
                                    $DES_NEGOCIO = $row1['DES_NEGOCIO'];
                            ?>
                            <option value="<?php echo $COD_NEGOCIO2?>" <?php if($COD_NEGOCIO==$COD_NEGOCIO2){ echo "SELECTED";}?>><?php echo $DES_NEGOCIO?></option>
                            <?php
                                }
                            ?>
                            </select></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td><label for="COD_TIENDA">Local asignado </label></td>
                           <td><select id="COD_TIENDA" name="COD_TIENDA">
                           <option value="0">SELECCIONAR</option>
                            <?php
								if(!empty($COD_NEGOCIO)){
									$S1="SELECT * FROM MN_TIENDA WHERE COD_TIENDA IN(SELECT COD_TIENDA FROM MN_NEGTND WHERE COD_NEGOCIO=".$COD_NEGOCIO.") ORDER BY DES_CLAVE ASC";
									$RS1 = sqlsrv_query($maestra, $S1);
									//oci_execute($RS1);
									while ($row1 = sqlsrv_fetch_array($RS1)) {
										$DES_TIENDA = $row1['DES_TIENDA'];
										$FDES_CLAVE = $row1['DES_CLAVE'];
										$FDES_CLAVE_F=substr("000".$FDES_CLAVE, -3); 
                            ?>
                            <option value="<?php echo $FDES_CLAVE?>" <?php if($FDES_CLAVE==$DES_CLAVE){ echo "SELECTED";}?>><?php echo $FDES_CLAVE_F." - ".$DES_TIENDA?></option>
                            <?php
									}
								}
                            ?>
                            </select></td>
                        </tr>
                        <tr style="background-color:#FFF3E0">
                           <td style="vertical-align:top; padding-top:10px"><label for="ID_MODOPERA">Volver a Aplicar<br>Modelo Operador</label></td>
                           <td>
								<script>
                                    function habilitar(value)
                                    {
                                        if(value==true)
                                        {
                                            // habilitamos
                                            document.getElementById("ID_MODOPERA").disabled=false;
                                        }else if(value==false){
                                            // deshabilitamos
                                            document.getElementById("ID_MODOPERA").disabled=true;
                                        }
                                    }
                                </script>
                               <select id="ID_MODOPERA" name="ID_MODOPERA" disabled>
                           <option value="0">SELECCIONAR</option>
                            <?php
									$S2="SELECT * FROM OP_MODOPERA WHERE EST_MODOPERA=1 ORDER BY ID_MODOPERA ASC";
									$RS2 = sqlsrv_query($conn, $S2);
									//oci_execute($RS2);
									while ($row2 = sqlsrv_fetch_array($RS2)) {
										$ID_MODOPERASEL = $row2['ID_MODOPERA'];
										$DES_MODOPERA = $row2['DES_MODOPERA'];
                            ?>
                            <option value="<?php echo $ID_MODOPERASEL?>" <?php if($ID_MODOPERASEL==$ID_MODOPERA){ echo "SELECTED";}?>><?php echo $DES_MODOPERA?></option>
                            <?php
									}
                            ?>
                            </select>
                            <input style="margin-left:10px; margin-top:12px" type="checkbox" name="VA_MODOPERA" value="1" onChange="habilitar(this.checked);" >
                            <label style="font-weight:400; font-size:9pt; clear:left; margin-left:6px">Si aplica nuevamente el Modelo de Operador,<br>se eliminar&aacute;n los &uacute;ltimos cambios realizados
                            <br>a los niveles y registros de autorizaci&oacute;n, <br>dejando s&oacute;lo el modelo seleccionado.</label>
                            </td>
                        </tr>

                        <?php
						//VERIFICAR SI OPERADOR CUENTA CON REGISTROS DE AUTORIZACION
							$BLOQUEAESTADO=1;
							$S1="SELECT COUNT(ID_OPERADOR) AS CTA_OPERA FROM OP_OPERANVA WHERE ID_OPERADOR=".$ID_OPERADOR;
							$RS1 = sqlsrv_query($conn, $S1);
							//oci_execute($RS1);
							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$CTA_OPERANVA= $row1['CTA_OPERA'];
							}
							$S1="SELECT COUNT(ID_OPERADOR) AS CTA_OPERA FROM OP_OPERAMDA WHERE ID_OPERADOR=".$ID_OPERADOR;
							$RS1 = sqlsrv_query($conn, $S1);
							//oci_execute($RS1);
							if ($row1 = sqlsrv_fetch_array($RS1)) {
								$CTA_OPERAMDA= $row1['CTA_OPERA'];
							}
							//if($CTA_OPERAMDA>0 && $CTA_OPERANVA>0) {
							if($CTA_OPERAMDA>0) {
								$BLOQUEAESTADO=0;
							}
						?>
                        <tr>
                           <td><label for="REG_ESTADO">Estado</label></td>
                           <td><select name="REG_ESTADO" <?php if($BLOQUEAESTADO==1) { echo "disabled";} ?>>
                            <option value="0" <?php if($REG_ESTADO==0){ echo "SELECTED";}?>>BLOQUEADO</option>
                            <option value="1" <?php if($REG_ESTADO==1){ echo "SELECTED";}?>>ACTIVO</option>
                            </select>
                            <?php if($BLOQUEAESTADO==1) { ?>
                            <p style="display:inline-block; padding:2px">Operador requiere configuraci&oacute;n<br>del registro de Autorizaciones.</p>
                            <?php } ?>
                            </td>
                        </tr>


                        <tr>
                           <td></td>
                           <td><input name="INGRESAR" type="submit" value="Actualizar">
                            <input name="NEO" type="hidden" value="2">
                            <input name="ID_OPERADOR" type="hidden" value="<?php echo $ID_OPERADOR;?>">
                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('reg_operador.php')"></td>
                        </tr>
                        </form>
                </table>
                                
			<?php
			}// FIN FICHA DE OPERADOR
			?>
			
			<?php include("reg_operanva.php");?>
			
			
			
			<?php
			if($ACT_MDA==1){ //REGISTRO DE AUTORIZACION

			//IDIOMA TITULOS INDICAT
			$IDIOMA=$_POST["IDIOMA"];
			if ($IDIOMA=="ESP") {
					$_SESSION['LAN_INDICAT'] = "DESCRIP_ES";	
			}
			if ($IDIOMA=="ENG") {
					$_SESSION['LAN_INDICAT'] = "DESCRIP_EN";	
			}
			
			if (!isset($_SESSION['LAN_INDICAT'])) {
				$_SESSION['LAN_INDICAT'] = "DESCRIP_EN";	
				}
		

			?>
                <p class="speech" style="color:<?php echo $TDESTADO?>"><?php echo $ELESTADO?></p>
                <h3>Data Operador: <?php echo $NOMBRE." ".$APELLIDO_P." ".$APELLIDO_M?><br>Registros de Autorizaci&oacute;n</h3>

                        <div style="text-align:right">
                        		<form action="reg_operador.php?ACT=<?php echo $ACT?>&ACT_MDA=1" method="post">
                                        <input style="padding:4px 8px; margin:1px;  border-color:#666" name="IDIOMA" type="submit" value="ESP" title="espa&ntilde;ol">
                                        <input style="padding:4px 8px; margin:1px;  border-color:#666" name="IDIOMA" type="submit" value="ENG" title="english">
                                </form>
                         </div>
                
                <?php
				$CONSULTA="SELECT * FROM OP_INDICAT WHERE RESERVADO=0 ORDER BY ID_INDICAT ASC";
				$RS = sqlsrv_query($conn, $CONSULTA);
				//oci_execute($RS);
				while ($row = sqlsrv_fetch_array($RS)) {
					$ID_INDICAT = $row['ID_INDICAT'];
					$DESCRIP_IND = $row[$_SESSION['LAN_INDICAT']];
				?>
                <style>
					#RegNvcAuth<?php echo $ID_INDICAT?> {position:absolute;width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(../images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
					#RegNvcAuth-contenedor<?php echo $ID_INDICAT?> {
						position:absolute;
						left: 340px;
						top:40px;
						width:auto;
						min-width:300px;
						height:auto;
						overflow:visible;
						padding:20px;
						background-color:#F1F1F1;
						-khtml-border-radius: 6px;
						-moz-border-radius: 6px;
						-webkit-border-radius: 6px;
						border-radius: 6px;
						background-image: url(../images/ARMS.png); 
						background-repeat: no-repeat; 
						background-position: 20px 10px; 
						}
					#RegNvcAuth-contenedor<?php echo $ID_INDICAT?> h3{
						margin-top:50px;
					}
					#RegNvcAuth-contenedor<?php echo $ID_INDICAT?> td{
						padding:4px 6px;
					}

				</style>
                <script>
					 function ActivarRegAuth<?php echo $ID_INDICAT?>(){
							var contenedor = document.getElementById("RegNvcAuth<?php echo $ID_INDICAT?>");
							contenedor.style.display = "block";
							window.scrollTo(0,0);
							return true;
						}
						
					 function CerrarRegAuth<?php echo $ID_INDICAT?>(){
							var contenedor = document.getElementById("RegNvcAuth<?php echo $ID_INDICAT?>");
							contenedor.style.display = "none";
							return true;
						}
				</script>
                
                <input type="button" style="display:block; width:100%; text-align:left; margin:2px 0" value="<?php echo $DESCRIP_IND?>"  onClick="ActivarRegAuth<?php echo $ID_INDICAT?>();">
                
                <div id="RegNvcAuth<?php echo $ID_INDICAT?>" style="display:none">
                    <div id="RegNvcAuth-contenedor<?php echo $ID_INDICAT?>">

                            <span style="position:absolute; top:0; right:20px;">
                            <img src="../images/ICO_Close.png" border="0" onClick="CerrarRegAuth<?php echo $ID_INDICAT?>();" title="Cerrar ventana">
                            </span>
                            <h3>Registros de Autorizaci&oacute;n<br><?php echo $DESCRIP_IND?></h3>
                            <table id="Listado" width="100%">
                                <form action="reg_operador_reg.php" method="post" name="formact<?php echo $ID_INDICAT?>" id="formact<?php echo $ID_INDICAT?>">
                                                <tr>
                                                    <th width="10px">
                                                            <script>
                                                                function MarcarCheck<?php echo $ID_INDICAT?>(val){ 
                                                                   for (i=0;i<document.formact<?php echo $ID_INDICAT?>.elements.length;i++) 
                                                                      if(document.formact<?php echo $ID_INDICAT?>.elements[i].type == "checkbox")	
                                                                        if(document.formact<?php echo $ID_INDICAT?>.SELCHECKBOX<?php echo $ID_INDICAT?>.checked == true) {
                                                                             document.formact<?php echo $ID_INDICAT?>.elements[i].checked=1;
                                                                        } else {
                                                                             document.formact<?php echo $ID_INDICAT?>.elements[i].checked=0;
                                                                        }
                                                                } 
                                                            </script>
                                                            <input name="SELCHECKBOX<?php echo $ID_INDICAT?>" type="checkbox" value="1" onChange="MarcarCheck<?php echo $ID_INDICAT?>(this.value)">
                                                    </th>
                                                    <th>Seleccionar todos</th>
                                                </tr>
                                            <?php
                                                    $CONSULTA1="SELECT * FROM OP_INDICATOPC WHERE ID_INDICAT=".$ID_INDICAT." AND RESERVADO=0 ORDER BY POSICION ASC";
                                                    $RS1 = sqlsrv_query($conn, $CONSULTA1);
                                                    //oci_execute($RS1);
                                                    while ($row = sqlsrv_fetch_array($RS1)) {
                                                            $ID_INDICATOPC=$row['ID_INDICATOPC'];
															$DESCRIP_INDOPC=$row[$_SESSION['LAN_INDICAT']];
                                                            $CONSULTA2="SELECT VALUE FROM OP_OPERAMDA WHERE ID_OPERADOR=".$ID_OPERADOR." AND ID_INDICATOPC=".$ID_INDICATOPC;
                                                            $RS2 = sqlsrv_query($conn, $CONSULTA2);
                                                            //oci_execute($RS2);
                                                            if ($row2 = sqlsrv_fetch_array($RS2)) {
                                                                    $IND_ACTIVO = $row2['VALUE'];
                                                            }
                                                            if($IND_ACTIVO==1) {
                                                                    $TDCOLOR=" style='background:#FFF3E0' ";
                                                            } else {
                                                                    $TDCOLOR="";
                                                            }
                                                        ?>
                                                            <tr<?=$TDCOLOR;?>>
                                                                <td width="10px"><input type="checkbox" id="IND<?php echo $ID_INDICATOPC;?>" name="IND<?php echo $ID_INDICATOPC;?>" value="1" <?php if($IND_ACTIVO==1) {?> checked <?php }?>></td>
                                                                <td><?php echo $DESCRIP_INDOPC;?></td>
                                                            </tr>
                                                        <?php
                                                    }
                                            ?>
                                                    <tr>
                                                        <td colspan="2" style="border:none">
                                                                <input type="hidden" name="ID_INDICAT" id="ID_INDICAT" value="<?php echo $ID_INDICAT?>">
                                                                <input type="hidden" name="ID_OPERADOR" id="ID_OPERADOR" value="<?php echo $ID_OPERADOR?>">
                                                                <input style="margin:2px" type="submit" name="REGIND" id="REGIND" value="Registrar">
                                                                <input style="margin:2px" type="button" name="CERRARV" id="CERRARV" value="Salir" onClick="javascript: CerrarRegAuth<?php echo $ID_INDICAT?>();">
                                                        </td>
                                                    </tr>
                                </form>
                             </table>
                    </div>
                </div>
                <?php }?>
			<?php
			} //FIN REGISTRO DE AUTORIZACION
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
 } //FIN ACT
 ?>
                </td>
                </tr>
                </table>
        
        </td>
        </tr>
        <tr>
        <td>
        <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
        </iframe>
        </td>
        </tr>  
        </table>
</td>
</tr>
</table>
</body>
</html>

