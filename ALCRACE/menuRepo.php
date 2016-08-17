

<div style="width:300px; overflow:visible; background-color:#FFF">
<table width="100%">
<?php 
$CONSULTA="SELECT * FROM RA_NVL1 ORDER BY COD_NVL1 ASC";
$RS = sqlsrv_query($conn, $CONSULTA);
//oci_execute($RS);
while ($row = sqlsrv_fetch_array($RS)){
		$DES_ES_NVL1 =$row['DES_ES'];
		$COD_NVL1 = $row['COD_NVL1'];
?>
					<script>
                    function Ocultar<?php echo $COD_NVL1?>(){
						var CodNvl1 = <?php echo $COD_NVL1?>;
                        var MenuInact = document.getElementById("MN_INACT"+CodNvl1);
                        var MenuActivo = document.getElementById("MN_ACTIVO"+CodNvl1);
								MenuInact.style.display = "table-cell";
								MenuActivo.style.display = "none";
							<?php
							//MENU NIVEL 2
							$SQLO="SELECT * FROM RA_NVL2 WHERE COD_NVL1=".$COD_NVL1." ORDER BY COD_NVL2 ASC";
							$RSO = sqlsrv_query($conn, $SQLO);
							//oci_execute($RSO);
							while ($rowO = sqlsrv_fetch_array($RSO)){
									$COD_NVL2O = $rowO['COD_NVL2'];
							?>
							var CodNvl2 = <?php echo $COD_NVL2O?>;
							var MenuNVL2 = document.getElementById("SUBMNU"+CodNvl2);
									MenuNVL2.style.display = "none";
							<?php
							}
							?>
                    }
                    function Mostrar<?php echo $COD_NVL1?>(){
						var CodNvl1 = <?php echo $COD_NVL1?>;
                        var MenuInact = document.getElementById("MN_INACT"+CodNvl1);
                        var MenuActivo = document.getElementById("MN_ACTIVO"+CodNvl1);
                            MenuInact.style.display = "none";
                            MenuActivo.style.display = "table-cell";
							<?php
							//MENU NIVEL 2
							$SQLM="SELECT * FROM RA_NVL2 WHERE COD_NVL1=".$COD_NVL1." ORDER BY COD_NVL2 ASC";
							$RSM = sqlsrv_query($conn, $SQLM);
							//oci_execute($RSM);
							while ($rowM = sqlsrv_fetch_array($RSM)){
									$COD_NVL2M = $rowM['COD_NVL2'];
							?>
							var CodNvl2 = <?php echo $COD_NVL2M?>;
							var MenuNVL2 = document.getElementById("SUBMNU"+CodNvl2);
									MenuNVL2.style.display = "table-row";
							<?php
							}
							?>
							<?php
							//SELECCIONAR TODO LO DISTINTO AL MENU ACTIVO
							$SQLM2="SELECT COD_NVL1 FROM RA_NVL1 WHERE COD_NVL1<>".$COD_NVL1;
							$RSM2 = sqlsrv_query($conn, $SQLM2);
							//oci_execute($RSM2);
							while ($rowM2 = sqlsrv_fetch_array($RSM2)) {
								$NO_COD_NVL1M = $rowM2['COD_NVL1'];
								?>
									var NoCodNvl1 = <?php echo $NO_COD_NVL1M?>;
									var NoMenuInact = document.getElementById("MN_INACT"+NoCodNvl1);
									var NoMenuActivo = document.getElementById("MN_ACTIVO"+NoCodNvl1);
											NoMenuInact.style.display = "table-cell";
											NoMenuActivo.style.display = "none";
								<?php
									//MENU NIVEL 2
									$SQLM3="SELECT * FROM RA_NVL2 WHERE COD_NVL1=".$NO_COD_NVL1M." ORDER BY COD_NVL2 ASC";
									$RSM3 = sqlsrv_query($conn, $SQLM3);
									//oci_execute($RSM3);
									while ($rowM3 = sqlsrv_fetch_array($RSM3)){
											$NO_COD_NVL2O = $rowM3['COD_NVL2'];
									?>
									var NoCodNvl2 = <?php echo $NO_COD_NVL2O?>;
									var NoMenuNVL2 = document.getElementById("SUBMNU"+NoCodNvl2);
											NoMenuNVL2.style.display = "none";
									<?php
									}
							}
						?>
					}
                    </script>

<tr>
	<td id="MN_INACT<?php echo $COD_NVL1;?>" onmouseover='this.style.background="#F1F1F1"' onmouseout='this.style.background="#FFFFFF"' class="menu"  onClick="Mostrar<?php echo $COD_NVL1?>();" style="cursor:pointer"><?php echo $DES_ES_NVL1?></td>
	<td id="MN_ACTIVO<?php echo $COD_NVL1;?>" style="display:none; cursor:pointer; " class="menuActivo"  onClick="Ocultar<?php echo $COD_NVL1?>();"><?php echo $DES_ES_NVL1?></td>
</tr>
<?php
	$SQLSM="SELECT * FROM RA_NVL2 WHERE COD_NVL1=".$COD_NVL1." ORDER BY COD_NVL2 ASC";
	$RSSM = sqlsrv_query($conn, $SQLSM);
	//oci_execute($RSSM);
	while ($rowSM= sqlsrv_fetch_array($RSSM)){
			$DES_ES_NVL2 =$rowSM['DES_ES'];
			$COD_NVL2 = $rowSM['COD_NVL2'];
			?>
			<script>
                function ActivarSNV2<?php echo $COD_NVL2?>(){
                    var SCodNvl2 = <?php echo $COD_NVL2?>;
                    var MenuActivoNV2 = document.getElementById("CODN21"+SCodNvl2);
                    var MenuInactNV2 = document.getElementById("CODN20"+SCodNvl2);
                            MenuActivoNV2.style.display = "table-cell";
                            MenuInactNV2.style.display = "none";
					<?php
					//DESMARCAR TODO EL RESTO
					$SQLSM2="SELECT * FROM RA_NVL2 WHERE COD_NVL2<>".$COD_NVL2." ORDER BY COD_NVL2 ASC";
					$RSSM2 = sqlsrv_query($conn, $SQLSM2);
					//oci_execute($RSSM2);
					while ($rowSM2= sqlsrv_fetch_array($RSSM2)){
							$NO_COD_NVL2 = $rowSM2['COD_NVL2'];
					?>
					var NoSCodNvl2 = <?php echo $NO_COD_NVL2?>;
					var NoMenuActivoNV2 = document.getElementById("CODN21"+NoSCodNvl2);
					var NoMenuInactNV2 = document.getElementById("CODN20"+NoSCodNvl2);
							NoMenuActivoNV2.style.display = "none";
							NoMenuInactNV2.style.display = "table-cell";
					<?php
					}
					?>
                }
            </script>
    <tr id="SUBMNU<?php echo $COD_NVL2;?>" style="display:none; cursor:pointer; ">
    		<td id="CODN20<?php echo $COD_NVL2;?>" onClick="ActivarSNV2<?php echo $COD_NVL2?>(); pagina('repo4690.php?r1=<?php echo $COD_NVL1?>&r2=<?php echo $COD_NVL2?>&tnd=<?php echo $_SESSION['TIENDA_SEL']; ?>');" onmouseover='this.style.background="#F1F1F1"' onmouseout='this.style.background="#FFFFFF"' class="SubMenu" ><a href="repo4690.php?r1=<?php echo $COD_NVL1?>&r2=<?php echo $COD_NVL2?>&tnd=<?php echo $_SESSION['TIENDA_SEL']; ?>"><?php echo $DES_ES_NVL2?></a></td>
    		<td id="CODN21<?php echo $COD_NVL2;?>" style="display:none; background-color:#F1F1F1; font-weight:600; " class="SubMenu" onclick=" pagina('repo4690.php?r1=<?php echo $COD_NVL1?>&r2=<?php echo $COD_NVL2?>&tnd=<?php echo $_SESSION['TIENDA_SEL']; ?>');" ><a href="repo4690.php?r1=<?php echo $COD_NVL1?>&r2=<?php echo $COD_NVL2?>&tnd=<?php echo $_SESSION['TIENDA_SEL']; ?>"><?php echo $DES_ES_NVL2?></a></td>
    </tr>
<?php
	}
?>
<tr><td><img src="images/separador.png" width="100%" height="2" /></td></tr>
<?php
}
?>
<tr><td align="center" valign="top" style="padding:20px 10px 40px 10px; background:url(../images/logo.png) no-repeat center center"><img src="../images/transpa.png" width="100px" /></td></tr>
</table>
</div>
<img src="images/Transpa.png" alt="" width="200px" height="1px" />