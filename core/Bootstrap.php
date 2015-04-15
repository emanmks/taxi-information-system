<?php

//File Bootstrap
//Lokasi : ../core/Bootstrap.php

class Bootstrap
{
	function __construct()
	{
		date_default_timezone_set('Asia/Makassar');
		$url = isset($_GET['url']) ? $_GET['url'] : NULL;
		$url = rtrim($url,'/');
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);
		
		
		//Untuk menentukan Default Controller
		if(empty($url[0]))
		{
			require APP . 'controllers/indexController.php';
			$controller = new index();
			$controller->loadModel('index');
			$controller->index();
			exit;
		}
		

		if($url[0] == 'index' || $url[0] == 'main')
		{
			require APP . 'controllers/indexController.php';
			$controller = new index();
			$controller->loadModel('index');
			
			if(isset($url[2]))
			{
				if(method_exists($controller,$url[1]))
				{
					$controller->{$url[1]}($url[2]);
				}
				else
				{
					$this->error();
				}
			}
			else
			{
				if(isset($url[1]))
				{
					if(method_exists($controller,$url[1]))
					{
						$controller->{$url[1]}();
					}
					else
					{
						$this->error();
					}
				}
				else
				{	
					$controller->index();
				}
			}
			
			exit;
		}
		
		//Untuk Controller Lainnya
		$file = APP . 'controllers/' . $url[0] . 'Controller.php';
		if(file_exists($file))
		{
			require $file;
		}
		else
		{
			$this->error();
			exit;
		}
		
		$controller = new $url[0]();
		$controller->loadModel($url[0]);
		
		//memanggil Methods yang ada di Controllers
		if(isset($url[3]))
		{
			if(method_exists($controller, $url[1]))
			{
				$controller->{$url[1]}($url[2],$url[3]);
			}else
			{
				$this->error();
			}
		}
		elseif(isset($url[2]))
		{
			if(method_exists($controller,$url[1]))
			{
				$controller->{$url[1]}($url[2]);
			}
			else
			{
				$this->error();
			}
		}
		else
		{
			if(isset($url[1]))
			{
				if(method_exists($controller,$url[1]))
				{
					$controller->{$url[1]}();
				}
				else
				{
					$this->error();
				}
			}
			else
			{	
				$controller->index();
			}
		}
		
	}
	
	function error()
	{
		require APP . 'controllers/errorController.php';
		$controller = new Error();
		$controller->index();
		exit;
	}

}

//End of File