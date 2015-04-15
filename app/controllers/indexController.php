<?php

class Index extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$loggedStatus = Session::get('user_loggedIn');
		if($loggedStatus):
			$this->view->totalArmada = array_shift($this->model->getTotalArmada());
			$this->view->totalArmadaReady = array_shift($this->model->getTotalArmadaReady());
			$this->view->totalArmadaTrouble = array_shift($this->model->getTotalArmadaTrouble());
			$this->view->totalSRO = array_shift($this->model->getTotalSRO());
			$this->view->lastSRO = array_shift($this->model->getLastSRO());
			$this->view->render('home/index');
		else:
			$this->view->render('home/login');
		endif;
	}

	function login()
	{
		$this->model->login();
	}

	function logout()
	{
		Session::destroy();
	}
}