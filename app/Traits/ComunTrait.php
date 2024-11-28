<?php
namespace App\Traits;
use App\Models\Conjunto;
use App\Models\Perfil;
use App\Models\Distribuidor;

    /**
     * manejador de funciones comunes 
     *
     * un trait hereda los metodos descritos para ser usados en todos los controllers que se necesiten
     * 
     * 
     */

trait ComunTrait{
	public function generateRandomString($size){
			$numeros = range(0, 9);
			$letras_min = range('a','z');
			//$letras_may = range('A','Z');
			$data_array = join("",array_merge($numeros, $letras_min));
			
			$randomString = '';
			$charactersLength = strlen($data_array);
			for ($i = 0; $i < $size; $i++) {
				$randomString .= $data_array[rand(0, $charactersLength - 1)];
			}
			return $randomString;
	}
}
?>