
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-haeding">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				<ul class="tabs tab-pills">
					<li style="list-style:none" class="d-flex justify-content-end">
						<a href="javascript:void(0)" 
						class="btn btn-dark tbmenu" 
						data-toggle="modal" 
						data-target="#theModal">Agregar</a>
					</li>
				</ul>
			</div>
			@include('common.searchbox')

			<div class="widget-content">
				<div class="table-responsive">
					<table class="table table-bordered table striped mt-1">
						<thead class="text-white" style="background: #3b3f5c">
							<tr>
								<th class="table-th text-white text-center">TIPO</th>
								<th class="table-th text-white text-center">VALOR</th>
								<th class="table-th text-white text-center">IMAGEN</th>
								<th class="table-th text-white text-center">ACCIONES</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $coin)
							<tr>
								<td><h6 class="text-center">{{$coin->type}}</h6></td>
								<td><h6 class="text-center">${{number_format($coin->value,2)}}</h6></td>
								<td class="text-center">
									<span>
										<img src="{{asset('storage/denominations/' . $coin->imagen)}}" alt="imagen de ejemplo" height="50" width="100" class="rounded">
									</span>
								</td>
								<td class="text-center">
									<a href="javascript:void(0)" wire:click="Edit({{$coin->id}})"
									class="btn btn-dark mtmobile" title="edit">

										<i class="fas fa-edit"></i>
									</a>

									
									<a href="javascript:void(0)" onclick="Confirmar('{{$coin->id}}', '{{$coin->value}}')" class="btn btn-dark mtmobile" title="delete">
										<i class="fas fa-trash"></i>
									</a>
									
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$data->links()}}
				</div>
			</div>
		</div>
	</div>
   @include('livewire.coins.form')
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){

		window.livewire.on('item-added', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
			
		});

		window.livewire.on('item-updated', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
			
		});

		window.livewire.on('item-deleted', msg => {
			//noty
			
		});

		window.livewire.on('show', msg => {
			$('#theModal').modal('show')
		});

		window.livewire.on('modal-hide', msg => {
			$('#theModal').modal('hide')
		});

		$('#theModal').livewire.on('hidden.bs.modal', function(e){
			$('.er').css('display', 'none')
		})



		

		
	});

	function Confirmar(id, value) {

			Swal.fire({
			  title: "¿Estás seguro?",
			  text: "La denominación de "+ "$" + value +" será eliminada",
			  type: "warning",
			  showCancelButton: true,
			  cancelButtonColor: '#fff',
			  confirmButtonColor: '#3b3f5c',
			  confirmButtonText: 'Aceptar'
			 }).then(function(result){
			 	if(result.value){
                   window.livewire.emit('delete', id);
                   Swal.fire("Exitoso!", "La categoria ha sido eliminada correctamente", "success");
                   
			 	}
			 })
	}

	
</script>

