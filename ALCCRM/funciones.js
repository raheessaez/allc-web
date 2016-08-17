
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
 

function calcular_edad(dia_nacim,mes_nacim,anio_nacim)
{

    fecha_hoy = new Date();
    ahora_anio = fecha_hoy.getYear();
    ahora_mes = fecha_hoy.getMonth();
    ahora_dia = fecha_hoy.getDate();
    edad = (ahora_anio + 1900) - anio_nacim;
		if ( ahora_mes < (mes_nacim - 1))  { edad--;}
		if (((mes_nacim - 1) == ahora_mes) && (ahora_dia < dia_nacim)){ edad--;}
	    if (edad > 1900) { edad -= 1900; }
		
		if ((edad>=18) && (edad<=99)) {
			return true;
		}

}  

 function ActivarNombre(val){
 	
	 	var TipoID = val;
		var Pos=TipoID.indexOf("|");
		var TipoPersona=val.substr(Pos+1);
        var Nombre0 = document.getElementById("NOMB_TIPOID_0");
        var ApellidoP0 = document.getElementById("APPP_TIPOID_0");
        var ApellidoM0 = document.getElementById("APPM_TIPOID_0");
        var Genero0 = document.getElementById("GENDER_TIPOID_0");
        var FecNac0 = document.getElementById("FECNAC_TIPOID_0");
        var TelPart0 = document.getElementById("TELPAR_TIPOID_0");
        var TelCel0 = document.getElementById("TELCEL_TIPOID_0");
        var Nombre1 = document.getElementById("NOMB_TIPOID_1");
		if(TipoPersona==0){
				Nombre0.style.display = "table-row";
				ApellidoP0.style.display = "table-row";
				ApellidoM0.style.display = "table-row";
				Genero0.style.display = "table-row";
				FecNac0.style.display = "table-row";
				TelPart0.style.display = "table-row";
				TelCel0.style.display = "table-row";
				Nombre1.style.display = "none";
		}
		if(TipoPersona==1){
				Nombre1.style.display = "table-row";
				Nombre0.style.display = "none";
				ApellidoP0.style.display = "none";
				ApellidoM0.style.display = "none";
				Genero0.style.display = "none";
				FecNac0.style.display = "none";
				TelPart0.style.display = "none";
				TelCel0.style.display = "none";
		}
        return true;
    }
	
	 function Activa_Hijo(val){
		 if (val>0){
			 var Edades = document.getElementById("EH");
			 Edades.style.display = "table-row";
			for (var i=1; i<=7; i++)
				  {
				 	 var IDEH='EH'+i;
					 var EdadHijo = document.getElementById(IDEH);
					 EdadHijo.style.display = "none";
				  }
			for (var i=1; i<=val; i++)
				  {
				 	 var IDEH='EH'+i;
					 var EdadHijo = document.getElementById(IDEH);
					 EdadHijo.style.display = "table-cell";
				  }
			return true;
		 }
		}
