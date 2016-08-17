
function ValidarFecha(Cadena){  
	var Fecha= new String(Cadena)

    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))  
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))  
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))  
  
    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){  
        return false  
    }  
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){  
        return false  
    }  
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){  
        return false  
    }  
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
        if (Mes==2 && Dia > 28 || Dia>30) {  
            return false  
			}
		}
		return true;
}
 
 
 function ActivarVentana(){
        var contenedor = document.getElementById("Ventana");
        contenedor.style.display = "block";
        return true;
    }
	
 function CerrarVentana(){
        var contenedor = document.getElementById("Ventana");
        contenedor.style.display = "none";
        return true;
    }


 function MostrarMenuGeneral(){
        var menu = document.getElementById("MenuGeneral");
        var pestanaOcl = document.getElementById("BTN-OcultarMenuGeneral");
        var pestanaVer = document.getElementById("BTN-VerMenuGeneral");
        menu.style.display = "table-cell";
        pestanaOcl.style.display = "block";
        pestanaVer.style.display = "none";
        return true;
    }
	
 function OcultarMenuGeneral(){
        var menu = document.getElementById("MenuGeneral");
        var pestanaOcl = document.getElementById("BTN-OcultarMenuGeneral");
        var pestanaVer = document.getElementById("BTN-VerMenuGeneral");
        menu.style.display = "none";
        pestanaOcl.style.display = "none";
        pestanaVer.style.display = "block";
        return true;
    }


 function ActivarMensajes(val, val2, ActBusq){
        var contenedor = document.getElementById("DatMensajes");
        contenedor.style.display = "block";
		var thevar = val;
		var maxpag = val2;
		var ActivaBusqueda = ActBusq;
		
		document.getElementById('DatMensajes').innerHTML = "<object type='text/html' data='tickets.php?dir="+thevar+"' id='MonitorIframe' onload='setIframeHeight(this.id)'></object>";
		if(ActivaBusqueda==1){
				var contenedor2 = document.getElementById("Paginado");
				contenedor2.style.display = "block";
				document.getElementById("ARCHIVO_SEL").value = thevar;
				document.getElementById("NUM_RE_PAG").value = -1;
				document.getElementById("NUM_AV_PAG").value = 1;
				document.getElementById("REPAG").disabled = true;
				document.getElementById("MAXPAG").value = maxpag; 
				document.getElementById("AVPAG").disabled = false;
		}
		if(ActivaBusqueda==0){
				var contenedor2 = document.getElementById("Paginado");
				contenedor2.style.display = "none";
		}
        return true;
    }
	
 function CerrarMensajes(){
        var contenedor = document.getElementById("DatMensajes");
        contenedor.style.display = "none";
        var contenedor2 = document.getElementById("Paginado");
        contenedor2.style.display = "none";
        return true;
    }

 function Pagina(val){
        var tipo= val;
		var maxpag = document.getElementById("MAXPAG").value;
		var archivo = document.getElementById("ARCHIVO_SEL").value;
		var ctp = document.getElementById("CTP").value;
		var num_re_pag = document.getElementById("NUM_RE_PAG").value
		var num_av_pag = document.getElementById("NUM_AV_PAG").value
		if (tipo==0) 
			{
				var paginar = '&paginar=' + num_re_pag + '&tipo=' + tipo;
				num_re_pag--;
				num_av_pag--; 
			} else {
				var paginar = '&paginar='+num_av_pag + '&tipo=' + tipo;
				num_re_pag++;
				num_av_pag++;
			}
			
		document.getElementById('DatMensajes').innerHTML = "<object type='text/html' data='tickets.php?dir="+archivo+paginar+"' id='MonitorIframe' onload='setIframeHeight(this.id)'></object>";
	    document.getElementById("NUM_RE_PAG").value = num_re_pag;
	    document.getElementById("NUM_AV_PAG").value = num_av_pag;
	    document.getElementById("MAXPAG").value = maxpag; 
		
		var totalpag=parseInt(maxpag/ctp);
		var saldopag=maxpag%ctp;
		
		if(num_av_pag<totalpag) {
				document.getElementById("AVPAG").disabled = false;
			} 
		if(num_av_pag==totalpag && saldopag==0) {
				document.getElementById("AVPAG").disabled = true;
			} 
		if(num_av_pag==totalpag && saldopag>0) {
				document.getElementById("AVPAG").disabled = false;
			} 
		if(num_av_pag>totalpag && saldopag>0) {
				document.getElementById("AVPAG").disabled = true;
			}

		if(num_re_pag==-1) {
				document.getElementById("REPAG").disabled = true;
			} else {
				document.getElementById("REPAG").disabled = false;
			}
				
	    return true;
    }
	


	
 function ActivarSearchDAT(){
        var contenedor = document.getElementById("SearchDAT");
        contenedor.style.display = "block";
		var archivo = document.getElementById("ARCHIVO_SEL").value;
		document.getElementById('SearchMensajes').innerHTML = "<object type='text/html' data='tickets_Search.php?dir="+archivo+"' id='SearchMonitorIframe' onload='setIframeHeight(this.id)'></object>";
        return true;
    }
	
 function CerrarSearchDAT(){
        var contenedor = document.getElementById("SearchDAT");
        contenedor.style.display = "none";
        return true;
    }


 function ActivarSearchJournal(val, diasel, local, anio, mes, buscar){
        var contenedor = document.getElementById("SearchJournal");
        contenedor.style.display = "block";
		document.getElementById('Journal').innerHTML = "<object type='text/html' data='Journal.php?celda="+val+"&diasel="+diasel+"&local="+local+"&anio="+anio+"&mes="+mes+"&buscar="+buscar+" ' id='SearchJuornalIframe' onload='setIframeHeight(this.id)'></object>";
       
	   
	    return true;
    }
	
 function CerrarSearchJournal(){
        var contenedor = document.getElementById("SearchJournal");
        contenedor.style.display = "none";
        return true;
    }


	function setIframeHeight( objectId )
	{
	 var ifDoc, ifRef = document.getElementById( objectId );
	
	 try
	 {   
	  ifDoc = ifRef.contentWindow.document.documentElement;  
	 }
	 catch( e )
	 { 
	  try
	  { 
	   ifDoc = ifRef.contentDocument.documentElement;  
	  }
	  catch(ee)
	  {   
	  }  
	 }
	 
	 if( ifDoc )
	 {
	  ifRef.height = 1;  
	  ifRef.height = ifDoc.scrollHeight;
	  
	  ifRef.width = 1;
	  ifRef.width = ifDoc.scrollWidth; 
	 }
	}	
	
