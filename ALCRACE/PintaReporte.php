

                                <style>
								#SoporteRACE {background-color:#FFF;padding:34px 0 40px 20px;overflow:visible;-khtml-border-radius: 4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;-moz-box-shadow: 0 1px 2px #999;-webkit-box-shadow: 0 1px 2px #999;box-shadow: 0 1px 2px #999;}
								#Reporte-RACE tr:nth-child(odd){ background: #FEFEFE; }
								#Reporte-RACE tr:nth-child(even){ background: #FAFAFA; }
								#Reporte-RACE td {padding:6px;}
								#Print-RACE {
									position:relative;
									float:right;
									top:-30px;
									width:34px;
									height:50px;
									background:url(../images/ICO_PrintNA.png) no-repeat left center;
									cursor:pointer;
									}
								#Print-RACE:hover {
									background:url(../images/ICO_PrintAC.png) no-repeat left center;
									}
								</style>
                                <?php
								$LOCAL=$_SESSION['TIENDA_SEL'];
								$ConRept = file($SYNC_OUT.$LOCAL."/adx_idt4/".$RPT);
								?>
                                <div id="SoporteRACE">
                                <div id="Print-RACE" title="Imprime Reporte"><a href="javascript: VentanaImprime('PrintRACE.php?Loc=<?=$LOCAL?>&Rpt=<?=$RPT?>');"><img src="../images/Transpa.png" width="100%" height="50px" border="none" /></a></div>
								<table id="Reporte-RACE">
								<?php
										
										foreach ($ConRept as $RowRept) {
											 if(trim($RowRept)!=""){
													 echo "<tr>";
													 echo "<td></td>";
													 echo "<td>";
														$RowRept = iconv("CP857", "ISO-8859-1", $RowRept);
														echo  "<pre>".$RowRept."</pre>";
													 echo "</td>";
													 echo "<td></td>";
													 echo "</tr>";
											 }
										}
										?>
				
								</table>
								</div>
