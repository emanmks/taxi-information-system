<?php

class Perawatan extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listPerawatan = $this->model->getListPerawatan();
		$this->view->render('perawatan/index');
	}

	function details($id)
	{
		$this->view->detailPerawatan = array_shift($this->model->getDetailPerawatan($id));
		$this->view->listParts = $this->model->getListParts($id);
		$this->view->render('perawatan/detail', true);
	}

	function filter($tgl)
	{
		$this->view->listPerawatan = $this->model->getListFilteredPerawatan($tgl);
		$this->view->render('perawatan/filter', true);
	}

	function addnew()
	{
		$this->model->addNew();
	}

	function update()
	{
		$this->model->update();
	}

	function getListParts()
	{
		$this->model->getParts();
	}

	function addParts()
	{
		$this->model->addParts();
	}

	function updateParts()
	{
		$this->model->updateParts();
	}

	function delete()
	{
		$this->model->delete();
	}

	function deleteParts()
	{
		$this->model->deleteParts();
	}
}