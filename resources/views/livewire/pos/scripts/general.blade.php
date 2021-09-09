<script type="text/javascript">
	
	document.addEventListener('DOMContentLoaded', function(){

		

		$(".tblscroll").niceScroll();

	});
	
		

		



	function Confirmar(id, eventName, text) {

		  

			Swal.fire({
			  title: "¿Estás seguro?",
			  text: text,
			  type: "warning",
			  showCancelButton: true,
			  cancelButtonColor: '#fff',
			  confirmButtonColor: '#3b3f5c',
			  confirmButtonText: 'Aceptar'
			 }).then(function(result){
			 	if(result.value){
                   window.livewire.emit(eventName, id);
                   Swal.fire("Exitoso!", "producto ha sido eliminada correctamente", "success");
                   
			}
		})
	}

</script>