<?php

class User extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->userLists = $this->model->getUserLists();
		$this->view->listPegawai = $this->model->getListPegawai();
		$this->view->render('user/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function resetPassword()
	{
		$this->model->resetPassword();
	}

	function updatePassword()
	{
		$this->model->updatePassword();
	}

	function setAkses()
	{
		$this->model->setAkses();
	}

	function delete()
	{
		$this->model->delete();
	}
}