<?php include("session.inc"); ?>
<?php include("headerhtml.inc"); ?>
<?php
$PAGINA = 1177;
$LIST = @$_GET["LIST"];
$NEO = @$_GET["NEO"];
$ACT = @$_GET["ACT"];

if ($NEO == "" and $ACT == "") {
    $LIST = 1;
}
?>
<?php if ($LIST <> 1) { ?>
    <script language="JavaScript">
        function validaingreso(theForm) {
            if (theForm.BIN_TARJETA.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.BIN_TARJETA.focus();
                return false;
            }
            if (theForm.LON_PAN.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.LON_PAN.focus();
                return false;
            }
            if (theForm.COD_OPERACION.value == 0) {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.COD_OPERACION.focus();
                return false;
            }
            if (theForm.FLAG_USUARIO.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.FLAG_USUARIO.focus();
                return false;
            }
            if (theForm.CARD_PLAN_ID.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.CARD_PLAN_ID.focus();
                return false;
            }
            if (theForm.NETWORK_ID.value == 0) {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.NETWORK_ID.focus();
                return false;
            }
            if (theForm.DEPARTAMENTO.value == "no_sel") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.DEPARTAMENTO.focus();
                return false;
            }
            if (theForm.FLAG_PROCESAMIENTO.value == "no_sel") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.FLAG_PROCESAMIENTO.focus();
                return false;
            }
            if (theForm.TP_TARJ.value == "no_sel") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.TP_TARJ.focus();
                return false;
            }
            if (theForm.TY_TND.value == "no_sel") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.TY_TND.focus();
                return false;
            }
            if (theForm.ID_FRANQUEO.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.ID_FRANQUEO.focus();
                return false;
            }
            if (theForm.DESCRIPCION.value == 0) {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.DESCRIPCION.focus();
                return false;
            }
            if (theForm.RECORD_ID.value == 0) {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.RECORD_ID.focus();
                return false;
            }
            if (theForm.TIPO_HOST.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.TIPO_HOST.focus();
                return false;
            }
			if (theForm.SEL_SUBV.value == "") {
                alert("COMPLETE EL CAMPO REQUERIDO.");
                theForm.SEL_SUBV.focus();
                return false;
            }
			

        } //validaingreso(theForm)
    </script>
<?php } ?>
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
                    <div id="GMessaje" onClick="QuitarGMessage();"><a href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">
                            <?= $ELMSJ ?>
                        </a></div>
                <?php } ?>
                <table width="100%">
                    <tr>
                        <td><h2>
                                <?= $LAPAGINA ?>&nbsp;&nbsp; &nbsp;   
                                <?php
                                if ($LIST == 1) {
                                    echo '<input type="button" value="EXPORTAR" onClick="abrir_exportar();">';
                                }
                                ?>
                            </h2>
                            <?php
                            if ($LIST == 1) {
                                ?>
                            </td>
                        </tr>
                        <tr>
                           

                        <script>
                            function CargarT(negocio, selector)
                            {
                                var dataString = 'COD_NEGOCIO=' + negocio;
                                $.ajax({
                                    type: "GET",
                                    url: "load_store.php",
                                    data: dataString,
                                    cache: false,
                                    success: function (response)
                                    {
                                        $("#" + selector).empty();
                                        $("#" + selector).html(response);
                                    }
                                })
                            }
                        </script>
                        <?php

                        function is_set($name) {
                            $res = "";
                            if (isset($_POST[$name])) {
                                $res = $_POST[$name];
                            } elseif (isset($_GET[$name])) {
                                $res = $_GET[$name];
                            }
                            return $res;
                        }

                        $BINES = is_set("BINES");
                        $FLTR_DESCRIPCION = is_set("FLTR_DESCRIPCION");
                        $FLTR_FLAG_PROCESAMIENTO = is_set("FLTR_FLAG_PROCESAMIENTO");
                        $FLTR_DEPARTAMENTO = is_set("FLTR_DEPARTAMENTO");
                        $FLTR_TIPO_TARJETA = is_set("FLTR_TIPO_TARJETA");
                        $FLTR_P_PAG_RET = is_set("FLTR_P_PAG_RET");
                        $FLTR_AC_PTS = is_set("FLTR_AC_PTS");
                        $FLTR_TARJ_PERMITIDA = is_set("FLTR_TARJ_PERMITIDA");
                        $FLTR_AUT_MANUAL = is_set("FLTR_AUT_MANUAL");
                        $FLTR_FACT_REQ = is_set("FLTR_FACT_REQ");
                        ?>
                        <table width="100%" id="Filtro">
                            <form action="mant_bines.php" method="post" name="frmbuscar_" id="frmbuscar_">
                                <tr>
                                    <td style="border-bottom:none">
                                        <select name="FLTR_FLAG_PROCESAMIENTO" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel">Seleccione Flag Prosec.</option>

                                            <?php
                                            if ($FLTR_FLAG_PROCESAMIENTO == "no_asoc") {
                                                echo '<option value="no_asoc" selected>NO ASOCIADO</option>';
                                            } else {
                                                echo '<option value="no_asoc">NO ASOCIADO</option>';
                                            }
                                            $r = "";
                                            $Q = "SELECT * FROM CO_FLAG_PROCES WHERE FLAG_PROCESAMIENTO IN(SELECT DISTINCT(FLAG_PROCESAMIENTO) FROM CO_BINES)";
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {

                                                if ($FLTR_FLAG_PROCESAMIENTO == $RW["FLAG_PROCESAMIENTO"]) {
                                                    $r.='<option value="' . $RW["FLAG_PROCESAMIENTO"] . '" selected>' . $RW["DES_PROCES"] . '</option>';
                                                } else {
                                                    $r.='<option value="' . $RW["FLAG_PROCESAMIENTO"] . '">' . $RW["DES_PROCES"] . '</option>';
                                                }
                                            }
                                            echo $r;
                                            ?>
                                        </select>
                                        <select name="FLTR_DEPARTAMENTO" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel">Seleccione Depto.</option>
                                            <?php
                                            if ($FLTR_DEPARTAMENTO == "no_asoc") {
                                                echo '<option value="no_asoc" selected>NO ASOCIADO</option>';
                                            } else {
                                                echo '<option value="no_asoc">NO ASOCIADO</option>';
                                            }
                                            $r = "";
                                            $Q = "SELECT * FROM ID_DPT_PS WHERE CD_DPT_CER IN(SELECT DISTINCT(DEPARTAMENTO) FROM CO_BINES)";
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {

                                                if ($FLTR_DEPARTAMENTO == $RW["CD_DPT_CER"]) {
                                                    $r.='<option value="' . $RW["CD_DPT_CER"] . '" selected>' . $RW["NM_DPT_PS"] . '</option>';
                                                } else {
                                                    $r.='<option value="' . $RW["CD_DPT_CER"] . '">' . $RW["NM_DPT_PS"] . '</option>';
                                                }
                                            }
                                            echo $r;
                                            ?>
                                        </select>
                                        <select name="FLTR_TIPO_TARJETA" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel">Seleccione Medio de Pago Asoc.</option>
                                            <?php
                                            if ($FLTR_TIPO_TARJETA == "no_asoc") {
                                                echo '<option value="no_asoc" selected>NO ASOCIADO</option>';
                                            } else {
                                                echo '<option value="no_asoc">NO ASOCIADO</option>';
                                            }
                                            $r = "";
                                            $Q = "SELECT * FROM AS_TND WHERE TY_TND IN(SELECT DISTINCT(TY_TND) FROM CO_BINES)";
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {
                                                if ($FLTR_TIPO_TARJETA == $RW["TY_TND"]) {
                                                    $r.='<option value="' . $RW["TY_TND"] . '" selected>' . $RW["DE_TND"] . '</option>';
                                                } else {
                                                    $r.='<option value="' . $RW["TY_TND"] . '">' . $RW["DE_TND"] . '</option>';
                                                }
                                            }
                                            echo $r;
                                            ?>
                                        </select>
                                    </td >
                                </tr>
                                <tr>
                                    <td style="border-bottom:none">
                                        <select name="FLTR_P_PAG_RET" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel"<?php if ($FLTR_P_PAG_RET == "no_sel") { ?>selected <?php } ?> >Pago con Retenci&oacute;n</option>
                                            <option value="1" <?php if ($FLTR_P_PAG_RET == "1") { ?>selected <?php } ?>>SI</option>
                                            <option value="0" <?php if ($FLTR_P_PAG_RET == "0") { ?>selected <?php } ?>>NO</option>
                                        </select>
                                        <select name="FLTR_AC_PTS" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel" <?php if ($FLTR_AC_PTS == "no_sel") { ?>selected <?php } ?>>Acumula Puntos</option>
                                            <option value="1" <?php if ($FLTR_AC_PTS == "1") { ?>selected <?php } ?>>SI</option>
                                            <option value="0" <?php if ($FLTR_AC_PTS == "0") { ?>selected <?php } ?>>NO</option>
                                        </select>
                                        <select name="FLTR_TARJ_PERMITIDA" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel" <?php if ($FLTR_TARJ_PERMITIDA == "no_sel") { ?>selected <?php } ?>>Tarjeta Permitida</option>
                                            <option value="1" <?php if ($FLTR_TARJ_PERMITIDA == "1") { ?>selected <?php } ?>>SI</option>
                                            <option value="0" <?php if ($FLTR_TARJ_PERMITIDA == "0") { ?>selected <?php } ?>>NO</option></select>
                                        <select name="FLTR_AUT_MANUAL" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel" <?php if ($FLTR_AUT_MANUAL == "no_sel") { ?>selected <?php } ?>>Autorizaci&oacute;n Manual</option>
                                            <option value="1" <?php if ($FLTR_AUT_MANUAL == "1") { ?>selected <?php } ?>>SI</option>
                                            <option value="0" <?php if ($FLTR_AUT_MANUAL == "0") { ?>selected <?php } ?>>NO</option></select>
                                        <select name="FLTR_FACT_REQ" onChange="document.forms.frmbuscar_.submit();">
                                            <option value="no_sel" <?php if ($FLTR_FACT_REQ == "no_sel") { ?>selected <?php } ?>>Factura Req.</option>
                                            <option value="1" <?php if ($FLTR_FACT_REQ == "1") { ?>selected <?php } ?>>SI</option>
                                            <option value="0" <?php if ($FLTR_FACT_REQ == "0") { ?>selected <?php } ?>>NO</option>
                                        </select>                      
                                    </td></tr>
                                <tr><td>
                                        <input style="text-transform:uppercase" name="BINES" type="text"  id="BINES" placeholder="BIN" value="<?= $BINES; ?>" size="22" maxlength="20" onKeyPress="return acceptNum(event);">
                                        <input style="text-transform:uppercase" name="FLTR_DESCRIPCION" type="text"  id="DESCRIPCION" placeholder="Descripci&oacute;n" value="<?= $FLTR_DESCRIPCION ?>" size="22" maxlength="20">
                                        <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar">
                                        <input name="LIMPIAR" type="button" id="LIMPIAR" value="Limpiar" onClick="pagina('mant_bines.php');">
                                    </td>
                                </tr>
                            </form>  
                        </table>  
                        <table style="margin:10px 20px; ">
                            <tr>
                                <td><?php

                                    function cambiar_ind($val) {
                                        $res = "";
                                        switch ($val) {
                                            case 1:
                                                $res = "SI";
                                                break;
                                            case 0:
                                                $res = "NO";
                                                break;
                                        }
                                        return $res;
                                    }

                                    function pre_format($val) {
                                        $res;
                                        if ($val == 0) {
                                            $res = "0.00";
                                        } elseif ($val == 1) {
                                            $res = "1.00";
                                        }
                                        if (strpos($val, ".") == false) {
                                            $res = $val . ".00";
                                        } else {
                                            $res = $val;
                                        }
                                        return $res;
                                    }

                                    $FLT = "";
                                    $FLTR_BIN = "";
                                    $FLTR_DES = "";
                                    $FLTR_FLAG = "";
                                    $FLTR_DEPTO = "";
                                    $FLTR_TIPO = "";
                                    $FLTR_P_PAG = "";
                                    $FLTR_AC = "";
                                    $FLTR_TARJ = "";
                                    $FLTR_AUT = "";
                                    $FLTR_FACT = "";
                                    $BINES = is_set("BINES");
                                    $FLTR_DESCRIPCION = is_set("FLTR_DESCRIPCION");
                                    $FLTR_FLAG_PROCESAMIENTO = is_set("FLTR_FLAG_PROCESAMIENTO");
                                    $FLTR_DEPARTAMENTO = is_set("FLTR_DEPARTAMENTO");
                                    $FLTR_TIPO_TARJETA = is_set("FLTR_TIPO_TARJETA");
                                    $FLTR_P_PAG_RET = is_set("FLTR_P_PAG_RET");
                                    $FLTR_AC_PTS = is_set("FLTR_AC_PTS");
                                    $FLTR_TARJ_PERMITIDA = is_set("FLTR_TARJ_PERMITIDA");
                                    $FLTR_AUT_MANUAL = is_set("FLTR_AUT_MANUAL");
                                    $FLTR_FACT_REQ = is_set("FLTR_FACT_REQ");
                                    if ($BINES != "") {
                                        $FLTR_BIN = "BIN_TARJETA LIKE '%" . $BINES . "%'";
                                    }
                                    if ($FLTR_DESCRIPCION != "") {
                                        $FLTR_DES = "DESCRIPCION LIKE '%" . strtoupper($FLTR_DESCRIPCION) . "%'";
                                    }
                                    if ($FLTR_FLAG_PROCESAMIENTO != "no_sel" and $FLTR_FLAG_PROCESAMIENTO != "") {
                                        if ($FLTR_FLAG_PROCESAMIENTO == "no_asoc") {
                                            $FLTR_FLAG = "FLAG_PROCESAMIENTO='0000'";
                                        } else {
                                            $FLTR_FLAG = "FLAG_PROCESAMIENTO='" . $FLTR_FLAG_PROCESAMIENTO . "'";
                                        }
                                    }
                                    if ($FLTR_DEPARTAMENTO != "no_sel" and $FLTR_DEPARTAMENTO != "") {
                                        if ($FLTR_DEPARTAMENTO == "no_asoc") {
                                            $FLTR_DEPTO = "DEPARTAMENTO='000000'";
                                        } else {
                                            $FLTR_DEPTO = "DEPARTAMENTO='" . $FLTR_DEPARTAMENTO . "'";
                                        }
                                    }
                                    if ($FLTR_TIPO_TARJETA != "no_sel" and $FLTR_TIPO_TARJETA != "") {
                                        if ($FLTR_TIPO_TARJETA == "no_asoc") {
                                            $FLTR_TIPO = "TY_TND='00'";
                                        } else {
                                            $FLTR_TIPO = "TY_TND='" . $FLTR_TIPO_TARJETA . "'";
                                        }
                                    }
                                    if ($FLTR_P_PAG_RET != "" and $FLTR_P_PAG_RET != "no_sel") {
                                        $FLTR_P_PAG = "P_PAG_RET=" . $FLTR_P_PAG_RET . "";
                                    }
                                    if ($FLTR_AC_PTS != "" and $FLTR_AC_PTS != "no_sel") {
                                        $FLTR_AC = "AC_PUNTOS='" . $FLTR_AC_PTS . "'";
                                    }
                                    if ($FLTR_TARJ_PERMITIDA != "" and $FLTR_TARJ_PERMITIDA != "no_sel") {
                                        $FLTR_TARJ = "TARJ_PERMITIDA='" . $FLTR_TARJ_PERMITIDA . "'";
                                    }
                                    if ($FLTR_AUT_MANUAL != "" and $FLTR_AUT_MANUAL != "no_sel") {
                                        $FLTR_AUT = "AUT_MANUAL='" . $FLTR_AUT_MANUAL . "'";
                                    }
                                    if ($FLTR_FACT_REQ != "" and $FLTR_FACT_REQ != "no_sel") {
                                        $FLTR_FACT = "FACT_REQ='" . $FLTR_FACT_REQ . "'";
                                    }

                                    if ($FLTR_BIN != "") {
                                        $FLT.=" AND " . $FLTR_BIN;
                                    }
                                    if ($FLTR_DES != "") {
                                        $FLT.=" AND " . $FLTR_DES;
                                    }
                                    if ($FLTR_FLAG != "") {
                                        $FLT.=" AND " . $FLTR_FLAG;
                                    }
                                    if ($FLTR_DEPTO != "") {
                                        $FLT.=" AND " . $FLTR_DEPTO;
                                    }
                                    if ($FLTR_TIPO != "") {
                                        $FLT.=" AND " . $FLTR_TIPO;
                                    }
                                    if ($FLTR_P_PAG != "") {
                                        $FLT.=" AND " . $FLTR_P_PAG;
                                    }
                                    if ($FLTR_AC != "") {
                                        $FLT.=" AND " . $FLTR_AC;
                                    }
                                    if ($FLTR_TARJ != "") {
                                        $FLT.=" AND " . $FLTR_TARJ;
                                    }
                                    if ($FLTR_AUT != "") {
                                        $FLT.=" AND " . $FLTR_AUT;
                                    }
                                    if ($FLTR_FACT != "") {
                                        $FLT.=" AND " . $FLTR_FACT;
                                    }

                                    if ($FLT != "") {
                                        $FLT = " WHERE ID_BINES<>0 " . $FLT;
                                    }

                                    $CONSULTA1 = "SELECT COUNT(*) AS CUENTA FROM CO_BINES" . $FLT;
                                    //echo $CONSULTA1;
                                    $RS = sqlsrv_query($conn, $CONSULTA1);
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
                                    //$CONSULTA2="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM CO_BINES";
                                    //$CONSULTA2.=$FLT." ORDER BY ID_BINES ASC) a WHERE ROWNUM <= ".$LSUP.") WHERE rnum >=  ".$LINF;


                                    $CONSULTA2 = "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY " . $CTP . " ORDER BY ID_BINES ASC) ROWNUMBER FROM CO_BINES  " . $FLT . ") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN " . $LINF . " AND " . $LSUP . "";

                                    //echo $CONSULTA2;
                                    //echo "<BR>".$CONSULTA2;
                                    $RS = sqlsrv_query($conn, $CONSULTA2);
                                    //oci_execute($RS);
                                    ?>

                                </td>
                            </tr>
                            <tr>
                                <td><table id="Listado">
                                        <tr>
                                            <th>Bin</th>
                                            <th>Descripci&oacute;n</th>
                                            <th>Tipo Tarjeta</th>
                                            <th>Bandera de Procesamiento</th>
                                            <th>Departamento</th>
                                            <th>Medio de Pago Asociado</th>
                                            <th>Tarj. Permitida</th>
                                            <th>Acumula Puntos</th>
                                            <th>Aut. Manual</th>
                                            <th>Pago con Reten.</th>
                                            <th>Factura Req.</th>
                                        </tr>
                                        <?php
                                        while ($row = sqlsrv_fetch_array($RS)) {
                                            $ID_BINES = "";
                                            $BIN_TARJETA = "";
                                            $TP_TARJ = "";
                                            $DESCRIPCION = "";
                                            $FLAG_PROCESAMIENTO = "";
                                            $DES_PROCES = "";
                                            $TARJ_PERMITIDA = "";
                                            $AUT_MANUAL = "";
                                            $PR_MED_PAGO = "";
                                            $TY_TND = "";
                                            $DE_TND = "";
                                            $DEPARTAMENTO = "";
                                            $NM_DPT_PS = "";
                                            $DESC_TP_TARJ = "";

                                            $AC_PUNTOS = "";
                                            $P_PAG_RET = "";
                                            $FACT_REQ = "";
                                            $ID_BINES = $row['ID_BINES'];
                                            $BIN_TARJETA = $row['BIN_TARJETA'];

                                            // OBTENER EL DESC_TRN_CUPO DESDE TABLA CO_CUPO
                                            $TP_TARJ = $row['TP_TARJ'];

                                            //$COD_TRN_PAGO = $row['COD_TRN_PAGO'];
                                            $DESCRIPCION = $row['DESCRIPCION'];

                                            $FLAG_PROCESAMIENTO = $row['FLAG_PROCESAMIENTO'];
                                            $Q = "SELECT * FROM CO_FLAG_PROCES WHERE FLAG_PROCESAMIENTO='" . $FLAG_PROCESAMIENTO . "'";
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {
                                                $DES_PROCES = $RW["DES_PROCES"];
                                            }
                                            if ($DES_PROCES == "") {
                                                $DES_PROCES = "No Asociado";
                                            }

                                            $TARJ_PERMITIDA = cambiar_ind($row['TARJ_PERMITIDA']);
                                            $AUT_MANUAL = cambiar_ind($row['AUT_MANUAL']);
                                            $PR_MED_PAGO = cambiar_ind($row['PR_MED_PAGO']);
                                            $AC_PUNTOS = cambiar_ind($row['AC_PUNTOS']);
                                            $P_PAG_RET = cambiar_ind($row['P_PAG_RET']);
                                            $FACT_REQ = cambiar_ind($row['FACT_REQ']);


                                            $TY_TND = $row['TY_TND'];
                                            $Q = "SELECT * FROM AS_TND WHERE TY_TND='" . $TY_TND . "'";
                                            $REST = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($REST)) {
                                                $DE_TND = $RW["DE_TND"];
                                            }

                                            if ($DE_TND == "") {
                                                $DE_TND = "No Asociado";
                                            }

                                            $DEPARTAMENTO = $row['DEPARTAMENTO'];
                                            $Q = "SELECT * FROM ID_DPT_PS WHERE CD_DPT_CER='" . $DEPARTAMENTO . "'";
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {
                                                $NM_DPT_PS = $RW["NM_DPT_PS"];
                                            }
                                            if ($NM_DPT_PS == "") {
                                                $NM_DPT_PS = "No Asociado";
                                            }


                                            $Q = "SELECT * FROM CO_TIPO_TARJETA WHERE TP_TARJ=" . $TP_TARJ;
                                            $RES = sqlsrv_query($conn, $Q);
                                            //oci_execute($RES);
                                            while ($RW = sqlsrv_fetch_array($RES)) {
                                                $DESC_TP_TARJ = $RW["DESC_TP_TARJ"];
                                            }
                                            if ($DE_TND == "") {
                                                $DE_TND = "No Asociado";
                                            }
                                            ?>
                                            <tr>
                                                <?php if ($SESPUBLICA == 1) { ?>
                                                    <td><a href="mant_bines.php?ACT=<?= $ID_BINES ?>">
                                                            <?= $BIN_TARJETA ?>
                                                        </a></td>
                                                <?php } else { ?>
                                                    <td><?= $BIN_TARJETA ?></td>
                                                <?php } ?>
                                                <td><?= $DESCRIPCION ?></td>
                                                <td><?= $DESC_TP_TARJ ?></td>
                                                <td><?= $DES_PROCES ?></td>
                                                <td><?= $NM_DPT_PS ?></td>
                                                <td><?= $DE_TND ?></td>
                                                <td><?= $TARJ_PERMITIDA ?></td>
                                                <td><?= $AC_PUNTOS ?></td>
                                                <td><?= $AUT_MANUAL ?></td>
                                                <td><?= $P_PAG_RET ?></td>
                                                <td><?= $FACT_REQ ?></td>
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
                                                    <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('mant_bines.php?LSUP=<?= $FILA_ANT ?>&LINF=<?= $ATRAS ?>&BINES=<?= $BINES ?>&FLTR_DESCRIPCION=<?= $FLTR_DESCRIPCION ?>&FLTR_FLAG_PROCESAMIENTO=<?= $FLTR_FLAG_PROCESAMIENTO ?>&FLTR_DEPARTAMENTO=<?= $FLTR_DEPARTAMENTO ?>&FLTR_TIPO_TARJETA=<?= $FLTR_TIPO_TARJETA ?>&FLTR_P_PAG_RET=<?= $FLTR_P_PAG_RET ?>&FLTR_AC_PTS=<?= $FLTR_AC_PTS ?>&FLTR_TARJ_PERMITIDA=<?= $FLTR_TARJ_PERMITIDA ?>&FLTR_AUT_MANUAL=<?= $FLTR_AUT_MANUAL ?>&FLTR_FACT_REQ=<?= $FLTR_FACT_REQ ?>');">
                                                    <?php
                                                }
                                                if ($LSUP <= $TOTALREG) {
                                                    $ADELANTE = $LSUP + 1;
                                                    $FILA_POS = $LSUP + $CTP;
                                                    ?>
                                                    <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('mant_bines.php?LSUP=<?= $FILA_POS ?>&LINF=<?= $ADELANTE ?>&BINES=<?= $BINES ?>&FLTR_DESCRIPCION=<?= $FLTR_DESCRIPCION ?>&FLTR_FLAG_PROCESAMIENTO=<?= $FLTR_FLAG_PROCESAMIENTO ?>&FLTR_DEPARTAMENTO=<?= $FLTR_DEPARTAMENTO ?>&FLTR_TIPO_TARJETA=<?= $FLTR_TIPO_TARJETA ?>&FLTR_P_PAG_RET=<?= $FLTR_P_PAG_RET ?>&FLTR_AC_PTS=<?= $FLTR_AC_PTS ?>&FLTR_TARJ_PERMITIDA=<?= $FLTR_TARJ_PERMITIDA ?>&FLTR_AUT_MANUAL=<?= $FLTR_AUT_MANUAL ?>&FLTR_FACT_REQ=<?= $FLTR_FACT_REQ ?>');">
                                                <?php } ?>
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
                                <style>
                                    .left
                                    {
                                        border-left:solid 1px #dfdfdf;
                                    }
                                </style>
                                <?php if ($NEO == 1) { ?>
                                    <table style="margin:10px 20px; ">
                                        <tr>
                                            <td>
                                            <form action="mant_bines_reg.php" method="post" name="forming" id="forming" onSubmit="return validaingreso(this)">
                                            <table id="forma-registro">
                                                    
                                                        <tr>
                                                            <td><label for="RECORD_ID">ID Record</label></td>
                                                            <td><input name="RECORD_ID" type="text" size="4" maxlength="2"></td>
                                                            <td class="left"><label for="BIN_TARJETA">BIN Tarjeta</label></td>
                                                            <td><input name="BIN_TARJETA" type="text" size="25" maxlength="20" onKeyPress="return acceptNum(event);"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="LON_PAN">Longitud PAN</label></td>
                                                            <td><input name="LON_PAN" type="text" size="3" maxlength="2" onKeyPress="return acceptNum(event);"></td>
                                                            <td class="left"><label for="COD_OPERACION">C&oacute;digo de Op.</label></td>
                                                            <td><select name="COD_OPERACION">
                                                                    <option value="A">Add/A&ntilde;adir</option>
                                                                    <option value="D">Delete/Borrar</option>
                                                                </select></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="FLAG_USUARIO">Flag Usuario</label></td>
                                                            <td><input name="FLAG_USUARIO" type="text" size="6" maxlength="4"></td>
                                                            <td><label for="CARD_PLAN_ID">Card Plan ID</label></td>
                                                            <td id="card_plan"><select name="CARD_PLAN_ID" onChange="cargar_subv(this.value)">
                                                                    <option value="no_sel">Seleccione</option>
                                                                    <?php
                                                                    $r = "";
                                                                    $CRD = "SELECT * FROM CO_CARD_PLAN";
                                                                    $RESC = sqlsrv_query($conn, $CRD);
                                                                    //oci_execute($RESC);
                                                                    while ($RW1 = sqlsrv_fetch_array($RESC)) {
                                                                        $r.='<option value="' . $RW1["CARD_ID"] . '">' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
                                                                    }
                                                                    echo $r;
                                                                    ?>

                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="NETWORK_ID">ID Network</label></td>
                                                            <td><input name="NETWORK_ID" type="text" size="3" maxlength="2"></td>
                                                            <td class="left"><label for="TIPO_HOST">Tipo Host</label></td>
                                                            <td><input name="TIPO_HOST" type="text" size="4" maxlength="3"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="ID_FRANQUEO">ID Franqueo</label></td>
                                                            <td><input name="ID_FRANQUEO" type="text" size="3" maxlength="2"></td>
                                                            <td class="left"><label for="DESCRIPCION">Descripci&oacute;n</label></td>
                                                            <td><input name="DESCRIPCION" type="text" size="18" maxlength="15"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="FLAG_PROCESAMIENTO">Flag Procesamiento</label></td>
                                                            <td><select name="FLAG_PROCESAMIENTO">
                                                                    <option value="no_sel">Seleccione</option>
                                                                    <?PHP
                                                                    $r = "";
                                                                    $Q = "SELECT * FROM CO_FLAG_PROCES";
                                                                    $RES = sqlsrv_query($conn, $Q);
                                                                    //oci_execute($RES);
                                                                    while ($RW = sqlsrv_fetch_array($RES)) {
                                                                        $DES_PROCES = strtoupper($RW["DES_PROCES"]);
                                                                        $r.='<option value="' . $RW["FLAG_PROCESAMIENTO"] . '">' . $DES_PROCES . '</option>';
                                                                    }
                                                                    echo $r;
                                                                    ?>

                                                                </select></td>
                                                            <td class="left"><label for="DEPARTAMENTO">Departamento</label></td>
                                                            <td>
                                                                <select name="DEPARTAMENTO">
                                                                    <option value="no_sel">Seleccione</option>
                                                                    <?PHP
                                                                    $r = "";
                                                                    $Q = "SELECT * FROM ID_DPT_PS";
                                                                    $RES = sqlsrv_query($conn, $Q);
                                                                    //oci_execute($RES);
                                                                    while ($RW = sqlsrv_fetch_array($RES)) {
                                                                        $NM_DPT_PS = strtoupper($RW["NM_DPT_PS"]);
                                                                        $r.='<option value="' . $RW["CD_DPT_CER"] . '">' . $NM_DPT_PS . '</option>';
                                                                    }
                                                                    echo $r;
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="TP_TARJ">Tipo Tarjeta</label></td>
                                                            <td><select name="TP_TARJ">
                                                                    <option value="no_sel">Seleccione</option>
                                                                    <?php
                                                                    $r = "";
                                                                    $Q = "SELECT * FROM CO_TIPO_TARJETA";
                                                                    $RES = sqlsrv_query($conn, $Q);
                                                                    //oci_execute($RES);
                                                                    while ($RW = sqlsrv_fetch_array($RES)) {
                                                                        $DESC_TP_TARJ = strtoupper($RW["DESC_TP_TARJ"]);
                                                                        $r.='<option value="' . $RW["TP_TARJ"] . '">' . $DESC_TP_TARJ . '</option>';
                                                                    }
                                                                    echo $r;
                                                                    ?>
                                                                </select></td>
                                                            <td class="left"><label for="TY_TND">Medio de Pago Asociado</label></td>
                                                            <td><select name="TY_TND">
                                                                    <option value="no_sel">Seleccione</option>
                                                                    <?php
                                                                    $r = "";
                                                                    $Q = "SELECT * FROM AS_TND";
                                                                    $RES = sqlsrv_query($conn, $Q);
                                                                    //oci_execute($RES);
                                                                    while ($RW = sqlsrv_fetch_array($RES)) {
                                                                        $DE_TND = strtoupper($RW["DE_TND"]);
                                                                        $r.='<option value="' . $RW["TY_TND"] . '">' . $DE_TND . '</option>';
                                                                    }
                                                                    echo $r;
                                                                    ?>
                                                                </select></td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="FLAG_BONO_SOL">Bono Solidario</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="FLAG_BONO_SOL"  name="FLAG_BONO_SOL" type="checkbox"  class="switch" value="1">
                                                                    <label style="text-align:left; color:#f1f1f1" for="FLAG_BONO_SOL">.</label>
                                                                </div>
                                                            </td>
                                                            <td><label for="P_PAG_RET">Pago con Retenci&oacute;n?</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="P_PAG_RET"  name="P_PAG_RET" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="P_PAG_RET">.</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="AC_PUNTOS">Acumula Puntos?</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="AC_PUNTOS"  name="AC_PUNTOS" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="AC_PUNTOS">.</label>
                                                                </div>
                                                            </td>
                                                            <td><label for="TARJ_PERMITIDA">Tarj. Permitida?</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="TARJ_PERMITIDA"  name="TARJ_PERMITIDA" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="TARJ_PERMITIDA">.</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="PR_MED_PAGO">Primer Medio de Pago?</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="PR_MED_PAGO"  name="PR_MED_PAGO" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="PR_MED_PAGO">.</label>
                                                                </div>
                                                            </td>
                                                            <td><label for="AUT_MANUAL">Autorizaci&oacute;n Manual?</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="AUT_MANUAL"  name="AUT_MANUAL" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="AUT_MANUAL">.</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><label for="FACT_REQ">Factura Requer.</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="FACT_REQ"  name="FACT_REQ" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="FACT_REQ">.</label>
                                                                </div>
                                                            </td>
                                                            <td style="display:none"><label for="PIN">Solicita Pin</label></td>
                                                            <td style="display:none">
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="PIN"  name="PIN" type="checkbox"  class="switch" value="1">
                                                                    <label style="text-align:left; color:#f1f1f1" for="PIN">.</label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                         <tr style="display:none">
                                                            <td><label for="CVC">Solicita CVC</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="CVC"  name="CVC" type="checkbox"  class="switch" value="1" >
                                                                    <label style="text-align:left; color:#f1f1f1" for="CVC">.</label>
                                                                </div>
                                                            </td>
                                                            <td><label for="MONTO_MAYOR">Impide Monto mayor a Trans.</label></td>
                                                            <td>
                                                                <div style="clear: both; margin: 0 10px 0 0;">
                                                                    <input id="MONTO_MAYOR"  name="MONTO_MAYOR" type="checkbox"  class="switch" value="1">
                                                                    <label style="text-align:left; color:#f1f1f1" for="MONTO_MAYOR">.</label>
                                                                </div>
                                                            </td>
                                                        </tr>                         
                                                        <tr>
                                                            <td></td>
                                                            <td><input name="INGRESAR" type="submit" value="Registrar">
                                                                <input name="LIMPIAR" type="reset" value="Limpiar">
                                                                <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_bines.php')"></td>
                                                        </tr>
                                                    
                                                </table>
                                                </form>
                                                <?php
                                                sqlsrv_close($conn);
                                            }
                                            if ($ACT <> "") {
                                                ?>
                                                <table style="margin:10px 20px; ">
                                                    <tr>
                                                        <td><?php
                                                            $CONSULTA = "SELECT * FROM CO_BINES WHERE ID_BINES=" . $ACT;
                                                            $RS = sqlsrv_query($conn, $CONSULTA);
                                                            //oci_execute($RS);
                                                            if ($row = sqlsrv_fetch_array($RS)) {
                                                                $BIN_TARJETA = $row["BIN_TARJETA"];
                                                                $LON_PAN = $row["LON_PAN"];
                                                                $COD_OPERACION = $row["COD_OPERACION"];
                                                                $FLAG_PROCESAMIENTO = $row["FLAG_PROCESAMIENTO"];
                                                                $FLAG_USUARIO = $row["FLAG_USUARIO"];
                                                                $CARD_PLAN_ID = $row["CARD_PLAN_ID"];
                                                                $NETWORK_ID = $row["NETWORK_ID"];
                                                                $TIPO_HOST = $row["TIPO_HOST"];
                                                                $TARJ_PERMITIDA = $row["TARJ_PERMITIDA"];
                                                                $PR_MED_PAGO = $row["PR_MED_PAGO"];
                                                                $AUT_MANUAL = $row["AUT_MANUAL"];
                                                                $FACT_REQ = $row["FACT_REQ"];
                                                                $DEPARTAMENTO = $row["DEPARTAMENTO"];
                                                                $ID_FRANQUEO = $row["ID_FRANQUEO"];
                                                                $FLAG_BONO_SOL = $row["FLAG_BONO_SOL"];
                                                                $TP_TARJ = $row["TP_TARJ"];
                                                                $P_PAG_RET = $row["P_PAG_RET"];
                                                                $DESCRIPCION = $row["DESCRIPCION"];
                                                                $AC_PUNTOS = $row["AC_PUNTOS"];
                                                                $TY_TND = $row["TY_TND"];
                                                                $DES_CLAVE = $row["DES_CLAVE"];
                                                                $RECORD_ID = $row["RECORD_ID"];
																$SEL_SUBV = $row["SUB_CARD_PLAN_ID"];
																
																$PIN = $row["PIN"];
                                                                $CVC = $row["CVC"];
																$MONTO_MAYOR = $row["MONTO_MAYOR"];
                                                            }
                                                            ?>
                                                            <p class="speech">Bin <?= $BIN_TARJETA ?></p>
                                                            <h3>Actualizar BINES</h3>
                                                            <form action="mant_bines_reg.php" method="post" name="formact" onSubmit="return validaingreso(this)" >
                                                            <table id="forma-registro">
                                                                
                                                                    <tr>
                                                                        <td><label for="RECORD_ID">ID Record</label></td>
                                                                        <td><input name="RECORD_ID" type="text" size="4" maxlength="2" value="<?= $RECORD_ID ?>"></td>
                                                                        <td><label for="BIN_TARJETA">BIN Tarjeta</label> </td>
                                                                        <td><input name="BIN_TARJETA" type="text" size="8" maxlength="6" value="<?= $BIN_TARJETA ?>" onKeyPress="return acceptNum(event);"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="LON_PAN">Longitud PAN</label></td>
                                                                        <td><input name="LON_PAN" type="text" size="6" maxlength="38" value="<?= $LON_PAN ?>"  onKeyPress="return acceptNum(event);" ></td>
                                                                        <td><label for="COD_OPERACION">C&oacute;d. Operaci&oacute;n</label></td>
                                                                        <td><select name="COD_OPERACION">
                                                                            <option value="A" <?php if($COD_OPERACION=="A"){ echo "selected";} ?>>Add/A&ntilde;adir</option>
                                                                            <option value="D" <?php if($COD_OPERACION=="D"){ echo "selected";} ?>>Delete/Borrar</option>
                                                                        </select></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="FLAG_USUARIO">Bandera de Usuario</label></td>
                                                                        <td><input name="FLAG_USUARIO" type="text" size="6" maxlength="4" value="<?= $FLAG_USUARIO ?>"></td>
                                                                        <td><label for="CARD_PLAN_ID">Card Plan ID</label></td>
                                                                         <td id="card_plan"><select name="CARD_PLAN_ID" onChange="cargar_subv(this.value)">
                                                                                <option value="no_sel">Seleccione</option>
                                                                                <?php
                                                                                $r = "";
                                                                                $CRD = "SELECT * FROM CO_CARD_PLAN";
                                                                                $RESC = sqlsrv_query($conn, $CRD);
                                                                                //oci_execute($RESC);
                                                                                while ($RW1 = sqlsrv_fetch_array($RESC)) {
                                                                                    $CARD_PLAN_ID = strtoupper((trim($CARD_PLAN_ID)));

                                                                                    if (strcmp($CARD_PLAN_ID, $RW1['CARD_ID']) !== 0) {
                                                                                        $r.='<option value="' . $RW1["CARD_ID"] . '">' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW1["CARD_ID"] . '" selected>' . $RW1["CARD_ID"] . ' - ' . $RW1["CARD_DESC"] . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>

                                                                            </select>
                                                                            <select name="SEL_SUBV" id="SEL_SUBV">
                                                                                <?php
                                                                                $r = "";
                                                                                $CRD = "SELECT * FROM SUB_CARD_PLAN_ID where CARD_ID='".$CARD_PLAN_ID."'";
                                                                                $RESC = sqlsrv_query($conn, $CRD);
                                                                                //oci_execute($RESC);
                                                                                while ($RW1 = sqlsrv_fetch_array($RESC)) {
                                                                                    $CARD_PLAN_ID = strtoupper((trim($CARD_PLAN_ID)));

                                                                                    if (strcmp($SEL_SUBV, $RW1['ID']) !== 0) {
                                                                                        $r.='<option value="' . $RW1["ID"] . '">' . $RW1["DESC_SUB"]  . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW1["ID"] . '" selected>' . $RW1["DESC_SUB"] . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>

                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="NETWORK_ID">ID Network</label></td>
                                                                        <td><input name="NETWORK_ID" type="text" size="3" maxlength="2" value="<?= $NETWORK_ID ?>"></td>
                                                                        <td><label for="TIPO_HOST">Tipo Host</label></td>
                                                                        <td><input name="TIPO_HOST" type="text" size="4" maxlength="3" value="<?= $TIPO_HOST ?>"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="ID_FRANQUEO">ID Franqueo</label></td>
                                                                        <td><input name="ID_FRANQUEO" type="text" size="3" maxlength="2" value="<?= $ID_FRANQUEO ?>"></td>
                                                                        <td><label for="DESCRIPCION">Descripci&oacute;n</label></td>
                                                                        <td><input name="DESCRIPCION" type="text" size="18" maxlength="15" value="<?= $DESCRIPCION ?>"></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="FLAG_PROCESAMIENTO">Bandera Proces.</label></td>
                                                                        <td>
                                                                            <select name="FLAG_PROCESAMIENTO">
                                                                                <option value="no_sel">Seleccione</option>
                                                                                <?php
                                                                                $r = "";
                                                                                $Q = "SELECT * FROM CO_FLAG_PROCES";
                                                                                $RES = sqlsrv_query($conn, $Q);
                                                                                //oci_execute($RES);
                                                                                while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                    $DES_PROCES = strtoupper($RW["DES_PROCES"]);
                                                                                    if ($FLAG_PROCESAMIENTO == $RW["FLAG_PROCESAMIENTO"]) {
                                                                                        $r.='<option value="' . $RW["FLAG_PROCESAMIENTO"] . '" selected>' . $DES_PROCES . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW["FLAG_PROCESAMIENTO"] . '">' . $DES_PROCES . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><label for="DEPARTAMENTO">Departamento</label></td>
                                                                        <td>
                                                                            <select name="DEPARTAMENTO">
                                                                                <option value="no_sel">Seleccione</option>
                                                                                <?PHP
                                                                                $r = "";
                                                                                $Q = "SELECT * FROM ID_DPT_PS";
                                                                                $RES = sqlsrv_query($conn, $Q);
                                                                                //oci_execute($RES);
                                                                                while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                    $NM_DPT_PS = strtoupper($RW["NM_DPT_PS"]);
                                                                                    if ($DEPARTAMENTO == $RW["CD_DPT_CER"] and $DEPARTAMENTO != "000000") {
                                                                                        $r.='<option value="' . $RW["CD_DPT_CER"] . '" selected>' . $NM_DPT_PS . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW["CD_DPT_CER"] . '">' . $NM_DPT_PS . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="TP_TARJ">Tipo Tarjeta</label></td>
                                                                        <td>
                                                                            <select name="TP_TARJ">
                                                                                <option value="no_sel">Seleccione</option>
                                                                                <?php
                                                                                $r = "";
                                                                                $Q = "SELECT * FROM CO_TIPO_TARJETA";
                                                                                $RES = sqlsrv_query($conn, $Q);
                                                                                //oci_execute($RES);
                                                                                while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                    $DESC_TP_TARJ = strtoupper($RW["DESC_TP_TARJ"]);
                                                                                    if ($TP_TARJ == $RW["TP_TARJ"]) {
                                                                                        $r.='<option value="' . $RW["TP_TARJ"] . '" selected>' . $DESC_TP_TARJ . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW["TP_TARJ"] . '">' . $DESC_TP_TARJ . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><label for="TY_TND">Medio de Pago Asociado</label></td>
                                                                        <td>
                                                                            <select name="TY_TND">
                                                                                <option value="no_sel">Seleccione</option>
                                                                                <?php
                                                                                $r = "";
                                                                                $Q = "SELECT * FROM AS_TND";
                                                                                $RES = sqlsrv_query($conn, $Q);
                                                                                //oci_execute($RES);
                                                                                while ($RW = sqlsrv_fetch_array($RES)) {
                                                                                    $DE_TND = strtoupper($RW["DE_TND"]);
                                                                                    if ($TY_TND == $RW["TY_TND"]) {
                                                                                        $r.='<option value="' . $RW["TY_TND"] . '" selected>' . $DE_TND . '</option>';
                                                                                    } else {
                                                                                        $r.='<option value="' . $RW["TY_TND"] . '">' . $DE_TND . '</option>';
                                                                                    }
                                                                                }
                                                                                echo $r;
                                                                                ?>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="FLAG_BONO_SOL">Bono Solidario</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="FLAG_BONO_SOL"  name="FLAG_BONO_SOL" type="checkbox"  class="switch" value="1" <?PHP
                                                                                if ($FLAG_BONO_SOL == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="FLAG_BONO_SOL">.</label>
                                                                            </div>
                                                                        </td>
                                                                        <td><label for="P_PAG_RET">Pago con Retenci&oacute;n?</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="P_PAG_RET"  name="P_PAG_RET" type="checkbox"  class="switch" value="1" <?PHP
                                                                                if ($P_PAG_RET == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="P_PAG_RET">.</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="AC_PUNTOS">Acumula Puntos?</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="AC_PUNTOS"  name="AC_PUNTOS" type="checkbox"  class="switch" value="1" <?PHP
                                                                                if ($AC_PUNTOS == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="AC_PUNTOS">.</label>
                                                                            </div>
                                                                        </td>
                                                                        <td><label for="TARJ_PERMITIDA">Tarj. Permitida?</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="TARJ_PERMITIDA"  name="TARJ_PERMITIDA" type="checkbox"  class="switch" value="1" <?PHP
                                                                                if ($TARJ_PERMITIDA == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="TARJ_PERMITIDA">.</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="PR_MED_PAGO">Primer Medio de Pago?</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="PR_MED_PAGO"  name="PR_MED_PAGO" type="checkbox"  class="switch" value="1" <?PHP
                                                                                if ($PR_MED_PAGO == 1) {
                                                                                    echo "checked";
                                                                                }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="PR_MED_PAGO">.</label>
                                                                            </div>
                                                                        </td>
                                                                        <td><label for="AUT_MANUAL">Autorizaci&oacute;n Manual?</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="AUT_MANUAL"  name="AUT_MANUAL" type="checkbox"  class="switch" value="1" <?PHP
                                                                                   if ($AUT_MANUAL == 1) {
                                                                                       echo "checked";
                                                                                   }
                                                                                ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="AUT_MANUAL">.</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><label for="FACT_REQ">Factura Requer.</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="FACT_REQ"  name="FACT_REQ" type="checkbox"  class="switch" value="1" <?PHP
                                                                            if ($FACT_REQ == 1) {
                                                                                echo "checked";
                                                                            }
                                                                            ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="FACT_REQ">.</label>
                                                                            </div>
                                                                        </td>
                                                                        <td style="display:none"><label for="PIN">Solicita Pin</label></td>
                                                                        <td style="display:none">
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="PIN"  name="PIN" type="checkbox"  class="switch" value="1" <?php if($PIN==1) echo "checked"; ?>> 
                                                                                <label style="text-align:left; color:#f1f1f1" for="PIN">.</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                     <tr style="display:none">
                                                                        <td><label for="CVC">Solicita CVC</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="CVC"  name="CVC" type="checkbox"  class="switch" value="1" <?php if($CVC==1) echo "checked"; ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="CVC">.</label>
                                                                            </div>
                                                                        </td>
                                                                        <td><label for="MONTO_MAYOR">Impide Monto mayor a Trans.</label></td>
                                                                        <td>
                                                                            <div style="clear: both; margin: 0 10px 0 0;">
                                                                                <input id="MONTO_MAYOR"  name="MONTO_MAYOR" type="checkbox"  class="switch" value="1" <?php if($MONTO_MAYOR==1) echo "checked"; ?>>
                                                                                <label style="text-align:left; color:#f1f1f1" for="MONTO_MAYOR">.</label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>                      
                                                                    <tr>
                                                                        <td><input name="ID_BINES" type="hidden" value="<?= $ACT ?>" ></td>
                                                                        <td><input name="ACTUALIZAR" type="submit" value="Actualizar">
                                                                        <?php
                                                                        $CONSULTA = "SELECT * FROM CO_BINES WHERE ID_BINES=" . $ACT;
                                                                        $RS = sqlsrv_query($conn, $CONSULTA);
                                                                        //oci_execute($RS);
                                                                        if ($row = sqlsrv_fetch_array($RS)) {
                                                                            $ELIMINAR = 1;
                                                                        } else {
                                                                            $ELIMINAR = 0;
                                                                        }
                                                                        if ($ELIMINAR == 1) {
                                                                            ?>
                                                                                <input name="ELIMINAR" type="button" value="Eliminar" onClick="javascript:pagina('mant_bines_reg.php?ELM=1&ID_BINES=<?= $ACT ?>')">
                                                                        <?php } ?>
                                                                            <input name="SALIR" type="button" value="Salir" onClick="javascript:pagina('mant_bines.php')"></td>
                                                                    </tr>
                                                                
                                                            </table>
                                                            </form>
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
                </table>
    </table>
    <iframe name="frmHIDEN" width="0%" height="0" frameborder="0" align="top" src="" framespacing="0" marginheight="0" marginwidth="0">
    </iframe>
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
                        $r.='<option value="' . $RW["DES_CLAVE"] . '">' . $RW["DES_TIENDA"] . '</option>';
                }
                echo $r;
                ?>
            </select>
            
            <h3>Ruta Controlador: Archivo de Bines</h3>
            <input type="text" name="BIN_RUTA" ID="BIN_RUTA" size="27" value="C:\ADX_IDT1">
            
            <h3>Comando: Archivo de Bines</h3>
            <textarea rows="3" cols="40" name="CMD_BIN" id="CMD_BIN">C:\ADX_IPGM\ACEBITBL.386</textarea>
            
            <br><br>
            <input type="button" value="EXPORTAR" onClick="exportar();">

        </div>
        <div id="mensaje"> </div>
        <div id="overlay" style="display:none; z-index:9999"> <span><img src="../images/Preload.GIF" title="loading" width="80px"></span> </div>
    </div>

</body>
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
	function cargar_subv(val_card) {
        var dataString = 'CARD_ID=' + val_card;
        $.ajax({
            type: "GET",
            url: "load_subv.php",
            data: dataString,
            cache: false,
            success: function (response) {
				$("#SEL_SUBV").remove();
				$("#card_plan").append(response);
            }
        })
    }

    function exportar() {

        var cod_tienda = $("#TIENDA_EXPORT").val();
        var cmd_bin = $("#CMD_BIN").val();
        var bin_ruta = $("#BIN_RUTA").val();
        
        var dataString = 'COD_TIENDA=' + cod_tienda + '&CMD_BIN=' + cmd_bin +'&BIN_RUTA=' + bin_ruta;
        $("#overlay").css("display", "block");
        $.ajax({
            type: "GET",
            url: "bin_export.php",
            data: dataString,
            cache: false,
            success: function (response) {
                $("#overlay").css("display", "none");
                $("#mensaje").html('<div id="GMessaje" onClick="QuitarGMessage();"><a id="mens" href="javascript: void(0)" onClick="QuitarGMessage();" style="color:#111111;">Exportacion Exitosa</a></div>');
            }
        })
    }

</script>


