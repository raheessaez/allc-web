<?php
include("session.inc");
$INGRESAR=$_POST["INGRESAR"];
if ($INGRESAR<>"") {
		$ID_TARJ=strtoupper($_POST["ID_TARJ"]);		
		$MNT_MIN_CMP=$_POST["MNT_MIN_CMP"];
		$ID_GRUPO=$_POST["ID_GRUPO"];
		$CARD_ID_SEL=$_POST["CARD_ID"];
	//	$CTS_POSIBLES=$_POST["CTS_POSIBLES"];  
//		$cuotas="000000000000000000000000000000000000000000000000";  
//		
//		 for ($i = 0; $i <= strlen($cuotas); $i++) {
//         if($CTS_POSIBLES= $i){
//			 $cuotas=
//			}
//         } 
//		
		if(isset($_POST["RESTRICT_FECHAS"]))
		{
			$RESTRICT_FECHAS=1;
			$DIA_INICIO=$_POST["DIA_INICIO"];
			$MES_INICIO=$_POST["MES_INICIO"];
			$ANIO_INICIO=$_POST["ANIO_INICIO"];
			$DIA_FIN=$_POST["DIA_FIN"];
			$MES_FIN=$_POST["MES_FIN"];
			$ANIO_FIN=$_POST["ANIO_FIN"];
			$FECHA_INICIO=$ANIO_INICIO."-".$MES_INICIO."-".$DIA_INICIO;
			$FECHA_TERMINO=$ANIO_FIN."-".$MES_FIN."-".$DIA_FIN;
			
			
		}
		else
		{
			$dia_actual=date("d");
			$mes_actual=date("m");
			$anio_actual=date("Y");
			$FECHA=$anio_actual."-".$mes_actual."-".$dia_actual;
			$FECHA_INICIO=$FECHA;
			$FECHA_TERMINO=$FECHA;
			$RESTRICT_FECHAS=0;	
		}
		if(isset($_POST["PRT_DIF_INT"]))
		{
			$PRT_DIF_INT=$_POST["PRT_DIF_INT"];
		}
		else
		{
			$PRT_DIF_INT=0;
		}
		if(isset($_POST["DIF_PLUS"]))
		{
			$DIF_PLUS=$_POST["DIF_PLUS"];
		}
		else
		{
			$DIF_PLUS=0;
		}
		$MESES_GRACIA=0;
		if(isset($_POST["PRT_MES_GRC"]))
		{
			$MESES_GRACIA=$_POST["PRT_MES_GRC"];
		}
		else
		{
			$MESES_GRACIA=0;
		}
		if(isset($_POST["PRT_MES_GRC"]) and $PRT_DIF_INT==0 and $DIF_PLUS == 0)
		{
			if(isset($_POST["MESES_GRACIA"]))
			{
				$MESES_GRACIA=$_POST["MESES_GRACIA"];
			}
		}
		if(strlen($ID_TARJ)==2)
		{
			$ID_TARJ_=$ID_TARJ."000";
		}
		elseif(strlen($ID_TARJ)==3)
		{
			$ID_TARJ_=$ID_TARJ."00";
		}
		elseif(strlen($ID_TARJ)==4)
		{
			$ID_TARJ_=$ID_TARJ."0";
		}
                
              
                
			$CONSULTA="SELECT ID_TARJ FROM CO_OP_PAGO WHERE ID_TARJ='".$ID_TARJ."00'";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			if ($row = sqlsrv_fetch_array($RS)) {
				header("Location: mant_op_pagos.php?NEO=1&MSJE=2");
			} else {
				
                        $C1="SELECT MAX(ID_OP) AS MAX FROM CO_OP_PAGO";
                                $RES1 = sqlsrv_query($conn, $C1);
                                //oci_execute($RES1);
                                if ($row1 = sqlsrv_fetch_array($RES1)) {
                                                $ID_OP=$row1['MAX']+1;
                                        } else {
                                                $ID_OP=1;
                                }
                                
                      $C2="INSERT INTO CO_OP_PAGO (ID_TARJ,PRT_DIF_INT,DIF_PLUS,PRT_MES_GRC,ID_GRUPO,CTS_POSIBLES,ID_OP,FECHA_INICIO, FECHA_TERMINO,SUB_CARD_PLAN_ID) ";
                        $C2=$C2." VALUES ('".$ID_TARJ_."',".$PRT_DIF_INT.",".$DIF_PLUS.",'".$MESES_GRACIA."','".$ID_GRUPO."','000000000000000000000000000000000000000000000000',".$ID_OP.",'".$FECHA_INICIO."','".$FECHA_TERMINO."',".$CARD_ID_SEL.")";
						
                       // $C2=$C2." VALUES ('".$ID_TARJ_."',".$PRT_DIF_INT.",".$DIF_PLUS.",'".$MESES_GRACIA."','000000000000000000000000000000000000000000000000',".$ID_OP.",'".$FECHA_INICIO."','".$FECHA_TERMINO."')";

                        $RES2 = sqlsrv_query($conn, $C2);
                        //oci_execute($RES2);

                        //REGISTRO DE ALTA

                        $SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
                        $SQLOG=$SQLOG."(1, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1180, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
                        $RSL = sqlsrv_query($maestra, $SQLOG);
                        //oci_execute($RSL);
                        header("Location: mant_op_pagos.php?ACT=".$ID_OP."&MSJE=3");
		}
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}				
$ACTUALIZAR=$_POST["ACTUALIZAR"];

if ($ACTUALIZAR<>"") {
		$ID_TARJ=trim(strtoupper($_POST["ID_TARJ"]));
		$ID_TARJ=substr($ID_TARJ,0,2);
		$ID_OP=$_POST["ID_OP"];
		$MNT_MIN_CMP=$_POST["MNT_MIN_CMP"];
		$ID_GRUPO=$_POST["ID_GRUPO"];
		$CARD_ID_SEL=$_POST["CARD_ID"];
		
		
		if(isset($_POST["RESTRICT_FECHAS"]))
		{
			$RESTRICT_FECHAS=1;
			$DIA_INICIO=$_POST["DIA_INICIO"];
			$MES_INICIO=$_POST["MES_INICIO"];
			$ANIO_INICIO=$_POST["ANIO_INICIO"];
			$DIA_FIN=$_POST["DIA_FIN"];
			$MES_FIN=$_POST["MES_FIN"];
			$ANIO_FIN=$_POST["ANIO_FIN"];
			$FECHA_INICIO=$ANIO_INICIO."-".$MES_INICIO."-".$DIA_INICIO;
			$FECHA_TERMINO=$ANIO_FIN."-".$MES_FIN."-".$DIA_FIN;		
		}
		else
		{
			$dia_actual=date("d");
			$mes_actual=date("m");
			$anio_actual=date("Y");
			$FECHA=$anio_actual."-".$mes_actual."-".$dia_actual;
			$FECHA_INICIO=$FECHA;
			$FECHA_TERMINO=$FECHA;
			$RESTRICT_FECHAS=0;	
		}
		
		if(isset($_POST["PRT_DIF_INT"]))
		{
			$PRT_DIF_INT=$_POST["PRT_DIF_INT"];
		}
		else
		{
			$PRT_DIF_INT=0;
		}
		if(isset($_POST["DIF_PLUS"]))
		{
			$DIF_PLUS=$_POST["DIF_PLUS"];
		}
		else
		{
			$DIF_PLUS=0;
		}
		$MESES_GRACIA=0;
		if(isset($_POST["PRT_MES_GRC"]))
		{
			$MESES_GRACIA=$_POST["PRT_MES_GRC"];
		}
		else
		{
			$MESES_GRACIA=0;
		}
		if(isset($_POST["PRT_MES_GRC"]) and $PRT_DIF_INT==0 and $DIF_PLUS == 0)
		{
			if(isset($_POST["MESES_GRACIA"]))
			{
				$MESES_GRACIA=$_POST["MESES_GRACIA"];
			}
		}
                
		$CTS_POS="";
		$CTS_=array();
		for($i=1;$i<=48;$i++)
		{
			if($i<10)
			{
				$pos="0".$i;
			}
			else
			{
				$pos=$i;
			}
			if(isset($_POST["CTS_POSIBLES".$pos]))
			{
				$CTS_POS.="1";
				$CTS_[]=$i;
			}
			else
			{
				$CTS_POS.="0";
			}
                        }
                        if(strlen($ID_TARJ)==2)
                        {
                                $ID_TARJ_=$ID_TARJ."000";
                        }
                        elseif(strlen($ID_TARJ)==3)
                        {
                                $ID_TARJ_=$ID_TARJ."00";
                        }
                        elseif(strlen($ID_TARJ)==4)
                        {
                                $ID_TARJ_=$ID_TARJ."0";
                        }
                
				$CA2="UPDATE CO_OP_PAGO SET ID_TARJ='".$ID_TARJ_."',PRT_DIF_INT=".$PRT_DIF_INT.", DIF_PLUS=".$DIF_PLUS.", PRT_MES_GRC='".$MESES_GRACIA."',ID_GRUPO='".$ID_GRUPO."',CTS_POSIBLES='".$CTS_POS."',FECHA_INICIO='".$FECHA_INICIO."',FECHA_TERMINO='".$FECHA_TERMINO."' WHERE ID_OP=".$ID_OP;
				//$CA2="UPDATE CO_OP_PAGO SET ID_TARJ='".$ID_TARJ_."',PRT_DIF_INT=".$PRT_DIF_INT.", DIF_PLUS=".$DIF_PLUS.", PRT_MES_GRC='".$MESES_GRACIA."',CTS_POSIBLES='".$CTS_POS."',FECHA_INICIO='".$FECHA_INICIO."',FECHA_TERMINO='".$FECHA_TERMINO."' WHERE ID_OP=".$ID_OP;
				
                $RS2 = sqlsrv_query($conn, $CA2);
				//oci_execute($RS2);
				
				 $CONSUB="SELECT * from SUB_CARD_PLAN_ID where id = (select SUB_CARD_PLAN_ID from CO_OP_PAGO where ID_OP=".$ID_OP.")";
				 $SUB = sqlsrv_query($conn, $CONSUB);
				if ($rowsub = sqlsrv_fetch_array($SUB)) {
                        $SUBVA = $rowsub["DESC_SUB"];
						
		                  
                 }
				 if(empty($SUBVA)){
					 $SUBVA ="00";
					 }
				
				
				$C2="DELETE FROM DET_OP_PAGO WHERE ID_OP=".$ID_OP;
				$RS2 = sqlsrv_query($conn, $C2);
				//oci_execute($RS2);
				
				for($i=0;$i<count($CTS_);$i++)
				{
					$MS_GRACIA=trim($MESES_GRACIA);
					
					$MNT_MIN_CMP="";
					
					$ID_OP_PADRE=$ID_OP;
                                        
					if($CTS_[$i]<10)
					{
						$pos="0".$CTS_[$i];
					}
					else
					{
						$pos=$CTS_[$i];
					}
					if(isset($_POST["MNT_MIN_CTS_SEL".$pos]) and $_POST["MNT_MIN_CTS_SEL".$pos]!="")
					{
						$MNT_MIN_CMP=$_POST["MNT_MIN_CTS_SEL".$pos];
					}
					else
					{
						$MNT_MIN_CMP=0;
					}
					if($PRT_DIF_INT==1 || $DIF_PLUS==1)
					{
                                            
						if(isset($_POST["MES_GRC_CTS_SEL".$pos]))
						{
							$MS_GRACIA=$_POST["MES_GRC_CTS_SEL".$pos];
						}
						else
						{
							$MS_GRACIA=0;
						}
                                                
					}
					if($DIF_PLUS==1 || $PRT_DIF_INT==1)
					{
					
						if($CTS_[$i]<10)
						{
                                                        
							$ID_TARJ_N=$ID_TARJ."0".$CTS_[$i];
						}
						else
						{
							$ID_TARJ_N=$ID_TARJ.$CTS_[$i];
						}
						
                                                // Si es 1 = Diferido Plus, Si es 0 = Diferido con intereses
                                                if($DIF_PLUS==1){
                                                    
                                                    $TP_DIF = 1;
                                                    
                                                }else{
                                                    
                                                    $TP_DIF = 0;
                                                    
                                                }
												
                       
						                        
						$FILLER="00000000000000000000000000000000000000000000000";
						$C4="INSERT INTO DET_OP_PAGO (ID_TARJ_N,MS_GRACIA,MNT_MIN_CMP,FILLER,ID_OP,TP_DIF,SUB_CARD)";
						$C4=$C4." VALUES ('".$ID_TARJ_N."',".$MS_GRACIA.",".$MNT_MIN_CMP.",'".$FILLER."',".$ID_OP_PADRE.",".$TP_DIF.",'".$SUBVA."')";
                                                
					}
					
					$RES4 = sqlsrv_query($conn, $C4);
					//oci_execute($RES4);
				}

                                                //REGISTRO DE MODIFICACION
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(3, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1180, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

				header("Location: mant_op_pagos.php?ACT=".$ID_OP."&MSJE=1");

//$ID_OP
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
			
$ELIMINAR=@$_GET["ELM"];


if ($ELIMINAR<>"") {
		$ID_OP=@$_GET["ID_OP"];
		
			$CONSULTA="DELETE FROM CO_OP_PAGO WHERE ID_OP='".$ID_OP."'";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);
			$CONSULTA="DELETE FROM DET_OP_PAGO WHERE ID_OP='".$ID_OP."'";
			$RS = sqlsrv_query($conn, $CONSULTA);
			//oci_execute($RS);

				//REGISTRO DE BAJA
					
						$SQLOG="INSERT INTO LG_EVENTO (COD_TIPO_EVENTO, FECHA, HORA, IP_CLIENTE, COD_USUARIO, IDACC, IDSISTEMA, IDPERFIL) VALUES ";
						$SQLOG=$SQLOG."(2, convert(datetime,GETDATE(), 121), '".$TIMESRV."', '".$IP_CLIENTE."', ".$SESIDUSU.", 1180, ".$SESIDSISTEMA.", ".$SESIDPERFIL.")";
						$RSL = sqlsrv_query($maestra, $SQLOG);
						//oci_execute($RSL);																	

			header("Location: mant_op_pagos.php?MSJE=4");
		sqlsrv_close($conn);
		sqlsrv_close($maestra);
}
?>