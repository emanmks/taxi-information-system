<?php

class Armada extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listArmada = $this->model->getListArmada();
		$this->view->render('armada/index');
	}

	function detail($id)
	{
		$this->view->detailArmada = array_shift($this->model->getDetailArmada($id));
		$this->view->detailPemilik = array_shift($this->model->getDetailPemilik($id));
		$this->view->detailKeuangan = array_shift($this->model->getDetailKeuangan($id));
		$this->view->render('armada/detail', true);
	}

	function formAddNew()
	{
		$this->view->render('armada/formaddnew', true);
	}

	function formUpdate($id)
	{
		$this->view->detailArmada = array_shift($this->model->getDetailArmada($id));
		$this->view->render('armada/formupdate', true);
	}

	function save()
	{
		$this->model->saveDetailArmada();
		$this->index();
	}

	function updateDetail()
	{
		$this->model->updateDetailArmada();
	}

	function updatePemilik()
	{
		$this->model->updatePemilikArmada();
	}

	function updateKeuangan()
	{
		$this->model->updateKeuanganArmada();
	}

	function delete()
	{
		$this->model->delete();
	}
}