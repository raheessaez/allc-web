<?php include("headerhtml.inc"); ?>

<SCRIPT LANGUAGE="JavaScript">
function autoRefresh() {
   parent.location.href="index.php";
}
function refreshAdv(refreshTime,refreshColor) {
   setTimeout('autoRefresh()',refreshTime)
}
</SCRIPT>
</head>
<body onLoad="refreshAdv(3000,'#FFFFFF');">
<div class="contenedor">
        <img src="images/Ooppss.png"></div>
</body>
</html>

