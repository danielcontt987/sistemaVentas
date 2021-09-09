           <div class="modal-footer">
              <button type="button" class="btn btn-default" wire:click.prevent="resetUI()" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
              
              @if($selected_id < 1)
              <button type="button" wire:click.prevent="Store()" class="btn btn-dark close-modal">Guardar</button>
              @else
              <button type ="button" wire:click.prevent="Update()" class="btn btn-dark close-modal"><i class="flaticon-cancel-12"></i> Actualizar </button>
              @endif
       </div>
      </div>
    </div>
  </div>  
</div>