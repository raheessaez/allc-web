<?php include("session.inc"); ?>
<?php include("headerhtml.inc"); ?>
<?php
$PAGINA = 1183;
$NOMENU = 1;

$LOG = @$_GET["LOG"];
$LOG2 = @$_GET["LOG2"];

if ($LOG2 == "") {
    $LOG = 0;
    $LOG2 = 1;
    $LIST = 1;
}

// FUNCINES

function View_Status($STATUS) {

    switch ($STATUS) {
        case "P":
            return "Procesado";
            break;
        case "E":
            return "Error";
            break;
        case "D":
            return "Duplicado";
            break;
    }
}


// FILTROS TRANSACCIONES 
$NOM_TLOG = "";
$BSC_ESTADO = "";
$BSC_TIENDA = "";
$DIA_ED = "";
$MES_ED = "";
$ANO_ED = "";
$DIA_EH = "";
$MES_EH = "";
$ANO_EH = "";
//FILTRO NOMBRE ARCHIVO
if (isset($_POST["BDNOMBRE"])) {
    $NOM_TLOG = trim(strtoupper(@$_POST["BDNOMBRE"]));
}
//FILTRO ESTADO ARCHIVO
if (isset($_POST["BSC_ESTADO"])) {
    $BSC_ESTADO = trim(strtoupper(@$_POST["BSC_ESTADO"]));
}
//FILTRO TIENDA ASOCIADA
if (isset($_POST["BSC_TIENDA"]) and $_POST["BSC_TIENDA"] <> "no_sel") {
    $BSC_TIENDA = trim(strtoupper(@$_POST["BSC_TIENDA"]));
}
//INICIO FILTRO POR FECHA INICIO
if (isset($_POST["DIA_ED"])) {
    $DIA_ED = trim(strtoupper(@$_POST["DIA_ED"]));
}
if (isset($_POST["MES_ED"])) {
    $MES_ED = trim(strtoupper(@$_POST["MES_ED"]));
}
if (isset($_POST["ANO_ED"])) {
    $ANO_ED = trim(strtoupper(@$_POST["ANO_ED"]));
}
//FIN FILTRO POR FECHA INICIO
//INICIO FILTRO POR FECHA HASTA
if (isset($_POST["DIA_EH"])) {
    $DIA_EH = trim(strtoupper(@$_POST["DIA_EH"]));
}
if (isset($_POST["MES_EH"])) {
    $MES_EH = trim(strtoupper(@$_POST["MES_EH"]));
}
if (isset($_POST["ANO_EH"])) {
    $ANO_EH = trim(strtoupper(@$_POST["ANO_EH"]));
}
//FIN FILTRO POR FECHA HASTA
//OBTENCIÓN DE PARAMETROS POR URL, SIMILARES A POST, PERO DESDE EL PAGINADOR
if (isset($_GET["BDNOMBRE"])) {
    $NOM_TLOG = trim(strtoupper(@$_GET["BDNOMBRE"]));
}
if (isset($_GET["BSC_ESTADO"])) {
    $BSC_ESTADO = trim(strtoupper(@$_GET["BSC_ESTADO"]));
}
if (isset($_GET["BSC_TIENDA"]) and $_GET["BSC_TIENDA"] <> "no_sel") {
    $BSC_TIENDA = @$_GET["BSC_TIENDA"];
}
//INICIO FILTRO POR FECHA INICIO
if (isset($_GET["DIA_ED"])) {
    $DIA_ED = trim(strtoupper(@$_GET["DIA_ED"]));
}
if (isset($_GET["MES_ED"])) {
    $MES_ED = trim(strtoupper(@$_GET["MES_ED"]));
}
if (isset($_GET["ANO_ED"])) {
    $ANO_ED = trim(strtoupper(@$_GET["ANO_ED"]));
}
//FIN FILTRO POR FECHA INICIO
//INICIO FILTRO POR FECHA HASTA
if (isset($_GET["DIA_EH"])) {
    $DIA_EH = trim(strtoupper(@$_GET["DIA_EH"]));
}
if (isset($_GET["MES_EH"])) {
    $MES_EH = trim(strtoupper(@$_GET["MES_EH"]));
}
if (isset($_GET["ANO_EH"])) {
    $ANO_EH = trim(strtoupper(@$_GET["ANO_EH"]));
}
//FIN FILTRO POR FECHA HASTA

if ($NOM_TLOG <> "") {
    $FLT_NOMBRE = " AND NOM_TLOG Like '%" . $NOM_TLOG . "%' ";
} else {
    $FLT_NOMBRE = "";
}
if ($BSC_ESTADO <> "") {
    $FLT_ESTADO = " AND STATUS Like '%" . $BSC_ESTADO . "%' ";
} else {
    $FLT_ESTADO = "";
}
if ($BSC_TIENDA <> "") {
    $FLT_TIENDA = " AND DES_CLAVE='" . $BSC_TIENDA . "' ";
} else {
    $FLT_TIENDA = "";
}

if($DIA_ED <> "" &&  $DIA_EH <> ""){
    
    $flag1 = strlen($DIA_ED);
    $flag2 = strlen($DIA_EH);
    
    if($flag1 < 2){
       $DIA_ED = '0'.$DIA_ED;
    }
    
    if($flag2 < 2){
        $DIA_EH = '0'.$DIA_EH;
    }
    
    
}


if ($DIA_ED <> "" && $MES_ED <> "" && $ANO_ED <> "" && $DIA_EH <> "" && $MES_EH <> "" & $ANO_EH <> "") {
    $FLT_FECHA = " AND FEC_TLOG BETWEEN '" . $ANO_ED . "" . $MES_ED . "" . $DIA_ED . " 00:00:00' AND '" . $ANO_EH . "" . $MES_EH . "" . $DIA_EH . " 23:59:59'";
} else {
    $FLT_FECHA = "";
}

// FILTROS EPS 

$BSC_TIENDA2 = "";
$DIA_ED2 = "";
$MES_ED2 = "";
$ANO_ED2 = "";
$DIA_EH2 = "";
$MES_EH2 = "";
$ANO_EH2 = "";

//FILTRO TIENDA ASOCIADA
if (isset($_POST["BSC_TIENDA2"]) and $_POST["BSC_TIENDA2"] <> "no_sel") {
    $BSC_TIENDA2 = trim(strtoupper(@$_POST["BSC_TIENDA2"]));
}
//INICIO FILTRO POR FECHA INICIO
if (isset($_POST["DIA_ED2"])) {
    $DIA_ED2 = trim(strtoupper(@$_POST["DIA_ED2"]));
}
if (isset($_POST["MES_ED2"])) {
    $MES_ED2 = trim(strtoupper(@$_POST["MES_ED2"]));
}
if (isset($_POST["ANO_ED2"])) {
    $ANO_ED2 = trim(strtoupper(@$_POST["ANO_ED2"]));
}
//FIN FILTRO POR FECHA INICIO
//INICIO FILTRO POR FECHA HASTA
if (isset($_POST["DIA_EH2"])) {
    $DIA_EH2 = trim(strtoupper(@$_POST["DIA_EH2"]));
}
if (isset($_POST["MES_EH2"])) {
    $MES_EH2 = trim(strtoupper(@$_POST["MES_EH2"]));
}
if (isset($_POST["ANO_EH2"])) {
    $ANO_EH2 = trim(strtoupper(@$_POST["ANO_EH2"]));
}
//FIN FILTRO POR FECHA HASTA EPS

if ($BSC_TIENDA2 <> "") {
    $FLT_TIENDA2 = " AND CD_STR_RT = '" . $BSC_TIENDA2 . "' ";
} else {
    $FLT_TIENDA2 = "";
}

if (isset($_GET["BSC_TIENDA2"]) and $_GET["BSC_TIENDA2"] <> "no_sel") {
    $FLT_TIENDA2 = @$_GET["BSC_TIENDA2"];
}


//INICIO FILTRO POR FECHA INICIO EPS
if (isset($_GET["DIA_ED2"])) {
    $DIA_ED2 = trim(strtoupper(@$_GET["DIA_ED2"]));
}
if (isset($_GET["MES_ED2"])) {
    $MES_ED2 = trim(strtoupper(@$_GET["MES_ED2"]));
}
if (isset($_GET["ANO_ED2"])) {
    $ANO_ED2 = trim(strtoupper(@$_GET["ANO_ED2"]));
}
//FIN FILTRO POR FECHA INICIO ESP
//INICIO FILTRO POR FECHA HASTA EPS
if (isset($_GET["DIA_EH2"])) {
    $DIA_EH2 = trim(strtoupper(@$_GET["DIA_EH2"]));
}
if (isset($_GET["MES_EH2"])) {
    $MES_EH2= trim(strtoupper(@$_GET["MES_EH2"]));
}
if (isset($_GET["ANO_EH2"])) {
    $ANO_EH2 = trim(strtoupper(@$_GET["ANO_EH2"]));
}


if($DIA_ED2 <> "" &&  $DIA_EH2 <> ""){
    
    $flag1 = strlen($DIA_ED2);
    $flag2 = strlen($DIA_EH2);
    
    if($flag1 < 2){
       $DIA_ED2 = '0'.$DIA_ED2;
    }
    
    if($flag2 < 2){
        $DIA_EH2 = '0'.$DIA_EH2;
    }
    
    
}

//FIN FILTRO POR FECHA HASTA EPS
if ($DIA_ED2 <> "" && $MES_ED2 <> "" && $ANO_ED2 <> "" && $DIA_EH2 <> "" && $MES_EH2 <> "" & $ANO_EH2 <> "") {

    $FLT_FECHA2=" AND Convert(varchar(20), BUSINESS_DATE, 111) >= '".$ANO_ED2.'/'.$MES_ED2.'/'.$DIA_ED2."' AND Convert(varchar(20), BUSINESS_DATE, 111) <='".$ANO_EH2.'/'.$MES_EH2.'/'.$DIA_EH2."'";
    
} else {
    $FLT_FECHA2 = "";
}

?>

<?php if ($LIST <> 1) { ?>
    <script language="JavaScript">
        function validaingreso(theForm) {

            if (theForm.NM_DPT_PS.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.NM_DPT_PS.focus();
                return false;
            }


        } //validaingreso(theForm)


    </script>
<?php } ?>
<script>
    function getDocHeight(doc) {
        doc = doc || document;
        var body = doc.body, html = doc.documentElement;
        var height = Math.max(body.scrollHeight, body.offsetHeight,
                html.clientHeight, html.scrollHeight, html.offsetHeight);
        return height;
    }

    function setIframeAlto(id) {

        var ifrm = document.getElementById(id);
        var doc = ifrm.contentDocument ? ifrm.contentDocument :
                ifrm.contentWindow.document;
        ifrm.style.visibility = 'hidden';
        ifrm.style.height = "10px";
        ifrm.style.height = getDocHeight(doc) + 20 + "px";
        ifrm.style.visibility = 'visible';
    }
    function load_xml(name_file, estado)
    {
        $("#load_xml").empty();
        $("#load_xml").html("<object type='text/html' style='overflow: visible;max-height: 480px;' data='load_xml.php?FILE=" + name_file + "&ESTADO=" + estado + "' id='FormaPersInner' onload='setIframeAlto(this.id)' width='100%'></object>");
    }
    function abrir_xml(name_file, estado) {
        load_xml(name_file, estado);
        var contenedor = document.getElementById("xml");
        contenedor.style.display = "block";
        window.scrollTo(0, 0);

        return true;
    }
    function cerrar_xml() {
        var contenedor = document.getElementById("xml");
        contenedor.style.display = "none";
        return true;
    }

</script>
<style>
    #xml {
        position: fixed;
        width: 100%;
        height: 130%;
        margin: 0 auto;
        left: 0;
        top: 0;
        background-image: url(../images/TranspaBlack72.png);
        background-repeat: repeat;
        background-position: left top;
        z-index: 10000;
    }
    #xml-contenedor {
        position: absolute;
        /* margin: auto auto; */
        margin-left: 15%;
        top: 40px;
        width: 65%;
        min-width: 300px;
        max-height: 600px;
        overflow: auto;
        height: auto;
        overflow: visible;
        padding: 20px;
        background-color: #F1F1F1;
        -khtml-border-radius: 6px;
        -moz-border-radius: 6px;
        -webkit-border-radius: 6px;
        border-radius: 6px;
        background-image: url(../images/ARMS.png);
        background-repeat: no-repeat;
        background-position: 20px 10px;
    }
    #xml-contenedor h3 {
        margin-top: 50px;
    }
    #xml-contenedor td {
        padding: 4px 6px;
    }
</style>
</head>

<body>
    <?php include("encabezado.php"); ?>
    <?php include("titulo_menu.php"); ?>
    <table width="100%" height="100%">
        <tr>
            <td align="right"  width="200" bgcolor="#FFFFFF"><?php include("menugeneral.php"); ?></td>
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
                    <div id="GMessaje" onClick="QuitarGMessage();"><a href="#" onClick="QuitarGMessage();" style="color:#111111;"><?php echo $ELMSJ ?></a></div>
                <?php } if ($LOG2 == 1) { ?>
                    <table width="100%">
                        <tr>
                            <td><?php
                                if ($LIST == 1) {
                                    ?>                         
                                    <table width="100%" id="Filtro">
                                        <tr>
                                            <td><form action="log_xml.php" method="post" name="frmbuscar" id="frmbuscar">
                                                    <select name="BSC_TIENDA" onChange="document.forms.frmbuscar.submit();">
                                                        <option value="no_sel">Seleccione Tienda</option>
                                                        <?php
                                                        $SQLFILTRO = "SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
                                                        $RS = sqlsrv_query($maestra, $SQLFILTRO);
                                                        //oci_execute($RS);
                                                        while ($row = sqlsrv_fetch_array($RS)) {
                                                            $NUM_TIENDA = $row['DES_CLAVE'];
                                                            $DES_TIENDA = $row['DES_TIENDA'];
                                                            $NUM_TIENDA_F = "0000" . $NUM_TIENDA;
                                                            $NUM_TIENDA_F = substr($NUM_TIENDA_F, -4);
                                                            ?>
                                                            <option value="<?php echo $NUM_TIENDA ?>" <?php
                                                            if ($NUM_TIENDA == $BSC_TIENDA) {
                                                                echo "SELECTED";
                                                            }
                                                            ?>>
                                                                        <?= $NUM_TIENDA_F . " - " . $DES_TIENDA; ?>
                                                            </option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <select name="BSC_ESTADO" onChange="document.forms.frmbuscar.submit();">
                                                        <option value="">Seleccione Estado</option>
                                                        <?php if (strcmp($BSC_ESTADO, 'P') === 0) { ?>
                                                            <option value="P" selected>Procesado</option>
                                                        <?php } else { ?>
                                                            <option value="P" >Procesado</option>
                                                        <?php } ?>



                                                        <?php if (strcmp($BSC_ESTADO, 'E') === 0) { ?>
                                                            <option value="E" selected>Error</option>
                                                        <?php } else { ?>
                                                            <option value="E" >Error</option>
                                                        <?php } ?>
                                                    </select>
                                                    <label style="clear:left" for="FECHA_EM_D">Desde </label>
                                                    <?php
                                                    $CONSULTA = "select max(FEC_TLOG) as MAX, MIN(FEC_TLOG) as MIN from CO_TLOG;";
                                                    //echo $CONSULTA;
                                                    $RS = sqlsrv_query($arts_conn, $CONSULTA);
                                                    //oci_execute($RS);

                                                    if ($row = sqlsrv_fetch_array($RS)) {
                                                        $MAX = $row['MAX'];
                                                        $MAX = @date_format($MAX, "d-m-Y");
                                                        $MIN = $row['MIN'];
                                                        $MIN = @date_format($MIN, "d-m-Y");
                                                    }

                                                    $fecha_d = explode("-", $MIN);
                                                    if ($DIA_ED == "") {
                                                        $DIA_ED = $fecha_d["0"];
                                                    }
                                                    if ($MES_ED == "") {
                                                        $MES_ED = $fecha_d["1"];
                                                    }
                                                    if ($ANO_ED == "") {
                                                        $ANO_ED = $fecha_d["2"];
                                                    }
                                                    $fecha_h = explode("-", $MAX);
                                                    if ($DIA_EH == "") {
                                                        $DIA_EH = $fecha_h["0"];
                                                    }
                                                    if ($MES_EH == "") {
                                                        $MES_EH = $fecha_h["1"];
                                                    }
                                                    if ($ANO_EH == "") {
                                                        $ANO_EH = $fecha_h["2"];
                                                    }
                                                    ?>
                                                    <input name="DIA_ED" type="text" id="DIA_ED" value="<?php echo $DIA_ED ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                                                    <select name="MES_ED" id="MES_ED">
                                                        <option value="01" <?php
                                                        if ($MES_ED == 1) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Enero</option>
                                                        <option value="02" <?php
                                                        if ($MES_ED == 2) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Febrero</option>
                                                        <option value="03" <?php
                                                        if ($MES_ED == 3) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Marzo</option>
                                                        <option value="04" <?php
                                                        if ($MES_ED == 4) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Abril</option>
                                                        <option value="05" <?php
                                                        if ($MES_ED == 5) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Mayo</option>
                                                        <option value="06" <?php
                                                        if ($MES_ED == 6) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Junio</option>
                                                        <option value="07" <?php
                                                        if ($MES_ED == 7) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Julio</option>
                                                        <option value="08" <?php
                                                        if ($MES_ED == 8) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Agosto</option>
                                                        <option value="09" <?php
                                                        if ($MES_ED == 9) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Septiembre</option>
                                                        <option value="10" <?php
                                                        if ($MES_ED == 10) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Octubre</option>
                                                        <option value="11" <?php
                                                        if ($MES_ED == 11) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Noviembre</option>
                                                        <option value="12" <?php
                                                        if ($MES_ED == 12) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Diciembre</option>
                                                    </select>
                                                    <input name="ANO_ED" type="text" id="ANO_ED" value="<?php echo $ANO_ED ?>" size="4" maxlength="4">
                                                    <label for="FECHA_EM_H">Hasta </label>
                                                    <input name="DIA_EH" type="text" id="DIA_EH" value="<?php echo $DIA_EH ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                                                    <select name="MES_EH" id="MES_EH">
                                                        <option value="01" <?php
                                                        if ($MES_EH == 1) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Enero</option>
                                                        <option value="02" <?php
                                                        if ($MES_EH == 2) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Febrero</option>
                                                        <option value="03" <?php
                                                        if ($MES_EH == 3) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Marzo</option>
                                                        <option value="04" <?php
                                                        if ($MES_EH == 4) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Abril</option>
                                                        <option value="05" <?php
                                                        if ($MES_EH == 5) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Mayo</option>
                                                        <option value="06" <?php
                                                        if ($MES_EH == 6) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Junio</option>
                                                        <option value="07" <?php
                                                        if ($MES_EH == 7) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Julio</option>
                                                        <option value="08" <?php
                                                        if ($MES_EH == 8) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Agosto</option>
                                                        <option value="09" <?php
                                                        if ($MES_EH == 9) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Septiembre</option>
                                                        <option value="10" <?php
                                                        if ($MES_EH == 10) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Octubre</option>
                                                        <option value="11" <?php
                                                        if ($MES_EH == 11) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Noviembre</option>
                                                        <option value="12" <?php
                                                        if ($MES_EH == 12) {
                                                            echo "SELECTED";
                                                        }
                                                        ?>>Diciembre</option>
                                                    </select>
                                                    <input name="ANO_EH" type="text" id="ANO_EH" value="<?php echo $ANO_EH ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                                                    <label for="BDNOMBRE" style="margin:8px 4px; font-weight:600; clear:left">Nombre Archivo XML</label>
                                                    <input name="BDNOMBRE" type="text"  id="BDNOMBRE" value="<?php echo $NOM_TLOG ?>" size="14" maxlength="40">
                                                    <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Archivo XML">
                                                    <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('log_xml.php');">
                                                    <input name="RECARGAR" type="button" id="RECARGAR" value="recargar" onClick="pagina('log_xml.php');">
                                                </form></td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>
                                <table style="margin:10px 20px; ">
                                    <tr>
                                        <td><?php
                                            if ($LIST == 1) {
                                                ?>
                                                <?php
                                                $CONSULTA = "SELECT COUNT(*) AS CUENTA FROM CO_TLOG  WHERE ID_TLOG <> 0 AND STATUS <> 'D' " . $FLT_NOMBRE . " " . $FLT_ESTADO . " " . $FLT_TIENDA . " " . $FLT_FECHA;
                                                //echo $CONSULTA;
                                                $RS = sqlsrv_query($arts_conn, $CONSULTA);
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
                                                }

                                                //$CONSULTA="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_TLOG ".$FLT_NOMBRE." ORDER BY FEC_TLOG ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;

                                                $CONSULTA = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY FEC_TLOG ASC) ROWNUMBER FROM  CO_TLOG WHERE ID_TLOG <> 0 AND STATUS <> 'D'" . $FLT_NOMBRE . " " . $FLT_ESTADO . " " . $FLT_TIENDA . " " . $FLT_FECHA . " ) AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";

                                                //echo $CONSULTA;


                                                $RS = sqlsrv_query($arts_conn, $CONSULTA);
                                                //oci_execute($RS);
                                                ?>
                                                <table id="Listado">
                                                    <tr>
                                                        <th>Nombre Archivo</th>
                                                        <th>Tienda</th>
                                                        <th>Status</th>
                                                        <th>Fecha de Registro</th>
                                                        <th>Archivo</th>
                                                    </tr>
                                                    <?php
                                                    while ($row = sqlsrv_fetch_array($RS)) {

                                                        $ID_TLOG = $row['ID_TLOG'];
                                                        $NOM_TLOG = $row['NOM_TLOG'];
                                                        $DES_CLAVE = $row['DES_CLAVE'];
                                                        $STATUS = $row['STATUS'];
                                                        $ESTADO = $row['STATUS'];
                                                        $FEC_TLOG = $row['FEC_TLOG'];
                                                        $FEC_TLOG = date_format($FEC_TLOG, "d-m-Y");

                                                        // ASIGNO STATUS
                                                        $STATUS = View_Status($STATUS);

                                                        $SQL2 = "SELECT * FROM MN_TIENDA WHERE DES_CLAVE=" . $DES_CLAVE;
                                                        $RS2 = sqlsrv_query($maestra, $SQL2);
                                                        //oci_execute($RS2);
                                                        if ($row2 = sqlsrv_fetch_array($RS2)) {
                                                            $DES_TIENDA = $row2['DES_TIENDA'];
                                                        }
                                                        ?>
                                                        <form action="load_xml.php" method="GET">
                                                            <tr>
                                                                <td><?= $NOM_TLOG ?></td>
                                                                <td><?= $DES_TIENDA ?></td>
                                                                <td><?= $STATUS ?></td>
                                                                <td><?= $FEC_TLOG ?></td>
                                                                <td><input type="hidden" name="FILE" id="FILE" value="<?= $NOM_TLOG ?>">
                                                                    <input type="button" name="btn_submit" value="Ver XML" onClick="abrir_xml('<?= $NOM_TLOG ?>', '<?= $ESTADO ?>')"></td>
                                                            </tr>
                                                        </form>
                                                        <?php
                                                    }
                                                    ?>
                                                    <tr>
                                                        <td colspan="4" nowrap style="background-color:transparent"><?php
                                                            if ($LINF >= $CTP + 1) {
                                                                $ATRAS = $LINF - $CTP;
                                                                $FILA_ANT = $LSUP - $CTP;
                                                                ?>
                                                                <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('log_xml.php?LSUP=<?php echo $FILA_ANT ?>&LINF=<?php echo $ATRAS ?>&NOM_TLOG=<?= $NOM_TLOG ?>&BSC_ESTADO=<?= $BSC_ESTADO ?>&BSC_TIENDA=<?= $BSC_TIENDA ?>&DIA_ED=<?= $DIA_ED ?>&MES_ED=<?= $MES_ED ?>&ANO_ED=<?= $ANO_ED ?>&DIA_EH=<?= $DIA_EH ?>&MES_EH=<?= $MES_EH ?>&ANO_EH=<?= $ANO_EH ?>');">
                                                                <?php
                                                            }
                                                            if ($LSUP <= $TOTALREG) {
                                                                $ADELANTE = $LSUP + 1;
                                                                $FILA_POS = $LSUP + $CTP;
                                                                ?>
                                                                <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('log_xml.php?LSUP=<?php echo $FILA_POS ?>&LINF=<?php echo $ADELANTE ?>&NOM_TLOG=<?= $NOM_TLOG ?>&BSC_ESTADO=<?= $BSC_ESTADO ?>&BSC_TIENDA=<?= $BSC_TIENDA ?>&DIA_ED=<?= $DIA_ED ?>&MES_ED=<?= $MES_ED ?>&ANO_ED=<?= $ANO_ED ?>&DIA_EH=<?= $DIA_EH ?>&MES_EH=<?= $MES_EH ?>&ANO_EH=<?= $ANO_EH ?>');">
                                                            <?php } ?>
                                                            <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG ?> de <?php echo $NUMTPAG ?></span></td>
                                                    </tr>
                                                </table>
                                                <?php
                                                sqlsrv_close($conn);
                                            }
                                            ?></td>

                                    </tr>
                                </table>
                            </td>
                        </tr>

                    </table>
                <?php } ?>
            </td>
            <!-- Inicio Log EPS -->
            <td>
                <?php if ($LOG2 == 2) { ?>

                   <form action="log_xml.php?LOG2=2" method="post" name="frmbuscar2" id="frmbuscar2">
                    <table width="100%" id="Filtro">
                       
                            <tr>

                                <td style="border-bottom:none !important;">

                                    <label style="clear:left" for="FECHA_EM_D2">Desde </label>
                                    <?php
                                    $CONSULTA = "select max(BUSINESS_DATE) as MAX, MIN(BUSINESS_DATE) as MIN from CO_EPS_LOG;";
                                    //echo $CONSULTA;
                                    $RS = sqlsrv_query($arts_conn, $CONSULTA);
                                    //oci_execute($RS);

                                    if ($row = sqlsrv_fetch_array($RS)) {
                                        $MAX = $row['MAX'];
                                        $MAX = @date_format($MAX, "d-m-Y");
                                        $MIN = $row['MIN'];
                                        $MIN = @date_format($MIN, "d-m-Y");
                                    }

                                    $fecha_d = explode("-", $MIN);
                                    if ($DIA_ED2 == "") {
                                        $DIA_ED2 = $fecha_d["0"];
                                    }
                                    if ($MES_ED2 == "") {
                                        $MES_ED2 = $fecha_d["1"];
                                    }
                                    if ($ANO_ED2 == "") {
                                        $ANO_ED2 = $fecha_d["2"];
                                    }
                                    $fecha_h = explode("-", $MAX);
                                    if ($DIA_EH2 == "") {
                                        $DIA_EH2 = $fecha_h["0"];
                                    }
                                    if ($MES_EH2 == "") {
                                        $MES_EH2 = $fecha_h["1"];
                                    }
                                    if ($ANO_EH2 == "") {
                                        $ANO_EH2 = $fecha_h["2"];
                                    }
                                    ?>
                                    
                                    <input name="DIA_ED2" type="text" id="DIA_ED2" value="<?php echo $DIA_ED2 ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                                    <select name="MES_ED2" id="MES_ED2">
                                        <option value="01" <?php
                                        if ($MES_ED2 == 1) {
                                            echo "SELECTED";
                                        }
                                        ?>>Enero</option>
                                        <option value="02" <?php
                                        if ($MES_ED2 == 2) {
                                            echo "SELECTED";
                                        }
                                        ?>>Febrero</option>
                                        <option value="03" <?php
                                        if ($MES_ED2 == 3) {
                                            echo "SELECTED";
                                        }
                                        ?>>Marzo</option>
                                        <option value="04" <?php
                                        if ($MES_ED2 == 4) {
                                            echo "SELECTED";
                                        }
                                        ?>>Abril</option>
                                        <option value="05" <?php
                                        if ($MES_ED2 == 5) {
                                            echo "SELECTED";
                                        }
                                        ?>>Mayo</option>
                                        <option value="06" <?php
                                        if ($MES_ED2 == 6) {
                                            echo "SELECTED";
                                        }
                                        ?>>Junio</option>
                                        <option value="07" <?php
                                        if ($MES_ED2 == 7) {
                                            echo "SELECTED";
                                        }
                                        ?>>Julio</option>
                                        <option value="08" <?php
                                        if ($MES_ED2 == 8) {
                                            echo "SELECTED";
                                        }
                                        ?>>Agosto</option>
                                        <option value="09" <?php
                                        if ($MES_ED2 == 9) {
                                            echo "SELECTED";
                                        }
                                        ?>>Septiembre</option>
                                        <option value="10" <?php
                                        if ($MES_ED2 == 10) {
                                            echo "SELECTED";
                                        }
                                        ?>>Octubre</option>
                                        <option value="11" <?php
                                        if ($MES_ED2 == 11) {
                                            echo "SELECTED";
                                        }
                                        ?>>Noviembre</option>
                                        <option value="12" <?php
                                        if ($MES_ED2 == 12) {
                                            echo "SELECTED";
                                        }
                                        ?>>Diciembre</option>
                                    </select>
                                    
                                    <input name="ANO_ED2" type="text" id="ANO_ED2" value="<?php echo $ANO_ED2 ?>" size="4" maxlength="4">
                                    <label for="FECHA_EM_H2">Hasta </label>
                                    <input name="DIA_EH2" type="text" id="DIA_EH2" value="<?php echo $DIA_EH2 ?>" size="2" maxlength="2" onKeyPress="return acceptNum(event);">
                                    
                                    <select name="MES_EH2" id="MES_EH2">
                                        <option value="01" <?php
                                        if ($MES_EH2 == 1) {
                                            echo "SELECTED";
                                        }
                                        ?>>Enero</option>
                                        <option value="02" <?php
                                        if ($MES_EH2 == 2) {
                                            echo "SELECTED";
                                        }
                                        ?>>Febrero</option>
                                        <option value="03" <?php
                                        if ($MES_EH2 == 3) {
                                            echo "SELECTED";
                                        }
                                        ?>>Marzo</option>
                                        <option value="04" <?php
                                        if ($MES_EH2 == 4) {
                                            echo "SELECTED";
                                        }
                                        ?>>Abril</option>
                                        <option value="05" <?php
                                        if ($MES_EH2 == 5) {
                                            echo "SELECTED";
                                        }
                                        ?>>Mayo</option>
                                        <option value="06" <?php
                                        if ($MES_EH2 == 6) {
                                            echo "SELECTED";
                                        }
                                        ?>>Junio</option>
                                        <option value="07" <?php
                                        if ($MES_EH2 == 7) {
                                            echo "SELECTED";
                                        }
                                        ?>>Julio</option>
                                        <option value="08" <?php
                                        if ($MES_EH2 == 8) {
                                            echo "SELECTED";
                                        }
                                        ?>>Agosto</option>
                                        <option value="09" <?php
                                        if ($MES_EH2 == 9) {
                                            echo "SELECTED";
                                        }
                                        ?>>Septiembre</option>
                                        <option value="10" <?php
                                        if ($MES_EH2 == 10) {
                                            echo "SELECTED";
                                        }
                                        ?>>Octubre</option>
                                        <option value="11" <?php
                                        if ($MES_EH2 == 11) {
                                            echo "SELECTED";
                                        }
                                        ?>>Noviembre</option>
                                        <option value="12" <?php
                                        if ($MES_EH2 == 12) {
                                            echo "SELECTED";
                                        }
                                        ?>>Diciembre</option>
                                    </select>
                                    <input name="ANO_EH2" type="text" id="ANO_EH2" value="<?php echo $ANO_EH2 ?>" size="4" maxlength="4" onKeyPress="return acceptNum(event);">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    
                                    <select name="BSC_TIENDA2" onChange="document.forms.frmbuscar2.submit();">
                                        <option value="no_sel">Seleccione Tienda</option>
                                        <?php
                                        $SQLFILTRO = "SELECT * FROM MN_TIENDA WHERE COD_TIENDA<>0 AND IND_ACTIVO = 1 ORDER BY DES_CLAVE ASC";
                                        $RS = sqlsrv_query($maestra, $SQLFILTRO);
                                        //oci_execute($RS);
                                        while ($row = sqlsrv_fetch_array($RS)) {
                                            $NUM_TIENDA = $row['DES_CLAVE'];
                                            $DES_TIENDA = $row['DES_TIENDA'];
                                            $NUM_TIENDA_F = "0000" . $NUM_TIENDA;
                                            $NUM_TIENDA_F = substr($NUM_TIENDA_F, -4);
                                            ?>
                                            <option value="<?php echo $NUM_TIENDA ?>" <?php
                                            if ($NUM_TIENDA == $BSC_TIENDA2) {
                                                echo "SELECTED";
                                            }
                                            ?>>
                                                        <?= $NUM_TIENDA_F . " - " . $DES_TIENDA; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    
                                    <input name="BUSCAR2" type="submit" id="BUSCAR2" value="Buscar EPS">
                                    <input name="LIMPIAR2" type="button" id="LIMPIAR2" value="Limpiar" onClick="pagina('log_xml.php?LOG2=2');">
                                    <input name="RECARGAR2" type="button" id="RECARGAR2" value="recargar" onClick="pagina('log_xml.php?LOG2=2');">
                                </td>

                            </tr>
                       
                    </table>
                  </form>
                    <!-- Inicio Contenido EPS -->
                    <table style="margin:10px 20px; ">
                        <tr>
                            <td>
                                <?php
                                $CONSULTA = "SELECT COUNT(*) AS CUENTA FROM CO_EPS_LOG  WHERE ID_EPS_LOG <> 0 " . $FLT_TIENDA2 . " " . $FLT_FECHA2;

                                $RS = sqlsrv_query($arts_conn, $CONSULTA);
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
                                }


                                $CONSULTA = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY ID_EPS_LOG ASC) ROWNUMBER FROM  CO_EPS_LOG WHERE ID_EPS_LOG <> 0 " . $FLT_TIENDA2 . " " . $FLT_FECHA2 . ") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";

                                $RS = sqlsrv_query($arts_conn, $CONSULTA);
                                //oci_execute($RS);
                                ?>
                                <table id="Listado">
                                    <tr>
                                        <th>Tienda</th>
                                        <th>Header</th>
                                        <th>Data</th>
                                        <th>Fecha de Registro</th>
                                        <th>Fecha Contable Log</th>
                                    </tr>
                                    <?php
                                    while ($row = sqlsrv_fetch_array($RS)) {

                                        $ID_EPS_LOG = $row['ID_EPS_LOG'];
                                        $CD_STR_RT = $row['CD_STR_RT'];
                                        $EXECUTION_DATE = $row['EXECUTION_DATE'];
                                        $BUSINESS_DATE = $row['BUSINESS_DATE'];
                                        $HEADER = $row['HEADER'];
                                        $DATA = $row['DATA'];

                                        // FECHAS SQLSERVER
                                        $EXECUTION_DATE = date_format($EXECUTION_DATE, "d-m-Y");
                                        $BUSINESS_DATE = date_format($BUSINESS_DATE, "d-m-Y");

                                        $QUERYN = "SELECT * FROM MN_TIENDA WHERE DES_CLAVE = " . $CD_STR_RT;
                                        $RSQ = sqlsrv_query($maestra, $QUERYN);
                                        if ($rown = sqlsrv_fetch_array($RSQ)) {
                                            $DES_CLAVE = $rown["DES_CLAVE"];
                                            $DES_TIENDA = $rown["DES_TIENDA"];
                                        }
                                        ?>
                                        <tr>
                                            <td><?= $DES_TIENDA . '-' . $DES_CLAVE ?></td>
                                            <td><?= $HEADER ?></td>
                                            <td><?= $DATA ?></td>
                                            <td><?= $EXECUTION_DATE ?></td>
                                            <td><?= $BUSINESS_DATE ?></td>
                                        </tr>

                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="4" nowrap style="background-color:transparent"><?php
                                            if ($LINF >= $CTP + 1) {
                                                $ATRAS = $LINF - $CTP;
                                                $FILA_ANT = $LSUP - $CTP;
                                                ?>
                                                <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('log_xml.php?LOG2=2&LSUP=<?php echo $FILA_ANT ?>&LINF=<?php echo $ATRAS ?>&BSC_TIENDA2=<?= $BSC_TIENDA2 ?>&DIA_ED2=<?= $DIA_ED2 ?>&MES_ED2=<?= $MES_ED2 ?>&ANO_ED2=<?= $ANO_ED2 ?>&DIA_EH2=<?= $DIA_EH2 ?>&MES_EH2=<?= $MES_EH2 ?>&ANO_EH2=<?= $ANO_EH2 ?>');">
                                                <?php
                                            }
                                            if ($LSUP <= $TOTALREG) {
                                                $ADELANTE = $LSUP + 1;
                                                $FILA_POS = $LSUP + $CTP;
                                                ?>
                                                <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('log_xml.php?LOG2=2&LSUP=<?php echo $FILA_POS ?>&LINF=<?php echo $ADELANTE ?>&BSC_TIENDA2=<?= $BSC_TIENDA2 ?>&DIA_ED2=<?= $DIA_ED2 ?>&MES_ED2=<?= $MES_ED2 ?>&ANO_ED2=<?= $ANO_ED2 ?>&DIA_EH2=<?= $DIA_EH2 ?>&MES_EH2=<?= $MES_EH2 ?>&ANO_EH2=<?= $ANO_EH2 ?>');">
                                            <?php } ?>
                                            <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG ?> de <?php echo $NUMTPAG ?></span></td>
                                    </tr>
                                </table>
                                <?php
                                sqlsrv_close($conn);
                                ?></td>

                        </tr>
                    </table>
                    <!-- Fin Contenido EPS -->
                    <?php
                }
                ?>


            </td>
            <!-- FIN Log EPS -->

        </tr>

    </table>
    <div id="xml" style="display:none; ">
        <div id="xml-contenedor"> <span style="position:absolute; top:0; right:20px;"> <img src="../images/ICO_Close.png" border="0" onClick="cerrar_xml();" title="Cerrar ventana"> </span>
            <h3>XML</h3>
            <div id="load_xml"> </div>
        </div>
    </div>
</body>
</html>
