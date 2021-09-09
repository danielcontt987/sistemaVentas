<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','barcode','cost', 'price', 'stock', 'alerts', 'image', 'category_id']; //llenado masivo en donde se van a llenar los campos

    public function products(){
   	 return $this->belogsTo(Category::class);
   }

    public function getImagenAttribute(){

  	   if($this->image !=null)
  	   	return(file_exists('storage/productos/' . $this->image) ? $this->image: 'noimg.png');
  	   else
  	   	return 'noimg.png';
  	   
    }
}


	


