<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Denomination extends Model
{
    use HasFactory;

    protected $fillable = ['type','value','image']; //llenado masivo en donde se van a llenar los campos

    public function denominations(){
   	 return $this->belogsTo(Denomination::class);
   }

    public function getImagenAttribute(){

  	   if($this->image !=null)
  	   	return(file_exists('storage/denominations/' . $this->image) ? $this->image: 'noimg.png');
  	   else
  	   	return 'noimg.png';
  	   
    }
}
