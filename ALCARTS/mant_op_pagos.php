

<?php
include("session.inc");
?>
<?php
include("headerhtml.inc");
?>
<?php
$PAGINA = 1180;
$LIST = @$_GET["LIST"];
$NEO = @$_GET["NEO"];
$ACT = @$_GET["ACT"];
if ($NEO == "" and $ACT == "") {
    $LIST = 1;
}
?>


<script language="JavaScript">
   
    function validaingreso(theForm) {
        
        var res = true;
        if (theForm.ID_TARJ.value == "no_sel") {
            alert("COMPLETE EL CAMPO REQUERIDO: Identificador.");
            theForm.ID_TARJ.focus();
            res = false;
        }
        var RESTRICT_FECHAS = $("#RESTRICT_FECHAS").prop('checked');
        if (RESTRICT_FECHAS == true) {
            var d_ini = theForm.DIA_INICIO.value;
            var m_ini = theForm.MES_INICIO.value;
            var a_ini = theForm.ANIO_INICIO.value;
            var d_term = theForm.DIA_FIN.value;
            var m_term = theForm.MES_FIN.value;
            var a_term = theForm.ANIO_FIN.value;
            var fecha_ini = new Date(a_ini, m_ini, d_ini);
            var fecha_term = new Date(a_term, m_term, d_term);
            if (fecha_ini >= fecha_term)
            {
                alert("Fecha de inicio debe ser menor y distinta a la de termino");
                theForm.MNT_MIN_CMP.focus();
                res = false;
            }
        }
        var PRT_MES_GRC = $("#PRT_MES_GRC").prop('checked');
        var PRT_DIF_INT = $("#PRT_DIF_INT").prop('checked');
        if (PRT_MES_GRC == true && PRT_DIF_INT == false) {
            if ($("#MESES_GRACIA").val() == "")
            {
                alert("COMPLETE EL CAMPO REQUERIDO: Meses de Gracia.");
                theForm.MESES_GRACIA.focus();
                res = false;
            }
        }
        return res;
    } //validaingreso(theForm)
    
    function mostrar_grc()
    {
        var val = $("#PRT_DIF_INT").prop('checked');
        var PRT_MES_GRC = $("#PRT_MES_GRC").prop('checked');
        if (val == 0 && PRT_MES_GRC == 1)
        {
            var html = '<label for="MESES_GRACIA">Meses de Gracia</label> ';
            var html_2 = '<input name="MESES_GRACIA" id="MESES_GRACIA" type="text" maxlength="2" size="4" onKeyPress="return acceptNum(event);">';
            var tr = $('#mes_gracia_1').html();
            $('#mes_gracia_1').html(html);
            $('#mes_gracia_2').html(html_2);
            $('#mes_gracia_1').css('border-top-color', '#DFDFDF');
            $('#mes_gracia_1').css('border-top-style', 'solid');
            $('#mes_gracia_1').css('border-top-width', '1px');
            $('#mes_gracia_2').css('border-top-color', '#DFDFDF');
            $('#mes_gracia_2').css('border-top-style', 'solid');
            $('#mes_gracia_2').css('border-top-width', '1px');
        } else
        {
            $('#mes_gracia_1').empty();
            $('#mes_gracia_2').empty();
            $('#mes_gracia_1').css('border-top-style', 'none');
            $('#mes_gracia_2').css('border-top-style', 'none');
        }
    }
    function ocultar_grc() {
        var PRT_DIF_INT = $("#PRT_DIF_INT").prop('checked');
        var DIF_PLUS = $("#DIF_PLUS").prop('checked');
        //var PRT_MES_GRC = $("#PRT_MES_GRC").prop('checked');
        mostrar('mes_gracia', 'GRC');


        if (DIF_PLUS == true ) 
		{
       		$('#PRT_DIF_INT').prop('checked', false);
		}
		
		
		if(PRT_DIF_INT == true )
		{
			$('#DIF_PLUS').prop('checked', false);	
		}
		
		
		
		

    }

    function mostrar(ide, OPC)
    {
        if (OPC == "GRC")
        {
            var val = $("#PRT_DIF_INT").prop('checked');
            var val_plus = $("#DIF_PLUS").prop('checked');
            var PRT_MES_GRC = $("#PRT_MES_GRC").prop('checked');
            var html = '<label for="MESES_GRACIA">Meses de Gracia</label> ';
            var html_2 = '<input name="MESES_GRACIA" id="MESES_GRACIA" type="text" maxlength="2" size="4" onKeyPress="return acceptNum(event);">';
            var tr = $('#' + ide + '_1').html();
            if (val == 1)
            {
                if (PRT_MES_GRC == 1)

                {
                    $('#' + ide + '_1').empty();
                    $('#' + ide + '_2').empty();
                    $('#' + ide + '_1').css('border-top-style', 'none');
                    $('#' + ide + '_2').css('border-top-style', 'none');
                }
            } else if (val_plus == 1)
            {
                if (PRT_MES_GRC == 1)

                {
                    $('#' + ide + '_1').empty();
                    $('#' + ide + '_2').empty();
                    $('#' + ide + '_1').css('border-top-style', 'none');
                    $('#' + ide + '_2').css('border-top-style', 'none');
                }
            } else if (PRT_MES_GRC == 1 && val_plus == 0 && val == 0)
            {

                if (tr != "")
                {
                    $('#' + ide + '_1').empty();
                    $('#' + ide + '_2').empty();
                    $('#' + ide + '_1').css('border-top-style', 'none');
                    $('#' + ide + '_2').css('border-top-style', 'none');
                } else
                {
                    $('#' + ide + '_1').html(html);
                    $('#' + ide + '_2').html(html_2);
                    $('#' + ide + '_1').css('border-top-color', '#DFDFDF');
                    $('#' + ide + '_1').css('border-top-style', 'solid');
                    $('#' + ide + '_1').css('border-top-width', '1px');
                    $('#' + ide + '_2').css('border-top-color', '#DFDFDF');
                    $('#' + ide + '_2').css('border-top-style', 'solid');
                    $('#' + ide + '_2').css('border-top-width', '1px');

                    $('#PRT_DIF_INT').prop('checked', false);
                }
                if (PRT_MES_GRC == 0) {
                    $('#mes_gracia_1').empty();
                    $('#mes_gracia_2').empty();
                    $('#mes_gracia_1').css('border-top-style', 'none');
                    $('#mes_gracia_2').css('border-top-style', 'none');
                }
            } else
            {
                $('#' + ide + '_1').empty();
                $('#' + ide + '_2').empty();
                $('#' + ide + '_1').css('border-top-style', 'none');
                $('#' + ide + '_2').css('border-top-style', 'none');
            }
        } else

        {
            var html = '<label>Fecha Inicio</label><input name="DIA_INICIO" type="text" id="DIA_INICIO" size="2" maxlength="2" onKeyPress="return acceptNum(event);" style="float:left" placeholder="00">';
            html = html + '<select name="MES_INICIO" id="MES_INICIO" style="float:left;margin:0"><option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
            html = html + '<input name="ANIO_INICIO" type="text" id="ANIO_INICIO" placeholder="0000" size="4" maxlength="4">';


            var html_2 = '<label>Fecha Termino</label><input name="DIA_FIN" type="text" id="DIA_FIN" size="2" maxlength="2" onKeyPress="return acceptNum(event);" style="float:left" placeholder="00">';
            html_2 = html_2 + '<select name="MES_FIN" id="MES_FIN" style="float:left;margin:0"><option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
            html_2 = html_2 + '<input name="ANIO_FIN" type="text" id="ANIO_FIN" placeholder="0000" size="4" maxlength="4">';
            var tr = $('#' + ide + '_1').html();
            if (tr != "")
            {
                $('#' + ide + '_1').empty();
                $('#' + ide + '_2').empty();
                $('#' + ide + '_1').css('border-top-style', 'none');
                $('#' + ide + '_2').css('border-top-style', 'none');
            } else
            {
                $('#' + ide + '_1').html(html);
                $('#' + ide + '_2').html(html_2);
                $('#' + ide + '_1').css('border-top-color', '#DFDFDF');
                $('#' + ide + '_1').css('border-top-style', 'solid');
                $('#' + ide + '_1').css('border-top-width', '1px');
                $('#' + ide + '_2').css('border-top-color', '#DFDFDF');
                $('#' + ide + '_2').css('border-top-style', 'solid');
                $('#' + ide + '_2').css('border-top-width', '1px');
            }
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
    #cuotas {position:absolute;width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(../images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
    #cuotas-contenedor{
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
    #cuotas-contenedor h3{
        margin-top:50px;
    }

    #cuotas-contenedor td{
        padding:4px 6px;
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
<?php
include("encabezado.php");
?>
    <?php
    include("titulo_menu.php");
    ?>
    <table width="100%" height="100%">
        <tr>
            <td align="right"  width="200" bgcolor="#FFFFFF"><?php
    include("menugeneral.php");
    ?></td>
            <td ><?php
                if ($MSJE == 1) {
                    $ELMSJ = "Registro actualizado";
                }
                if ($MSJE == 2) {
                    $ELMSJ = "Registro no disponible, verifique";
                }
                if ($MSJE == 3) {
                    $ELMSJ = "Registro realizado";
                }
                if ($MSJE == 4) {
                    $ELMSJ = "Registro eliminado";
                }
                if ($MSJE <> "") {
                    ?>
                    <div id="GMessaje" onClick="QuitarGMessage();"><a href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">
                    <?= $ELMSJ ?>
                        </a></div>
                            <?php
                        }
                        ?>
                <table width="100%">
                    <tr>
                        <td><h2>
<?= $LAPAGINA ?>
                                &nbsp;&nbsp;&nbsp;
                                <?php
                                if ($LIST == 1) {
                                    echo '<input type="button" value="EXPORTAR" onClick="abrir_exportar();">';
                                }
                                ?>
                            </h2>

                                <?php
                                if ($LIST == 1) {
                                    ?>
                                <table style="margin:10px 20px; ">
                                    <tr>
                                        <td><?php

                                    function flag_process($in) {
                                        switch ($in) {
                                            case 0:
                                                return "NO";
                                                break;
                                            case 1:
                                                return "SI";
                                                break;
                                        }
                                        if ($in >= 1) {
                                            return "SI";
                                        }
                                    }

                                    $FLTR_TIENDA = "";
                                    if (isset($_POST["C_TIENDA"])) {
                                        if ($_POST["C_TIENDA"] == 'NADA') {
                                            $FLTR_TIENDA = "";
                                        } else {
                                            $FLTR_TIENDA = "WHERE DES_CLAVE=" . $_POST["C_TIENDA"];
                                            $FTIENDA = $_POST["C_TIENDA"];
                                        }
                                    } elseif (isset($_GET["FTIENDA"])) {
                                        if ($_GET["FTIENDA"] == 'NADA' or $_GET["FTIENDA"] == '') {
                                            $FLTR_TIENDA = "";
                                        } else {
                                            $FLTR_TIENDA = "WHERE DES_CLAVE=" . $_GET["FTIENDA"];
                                            $FTIENDA = $_GET["FTIENDA"];
                                        }
                                    } else {
                                        $FLTR_TIENDA = "";
                                    }
                                    if ($FTIENDA != "") {
                                        $FLTR_TIENDA = "WHERE DES_CLAVE=" . $FTIENDA;
                                    }
                                    $CONSULTA = "SELECT COUNT(*) AS CUENTA FROM CO_OP_PAGO " . $FLTR_TIENDA;
                                    $RS = sqlsrv_query($conn, $CONSULTA);
                                    //oci_execute($RS);
                                    if ($row = sqlsrv_fetch_array($RS)) {
                                        $TOTALREG = $row['CUENTA'];
                                        $NUMTPAG = round($TOTALREG / $CTP, 0);
                                        $RESTO = $TOTALREG % $CTP;
                                        $CUANTORESTO = round($RESTO / $CTP, 0);
                                        if ($RESTO > 0 and $CUANTORESTO == 0) {
                                            $NUMTPAG = $NUMTPAG + 1;
                                        }
                                        $NUMPAG = round($LSUP / $CTP, 0);
                                        if ($NUMTPAG == 0) {
                                            $NUMTPAG = 1;
                                        }
                                        //$CONSULTA = "SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_OP_PAGO " . $FLTR_TIENDA . " ORDER BY ID_TARJ ASC) a WHERE ROWNUM <= " . $LSUP . ") WHERE rnum >=  " . $LINF;

                                        $CONSULTA = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY ID_TARJ ASC) ROWNUMBER FROM CO_OP_PAGO " . $FLTR_TIENDA . ") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";

                                        $TIENDA = 0;
                                    }
                                    $RS = sqlsrv_query($conn, $CONSULTA);
                                    //oci_execute($RS);
                                    ?>
                                            <table id="Listado">
                                                <tr>
												    
                                                    <th>Identificador</th>
                                                    <th>Diferido Con Intereses</th>
                                                    <th>Diferido Plus</th>
                                                    <th>Meses De Gracia</th>
                                                    <th>Grupo</th>
                                                    <th>Restricciones de Fecha</th>
													
                                                </tr>
    <?php
    while ($row = sqlsrv_fetch_array($RS)) {

        $ID_TARJ = $row['ID_TARJ'];
        $ID_TARJ = substr($ID_TARJ, 0, 2);
        $PRT_DIF_INT = flag_process($row['PRT_DIF_INT']);
        $DIF_PLUS = flag_process($row['DIF_PLUS']);
        $PRT_MES_GRC = flag_process($row['PRT_MES_GRC']);
        $ID_GRUPO = $row['ID_GRUPO'];
        $CTS_POSIBLES = $row['CTS_POSIBLES'];
		$subvariedad=$row['SUB_CARD_PLAN_ID'];
		
		$S = "SELECT * FROM SUB_CARD_PLAN_ID WHERE ID=" . $subvariedad ;
        $QUERY = sqlsrv_query($conn, $S);
		
		if ($SUB = sqlsrv_fetch_array($QUERY)) {
			
            $SUBVA = $SUB["DESC_SUB"];
        }
        
		
		
        $ID_OP = $row['ID_OP'];
        $Q = "SELECT * FROM CO_GRUPO WHERE ID_GRUPO='" . $ID_GRUPO . "'";
        $RES = sqlsrv_query($conn, $Q);
        //oci_execute($RES);
        while ($R = sqlsrv_fetch_array($RES)) {
            $GRUPO = $R["DESCRIPCION"];
        }
        if ($PRT_DIF_INT == "SI" and $PRT_MES_GRC == "SI") {
            $MES_T = $PRT_MES_GRC . ", Por Cada Cuota";
        } elseif ($PRT_MES_GRC == "SI") {
            $MES_T = $PRT_MES_GRC . " - " . $row['PRT_MES_GRC'];
        } else {
            $MES_T = $PRT_MES_GRC;
        }

        $FECHA_INICIO = $row["FECHA_INICIO"];
        $FECHA_TERMINO = $row["FECHA_TERMINO"];

        $FECHA_INICIO = date_format($FECHA_INICIO, 'd-m-Y');
        $FECHA_TERMINO = date_format($FECHA_TERMINO, 'd-m-Y');


        if ($FECHA_INICIO == $FECHA_TERMINO) {
            $R_FECHAS = "NO";
            $TXT_FECHAS = $R_FECHAS;
        } else {
            $R_FECHAS = "SI";
            $TXT_FECHAS = $R_FECHAS . ", Desde: " . $FECHA_INICIO . ", Hasta: " . $FECHA_TERMINO;
        }
        ?>
                                                    <tr>
                                                    <?php
                                                    if ($SESPUBLICA == 1) {
                                                        ?>
                                                            <td><a href="mant_op_pagos.php?ACT=<?= $ID_OP ?>">
                                                            <?= $ID_TARJ.$SUBVA ?>
                                                                </a></td>
                                                                    <?php
                                                                } else {
                                                                    ?>
                                                            <td><?= $ID_TARJ.$SUBVA ?></td>
                                                            <?php
                                                        }
                                                        ?>
                                                        <td><?= $PRT_DIF_INT ?></td>
                                                        <td><?= $DIF_PLUS ?></td>
                                                        <td><?= $MES_T ?></td>
                                                        <td><?= $GRUPO  ?></td>
                                                        <td><?= $TXT_FECHAS ?></td>
														
														
                                                    </tr>
        <?php
    }
    ?>
                                                <tr>
                                                    <td colspan="11" nowrap style="background-color:transparent"><?php
                                                if ($LINF >= $CTP + 1) {
                                                    $ATRAS = $LINF - $CTP;
                                                    $FILA_ANT = $LSUP - $CTP;
                                                    ?>
                                                            <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_op_pagos.php?LSUP=<?= $FILA_ANT ?>&LINF=<?= $ATRAS ?>');">
                                                            <?php
                                                        }
                                                        if ($LSUP <= $TOTALREG) {
                                                            $ADELANTE = $LSUP + 1;
                                                            $FILA_POS = $LSUP + $CTP;
                                                            ?>
                                                            <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_op_pagos.php?LSUP=<?= $FILA_POS ?>&LINF=<?= $ADELANTE ?>');">
                                                            <?php
                                                        }
                                                        ?>
                                                        <span style="vertical-align:baseline;">P&aacute;gina
                                                        <?= $NUMPAG ?>
                                                            de
                                                            <?= $NUMTPAG ?>
                                                        </span></td>
                                                </tr>
                                            </table>
    <?php
    sqlsrv_close($conn);
}
?>
                                        <?php
                                        if ($NEO == 1) {
                                            ?>
                                            <table style="margin:10px 20px; ">
                                                <tr>
                                                    <td><form action="mant_op_pagos_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                                                            <table id="forma-registro" style="width: 600px;">
                                                               
                                                                <tr class="anterior">
                                                                    <td><label for="ID_GRUPO">Grupo</label></td>
                                                                    <td><select  style="clear:left; " name="ID_GRUPO">
                                                                    <?php 
                                                                      $r = "";
                                                                      $Q = "SELECT * FROM CO_GRUPO";
                                                                      $RES = sqlsrv_query($conn, $Q);
                                                                      //oci_execute($RES);
                                                                      while ($RW = sqlsrv_fetch_array($RES)) {
                                                                      $r .= '<option value="' . $RW["ID_GRUPO"] . '">' . $RW["DESCRIPCION"] . '</option>';
                                                                      }
                                                                      echo $r;
                                                                     
                                                                    ?>
                                                                        </select></td>
                                                                </tr>
                                                                
                                                                <tr class="anterior">
                                                                    <td><label for="ID_TARJ" >Identificador</label></td>
                                                                    <td id="dato" > <select name="ID_TARJ" onChange="cargar_familia(this.value)" >
                                                                         <option value="no_sel" >Seleccione</option>
                                                                            <?php
																		//	$ID_TARJ = "SELECT ID_TARJ FROM CO_OP_PAGO";
//                                                                            $consul = sqlsrv_query($conn, $ID_TARJ);
//                                                                           $ARRAY_ID_T=array();
//                                                                            while ($RW = sqlsrv_fetch_array($consul)) {
//
//																			  $ID_T=substr(trim($RW["ID_TARJ"]),0,2); 
//																				$ARRAY_ID_T[]=$ID_T;
//                                                                           
//																			}
																			 $r = "";
                                                                            $CRD = "SELECT * FROM CO_CARD_PLAN";
                                                                            $RESC = sqlsrv_query($conn, $CRD);
                                                                            //oci_execute($RESC);
                                                                            while ($RW1 = sqlsrv_fetch_array($RESC)) {
																				
																				
                                                                                	$r.='<option value="' . $RW1["CARD_ID"] . '"> ' . $RW1["CARD_IDEN"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
																				
                                                                            
																			
																			}
                                                                            echo $r;
																			  
                                                                            ?>

                                                                        </select>
                                                                    </td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td><label for="PRT_DIF_INT">Permite Diferido Con Intereses</label></td>
                                                                    <td>
                                                                        <div style="clear: both; margin: 0 10px 0 0;">
                                                                            <input name="PRT_DIF_INT" id="PRT_DIF_INT" type="checkbox" class="switch" value="1" onchange="ocultar_grc()" >
                                                                            <label style="text-align:left; color:#f1f1f1" for="PRT_DIF_INT">.</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td><label for="DIF_PLUS">Permite Diferido Plus</label></td>
                                                                    <td>
                                                                        <div style="clear: both; margin: 0 10px 0 0;">
                                                                            <input name="DIF_PLUS" id="DIF_PLUS"  type="checkbox" class="switch" value="1" onchange="ocultar_grc()">
                                                                            <label style="text-align:left; color:#f1f1f1" for="DIF_PLUS">.</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td><label for="PRT_MES_GRC">Permite Mes de Gracia</label></td>
                                                                    <td>
                                                                        <div style="clear: both; margin: 0 10px 0 0;">
                                                                            <input name="PRT_MES_GRC" id="PRT_MES_GRC" type="checkbox" class="switch" value="1"  onChange="mostrar('mes_gracia', 'GRC')">
                                                                            <label style="text-align:left; color:#f1f1f1" for="PRT_MES_GRC">.</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td id="mes_gracia_1" style="border-top: none;"></td>
                                                                    <td id="mes_gracia_2" style="border-top: none;"></td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td><label for="RESTRICT_FECHAS">Restricci&oacute;n de Fecha</label></td>
                                                                    <td>
                                                                        <div style="clear: both; margin: 0 10px 0 0;">
                                                                            <input name="RESTRICT_FECHAS" id="RESTRICT_FECHAS" type="checkbox" class="switch" value="1" onChange="mostrar('RESTRICT_FECHAS', 'RSTR')">
                                                                            <label style="text-align:left; color:#f1f1f1" for="RESTRICT_FECHAS">.</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr class="anterior">
                                                                    <td id="RESTRICT_FECHAS_1" style="border-top: none;"></td>
                                                                    <td id="RESTRICT_FECHAS_2" style="border-top: none;"></td>
                                                                <tr>
                                                                    <td></td>
                                                                    <td><input name="INGRESAR" id="INGRESAR" type="submit" value="Registrar">
                                                                        <input name="LIMPIAR" type="reset" value="Limpiar">
                                                                        <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_op_pagos.php')"></td>
                                                                </tr>
                                                            </table>
                                                        </form>
                                                        <div id="popup_cts_ingresar" style="display:none">
                                                            <div id="popup_cts_ingresar-contenedor">
                                                                <span style="position:absolute; top:0; right:20px;">
                                                                    <img src="../images/ICO_Close.png" border="0" onClick="cerrar_exportar();" title="Cerrar ventana">
                                                                </span>
                                                                <div id="cargar">
                                                                </div>
                                                                <input type="button" value="EXPORTAR" onClick="exportar();">

                                                            </div>
                                                        </div>
                                                        <?php
                                                        sqlsrv_close($conn);
                                                    }
                                                    if ($ACT <> "") {
                                                        ?>
                                                        <table style="margin:10px 20px; ">
                                                            <tr>
                                                   <td><?php
                                                    $CONSULTA = "SELECT * FROM CO_OP_PAGO WHERE ID_OP='" . $ACT . "'";
                                                    $RS = sqlsrv_query($conn, $CONSULTA);
                                                    //oci_execute($RS);
                                                    if ($row = sqlsrv_fetch_array($RS)) {
                                                        $ID_TARJ = $row["ID_TARJ"];
                                                        $ID_TARJ = substr($ID_TARJ, 0, 4);
                                                        $PRT_DIF_INT = $row["PRT_DIF_INT"];
                                                        $DIF_PLUS = $row["DIF_PLUS"];
                                                        $PRT_MES_GRC = $row["PRT_MES_GRC"];
                                                        $ID_GRUPO = $row["ID_GRUPO"];
                                                        $CTS_POSIBLES = $row["CTS_POSIBLES"];
                                                        $FECHA_INICIO = $row["FECHA_INICIO"];
                                                        $FECHA_TERMINO = $row["FECHA_TERMINO"];

                                                        $FECHA_INICIO = date_format($FECHA_INICIO, 'd-m-Y');
                                                        $FECHA_TERMINO = date_format($FECHA_TERMINO, 'd-m-Y');

                                                        if ($FECHA_INICIO == $FECHA_TERMINO) {
                                                            $RESTRICT_FECHAS = 0;
                                                        } else {
                                                            $RESTRICT_FECHAS = 1;
                                                        }
                                                        $FECHA_INI = explode("-", $FECHA_INICIO);
                                                        $FECHA_TERM = explode("-", $FECHA_TERMINO);
                                                        $ID_OP = $row["ID_OP"];
                                                        $Q = "SELECT * FROM DET_OP_PAGO WHERE ID_OP='" . $ID_OP . "'";
                                                        $RES = sqlsrv_query($conn, $Q);
                                                        //oci_execute($RES);
                                                        while ($R = sqlsrv_fetch_array($RES)) {
                                                            $MESES = $R["MS_GRACIA"];
                                                            $MNT_MIN_CMP = $R["MNT_MIN_CMP"];
                                                        }
                                                    }
                                                            ?>
                                                                    <p class="speech">Opci&oacute;n <?= $ID_TARJ ?></p>
                                                                    <h3>
                                                                        Actualizar Opciones de Pago
                                                                    </h3>
                                                                    
                                                                    <form action="mant_op_pagos_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this);">
                                                                        
                                                                        <table id="forma-registro" style="width: 600px;">
                                                                            
																			  <tr class="anterior">
                                                                    <td><label for="ID_GRUPO">Grupo</label></td>
                                                                    <td><select  style="clear:left; " name="ID_GRUPO">
                                                                    <?php 
                                                                      $r = "";
                                                                      $Q = "SELECT * FROM CO_GRUPO";
                                                                      $RES = sqlsrv_query($conn, $Q);
                                                                      //oci_execute($RES);
                                                                      while ($RW = sqlsrv_fetch_array($RES)) {
																		 
																		 
																		 if (strcmp($ID_GRUPO , $RW['ID_GRUPO']) !== 0) { 
																	  
                                                                      $r .= '<option value="' . $RW["ID_GRUPO"] . '">' . $RW["DESCRIPCION"] . '</option>';
																		 }else{
																			$r .= '<option value="' . $RW["ID_GRUPO"] . '"selected>' . $RW["DESCRIPCION"] . '</option>'; 
																		 }
																	  
                                                                      }
                                                                      echo $r;
                                                                     
                                                                    ?>
                                                                        </select></td>
                                                                </tr>
																			
																			
																			
																			<tr class="anterior">
                                                                            <input type="hidden" name="ID_OP" value="<?= $ACT; ?>">
																		    <td><label for="ID_TARJ">Identificador</label></td>
                                                                            <td id="dato"><select name="ID_TARJ" onChange="cargar_familia(this.value)">
                                                                                    <option value="no_sel">Seleccione</option>
                                                                                    
                                                                                    <?php
                                                                                        $r = "";
                                                                                        $CRD = "SELECT * FROM CO_CARD_PLAN";
                                                                                        $RESC = sqlsrv_query($conn, $CRD);
                                                                                        //oci_execute($RESC);
                                                                                        while ($RW1 = sqlsrv_fetch_array($RESC)) {
                                                                                            $ID_TARJ = strtoupper((trim($ID_TARJ)));


                                                                                            if (strcmp($ID_TARJ, $RW1['CARD_IDEN']) !== 0) {
                                                                                                $r.='<option value="' . $RW1["CARD_ID"] . '">' . $RW1["CARD_IDEN"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
                                                                                            } else {
                                                                                                $r.='<option value="' . $RW1["CARD_ID"] . '" selected>' . $RW1["CARD_IDEN"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
                                                                                            }
                                                                                        }
                                                                                        echo $r;
                                                                                    ?>

                                                                                </select>
                                                                            </td>

                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <td><label for="PRT_DIF_INT">Permite Diferido con Intereses</label></td>
                                                                                <td>
                                                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                                                        <input name="PRT_DIF_INT" id="PRT_DIF_INT" type="checkbox" onchange="ocultar_grc()" class="switch" value="1" <?php
                                                                                if ($PRT_DIF_INT == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                        <label style="text-align:left; color:#f1f1f1" for="PRT_DIF_INT">.</label>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <td><label for="DIF_PLUS">Permite Diferido Plus</label></td>
                                                                                <td>
                                                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                                                        <input name="DIF_PLUS" id="DIF_PLUS" type="checkbox" onchange="ocultar_grc()" class="switch" value="1" <?php
                                                                                if ($DIF_PLUS == 1) {
                                                                                    echo "checked";
                                                                                }
    ?>>
                                                                                        <label style="text-align:left; color:#f1f1f1" for="DIF_PLUS">.</label>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <td><label for="PRT_MES_GRC">Permite Meses de Gracia</label></td>
                                                                                <td>
                                                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                                                        <input name="PRT_MES_GRC" id="PRT_MES_GRC" type="checkbox" class="switch" value="1" <?php
                                                                                               if ($PRT_MES_GRC >= 1) {
                                                                                                   echo "checked";
                                                                                               }
                                                                                               ?> onChange="mostrar('mes_gracia', 'GRC')">
                                                                                        <label style="text-align:left; color:#f1f1f1" for="PRT_MES_GRC">.</label>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <?php
                                                                                if ($PRT_MES_GRC >= 1 and $PRT_DIF_INT == 0 and $DIF_PLUS == 0) {
                                                                                    echo '<td id="mes_gracia_1"><label for="MESES_GRACIA">Meses de Gracia</label> </td>
                                                                                    <td id="mes_gracia_2"><input name="MESES_GRACIA" type="text" maxlength="2" size="4" value="' . $PRT_MES_GRC . '" onKeyPress="return acceptNum(event);"></td> ';
                                                                                } else {
                                                                                    echo '<td id="mes_gracia_1" style="border-top:none;"></td>
                                                                                          <td id="mes_gracia_2" style="border-top:none;"></td>';
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <td><label for="RESTRICT_FECHAS">Restricci&oacute;n de Fecha</label></td>
                                                                                <td>
                                                                                    <div style="clear: both; margin: 0 10px 0 0;">
                                                                                        <input name="RESTRICT_FECHAS" id="RESTRICT_FECHAS" type="checkbox" class="switch" value="1" <?php
                                                                                if ($RESTRICT_FECHAS == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?> onChange="mostrar('RESTRICT_FECHAS', 'RSTR')">
                                                                                        <label style="text-align:left; color:#f1f1f1" for="RESTRICT_FECHAS">.</label>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr class="anterior">
                                                                                <?php
                                                                                if ($RESTRICT_FECHAS == 1) {
                                                                                    echo '<td id="RESTRICT_FECHAS_1"><label>Fecha Inicio</label><input name="DIA_INICIO" type="text" id="DIA_INICIO" size="2" maxlength="2" onKeyPress="return acceptNum(event);" style="float:left" placeholder="00" value=' . $FECHA_INI["0"] . '>';
                                                                                    echo '<select name="MES_INICIO" id="MES_INICIO" style="float:left;margin:0">';
                                                                                    switch ($FECHA_INI["1"]) {
                                                                                        case "01":
                                                                                            echo '<option value="01" selected>Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "02":
                                                                                            echo '<option value="01" >Enero</option><option value="02" selected>Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "03":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" selected>Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "04":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" selected>Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "05":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" selected>Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "06":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" selected>Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "07":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" selected>Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "08":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" selected>Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "09":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" selected>Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "10":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10" selected>Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "11":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" selected>Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "12":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" selected>Diciembre</option></select>';
                                                                                            break;
                                                                                    }
                                                                                    echo '<input name="ANIO_INICIO" type="text" id="ANIO_INICIO" placeholder="0000" value="' . $FECHA_INI["2"] . '" size="4" maxlength="4"></td>';
                                                                                    echo '<td id="RESTRICT_FECHAS_2"><label>Fecha Termino</label><input name="DIA_TERM" type="text" id="DIA_TERM" size="2" maxlength="2" onKeyPress="return acceptNum(event);" style="float:left" placeholder="00" value=' . $FECHA_TERM["0"] . '>';
                                                                                    echo '<select name="MES_TERM" id="MES_TERM" style="float:left;margin:0">';
                                                                                    switch ($FECHA_TERM["1"]) {
                                                                                        case "01":
                                                                                            echo '<option value="01" selected>Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "02":
                                                                                            echo '<option value="01" >Enero</option><option value="02" selected>Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "03":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" selected>Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "04":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" selected>Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "05":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" selected>Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "06":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" selected>Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "07":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" selected>Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "08":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" selected>Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "09":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" selected>Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "10":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10" selected>Octubre</option><option value="11" >Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "11":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" selected>Noviembre</option><option value="12" >Diciembre</option></select>';
                                                                                            break;
                                                                                        case "12":
                                                                                            echo '<option value="01" >Enero</option><option value="02" >Febrero</option><option value="03" >Marzo</option><option value="04" >Abril</option><option value="05" >Mayo</option><option value="06" >Junio</option><option value="07" >Julio</option><option value="08" >Agosto</option><option value="09" >Septiembre</option><option value="10">Octubre</option><option value="11" >Noviembre</option><option value="12" selected>Diciembre</option></select>';
                                                                                            break;
                                                                                    }
                                                                                    echo '<input name="ANIO_TERM" type="text" id="ANIO_TERM" placeholder="0000" value="' . $FECHA_TERM["2"] . '" size="4" maxlength="4"></td>';
                                                                                } else {
                                                                                    echo '<td id="RESTRICT_FECHAS_1"></td><td id="RESTRICT_FECHAS_2"></td>';
                                                                                }
                                                                                ?>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label >Cuotas Seleccionadas</label></td>
                                                                                <td>
                                                                                    <table>
                                                                                        <tr>
                                                                                            <td style="border-top:none;">N&uacute;m Cuota</td>
                                                                                            <td style="border-top:none;">Monto M&iacute;n. Compra</td>
                                                                                        <?php
                                                                                        if ($PRT_MES_GRC == 1) {
                                                                                            ?>
                                                                                                <td style="border-top:none;">Meses Gracia</td>
                                                                                        <?php } ?>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $res = "";
                                                                                        $Q = "SELECT * FROM DET_OP_PAGO WHERE ID_OP='" . $ID_OP . "' ORDER BY CNT_CTS, ID_TARJ_N";
																						
                                                                                        $RES = sqlsrv_query($conn, $Q);
                                                                                        //oci_execute($RES);
                                                                                        while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                            $res.="<tr>";
                                                                                            $cts = substr($RW["ID_TARJ_N"], 2);
                                                                                            if ($cts != 99) {
                                                                                                $cts_ini = $cts;
                                                                                                if ($cts < 10 and strlen($cts) < 2) {
                                                                                                    $cts_ini = "0" . $cts;
                                                                                                }
                                                                                                //echo strlen($CNT_CTS)."<br>";
                                                                                                $res.="<td>" . $cts_ini . "</td>";
                                                                                                $res.="<td>" . $RW["MNT_MIN_CMP"] . "</td>";
                                                                                                if ($PRT_MES_GRC == 1) {
                                                                                                    $res.="<td>" . $RW["MS_GRACIA"] . "</td>";
                                                                                                }
                                                                                            } else {
                                                                                                $CNT_CTS = $RW["CNT_CTS"];
                                                                                                $cts_ini = $CNT_CTS;
                                                                                                if ($CNT_CTS < 10 and strlen($CNT_CTS) < 2) {
                                                                                                    $cts_ini = "0" . $CNT_CTS;
                                                                                                }
                                                                                                //echo strlen($CNT_CTS)."<br>";
                                                                                                $res.="<td>" . $cts_ini . "</td>";
                                                                                                $res.="<td>" . $RW["MNT_MIN_CMP"] . "</td>";
                                                                                                if ($PRT_MES_GRC == 1) {
                                                                                                    $res.="<td>" . $RW["MS_GRACIA"] . "</td>";
                                                                                                }
                                                                                            }
                                                                                            $res.="</tr>";
                                                                                        }
                                                                                        echo $res;
                                                                                        ?>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan="2" align="right"><input name="SIGUIENTE" id="SIGUIENTE" type="button" value="Actualizar Cuotas" onClick="abrir_cuotas()">
                                                                                    <input name="ACTUALIZAR" id="ACTUALIZAR" type="submit" value="Actualizar">

                                                                                    <?php
                                                                                    $CONSULTA = "SELECT * FROM CO_OP_PAGO WHERE ID_OP=" . $ACT;
                                                                                    $RS = sqlsrv_query($conn, $CONSULTA);
                                                                                    //oci_execute($RS);
                                                                                    if ($row = sqlsrv_fetch_array($RS)) {
                                                                                        $ELIMINAR = 1;
                                                                                    } else {
                                                                                        $ELIMINAR = 0;
                                                                                    }
                                                                                    if ($ELIMINAR == 1) {
                                                                                        ?>
                                                                                        <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_op_pagos_reg.php?ELM=1&ID_OP=<?= $ACT ?>')">
        <?php
    }
    ?>
                                                                                    <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_op_pagos.php')"></td>
                                                                            </tr>
                                                                        </table>

                                                                        <div id="cuotas" style="display:none; ">
                                                                            <div id="cuotas-contenedor">
                                                                                <span style="position:absolute; top:0; right:20px;">
                                                                                    <img src="../images/ICO_Close.png" border="0" onClick="cerrar_cuotas();" title="Cerrar ventana">
                                                                                </span>
                                                                                <h3>Cuotas Posibles</h3>
                                                                                <div id="ctr_forms"></div>
                                                                                <div id="form" style="margin-bottom:10px;">
                                                                                    <table class="table_form" id="forma-registro">
                                                                                        <tr>
                                                                                            <th colspan="2" align="center">Cuota</th>
                                                                                            <th>Monto M&iacute;n. Compra</th>
                                                                                        <?php
                                                                                        if ($PRT_MES_GRC == 1 and $PRT_DIF_INT == 1) {
                                                                                            ?>
                                                                                                <th>Meses Gracia</th>
                                                                                        <?php } ?>
                                                                                        </tr>
                                                                                        <?php
                                                                                        $CONTADOR = 0;
                                                                                        $Q = "SELECT * FROM DET_OP_PAGO WHERE ID_OP='" . $ID_OP . "' ORDER BY CNT_CTS, ID_TARJ_N";
                                                                                        $RES = sqlsrv_query($conn, $Q);
                                                                                        //oci_execute($RES);
                                                                                        while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                            echo "<tr>";
                                                                                            $cts = substr($RW["ID_TARJ_N"], 2);
                                                                                            if ($cts != 99) {

                                                                                                if ($cts < 10 and strlen($cts) < 2) {
                                                                                                    $cts_ini = "0" . $cts;
                                                                                                } else {
                                                                                                    $cts_ini = $cts;
                                                                                                }
                                                                                                echo '<td align="center"><label style="display:inline-block">' . $cts_ini . '</label></td><td><div style="clear: both; margin: 0 10px 0 0;display:inline-block;padding-left:10px;max-width:100px;"><input name="CTS_POSIBLES' . $cts_ini . '" id="CTS_POSIBLES' . $cts_ini . '" type="checkbox" class="switch CHK_CTS" value="1" checked> onChange="habilitar(' . $cts_ini . ')"><label style="text-align:left; color:#f1f1f1" for="CTS_POSIBLES' . $cts_ini . '">.</label></div></td><td><input name="MNT_MIN_CTS_SEL' . $cts_ini . '" id="MNT_MIN_CTS_SEL' . $cts_ini . '" type="text" size="16" maxlength="6" placeholder="Monto Min Compra" value="' . $RW["MNT_MIN_CMP"] . '" onKeyPress="return acceptNum(event);"></td>';
                                                                                                if ($PRT_MES_GRC == 1 and $PRT_DIF_INT == 1) {
                                                                                                    echo '<td><input name="MES_GRC_CTS_SEL' . $cts_ini . '" id="MES_GRC_CTS_SEL' . $cts_ini . '" class="MES_GRC" type="text" size="16" maxlength="2" placeholder="Meses de Gracia" value="' . $RW["MS_GRACIA"] . '" onKeyPress="return acceptNum(event);"></td>';
                                                                                                }
                                                                                            } else {
                                                                                                $CNT_CTS = $RW["CNT_CTS"];
                                                                                                //$cts_ini=$CNT_CTS;
                                                                                                if ($CNT_CTS < 10 and strlen($CNT_CTS) < 2) {
                                                                                                    $cts_ini = "0" . $CNT_CTS;
                                                                                                } else {
                                                                                                    $cts_ini = $CNT_CTS;
                                                                                                }
                                                                                                echo '<td align="center"><label style="display:inline-block">' . $cts_ini . '</label></td><td><div style="clear: both; margin: 0 10px 0 0;display:inline-block;padding-left:10px;max-width:100px;"><input name="CTS_POSIBLES' . $cts_ini . '" id="CTS_POSIBLES' . $cts_ini . '" type="checkbox" class="switch CHK_CTS" value="1" checked> onChange="habilitar(' . $cts_ini . ')"><label style="text-align:left; color:#f1f1f1" for="CTS_POSIBLES' . $cts_ini . '">.</label></div></td><td><input name="MNT_MIN_CTS_SEL' . $cts_ini . '" id="MNT_MIN_CTS_SEL' . $cts_ini . '" type="text" size="16" maxlength="6" placeholder="Monto Min Compra" value="' . $RW["MNT_MIN_CMP"] . '" onKeyPress="return acceptNum(event);"></td>';
                                                                                                if ($PRT_MES_GRC == 1 and $PRT_DIF_INT == 1) {
                                                                                                    echo '<td><input name="MES_GRC_CTS_SEL' . $cts_ini . '" id="MES_GRC_CTS_SEL' . $cts_ini . '" class="MES_GRC" type="text" size="16" maxlength="2" placeholder="Meses de Gracia" value="' . $RW["MS_GRACIA"] . '" onKeyPress="return acceptNum(event);"></td>';
                                                                                                }
                                                                                            }
                                                                                            echo "</tr>";
                                                                                            $CONTADOR++;
                                                                                        }
                                                                                        ?>
                                                                                    </table></div>
                                                                                <input name="ACTUALIZAR" id="ACTUALIZAR" type="submit" value="Actualizar">
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                    <script>
                                                                        function load_cts()
                                                                        {
                                                                            arr_cts = [];
                                                                            var ide, t_i, html = "";
                                                                            html += '<select id="add_cts">';
                                                                            for (i = 0; i < 48; i++)
                                                                            {
                                                                                t_i = i + 1;
                                                                                ide = i + 1;
                                                                                if (ide < 10)
                                                                                {
                                                                                    t_i = "0" + t_i;
                                                                                    ide = '0' + ide;
                                                                                } else
                                                                                {
                                                                                    ide = ide;
                                                                                }
                                                                                if ($("#CTS_POSIBLES" + t_i).length == false)
                                                                                {
                                                                                    arr_cts.push(ide);
                                                                                    if (i == 0)
                                                                                    {
                                                                                        html += '<option value="' + t_i + '" selected>' + ide + '</option>';
                                                                                    } else
                                                                                    {
                                                                                        html += '<option value="' + t_i + '">' + ide + '</option>';
                                                                                    }
                                                                                }
                                                                            }
                                                                            html += '</select>&nbsp;&nbsp;<input type="button" value="Agregar Cuota" onClick="add_cts_()">';
                                                                            $("#ctr_forms").empty();
                                                                            $("#ctr_forms").html(html);

                                                                        }
                                                                        function add_cts_()
                                                                        {
                                                                            var counter_cts, res = "", val_add;
                                                                            counter = $(".CHK_CTS").length;
                                                                            val_add = $("#add_cts").val();
                                                                            val_ms_gr = $("#PRT_MES_GRC");
                                                                            val_dif = $("#PRT_DIF_INT");
                                                                            val_plus = $("#DIF_PLUS");
                                                                            if (val_add != null)
                                                                            {
                                                                                ide = val_add;

                                                                                res += '<tr><td align="center"><label style="display:inline-block">' + ide + '</label></td><td><div style="clear: both; margin: 0 10px 0 0;display:inline-block;padding-left:10px;max-width:100px;"><input class="CHK_CTS switch" type="checkbox" name="CTS_POSIBLES' + val_add + '" id="CTS_POSIBLES' + val_add + '" value="1" checked onChange="habilitar(' + val_add + ')"><label style="text-align:left; color:#f1f1f1" for="CTS_POSIBLES' + val_add + '">.</label></div></td>';
                                                                                res += '<td><input name="MNT_MIN_CTS_SEL' + val_add + '" id="MNT_MIN_CTS_SEL' + val_add + '" type="text" size="16" maxlength="6" placeholder="Monto Min Compra" onKeyPress="return acceptNum(event);"></td>';
                                                                                if (val_ms_gr.prop('checked') == true && (val_dif.prop('checked') == true || val_plus.prop('checked') == true))
                                                                                {
                                                                                    res += '<td><input name="MES_GRC_CTS_SEL' + val_add + '" id="MES_GRC_CTS_SEL' + val_add + '" class="MES_GRC" type="text" size="16" maxlength="2" placeholder="Meses de Gracia" onKeyPress="return acceptNum(event);"></td>';
                                                                                }
                                                                                res += '</tr>';
                                                                                $(".table_form").append(res);
                                                                                load_cts();
                                                                            }
                                                                        }
                                                                        function habilitar(ide)
                                                                        {
                                                                            var check, mnt_min, m_grc;
                                                                            check = $("#CTS_POSIBLES" + ide);
                                                                            mnt_min = $("#MNT_MIN_CTS_SEL" + ide);
                                                                            m_grc = $("#MES_GRC_CTS_SEL" + ide);
                                                                            if (check.prop('checked') == true)
                                                                            {
                                                                                mnt_min.prop('disabled', false);
                                                                                m_grc.prop('disabled', false);
                                                                            } else
                                                                            {
                                                                                mnt_min.prop('disabled', true);
                                                                                m_grc.prop('disabled', true);
                                                                            }
                                                                        }
                                                                        function abrir_cuotas() {
                                                                            var contenedor = document.getElementById("cuotas");
                                                                            contenedor.style.display = "block";
                                                                            window.scrollTo(0, 0);
                                                                            load_cts();
                                                                            return true;
                                                                        }
                                                                        function cerrar_cuotas() {
                                                                            var contenedor = document.getElementById("cuotas");
                                                                            contenedor.style.display = "none";
                                                                            return true;
                                                                        }
                                                                    </script>
    <?php
    sqlsrv_close($conn);
}
?>
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table>
                </table	>
    </table>
    <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0"> </iframe>
    <div id="exportar" style="display:none">
        <div id="exportar-contenedor">
            <span style="position:absolute; top:0; right:20px;">
                <img src="../images/ICO_Close.png" border="0" onClick="cerrar_exportar();" title="Cerrar ventana">
            </span>
            <br><br>
            <h3>Seleccion Tienda a Exportar</h3>
            <select  style="clear:left; " name="TIENDA_EXPORT" id="TIENDA_EXPORT">
                <option value="TODOS">EXPORTAR TODAS</option>
                <?php
                $r = "";
                $Q = "SELECT * FROM MN_TIENDA WHERE IND_ACTIVO=1";
                //$RES = sqlsrv_query($maestra, $Q);
                $RES = sqlsrv_query($maestra, $Q);
                //oci_execute($RES);
                while ($RW = sqlsrv_fetch_array($RES)) {
                    if (trim($RW["DES_TIENDA"]) != "ARMS Central")
                        $r .= '<option value="' . $RW["DES_CLAVE"] . '">' . $RW["DES_TIENDA"] . '</option>';
                }
                echo $r;
                ?>
            </select>
			<h3>Ruta Controlador: Opciones de Pago</h3>
            <input type="text" name="OPPAGO_RUTA" ID="OPPAGO_RUTA" size="27" value="C:\ADX_IDT1">
            

           

            <br><br>
            <input type="button" value="EXPORTAR" onClick="exportar();">

<?php ?>
        </div>
        <div id="mensaje"> </div>
        <div id="overlay" style="display:none; z-index:9999"> <span><img src="../images/Preload.GIF" title="loading" width="80px"></span> </div>
    </div>
    <style>
        #exportar {position:absolute;width:100%;height:300%;margin: 0 auto;left: 0;top:0;background-image: url(../images/TranspaBlack72.png);background-repeat: repeat;background-position: left top;z-index:10000;}
        #exportar-contenedor{
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
        #exportar-contenedor h3{
            margin-top:20px;
        }

        #exportar-contenedor td{
            padding:4px 6px;
        }
    </style>
	 <script>

	

				function cargar_familia(pos)

				{

					var texto="";

					var t;

					var dataString='CARD_ID='+pos;

					$.ajax({

						type: "GET",

						url: "cargar_sub.php",

						data: dataString,

						cache: false,

						success: function(response)

						{
							$("#CARD_ID_SEL").remove();
							texto=texto+'<select name="CARD_ID" id="CARD_ID_SEL">';

							texto=texto+response;

							texto=texto+'</select>';

							t=texto;

							$("#dato").append(t);

						}

					})			

				}

				</script>
    <script>
        function abrir_exportar() {
            var contenedor = document.getElementById("exportar");
            contenedor.style.display = "block";
            window.scrollTo(0, 0);
            return true;
        }
        function cerrar_exportar() {
            var contenedor = document.getElementById("exportar");
            contenedor.style.display = "none";
            return true;
        }
        function exportar()
        {
            var cod_tienda = $("#TIENDA_EXPORT").val();
            var cmd_oppago = $("#CMD_OPPAGO").val();
            var oppago_ruta = $("#OPPAGO_RUTA").val();

            var dataString = 'COD_TIENDA=' + cod_tienda + '&CMD_OPPAGO=' + cmd_oppago + '&OPPAGO_RUTA=' + oppago_ruta;

            $("#overlay").css("display", "block");
            $.ajax({
                type: "GET",
                url: "op_export.php",
                data: dataString,
                cache: false,
                success: function (response)
                {
                    $("#overlay").css("display", "none");
                    $("#mensaje").html('<div id="GMessaje" onClick="QuitarGMessage();"><a id="mens" href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">Exportacion Exitosa</a></div>');
                }
            })
        }
    </script>
</body>
