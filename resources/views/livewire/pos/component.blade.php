<div>
    <style type="text/css"></style>

    <div class="row layout-top-spacing">
    	<div class="col-sm-12 col-md-8">
    		<!--Detalles-->
    		@include('livewire.pos.partials.details')
    	</div>	
    		<div class="col-sm-12 col-md-4">
    			<!--Total-->
    			@include('livewire.pos.partials.total')
    			<!--Denominations-->
    			@include('livewire.pos.partials.coins')
    		</div>
    </div>
    <livewire:modal-search>
</div>

<script src="{{ asset ('js/key.js') }}"></script>
<script src="{{ asset('js/onscan.js') }}"></script>

<script>
    
try{

    onScan.attachTo(document, {
    suffixKeyCodes: [13],
    onScan: function(barcode) {
        console.log(barcode)
        window.livewire.emit('scan-code', barcode)
    },
    onScanError: function(e){
        console.log(e)
    }
})

    console.log('Scanner ready!')


} catch(e){
    console.log('Error de lectura: ', e)
}


</script>

@include('livewire.pos.scripts.shortcuts')
@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.general')


