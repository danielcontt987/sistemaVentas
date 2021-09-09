<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class ProductController extends Component
{
	use WithPagination;
	use WithFileUploads;

	public $name, $barcode,	$cost, $price, $stock, $alerts,	$image,	$description, $categoryid, $selected_id, $pageTitle, $componentName, $search;

	private $pagination = 5;

	public function paginationView(){
		return'vendor.livewire.bootstrap';
	} 

	public function mount(){
		$this->pageTitle='Listado';
		$this->componentName="Productos";
		$this->categoryid='Elegir';
	}



    public function render()
    {
    	if(strlen($this->search) > 0)
    	     $products = Product::join('categories as c', 'c.id', 'products.category_id')
			    	     ->select('products.*', 'c.name as category')
			    	     ->where('products.barcode', 'like', '%' . $this->search . '%')
			    	     ->orWhere('c.name', 'like', '%' . $this->search . '%')
			    	     ->orderBy('products.name', 'asc')
			    	     ->paginate($this->pagination);

        else
        	$products = Product::join('categories as c', 'c.id', 'products.category_id')
    	               ->select('products.*', 'c.name as category')   	     
    	               ->paginate($this->pagination);


        return view('livewire.products.product', [
         'data' => $products,
         'categories' => Category::orderBy('name', 'asc')->get()
          
        ])
         ->extends('layouts.theme.app')
        ->section('content');
    }

    public function Store(){
    	$rules =[
          'name' => 'required|unique:products|min:3',
          'cost' => 'required',
          'price' => 'required',
          'stock' => 'required',
          'alerts' => 'required',
          'categoryid' => 'required|not_in:Elegir'
    	];

    	$message = [
           'name.required' => 'Nombre del producto es requerido',
           'name.unique'=> 'Ya existe el nombre del producto',
           'name.min' => 'El nombre debe de tener al menos 3 caracteres',
           'cost.required' => 'El costo es requerido',
           'price.required' => 'El precio es requerido',
           'stock.required' => 'El stock es requerido',
           'alerts.required' => 'Ingresa el valor miínimo de existencias',
           'categoryid.not_in' => 'Elige un nombre de categoria a elegir'
    	];

    	$this->validate($rules, $message);


    	$product = Product::create([
           'name' => $this->name,
           'cost' => $this->cost,
           'price' => $this->price,
           'barcode' => $this->barcode,
           'stock' => $this->stock,
           'alerts' => $this->alerts,
           'category_id' => $this->categoryid
    	]);

    	$customFileName;

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/productos', $customFileName);
            $product->image = $customFileName;
            $product->save();
        }

    	

    	$this->resetUI();
    	$this->emit('product-added', 'Producto Registrada');
    }

        public function Edit($id){

        $record = Product::find($id, ['id','name','barcode','cost', 'price', 'stock', 'alerts', 'image', 'category_id']);
        $this->selected_id = $record->id;
        $this->name = $record->name;
        $this->barcode = $record->barcode;
        $this->cost = $record->cost;
        $this->price = $record->price;
        $this->stock = $record->stock;
        $this->alerts = $record->alerts;
        $this->categoryid = $record->category_id;
        $this->image = null;
        $this->emit('show', 'show modal!');

    }
    public function Update(){
    	$rules =[
          'name' => "required|min:3|unique:products,name,{$this->selected_id}",
          'cost' => 'required',
          'price' => 'required',
          'stock' => 'required',
          'alerts' => 'required',
          'categoryid' => 'required|not_in:Elegir'
    	];

    	$message = [
           'name.required' => 'Nombre del producto es requerido',
           'name.unique'=> 'Ya existe el nombre del producto',
           'name.min' => 'El nombre debe de tener al menos 3 caracteres',
           'cost.required' => 'El costo es requerido',
           'price.required' => 'El precio es requerido',
           'stock.required' => 'El stock es requerido',
           'alerts.required' => 'Ingresa el valor miínimo de existencias',
           'categoryid.not_in' => 'Elige un nombre de categoria a elegir'
    	];

    	$this->validate($rules, $message);

        $product = Product::find($this->selected_id);
    	$product->update([
           'name' => $this->name,
           'cost' => $this->cost,
           'price' => $this->price,
           'barcode' => $this->barcode,
           'stock' => $this->stock,
           'alerts' => $this->alerts,
           'category_id' => $this->categoryid
    	]);

    	$customFileName;

        if($this->image){
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/productos', $customFileName);
            $imageTemp = $product->image;
            $product->image = $customFileName;
            $product->save();

            if ($imageTemp !=null) {
            	if (file_exists('storage/products/' . $imageTemp)) {
            		unlink('storage/products/' . $imageTemp);
            	}
            }
        }

    	

    	$this->resetUI();
    	$this->emit('product-updated', 'Producto Actualizado');
    }




    public function resetUI(){
    	
    	
        $this->name = '';
        $this->image = null;
        $this->search = '';
        $this->selected_id = 0;
		$this->cost='';
		$this->price='';
		$this->barcode='';
		$this->stock='';
		$this->alerts='';
		$this->categoryid='Elegir';

    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Product $product)
    {
    	$imageTemp = $product->image;
    	$product->delete();

    	if($imageTemp =!null){
    		if (file_exists('storage/products/' . $imageTemp)) {
            		unlink('storage/products/' . $imageTemp);
            }
    	}

    	$this->resetUI();
    	$this->emit('product-deleted', 'producto eliminado');
    }    
}
