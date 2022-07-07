function confirma_exclusao(url){
	var c = confirm('Confirma a exclusão deste registro?');
	
	if(c){
		 document.location=url;	
	}
}