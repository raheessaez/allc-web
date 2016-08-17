function validaTienda(theForm){


		if (theForm.DES_TIENDA.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_TIENDA.focus();
			return false;
		}
		if (theForm.COD_CIUDAD.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_CIUDAD.focus();
			return false;
		}
		if (theForm.DIRECCION.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DIRECCION.focus();
			return false;
		}
		if (theForm.IP.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IP.focus();
			return false;
		}
} //validaTienda(theForm)

function validaNegocio(theForm){
		if (theForm.DES_NEGOCIO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_NEGOCIO.focus();
			return false;
		}
} //validaNegocio(theForm)

function validaCiudad(theForm){
		if (theForm.DES_CIUDAD.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_CIUDAD.focus();
			return false;
		}
} //validaCiudad(theForm)

function validaDepartamento(theForm){
	
		if (theForm.DES_DEPARTAMENTO.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_DEPARTAMENTO.focus();
			return false;
	}

} //validaDepartamento(theForm)

function validaPerfilUsuario(theForm){
		if (theForm.IDSISTEMA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IDSISTEMA.focus();
			return false;
		}

		if (theForm.IDPERFIL.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IDPERFIL.focus();
			return false;
		}
} //validaPerfilUsuario(theForm)

function validaTiendaUsuario(theForm){
		if (theForm.COD_NEGOCIO.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_NEGOCIO.focus();
			return false;
		}

		if (theForm.COD_TIENDA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.COD_TIENDA.focus();
			return false;
		}
} //validaTiendaUsuario(theForm)


function validaCorreo(inputStr){var atPos=inputStr.indexOf("@",0);var spacePos=inputStr.indexOf(" ",0);if (spacePos>0){return false;}	else if (atPos<0){return false;}else{var pointPos=inputStr.indexOf(".",atPos);if (pointPos==-1){return false;}else if (pointPos==inputStr.length-1){return false;}}return true;}

function validaUsuario(theForm){
		if (theForm.NOMBRE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMBRE.focus();
			return false;
	}
		if (theForm.EMAIL.value == ""){
				alert("COMPLETE EL CAMPO REQUERIDO.");
				theForm.EMAIL.focus();
				return false;
		} 
			else if (!validaCorreo(theForm.EMAIL.value)){
				alert("La direcci\xF3n de CORREO ingresada no es correcta.");
				theForm.EMAIL.focus();
				theForm.EMAIL.select();
				return false;
		}
	login = theForm.CUENTA.value;
	if (login.length < 5 || login.length > 200) {
		alert("LA CUENTA DEBE CONTENER SOBRE 5 CARACTERES");
		theForm.CUENTA.focus();
		return false;
		} else {
			for (i=0;i<login.length;i++) {
				c = login.substring(i,i+1);
				if (c == " ") {
					alert("LA CUENTA NO DEBE CONTENER ESPACIOS EN BLANCO");
					theForm.CUENTA.focus();
					return false;
				}
				if (c == "'") {
					alert("COMPLETE EL CAMPO REQUERIDO.");
					theForm.CUENTA.focus();
					return false;
				}
			}			
		}
		
		password = theForm.CLAVE.value;
		verificac = theForm.CLAVE_VER.value;
		if (password.length < 5 || password.length > 20) {
			alert("LA CLAVE DEBE CONTENER ENTRE 5 Y 20 CARACTERES");
			theForm.CLAVE.focus();
			return false;
		} else {
			for (i=0;i<password.length;i++) {
				c = password.substring(i,i+1);
				if (c == " ") {
					alert("LA CLAVE NO DEBE CONTENER ESPACIOS EN BLANCO");
					theForm.CLAVE.focus();
					return false;
				}
				if (c == "'") {
					alert("COMPLETE EL CAMPO REQUERIDO.");
					theForm.CLAVE.focus();
					return false;
				}
			}
			if (password!=verificac) {
					alert("LAS CLAVES DEBEN SER IGUALES, VERIFIQUE.");
					theForm.CLAVE.focus();
					return false;
			}
		}
		

} //validaUsuario(theForm)

function validaPerfil(theForm){
		if (theForm.IDSISTEMA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IDSISTEMA.focus();
			return false;
		}

		if (theForm.NOMBRE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMBRE.focus();
			return false;
		}
} //validaPerfil(theForm)

function validaModulo(theForm){
		if (theForm.IDSISTEMA.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.IDSISTEMA.focus();
			return false;
		}
		if (theForm.NOMBRE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMBRE.focus();
			return false;
		}
		if (theForm.ENLACE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.ENLACE.focus();
			return false;
		}
		if (theForm.TIPO.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.TIPO.focus();
			return false;
		}
} //validaModulo(theForm)

function validaSistema(theForm){
		if (theForm.NOMBRE.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NOMBRE.focus();
			return false;
		}
		if (theForm.CARPETA.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.CARPETA.focus();
			return false;
		}
		if (theForm.BDIP.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.BDIP.focus();
			return false;
		}
		if (theForm.BDUS.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.BDUS.focus();
			return false;
		}
		if (theForm.BDPS.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.BDPS.focus();
			return false;
		}
} //validaSistema(theForm)

function validaParametros(theForm){
		if (theForm.DES_PARAM.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_PARAM.focus();
			return false;
		}
		if (theForm.VAR_PARAM.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.VAR_PARAM.focus();
			return false;
		}
		if (theForm.VAL_PARAM.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.VAL_PARAM.focus();
			return false;
		}
		if (theForm.AMBITO.value == 0){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.AMBITO.focus();
			return false;
		}
} //validaParametros(theForm)

function validaValParam(theForm){
		if (theForm.DES_CLAVE.value == 9999){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.DES_CLAVE.focus();
			return false;
		}
		if (theForm.NEOVAL_PARAM.value == ""){
			alert("COMPLETE EL CAMPO REQUERIDO.");
			theForm.NEOVAL_PARAM.focus();
			return false;
		}
} //validaValParam(theForm)

