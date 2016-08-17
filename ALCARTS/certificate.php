<?php include("session.inc");?>

<?php include("headerhtml.inc");?>

<?php

function DOLARS($VAL)
{
	if (strlen($VAL) > 1)
	{
		$DEC_VAL = substr($VAL, -2);
		$INT_VAL = substr($VAL, 0, -2);
		return "US $" . $INT_VAL . "." . $DEC_VAL;
	}
	else
	{
		return $VAL;
	}
}

	$PAGINA=3183;
	$NOMENU=1;

	$LIST=@$_GET["LIST"];

	$NEO=@$_GET["NEO"];

	$ACT=@$_GET["ACT"];

	if ($NEO=="" and $ACT=="") {

		 $LIST=1;

	}

?>
<script language="JavaScript">

function Seguro() {
var aceptaEntrar = window.confirm("ESTA SEGURO?");
if (aceptaEntrar)  {


} else { return false; }
}   
   
	 
	
	
	


function mostrarOcultarTablas(id,btn){
	mostrado=0;
	var elem = document.getElementById(id);
	var boton= document.getElementById(btn);
		if(elem.style.display=='block'){
		    mostrado=1;
			elem.style.display='none';
			boton.value = 'Abrir Detalle';
			
		}
		if(mostrado!=1){
		elem.style.display='block';
		boton.value = 'Cerrar Detalle'; 
		
      }
	

	}
	
	function cambiarinput(id,btn){
	mostrado=0;
	
	var input= document.getElementById(id);
	var boton= document.getElementById(btn);
		if(input.disabled){
		   
			input.disabled = false;
			boton.value = 'Actualizar';
			boton.style.backgroundColor='#990000';
		}else
		{
		input.disabled = true;
		boton.value = 'Habilita Edicion';
		boton.style.backgroundColor='#7A2A9C';
		
      }
	

	}

</script>






<style>

#overlay {

 position: fixed;

  top: 0;

  left: 0;

  width: 100%;

  height: 100%;

  text-align: center;

  background-color: #000;

  filter: alpha(opacity=50);

  -moz-opacity: 0.5;

  opacity: 0.5;    

}

#overlay span {

        padding: 50px;

    border-radius: 5px;

    color: #000;

    background-color: #fff;

    position: relative;

    top: 50%;

    font-size: 40px;

	    padding-top: 80px;

}
input.switch:empty
{margin-left: -999px;}
input.switch:empty ~ label
{
position: relative;
float: left;
line-height: 1.6em;
text-indent: 4em;
margin: 0.2em 0;
cursor: pointer;
 -webkit-user-select: none;
 -moz-user-select: none;
 -ms-user-select: none;
 user-select: none;
}
input.switch:empty ~ label:before, 
input.switch:empty ~ label:after
{
position: absolute;
display: block;
top: 0;
bottom: 0;
left: 0;
content: ' ';
width: 3.6em;
background-color: #c33;
border-radius: 0.3em;
box-shadow: inset 0 0.2em 0 rgba(0,0,0,0.3);
-webkit-transition: all 100ms ease-in;
 transition: all 100ms ease-in;
}
input.switch:empty ~ label:after
{
width: 1.4em;
top: 0.1em;
bottom: 0.1em;
margin-left: 0.1em;
background-color: #fff;
border-radius: 0.15em;
box-shadow: inset 0 -0.2em 0 rgba(0,0,0,0.2);
}
input.switch:checked ~ label:before
{
background-color: #393;
}
input.switch:checked ~ label:after
{
margin-left: 2.1em;
}
</style>

</head>

<body>

<?php include("encabezado.php");?>

<?php include("titulo_menu.php");?>

<table width="100%" height="100%">

<tr>

<td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php");?></td> 

<td >

<?php

if ($MSJE==1) {

$ELMSJ="Certificacion realizada";

} 

if ($MSJE == 2) {

	$ELMSJ="Certificacion no realizada";

} 



if ($MSJE <> "") {

?>

<div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?=$ELMSJ?></a></div>

<?php }?>

        <table width="100%">

        <tr><td>  

        <h2><?= $LAPAGINA?></h2>

     </td>
           

              

<?php



?>          
			 <form action="certificate_reg.php?LIST=1" method="post" name="forming" id="forming" >

			
           
            <table id="Listado" style="margin:10px 20px;">
                
                	 <tr>
                     
                     <th>FECHA PERIODO</th>
                     <th>TOTAL <br> EFECTIVO</th>
                     <th>TOTAL <br> CHEQUES</th>
                     <th>TOTAL CUPONES <br> DE ALIMENTOS</th>
                     <th>TOTAL <br>VARIOS 1</th>
                     <th>TOTAL <br> VARIOS 2</th>
                     <th>TOTAL <br>VARIOS 3</th>
                     <th>TOTAL <br>CUPONES DEL FABRICANTE</th>
                     <th>TOTAL <br>TIENDA DE CUPONES</th>
                     <th>ACCION</th>
                    </tr> 
          
		  
		  <?php
		        
				 
				 
		  
		  
		     
				 
			
			   
			    $estasdostr1=0;
			  
						
                if($estasdostr1==0){
		 
					
				$CONSULTA1="select * from LE_STR_REC_TOT A WHERE A.ID_STR_REC_TOT IN (SELECT ID_STR_REC_TOT FROM CERT_STR)";
				$RS1 = sqlsrv_query($conn, $CONSULTA1);

             

				while ($row1 = sqlsrv_fetch_array($RS1)){
			
					  $ID=$row1['ID_STR_REC_TOT'];
					  $record_type = $row1['REC_TYP'];
					  $STR_ID=$row1['STR_ID'];
					  $TM_STP = $row1['TM_STP'];
                      $TM_STP_DATE = date_format($TM_STP, 'Y/m/d H:i:s');
					  $LS_TML=$row1['LS_TML'];
					  $RESRT=$row1['RESRT'];
					  $GS_PLS=$row1['GS_PLS'];
					  $GS_MNS=$row1['GS_MNS'];
					  
					  $SLS_TRN_CNT=$row1['SLS_TRN_CNT'];
					  $LON_TND_AMT_CSH=$row1['LON_TND_AMT_CSH'];
					  $LON_TND_AMT_CHK=$row1['LON_TND_AMT_CHK'];
					  $LON_TND_AMT_FDS=$row1['LON_TND_AMT_FDS'];
					  $LON_TND_AMT_MSC1=$row1['LON_TND_AMT_MSC1'];
					  $LON_TND_AMT_MSC2=$row1['LON_TND_AMT_MSC2'];
					  $LON_TND_AMT_MSC3=$row1['LON_TND_AMT_MSC3'];
					  $LON_TND_AMT_MF_CPN=$row1['LON_TND_AMT_MF_CPN'];
					  $LON_TND_AMT_STR_CPN=$row1['LON_TND_AMT_STR_CPN'];
					  
					  $PKP_TND_AMT_CSH=$row1['PKP_TND_AMT_CSH'];
					  $PKP_TND_AMT_CHK=$row1['PKP_TND_AMT_CHK'];
					  $PKP_TND_AMT_FDS=$row1['PKP_TND_AMT_FDS'];
					  $PKP_TND_AMT_MSC1=$row1['PKP_TND_AMT_MSC1'];
					  $PKP_TND_AMT_MSC2=$row1['PKP_TND_AMT_MSC2'];
					  $PKP_TND_AMT_MSC3=$row1['PKP_TND_AMT_MSC3'];
					  $PKP_TND_AMT_MF_CPN=$row1['PKP_TND_AMT_MF_CPN'];
					  $PKP_TND_AMT_STR_CPN=$row1['PKP_TND_AMT_STR_CPN'];
					  
					  $CNTD_TND_AMT_CSH=$row1['CNTD_TND_AMT_CSH'];
					  $CNTD_TND_AMT_CHK=$row1['CNTD_TND_AMT_CHK'];
					  $CNTD_TND_AMT_FDS=$row1['CNTD_TND_AMT_FDS'];
					  $CNTD_TND_AMT_MSC1=$row1['CNTD_TND_AMT_MSC1'];
					  $CNTD_TND_AMT_MSC2=$row1['CNTD_TND_AMT_MSC2'];
					  $CNTD_TND_AMT_MSC3=$row1['CNTD_TND_AMT_MSC3'];
					  $CNTD_TND_AMT_MF_CPN=$row1['CNTD_TND_AMT_MF_CPN'];
					  $CNTD_TND_AMT_STR_CPN=$row1['CNTD_TND_AMT_STR_CPN'];
					  
					  $NT_TND_AMT_CSH=$row1['NT_TND_AMT_CSH'];
					  $NT_TND_AMT_CHK=$row1['NT_TND_AMT_CHK'];
					  $NT_TND_AMT_FDS=$row1['NT_TND_AMT_FDS'];
					  $NT_TND_AMT_MSC1=$row1['NT_TND_AMT_MSC1'];
					  $NT_TND_AMT_MSC2=$row1['NT_TND_AMT_MSC2'];
					  $NT_TND_AMT_MSC3=$row1['NT_TND_AMT_MSC3'];
					  $NT_TND_AMT_MF_CPN=$row1['NT_TND_AMT_MF_CPN'];
					  $NT_TND_AMT_STR_CPN=$row['NT_TND_AMT_STR_CPN'];
					  
					  $OPN_TND_AMT_CSH=$row1['OPN_TND_AMT_CSH'];
					  $OPN_TND_AMT_CHK=$row1['OPN_TND_AMT_CHK'];
					  $OPN_TND_AMT_FDS=$row1['OPN_TND_AMT_FDS'];
					  $OPN_TND_AMT_MSC1=$row1['OPN_TND_AMT_MSC1'];
					  $OPN_TND_AMT_MSC2=$row1['OPN_TND_AMT_MSC2'];
					  $OPN_TND_AMT_MSC3=$row1['OPN_TND_AMT_MSC3'];
					  $OPN_TND_AMT_MF_CPN=$row1['OPN_TND_AMT_MF_CPN'];
					  $OPN_TND_AMT_STR_CPN=$row1['OPN_TND_AMT_STR_CPN'];
					  
					
					  
					  $TXBL_EXM_AMT=$row1['TXBL_EXM_AMT'];
					  $TX_EXM_AMT_A=$row1['TX_EXM_AMT_A'];
					  $TX_EXM_AMT_B=$row1['TX_EXM_AMT_B'];
					  $TX_EXM_AMT_C=$row1['TX_EXM_AMT_C'];
					  $TX_EXM_AMT_D=$row1['TX_EXM_AMT_D'];
					  $TXBL_EXM_AMT_A=$row1['TXBL_EXM_AMT_A'];
					  $TXBL_EXM_AMT_B=$row1['TXBL_EXM_AMT_B'];
					  $TXBL_EXM_AMT_C=$row1['TXBL_EXM_AMT_C'];
					  $TXBL_EXM_AMT_D=$row1['TXBL_EXM_AMT_D'];
					  $TX_EXM_AMT_E=$row1['TX_EXM_AMT_E'];
					  $TX_EXM_AMT_F=$row1['TX_EXM_AMT_F'];
					  $TX_EXM_AMT_G=$row1['TX_EXM_AMT_G'];
					  $TX_EXM_AMT_H=$row1['TX_EXM_AMT_H'];
					  $TXBL_EXM_AMT_E=$row1['TXBL_EXM_AMT_E'];
					  $TXBL_EXM_AMT_F=$row1['TXBL_EXM_AMT_F'];
					  $TXBL_EXM_AMT_G=$row1['TXBL_EXM_AMT_G'];
					  $TXBL_EXM_AMT_H=$row1['TXBL_EXM_AMT_H'];
					  $MF_AUT_CPN_AMT=$row1['MF_AUT_CPN_AMT'];
					  $STR_AUT_CPN_AMT=$row1['STR_AUT_CPN_AMT'];
					  $DBLD_CPN_AMT=$row1['DBLD_CPN_AMT'];
					  $PC_TRN_AMT=$row1['PC_TRN_AMT'];
					  $PC_TRN_CNT=$row1['PC_TRN_CNT'];
					  $PC_AUT_CPN_CNT=$row1['PC_AUT_CPN_CNT'];
					  $PC_AUT_CPN_AMT=$row1['PC_AUT_CPN_AMT'];
					  $STR_CD=$row1['STR_CD'];
					  
					  $TOTAL_EFECTIVO= $LON_TND_AMT_CSH + $PKP_TND_AMT_CSH + $CNTD_TND_AMT_CSH + $NT_TND_AMT_CSH + $OPN_TND_AMT_CSH;
					  $TOTAL_CHEQUES= $LON_TND_AMT_CHK + $PKP_TND_AMT_CHK + $CNTD_TND_AMT_CHK + $NT_TND_AMT_CHK + $OPN_TND_AMT_CHK ;
					  $TOTAL_FOODS= $LON_TND_AMT_FDS + $PKP_TND_AMT_FDS +  $CNTD_TND_AMT_FDS + $NT_TND_AMT_FDS + $OPN_TND_AMT_FDS;
					  $TOTAL_DIVERSOS1= $LON_TND_AMT_MSC1 + $PKP_TND_AMT_MSC1 + $CNTD_TND_AMT_MSC1 + $NT_TND_AMT_MSC1 + $OPN_TND_AMT_MSC1;
					  $TOTAL_DIVERSOS2= $LON_TND_AMT_MSC2 + $PKP_TND_AMT_MSC2 + $CNTD_TND_AMT_MSC2 + $NT_TND_AMT_MSC2 + $OPN_TND_AMT_MSC2;
					  $TOTAL_DIVERSOS3= $LON_TND_AMT_MSC3 + $PKP_TND_AMT_MSC3 + $CNTD_TND_AMT_MSC3 + $NT_TND_AMT_MSC3 + $OPN_TND_AMT_MSC3;
					  $TOTAL_CUPONES_F= $LON_TND_AMT_MF_CPN + $PKP_TND_AMT_MF_CPN + $CNTD_TND_AMT_MF_CPN + $NT_TND_AMT_MF_CPN + $OPN_TND_AMT_MF_CPN;
					  $TOTAL_TINE_CUPONES=$LON_TND_AMT_STR_CPN + $PKP_TND_AMT_STR_CPN + $CNTD_TND_AMT_STR_CPN + $NT_TND_AMT_STR_CPN + $OPN_TND_AMT_STR_CPN ;
					 
					 
					 
					
					  
					  
			    $CONSULTAEST="SELECT * FROM CERT_STR WHERE ID_STR_REC_TOT=".$ID;
				$RSEST = sqlsrv_query($conn, $CONSULTAEST);
				
				if ($row1est = sqlsrv_fetch_array($RSEST)){
		            $USU1=$row1est['ID_USU'];
					
					
				  $CONSULTAUSU1="SELECT NOMBRE FROM US_USUARIOS WHERE IDUSU=".$USU1;
				 $RSUSU = sqlsrv_query($maestra, $CONSULTAUSU1);
				   
					if ($row_usu = sqlsrv_fetch_array($RSUSU)){
						
		            $CERT_USU=$row_usu['NOMBRE'];
					
					}
					
					
				
					
				
					?>
			
                    
                     
                
                    <tr>
                    
                    <td><?=$TM_STP_DATE?></td>
                    <td><?=$TOTAL_EFECTIVO ?></td>
                    <td><?=$TOTAL_CHEQUES ?></td>
                    <td><?=$TOTAL_FOODS ?></td>
                    <td><?=$TOTAL_DIVERSOS1 ?></td>
                    <td><?=$TOTAL_DIVERSOS2 ?></td>
                    <td><?=$TOTAL_DIVERSOS3 ?></td>
                    <td><?=$TOTAL_CUPONES_F ?></td>
                    <td><?=$TOTAL_TINE_CUPONES ?></td>
                    
            <td><input name="Mostrar" id="<?=$ID?>"  type="button" value="Abrir Detalle" onClick="javascript:mostrarOcultarTablas('Listado2<?=$ID?>','<?=$ID?>')"> </td>
                    </tr>
                    
                    
					<tr>
                    <td colspan="10">
                    	
                        
                        
                        
          
   
             <?php
			$CONSULTA_LIST = "SELECT * FROM  le_Str_rec_tot where id_str_rec_tot=".$ID." and str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=".$STR_CD." ) order by TM_STP desc;";
			$RS_LIST = sqlsrv_query($conn, $CONSULTA_LIST);
			
			
			
			
            ?>
            
              <table id="Listado2<?=$ID?>" style="display: none">
              <?
               
					 
					
					
					?>
              
                  <tr>
                  <th colspan="10">
	             <h3 >Certificado por: <?=" ".$CERT_USU?> </h3>
                  </th>
                  </tr>
                
             
             
             
				 <tr>
                  <th colspan="10"> <h3 > Detalle Oficina </h3></th>
                 </tr>
                <tr>
                  <th>Fecha Cierre Periodo</th>
                  <th>Bruto a favor</th>
                  <th>Bruto en Contra</th>
                  <th>Dotaciones</th>
                  <th>Monto neto (Monto neto en negativo por dotaciones a operadores)</th>
                </tr>
        <?php
			while ($ROW_LIST = sqlsrv_fetch_array($RS_LIST))
			{
				 $TM_STP=$row1['TM_STP'];
                  $TM_STP = date_format($TM_STP, 'Y-m-d H:i:s');
				echo "<tr>";
				echo '<td>' . $TM_STP . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["GS_PLS"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["GS_MNS"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["LON_TND_AMT_CSH"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["NT_TND_AMT_CSH"]) . '</td></tr>';
			}

?>
      <tr>
      <th colspan="10">
	  <h3 >Detalle Movimientos</h3>
     </th>
     </tr>
         
                <tr>
                  <th>Tipo Movimiento</th>
                  <th>Cuenta</th>
                  <th>Monto</th>
                </tr>
        <?php
			$CONSULTA_OPERADOR = "SELECT * FROM  le_tnd_rec_tot where str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $STR_CD . " ) order by ACNT_ID,REC_TYP asc;";
			$RS_OPERADOR = sqlsrv_query($conn, $CONSULTA_OPERADOR);
			while ($ROW_OPERADOR = sqlsrv_fetch_array($RS_OPERADOR))
			{
				$TM_STP_DB = $ROW_OPERADOR['TM_STP'];
				$TM_STP = date_format($TM_STP_DB, 'Y-m-d H:i:s');
				if ($ROW_OPERADOR["ACNT_ID"] == 0)
				{
					$ACNT_ID = "TIENDA";
				}
				else
				{
					$ACNT_ID = "Operador: " . $ROW_OPERADOR["ACNT_ID"];
				}

				switch ($ROW_OPERADOR["REC_TYP"])
				{
				case 4:
					echo "<tr>";
					echo '<td>Dotaci&oacute;n</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;

				case 5:
					echo "<tr>";
					echo '<td>Retiros</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;

				case 7:
					echo "<tr>";
					echo '<td>Monto Neto</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;
			     	}
			
			   }

                 ?>

 

                      </table>
                    </td>
                   </tr>
					  
               
                

                <?php
			           
					          
							   } 
							   }
				           
					   
					  
				         	 
							 
							 
							 
							 
							 
							 
							
				// $CONSULTAEST="SELECT * FROM CERT_STR ";
//				$RSEST = sqlsrv_query($conn, $CONSULTAEST);
//				
//				while ($row1est = sqlsrv_fetch_array($RSEST)){
//					
//					$estado=$row1est['ESTADO'];
//					$IDEST=$row1est['ID_STR_REC_TOT'];


							
				$CONSULTA1="select * from LE_STR_REC_TOT WHERE ID_STR_REC_TOT NOT IN (SELECT ID_STR_REC_TOT FROM CERT_STR )";		
				$RS1 = sqlsrv_query($conn, $CONSULTA1);

               ?>

             
             
   
                <?php

				while ($row1 = sqlsrv_fetch_array($RS1)){
					
					  $ID=$row1['ID_STR_REC_TOT'];
					  $record_type = $row1['REC_TYP'];
					  $STR_ID=$row1['STR_ID'];
					  $TM_STP=$row1['TM_STP'];
                      $TM_STP = date_format($TM_STP, 'Y-m-d H:i:s');
					  $LS_TML=$row1['LS_TML'];
					  $RESRT=$row1['RESRT'];
					  $GS_PLS=$row1['GS_PLS'];
					  $GS_MNS=$row1['GS_MNS'];
					  
					  $SLS_TRN_CNT=$row1['SLS_TRN_CNT'];
					  $LON_TND_AMT_CSH=$row1['LON_TND_AMT_CSH'];
					  $LON_TND_AMT_CHK=$row1['LON_TND_AMT_CHK'];
					  $LON_TND_AMT_FDS=$row1['LON_TND_AMT_FDS'];
					  $LON_TND_AMT_MSC1=$row1['LON_TND_AMT_MSC1'];
					  $LON_TND_AMT_MSC2=$row1['LON_TND_AMT_MSC2'];
					  $LON_TND_AMT_MSC3=$row1['LON_TND_AMT_MSC3'];
					  $LON_TND_AMT_MF_CPN=$row1['LON_TND_AMT_MF_CPN'];
					  $LON_TND_AMT_STR_CPN=$row1['LON_TND_AMT_STR_CPN'];
					  
					  $PKP_TND_AMT_CSH=$row1['PKP_TND_AMT_CSH'];
					  $PKP_TND_AMT_CHK=$row1['PKP_TND_AMT_CHK'];
					  $PKP_TND_AMT_FDS=$row1['PKP_TND_AMT_FDS'];
					  $PKP_TND_AMT_MSC1=$row1['PKP_TND_AMT_MSC1'];
					  $PKP_TND_AMT_MSC2=$row1['PKP_TND_AMT_MSC2'];
					  $PKP_TND_AMT_MSC3=$row1['PKP_TND_AMT_MSC3'];
					  $PKP_TND_AMT_MF_CPN=$row1['PKP_TND_AMT_MF_CPN'];
					  $PKP_TND_AMT_STR_CPN=$row1['PKP_TND_AMT_STR_CPN'];
					  
					  $CNTD_TND_AMT_CSH=$row1['CNTD_TND_AMT_CSH'];
					  $CNTD_TND_AMT_CHK=$row1['CNTD_TND_AMT_CHK'];
					  $CNTD_TND_AMT_FDS=$row1['CNTD_TND_AMT_FDS'];
					  $CNTD_TND_AMT_MSC1=$row1['CNTD_TND_AMT_MSC1'];
					  $CNTD_TND_AMT_MSC2=$row1['CNTD_TND_AMT_MSC2'];
					  $CNTD_TND_AMT_MSC3=$row1['CNTD_TND_AMT_MSC3'];
					  $CNTD_TND_AMT_MF_CPN=$row1['CNTD_TND_AMT_MF_CPN'];
					  $CNTD_TND_AMT_STR_CPN=$row1['CNTD_TND_AMT_STR_CPN'];
					  
					  $NT_TND_AMT_CSH=$row1['NT_TND_AMT_CSH'];
					  $NT_TND_AMT_CHK=$row1['NT_TND_AMT_CHK'];
					  $NT_TND_AMT_FDS=$row1['NT_TND_AMT_FDS'];
					  $NT_TND_AMT_MSC1=$row1['NT_TND_AMT_MSC1'];
					  $NT_TND_AMT_MSC2=$row1['NT_TND_AMT_MSC2'];
					  $NT_TND_AMT_MSC3=$row1['NT_TND_AMT_MSC3'];
					  $NT_TND_AMT_MF_CPN=$row1['NT_TND_AMT_MF_CPN'];
					  $NT_TND_AMT_STR_CPN=$row['NT_TND_AMT_STR_CPN'];
					  
					  $OPN_TND_AMT_CSH=$row1['OPN_TND_AMT_CSH'];
					  $OPN_TND_AMT_CHK=$row1['OPN_TND_AMT_CHK'];
					  $OPN_TND_AMT_FDS=$row1['OPN_TND_AMT_FDS'];
					  $OPN_TND_AMT_MSC1=$row1['OPN_TND_AMT_MSC1'];
					  $OPN_TND_AMT_MSC2=$row1['OPN_TND_AMT_MSC2'];
					  $OPN_TND_AMT_MSC3=$row1['OPN_TND_AMT_MSC3'];
					  $OPN_TND_AMT_MF_CPN=$row1['OPN_TND_AMT_MF_CPN'];
					  $OPN_TND_AMT_STR_CPN=$row1['OPN_TND_AMT_STR_CPN'];
					  
					  $MSC_TRN_AMT=$row1['MSC_TRN_AMT'];
					  
					  
					  $TXBL_EXM_AMT=$row1['TXBL_EXM_AMT'];
					  $TX_EXM_AMT_A=$row1['TX_EXM_AMT_A'];
					  $TX_EXM_AMT_B=$row1['TX_EXM_AMT_B'];
					  $TX_EXM_AMT_C=$row1['TX_EXM_AMT_C'];
					  $TX_EXM_AMT_D=$row1['TX_EXM_AMT_D'];
					  $TXBL_EXM_AMT_A=$row1['TXBL_EXM_AMT_A'];
					  $TXBL_EXM_AMT_B=$row1['TXBL_EXM_AMT_B'];
					  $TXBL_EXM_AMT_C=$row1['TXBL_EXM_AMT_C'];
					  $TXBL_EXM_AMT_D=$row1['TXBL_EXM_AMT_D'];
					  $TX_EXM_AMT_E=$row1['TX_EXM_AMT_E'];
					  $TX_EXM_AMT_F=$row1['TX_EXM_AMT_F'];
					  $TX_EXM_AMT_G=$row1['TX_EXM_AMT_G'];
					  $TX_EXM_AMT_H=$row1['TX_EXM_AMT_H'];
					  $TXBL_EXM_AMT_E=$row1['TXBL_EXM_AMT_E'];
					  $TXBL_EXM_AMT_F=$row1['TXBL_EXM_AMT_F'];
					  $TXBL_EXM_AMT_G=$row1['TXBL_EXM_AMT_G'];
					  $TXBL_EXM_AMT_H=$row1['TXBL_EXM_AMT_H'];
					  $MF_AUT_CPN_AMT=$row1['MF_AUT_CPN_AMT'];
					  $STR_AUT_CPN_AMT=$row1['STR_AUT_CPN_AMT'];
					  $DBLD_CPN_AMT=$row1['DBLD_CPN_AMT'];
					  $PC_TRN_AMT=$row1['PC_TRN_AMT'];
					  $PC_TRN_CNT=$row1['PC_TRN_CNT'];
					  $PC_AUT_CPN_CNT=$row1['PC_AUT_CPN_CNT'];
					  $PC_AUT_CPN_AMT=$row1['PC_AUT_CPN_AMT'];
					  $STR_CD1=$row1['STR_CD'];
					  
					  $TOTAL_EFECTIVO1= $LON_TND_AMT_CSH + $PKP_TND_AMT_CSH + $CNTD_TND_AMT_CSH + $NT_TND_AMT_CSH + $OPN_TND_AMT_CSH;
					  $TOTAL_CHEQUES= $LON_TND_AMT_CHK + $PKP_TND_AMT_CHK + $CNTD_TND_AMT_CHK + $NT_TND_AMT_CHK + $OPN_TND_AMT_CHK ;
					  $TOTAL_FOODS= $LON_TND_AMT_FDS + $PKP_TND_AMT_FDS +  $CNTD_TND_AMT_FDS + $NT_TND_AMT_FDS + $OPN_TND_AMT_FDS;
					  $TOTAL_DIVERSOS1= $LON_TND_AMT_MSC1 + $PKP_TND_AMT_MSC1 + $CNTD_TND_AMT_MSC1 + $NT_TND_AMT_MSC1 + $OPN_TND_AMT_MSC1;
					  $TOTAL_DIVERSOS2= $LON_TND_AMT_MSC2 + $PKP_TND_AMT_MSC2 + $CNTD_TND_AMT_MSC2 + $NT_TND_AMT_MSC2 + $OPN_TND_AMT_MSC2;
					  $TOTAL_DIVERSOS3= $LON_TND_AMT_MSC3 + $PKP_TND_AMT_MSC3 + $CNTD_TND_AMT_MSC3 + $NT_TND_AMT_MSC3 + $OPN_TND_AMT_MSC3;
					  $TOTAL_CUPONES_F= $LON_TND_AMT_MF_CPN + $PKP_TND_AMT_MF_CPN + $CNTD_TND_AMT_MF_CPN + $NT_TND_AMT_MF_CPN + $OPN_TND_AMT_MF_CPN;
					  $TOTAL_TINE_CUPONES=$LON_TND_AMT_STR_CPN + $PKP_TND_AMT_STR_CPN + $CNTD_TND_AMT_STR_CPN + $NT_TND_AMT_STR_CPN + $OPN_TND_AMT_STR_CPN ;
					  
					  
					  
					  $CONSULTANO= "select * from LE_STR_REC_TOT WHERE TM_STP NOT IN (SELECT max(TM_STP) AS FECHA_MAX FROM  LE_STR_REC_TOT)";
				      $RSNO = sqlsrv_query($conn, $CONSULTANO);
				
				     if ($rowno = sqlsrv_fetch_array($RSNO)){
		
					?>
			
                    
                     
                
                    <tr>
                   
                    <td><?=$TM_STP?></td>
                    <td><?=$TOTAL_EFECTIVO1 ?></td>
                    <td><?=$TOTAL_CHEQUES ?></td>
                    <td><?=$TOTAL_FOODS ?></td>
                    <td><?=$TOTAL_DIVERSOS1 ?></td>
                    <td><?=$TOTAL_DIVERSOS2 ?></td>
                    <td><?=$TOTAL_DIVERSOS3 ?></td>
                    <td><?=$TOTAL_CUPONES_F ?></td>
                    <td><?=$TOTAL_TINE_CUPONES ?></td>
                    
                    <td><input name="Mostrar" id="<?=$ID?>"  type="button" value="Abrir Detalle" onClick="javascript:mostrarOcultarTablas('Listado2<?=$ID?>','<?=$ID?>')"> </td>
                    	<input type="hidden" name="ID" value="<?=$ID?>">
                        <input type="hidden" name="STR_CD" value="<?=$STR_CD1?>">
                        
                  
             
                        
                    <td>
                    <script>
						function Seguro<?=$ID?>() {
						var aceptaEntrar = window.confirm("ESTA SEGURO?");
						if (aceptaEntrar)  {
						 
						 document.forms.forming.submit();
						 
						
						} else { 
						
						return false;
						
						
						 }
						
						
						}   
					</script>
                    <input name="Certificar" id="cert<?=$ID?>"  type="button" value="Certificar" onClick="Seguro<?=$ID?>();" >
                    </td>
                    </tr>
                    
						<tr>
                    <td colspan="10">
                    	
                        
                 
                        
            <table id="Listado2<?=$ID?>" style="display: none">
   
             <?php
			$CONSULTA_LIST = "SELECT * FROM  le_Str_rec_tot where id_str_rec_tot=".$ID." and str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=".$STR_CD1." ) order by TM_STP desc;";
			$RS_LIST = sqlsrv_query($conn, $CONSULTA_LIST);
			
            ?>
				 <tr>
                  <th colspan="10"> <h3 > Detalle Oficina </h3></th>
                 </tr>
                <tr>
                  <th>Fecha Cierre Periodo</th>
                  <th>Bruto a favor</th>
                  <th>Bruto en Contra</th>
                  <th>Dotaciones</th>
                  <th>Monto neto (Monto neto en negativo por dotaciones a operadores)</th>
                </tr>
        <?php
			while ($ROW_LIST = sqlsrv_fetch_array($RS_LIST))
			{
				$TM_STP_DB = $ROW_LIST['TM_STP'];
				$TM_STP_DB = date_format($TM_STP_DB, 'Y-m-d H:i:s');
				echo "<tr>";
				echo '<td>' . $TM_STP . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["GS_PLS"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["GS_MNS"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["LON_TND_AMT_CSH"]) . '</td>';
				echo '<td>' . DOLARS($ROW_LIST["NT_TND_AMT_CSH"]) . '</td></tr>';
			}

?>
      <tr>
      <th colspan="10">
	  <h3 >Detalle Movimientos</h3>
     </th>
     </tr>
         
                <tr>
                  <th>Tipo Movimiento</th>
                  <th>Cuenta</th>
                  <th>Monto</th>
                </tr>
        <?php
			$CONSULTA_OPERADOR = "SELECT * FROM  le_tnd_rec_tot where  str_cd in(select STR_CD from LE_STR_REC_TOT where STR_CD=" . $STR_CD1 . " ) order by ACNT_ID,REC_TYP asc";
			$RS_OPERADOR = sqlsrv_query($conn, $CONSULTA_OPERADOR);
			while ($ROW_OPERADOR = sqlsrv_fetch_array($RS_OPERADOR))
			{
				$TM_STP_DB = $ROW_OPERADOR['TM_STP'];
				$TM_STP_DB = date_format($TM_STP_DB, 'Y-m-d H:i:s');
				if ($ROW_OPERADOR["ACNT_ID"] == 0)
				{
					$ACNT_ID = "TIENDA";
				}
				else
				{
					$ACNT_ID = "Operador: " . $ROW_OPERADOR["ACNT_ID"];
				}

				switch ($ROW_OPERADOR["REC_TYP"])
				{
				case 4:
					echo "<tr>";
					echo '<td>Dotaci&oacute;n</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;

				case 5:
					echo "<tr>";
					echo '<td>Retiros</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;

				case 7:
					echo "<tr>";
					echo '<td>Monto Neto</td>';
					echo '<td>' . $ACNT_ID . '</td>';
					echo '<td>' . DOLARS($ROW_OPERADOR["TND_AMT_CSH_1"]) . '</td></tr>';
					break;
			     	}
			
			   }

                 ?>

 

                      </table>
                    </td>
                   </tr>
					  
               
                

                <?php

				 	         }
		 
			             	}
							
						 }
						 
				
					
				
				 	
				?>
				 
				
				 
								
			

				

             

                </table>
             
               
                </form>

<?php

		sqlsrv_close($conn);



?>



                </tr>

                </table>

        </td>

        </tr>

        </table>

</td>

</tr>

</table>

</body>