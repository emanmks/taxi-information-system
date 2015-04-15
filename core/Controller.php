<?php

class Controller
{
	function __construct()
	{
		$this->view = new View();
	}
	
	public function loadModel($name)
	{
		$path = APP . 'models/'.$name.'Model.php';
		
		if((empty($name)) || ($name == 'index') || ($name == 'main'))
		{
			require APP . 'models/indexModel.php';
			
			$modelName = 'indexModel';
			$this->model = new $modelName();
			return false;
		}
		
		if(file_exists($path))
		{
			require APP . 'models/'.$name.'Model.php';
			
			$modelName = $name.'Model';
			$this->model = new $modelName();
		}
	}
	
	function loadFunction($funcName, $strName)
	{
		$path = LIBS . $funcName .'Class.php';
		
		if(file_exists($path)):
			require $path;
			
			$functionName = $funcName . 'Class';
			$this->{$strName} = new $functionName();
		endif;
	}
	
	function restrict()
	{
		$logged = Session::get('admin_loggedIn');
		if ($logged == false) {
			Session::destroy();
			exit;
		}
	}
}