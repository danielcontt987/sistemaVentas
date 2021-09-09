<script type="text/javascript">
	var listener = new window.keypress.Listener();

	listener.simple_combo("b", function () {
		console.log('b')
		livewire.emit('saveSale')
	})


	listener.simple_combo("f8", function(){
		document.getElementById('cash').value='';
		document.getElementById('cash').focus();

	})

	listener.simple_combo("v", function(){ // control + v
		var total = parseFloat(document.getElementById('hiddenTotal').value);
		if(total>0){
			Confirmar(0,'clearCart', '¿Segur@ de eliminar esta venta?')
		}else{
           noty('Agrega productos a la venta');
		}



	})
</script>