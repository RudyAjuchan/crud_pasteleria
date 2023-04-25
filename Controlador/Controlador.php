<?php 
class Controlador{
	public function modelo($modelo){
		require_once 'Modelo/'.$modelo.'.php';
		return new $modelo();
	}
	public function modelo2($modelo,$datos){
		require_once 'Modelo/'.$modelo.'.php';
		return new $modelo();
	}
	public function vista($vista,$datos){
		if (file_exists('Vista/'.$vista.'.php')) {
			require_once 'Vista/'.$vista.'.php';
		}else{
			echo "<script>alert('La vista no existe');</script>";
		}
		
	}
	public function vista2($vista){
		if(isset($_GET['url'])){
			$url= rtrim($_GET['url'],'/');
			$url= filter_var($url,FILTER_SANITIZE_URL);
			$url= explode('/',$url);
			$url= ucwords($url[1]);
			if (file_exists('Vista/'.$vista.'.php')) {
				require_once 'Vista/'.$vista.'.php';
			}else{				
				header("Location:  http://localhost:8070/crud_pasteleria/Page/error");
			}
		}else{
			require_once 'Vista/'.$vista.'.php';
		}
		
		
	}
}
?>