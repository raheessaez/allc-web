function setIframeHeight( objectId ){
var ifDoc, ifRef = document.getElementById( objectId );
try
{   ifDoc = ifRef.contentWindow.document.documentElement;  }
catch( e ) { try { ifDoc = ifRef.contentDocument.documentElement;  }
catch(ee) {   }  
}
if( ifDoc ){
ifRef.height = 1;  
ifRef.height = ifDoc.scrollHeight;
ifRef.width = 1;
ifRef.width = ifDoc.scrollWidth; 
}
}	
