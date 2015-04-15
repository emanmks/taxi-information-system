<?php

class Ownership extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listOwnership = $this->model->getListOwnership();
		$this->view->render('ownership/index');
	}

	function detail($id)
	{
		$this->view->detailOwnership = array_shift($this->model->getDetailOwnership($id));
		$this->view->render('ownership/detail', true);
	}

	function formAddNew()
	{
		$this->view->nomorRequest = $this->model->getNomorRequest();
		$this->view->render('ownership/formaddnew', true);
	}

	function save()
	{
		$this->model->saveDetailOwnership();
	}

	function approve()
	{
		$this->model->approveOwnership();
	}

	function finished()
	{
		$this->model->finishOwnershipPayment();
	}

	function unfinished()
	{
		$this->model->unFinishOwnershipPayment();
	}

	function delete()
	{
		$this->model->delete();
	}
}