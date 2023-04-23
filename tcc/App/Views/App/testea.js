var formatoPermitido = ".xml";

function teste (pFormulario){
	var nomearquivo = pFormulario.value;
	if(pFormulario.type=="file"){
	var tamanho = nomearquivo.length;
	tamanho = tamanho -4;
	var controle = nomearquivo.substr(tamanho,4);
	if (controle == ".xml"){	
		return true;
	} else {
	window.alert("FORMATO INVÁLIDO, SELECIONE UM ARQUIVO XML");
	return false;
	}
	}	
}

