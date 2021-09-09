<div class="row sales layout-top-spacing">
	<div class="col-sm"-12>
		<div class="widget widget-chart-one">
			<div class="widget-haeding">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				<ul class="tabs tab-pills">
					<li style="list-style:none" class="d-flex justify-content-end" >
						<a class="btn btn-dark tbmenu"href="javascript:void(0)" class="tabmenu bgdark" data-toggle="modal" data-target="#theModal">Agregar</a>
					</li>
				</ul>
			</div>
			@include('common.searchbox')
			<div class="widget-content">
				<div class="table-responsive">
					<table class="table table-bordered table striped mt-1">
						<thead class="text-white" style="background: #3b3f5c">
							<tr>
								<th class="table-th text-white text-center">NOMBRE</th>
								<th class="table-th text-white text-center">BARCODE</th>
								<th class="table-th text-white text-center">CATEGORIA</th>
								<th class="table-th text-white text-center">PRECIO</th>
								<th class="table-th text-white text-center">STOCK</th>
								<th class="table-th text-white text-center">INV.MIN</th>
								<th class="table-th text-white text-center">IMAGEN</th>
								<th class="table-th text-white text-center">ACCIONES</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $product)
							<tr>
								<td class="text-center"><h6>{{$product->name}}</h6></td>
								<td class="text-center"><h6>{{$product->barcode}}</h6></td>
								<td class="text-center"><h6>{{$product->category}}</h6></td>
								<td class="text-center"><h6>{{$product->price}}</h6></td>
								<td class="text-center"><h6>{{$product->stock}}</h6></td>
								<td class="text-center"><h6>{{$product->alerts}}</h6></td>
								
								<td class="text-center">
									<span>
										<img src="{{asset('storage/productos/' . $product->imagen)}}" alt="imagen de ejemplo" height="70" width="80" class="rounded">
									</span>
								</td>
								<td class="text-center">
									<a href="javascript:void(0)" wire:click.prevent="Edit('{{$product->id}}')" class="btn btn-dark mtmobile" title="edit">
										<i class="fas fa-edit"></i>
									</a>
									<a href="javascript:void(0)" onclick="Confirm('{{$product->id}}','{{$product->name}}')" class="btn btn-dark mtmobile" title="delete">
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
   @include('livewire.products.form')
</div>

<script type="text/javascript">
	

		/*
		window.livewire.on('product-added', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
			
		});
		window.livewire.on('product-updated', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos actualizados correctamente", "success");
		window.livewire.on('product-deleted', msg => {
			//noty
		});	
		window.livewire.on('modal-show', msg => {
			$('#theModal').modal('show')
		});	
		window.livewire.on('modal-hide', msg => {
			$('#theModal').modal('hide')
		});
		window.livewire.on('hidden.bs.modal', msg => {
			$('.er').css('display', 'none');
		});	*/

		
	document.addEventListener('DOMContentLoaded', function(){

		window.livewire.on('show', msg => {
			$('#theModal').modal('show')
		});

		window.livewire.on('product-added', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
			
		});

		window.livewire.on('product-updated', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos actualizados correctamente", "success");

			
		});

		
	});

	function Confirm(id, name) {

		    
			Swal.fire({
			  title: "¿Estás seguro?",
			  text: "El producto "+ name +" será eliminada",
			  type: "warning",
			  showCancelButton: true,
			  cancelButtonColor: '#fff',
			  confirmButtonColor: '#3b3f5c',
			  confirmButtonText: 'Aceptar'
			 }).then(function(result){
			 	if(result.value){
                   window.livewire.emit('deleteRow', id);
                   Swal.fire("Exitoso!", "La categoria ha sido eliminada correctamente", "success");
                   
			 	}
			 })
	}
</script>