<?php
if(isset($_POST["REGISTRAR"]))
	{
		 $SQL="SELECT * FROM PACE_CAMPO WHERE COD_NVL1=".$COD_NIVEL." ORDER BY UBICACION ASC";
        $RS = sqlsrv_query($conn, $SQL);
        //oci_execute($RS);
        while($row = sqlsrv_fetch_array($RS)) 
        {
			$TIPO_=$row["TIPO_CAMPO"];
			if(strtoupper(trim($TIPO_))!="ARRAY")
			{
				if(strtoupper(trim($TIPO_))=="BOOLEAN")
				{
					$control=$row["COD_CAMPO"];
					if(isset($_POST[$control]))
					{
						$valor_=1;
						$qry="Update PACE_CAMPO set VALOR='".$valor_."'";
						$qry.=" where COD_CAMPO=".$control;
					}
					else
					{
						$valor_=0;
						$qry="Update PACE_CAMPO set VALOR='".$valor_."'";
						$qry.=" where COD_CAMPO=".$control;
					}
				}
				elseif(strtoupper(trim($TIPO_))=="STRING")
				{
					$control=$row["COD_CAMPO"];
					$valor_=$_POST[$control];
					$qry="Update PACE_CAMPO set VALOR='".'"'.$valor_.'"'."'";
					$qry.=" where COD_CAMPO=".$control;
				}
				elseif(strtoupper(trim($TIPO_))=="UINT" || strtoupper(trim($TIPO_))=="ULONG" || strtoupper(trim($TIPO_))=="INT")
				{
					$control=$row["COD_CAMPO"];
					$valor_=$_POST[$control];
					$qry="Update PACE_CAMPO set VALOR='".$valor_."'";
					$qry.=" where COD_CAMPO=".$control;
				}
				$Res_ = sqlsrv_query($conn, $qry);
				//oci_execute($Res_);
			}
			else
			{
				$COD_=$row["COD_CAMPO"];
				$q="SELECT * FROM PACE_DCAMPO WHERE ID_PADRE =".$COD_." order by POSICION ASC";
				$r = sqlsrv_query($conn, $q);
				//oci_execute($r);
				
				while($rw = sqlsrv_fetch_array($r)) 
				{
					$query_="";
					$TIPO_C=$rw["TIPO"];
					if(strtoupper(trim($TIPO_C))=="BOOLEAN")
					{
						$control=$rw["ID_DCAMPO"];
						if(isset($_POST[$control]))
						{
							$valor_=1;
							$query_="Update PACE_DCAMPO set VALOR='".$valor_."'";
							$query_.=" where ID_DCAMPO=".$control;
						}
						else
						{
							$valor_=0;
							$query_="Update PACE_DCAMPO set VALOR='".$valor_."'";
							$query_.=" where ID_DCAMPO=".$control;
						}
					}
					elseif(strtoupper(trim($TIPO_C))=="STRING")
					{
						$control=$rw["ID_DCAMPO"];
						$valor_=$_POST[$control];
						$query_="Update PACE_DCAMPO set VALOR='".'"'.$valor_.'"'."'";
						$query_.=" where ID_DCAMPO=".$control;
					}
					elseif(strtoupper(trim($TIPO_C))=="UINT" || strtoupper(trim($TIPO_C))=="ULONG" || strtoupper(trim($TIPO_C))=="INT")
					{
						$control=$rw["ID_DCAMPO"];
						$valor_=$_POST[$control];
						$query_="Update PACE_DCAMPO set VALOR='".$valor_."'";
						$query_.=" where ID_DCAMPO=".$control;
					}
					$Rest = sqlsrv_query($conn, $query_);
					//oci_execute($Rest);
				}
			}
			
			
		}
		//if(isset($_POST["sel_"]))
//		{
//			$query_="select * from pace_def_det where id_Padre =".$_POST["sel_"]."";
//			$result = sqlsrv_query($conn, $query_);
//			//oci_execute($result);
//			$resp="";
//			while($row = sqlsrv_fetch_array($result)) 
//			{
//				echo $_POST[$row["COD_DEF_DETALLE"]];
//			}
//		}
	}

?>