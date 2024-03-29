<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use App\Models\SaleDetails;
use Carbon\Carbon;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PosController extends Component
{
	public $total,$itemsQuantity,$efectivo,$change;

    
    public function mount(){
    	$this->efectivo = 0;
    	$this->change = 0;
    	$this->total = Cart::getTotal();
    	$this->itemsQuantity = Cart::getTotalQuantity();
    }


    public function render(){
    	  $this->itemsQuantity = Cart::getTotalQuantity();
        return view('livewire.pos.component',[
           'denominations' => Denomination::orderBy('value', 'DESC')->get(),
           'cart' => Cart::getContent()->sortBy('name')
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Acash($value){
        $this->efectivo += ($value == 0 ? floatval($this->total) : floatval($value));
        $this->change = (floatval($this->efectivo) - floatval($this->total));
    }

    protected $listeners = [
      'scan-code' => 'ScanCode',
      'removeItem' => 'removeItem',
      'clearCart' => 'clearCart',
      'saveSale' => 'saveSale',
      'scan-code-byid' => "ScanCodeById"
    ];

    public function ScanCodeById(Product $product)
    {
        $this->increaseQty($product->id);
    }

    public function ScanCode($barcode, $cant = 1){
      //dd($barcode);
    	$product = Product::where('barcode', $barcode)->first();

    	if ($product == null || empty($product)) {
    		$this->emit('scan-notfound','El producto no esta registrado');
    	}else{
    		if ($this->InCart($product->id)) {
    			$this->increaseQty($product->id);
    			return;
    		}

    		if ($product->stock < 1) {
    			$this->emit('no-stock', 'Stock insuficiente D":');
    			return;
    		}

    		Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

    		$this->total = Cart::getTotal();

    		$this->emit('scan-ok', 'Producto Agregado');
    	}
    }
    public function InCart($productId){
    	$exist = Cart::get($productId);

    	if ($exist) 
    		return true;
    	else
    		return false;
    }

    public function increaseQty($productId, $cant = 1){
    	$title = '';
    	$product = Product::find($productId);
    	$exist = Cart::get($productId);
    	if ($exist){
        if ($product->stock < ($cant + $exist->quantity)){
          $this->emit('no-stock', 'Stock insuficiente :(');
          return;
        }else{
          $title = 'Cantidad actualizada';
        }
      }else{
    		$title = 'Producto Agregado';
      }

    	Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

    	$this->total = Cart::getTotal();
    	$this->itemsQuantity = Cart::getTotalQuantity();
      // dd($this->itemsQuantity);
    	$this->emit('scan-ok', $title);

    }

    public function updateQty($productId, $cant = 1){
      $title ='';
      $product = Product::find($productId);
      $exist = Cart::get($productId);
      if ($exist)
        $title = 'Cantidad actualizada';
        else
        $title = 'Producto Agregado';
      if ($exist) {
       if ($product->stock < $cant) {
         $this->emit('no-stock', 'Stock insuficiente D:');
         return;
       }
    }
     
      $this->removeItem($productId);

      if ($cant > 0) {
          Cart::add($product->id, $product->name, $product->price, $cant, $product->image);

          $this->total = Cart::getTotal();
          $this->itemsQuantity = Cart::getTotalQuantity();
          $this->emit('scan-ok', $title);
      }
     
     
    }  
    
    public function removeItem($productId){
      Cart::remove($productId);

      $this->total = Cart::getTotal();
      $this->itemsQuantity = Cart::getTotalQuantity();
      $this->emit('scan-ok', 'Producto eliminado');
   }

  

    public function decreaseQty($productId){
      $item = Cart::get($productId);
      Cart::remove($productId);

      $newQty = ($item->quantity) - 1;

      if($newQty > 0)
        Cart::add($item->id, $item->name, $item->price, $newQty, $item->attributes[0]);

             $this->total = Cart::getTotal();
         $this->itemsQuantity = Cart::getTotalQuantity();
         $this->emit('scan-ok', 'Cantidad Actualizada :D');
      
   }

   public function clearCart(){
     Cart::clear();
     $this->efectivo = 0;
     $this->change = 0;
     $this->total = Cart::getTotal();
     $this->itemsQuantity = Cart::getTotalQuantity();
     $this->emit('scan-ok', 'Carrito vacío');

   }

   public function saveSale(){
     
     if($this->total <= 0){
      $this->emit('sale-error', 'Agrega productos a la venta');
      return;
     }
     if($this->efectivo <= 0){
      $this->emit('sale-error', 'Ingresa el efectivo');
      return;
     }
     if($this->total > $this->efectivo){
      $this->emit('sale-error', 'El efectivo debe ser mayor al total');
      return;
     }

     DB::beginTransaction();
     try{
      $sale = Sale::create([
         'total' => $this->total,
         'items' => Cart::getTotalQuantity(),
         'cash' => $this->efectivo,
         'change' => $this->change,
         'created_at' => Carbon::now(),
         'updated_at' => Carbon::now(),
         'user_id' => Auth()->user()->id

      ]);

      if($sale){
         $items = Cart::getContent();
         foreach ($items as $item) {
           saleDetails::create([
            'price' => $item->price,
            'quantity' => $item->quantity,
            'product_id' => $item->id,
            'sale_id' => $sale->id,
           ]);

           //Update stock

           $product = Product::find($item->id);
           $product->stock = $product->stock - $item->quantity;
           $product->save();
         }
      }

      DB::commit();

      Cart::clear();

      $this->efectivo = 0;
      $this->change = 0;
      $this->total = Cart::getTotal();
      $this->itemsQuantity = Cart::getTotalQuantity();
      $this->emit('sale-ok', 'Venta registrada');
      $this->emit('print-ticket', $sale->id);

    }catch(Exception $e){

      DB::rollback();
      $this->emit('sale-error', $e->getMessage());

    }

    
   }

   public function printTicket($sale){
    return Redirect::to("ticket/$sale->id");
  }
   
}  
