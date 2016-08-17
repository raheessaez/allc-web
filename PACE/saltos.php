<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Documento sin título</title>
</head>

<body>
<?php
$file = file("../ALCARTS/mant_flagp.php");
foreach ($file as $RowRept) 
{
	if(trim($RowRept)!="")
	{
		$res.= $RowRept."<br>";
	}
}
?>
<textarea style="width:400px; height:500px;"><?=$res?></textarea>
</body>
</html>

</body>
</html>