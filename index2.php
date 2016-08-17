<?php
$serverName = "(local)\sa"; //serverName\instanceName
$connectionInfo = array( "Database"=>"SAADMIN", "UID"=>"sa", "PWD"=>"ALLC_0180");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}

?>