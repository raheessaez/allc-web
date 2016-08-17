			<script>
                $(document).ready(function() {
                        var posicion = $("#WindowItem").offset();
                });	
            </script>
            <div id="WindowItem" style="display:none">
                <div id="WindowItem-contenedor">
                        <span style="position:absolute; top:0; right:20px;">
                        <img src="../images/ICO_Close.png" border="0" onClick="CerrarSearchItem();" title="Cerrar ventana">
                        </span>
                        <h3><?php echo $LATIENDA_SI;?></h3>
                        <div id="BuscarItem">
										<?php
                                            $CTP_V=10;
                                            $LSUP_V=@$_GET["LSUP_V"];
                                            if ($LSUP_V=="") {
                                                $LSUP_V=$CTP_V;
                                            }
                                            $LINF_V=@$_GET["LINF_V"];
                                            if ($LINF_V=="") {
                                                $LINF_V=1;
                                            }
                                        
                                            $FLT_CD_ITM="";
                                            $BITEM=trim(strtoupper(@$_POST["BITEM"]));
                                            if (empty($BITEM)) { $BITEM=trim(strtoupper(@$_GET["BITEM"])) ;}
                                            if (!empty($BITEM)) {
                                                  $FLT_CD_ITM=" WHERE CD_ITM Like '%".$BITEM."%' OR (UPPER(LTRIM(NM_ITM)))  Like '%".strtoupper($BITEM)."%' "; 
                                            } 
                                        
												$FILTRO_TIENDA=" AND ID_ITM IN(SELECT ID_ITM FROM AS_ITM_STR WHERE ID_BSN_UN=".$ID_BSN_UN_SEL.") " ;
												$SQL="SELECT * FROM PA_STR_RTL WHERE ID_BSN_UN=".$ID_BSN_UN_SEL;
												$RS = sqlsrv_query($arts_conn, $SQL);
												//oci_execute($RS);
												if ($row = sqlsrv_fetch_array($RS)) {
													$CD_STR_RT = $row['CD_STR_RT'];
												}
		
                                        ?>
                                        <table id="Filtro" style="width:100%">
                                                  <tr>
                                                    <td>
                                                        <form action="print_flejes.php?NEO=1&V=1" method="post" name="frmbuscar" id="frmbuscar">

                                                                   <input type="hidden" name="COD_NEGOCIO_SI" value="<?php echo $COD_NEGOCIO_SEL ?>" />
                                                                   <input type="hidden" name="COD_TIENDA_SI" value="<?php echo $COD_TIENDA_SEL ?>" />
                                                                   <input type="hidden" name="COD_FTIPO_SI" value="<?php echo $COD_FTIPO_SEL ?>" />


                                                                   <input type="hidden" name="FTIENDA" value="<?php echo $ID_BSN_UN_SEL ?>" />
                                                                   <input name="BITEM" type="text" id="BITEM" size="12" value="<?php echo $BITEM ?>">
                                                                   <input name="BUSCAR" type="submit" id="BUSCAR" value="Buscar Art&iacute;culo">
                                        
                                                        </form>
														<script>
                                                                document.frmbuscar.BITEM.focus();
                                                        </script>
                                                      </td>
                                                      </tr>
                                                      </table>
                                                      <?php if(!empty($BITEM)) {?>
                                                        <?php
                                                        $CONSULTA="SELECT COUNT(ID_ITM) AS CUENTA FROM AS_ITM ".$FLT_CD_ITM.$FILTRO_TIENDA;
                                                        $RS = sqlsrv_query($arts_conn, $CONSULTA);
                                                        //oci_execute($RS);
                                                        if ($row = sqlsrv_fetch_array($RS)) {
                                                            $TOTALREG = $row['CUENTA'];
                                                            $NUMTPAG = round($TOTALREG/$CTP_V,0);
                                                            $RESTO=$TOTALREG%$CTP_V;
                                                            $CUANTORESTO=round($RESTO/$CTP_V, 0);
                                                            if($RESTO>0 and $CUANTORESTO==0) {$NUMTPAG=$NUMTPAG+1;}
                                                            $NUMPAG = round($LSUP_V/$CTP_V,0);
                                                            if ($NUMTPAG==0) {
                                                                $NUMTPAG=1;
                                                                }
                                                        }
                                        
                                                        //$SQL="SELECT * FROM (SELECT  a.*, ROWNUM rnum FROM (SELECT * FROM AS_ITM ".$FLT_CD_ITM.$FILTRO_TIENDA." ORDER BY CD_ITM ASC) a WHERE ROWNUM <= ".$LSUP_V.") WHERE rnum >=  ".$LINF_V;
                                                        //$RS = sqlsrv_query($arts_conn, $SQL);
                                                        //oci_execute($RS);

                                                        $SQL= "SELECT * FROM (SELECT *,ROW_NUMBER() OVER (PARTITION BY ".$CTP." ORDER BY CD_ITM DESC) ROWNUMBER FROM AS_ITM ".$FLT_CD_ITM.$FILTRO_TIENDA.") AS TABLEWITHROWNUMBER WHERE ROWNUMBER BETWEEN ".$LINF." AND ".$LSUP."";
														echo $SQL;
                                                        $RS = sqlsrv_query($arts_conn, $SQL);
                                                       ?>
                                                        <table id="Listado" style="width:100%">
                                                        <tr>
                                                            <th>C&oacute;d. EAN</span></th>
                                                            <th>C&oacute;d. ACE</span></th>
                                                            <th>Nombre</span></th>
                                                            <th>Precio (<?php echo $MONEDA;?>)</span></th>
                                                        </tr>
                                                        <?php
                                                        while ($row = sqlsrv_fetch_array($RS)){
															
                                                                $ID_ITM = $row['ID_ITM'];
																$CD_ITM = $row['CD_ITM'];
																$NM_ITM = $row['NM_ITM'];
																
																if(empty($NM_ITM)){ $NM_ITM="SIN DESCRIP.";}
																$SQL1="SELECT * FROM AS_ITM_STR WHERE ID_ITM=".$ID_ITM;
																$RS1 = sqlsrv_query($arts_conn, $SQL1);
																//oci_execute($RS1);
																if ($row1 = sqlsrv_fetch_array($RS1)) {
																	$SLS_PRC = $row1['SLS_PRC'];
																}
																$SQL2="SELECT * FROM ID_PS WHERE  ID_ITM=".$ID_ITM;
																$RS2 = sqlsrv_query($arts_conn, $SQL2);
																//oci_execute($RS2);
																if ($row2 = sqlsrv_fetch_array($RS2)) {
																	$ID_ITM_PS = $row2['ID_ITM_PS'];
																}
																$PREC_ITM=$SLS_PRC/$DIVCENTS;
																$PREC_ITM=number_format($PREC_ITM, $CENTS, $GLBSDEC, $GLBSMIL);

                                                       ?>
                                                        <tr>
                                                            <td ><a href="print_flejes.php?NEO=1&ID_ITM=<?php echo $ID_ITM?>&ID_BSN_UN=<?php echo $FTIENDA?>&SLS_PRC=<?php echo $SLS_PRC?>&CD_STR_RT_F=<?php echo $CD_STR_RT_F?>&ID_ITM_PS=<?php echo $ID_ITM_PS?>&CD_ITM_SEL=<?php echo $CD_ITM?>&COD_NEGOCIO_SI=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA_SI=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO_SI=<?php echo $COD_FTIPO_SEL?>" style="font-size:12pt; font-weight:400"><?php echo $ID_ITM_PS?></a></td>
                                                            <td style="text-align:right;"><a href="print_flejes.php?NEO=1&ID_ITM=<?php echo $ID_ITM?>&ID_BSN_UN=<?php echo $FTIENDA?>&SLS_PRC=<?php echo $SLS_PRC?>&CD_STR_RT_F=<?php echo $CD_STR_RT_F?>&ID_ITM_PS=<?php echo $ID_ITM_PS?>&CD_ITM_SEL=<?php echo $CD_ITM?>&COD_NEGOCIO_SI=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA_SI=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO_SI=<?php echo $COD_FTIPO_SEL?>" style="font-size:12pt; font-weight:400"><?php echo $CD_ITM?></a></td>
                                                            <td><a href="print_flejes.php?NEO=1&ID_ITM=<?php echo $ID_ITM?>&ID_BSN_UN=<?php echo $FTIENDA?>&SLS_PRC=<?php echo $SLS_PRC?>&CD_STR_RT_F=<?php echo $CD_STR_RT_F?>&ID_ITM_PS=<?php echo $ID_ITM_PS?>&CD_ITM_SEL=<?php echo $CD_ITM?>&COD_NEGOCIO_SI=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA_SI=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO_SI=<?php echo $COD_FTIPO_SEL?>" style="font-size:12pt; font-weight:400"><?php echo $NM_ITM?></a></td>
                                                            <td style="text-align:right"><?php echo $PREC_ITM?></td>
                                                        </tr>
                                                        <?php
														$CUENTATD=$CUENTATD+1;
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td colspan="4" nowrap style="background-color:transparent">
                                                            <?php
                                                            if ($LINF_V>=$CTP_V+1) {
                                                                $ATRAS=$LINF_V-$CTP_V;
                                                                $FILA_ANT=$LSUP_V-$CTP_V;
                                                           ?>
                                                            <input name="ANTERIOR" type="button" value="Anterior"  onClick="pagina('print_flejes.php?NEO=1&V=1&LSUP_V=<?php echo $FILA_ANT?>&LINF_V=<?php echo $ATRAS?>&BITEM=<?php echo $BITEM?>&FTIENDA=<?php echo $FTIENDA?>&COD_NEGOCIO_SI=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA_SI=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO_SI=<?php echo $COD_FTIPO_SEL?>');">
                                                            <?php
                                                            }
                                                            if ($LSUP_V<=$TOTALREG) {
                                                                $ADELANTE=$LSUP_V+1;
                                                                $FILA_POS=$LSUP_V+$CTP_V;
                                                           ?>
                                                            <input name="SIGUIENTE" type="button" value="Siguiente" onClick="pagina('print_flejes.php?NEO=1&V=1&LSUP_V=<?php echo $FILA_POS?>&LINF_V=<?php echo $ADELANTE?>&BITEM=<?php echo $BITEM?>&FTIENDA=<?php echo $FTIENDA?>&COD_NEGOCIO_SI=<?php echo $COD_NEGOCIO_SEL?>&COD_TIENDA_SI=<?php echo $COD_TIENDA_SEL?>&COD_FTIPO_SI=<?php echo $COD_FTIPO_SEL?>');">
                                                            <?php }?>
                                                            <span style="vertical-align:baseline;">P&aacute;gina <?php echo $NUMPAG?> de <?php echo $NUMTPAG?></span>
                                                            </td>
                                                        </tr>
                                                        </table>
                                                        <?php } ?>
                        
                        </div>                        
                </div>
            </div>

