
<div class="row sales layout-top-spacing">
	<div class="col-sm-12">
		<div class="widget widget-chart-one">
			<div class="widget-haeding">
				<h4 class="card-title">
					<b>{{$componentName}} | {{$pageTitle}}</b>
				</h4>
				@can('categoria_crear')
					<ul class="tabs tab-pills">
						<li style="list-style:none" class="d-flex justify-content-end">
							<a href="javascript:void(0)" 
							class="btn btn-dark tbmenu" 
							data-toggle="modal" 
							data-target="#theModal">Agregar</a>
						</li>
					</ul>
				@endcan
			</div>
			@can('categoria_buscar')
				@include('common.searchbox')
			@endcan

			<div class="widget-content">
				<div class="table-responsive">
					<table class="table table-bordered table striped mt-1">
						<thead class="text-white" style="background: #3b3f5c">
							<tr>
								<th class="table-th text-white text-center">DESCRIPCIÓN</th>
								<th class="table-th text-white text-center">IMAGEN</th>
								<th class="table-th text-white text-center">ACCIONES</th>
							</tr>
						</thead>
						<tbody>
							@foreach($categories as $category)
							<tr>
								<td><h6 class="text-center">{{$category->name}}</h6></td>
								<td class="text-center">
									<span>
										<img src="{{asset('storage/categorias/' . $category->imagen)}}" alt="imagen de ejemplo" height="150" width="200" class="rounded">
									</span>
								</td>
								<td class="text-center">
									@can('categoria_actualizar')
										<a href="javascript:void(0)" wire:click="Edit({{$category->id}})"
											class="btn btn-dark mtmobile" title="edit">
											<i class="fas fa-edit"></i>
										</a>
									@endcan
									
									@can('categoria_eliminar')
										<a href="javascript:void(0)" onclick="Confirmar('{{$category->id}}', '{{$category->products->count()}}', '{{$category->name}}')" class="btn btn-dark mtmobile" title="delete">
											<i class="fas fa-trash"></i>
										</a>
									@endcan								
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					{{$categories->links()}}
				</div>
			</div>
		</div>
	</div>
   @include('livewire.category.form')
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){

		window.livewire.on('show-modal', msg => {
			$('#theModal').modal('show')
		});

		window.livewire.on('category-added', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos guardados correctamente", "success");
			
		});

		window.livewire.on('category-updated', msg => {
			$('#theModal').modal('hide')
			Swal.fire("Exitoso!", "Datos actualizados correctamente", "success");

			
		});

		
	});

	function Confirmar(id, products, name) {

		    if (products > 0) {
               Swal.fire('Upps!', 'No se puede eliminar la categoria porque tiene productos relacionados', 'info')
               return;
		    }
		  

			Swal.fire({
			  title: "¿Estás seguro?",
			  text: "La categoria "+ name +" será eliminada",
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

