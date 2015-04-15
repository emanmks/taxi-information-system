<?php

class Parts extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	// Fungsi untuk Master Parts
	function index()
	{
		$this->view->listParts = $this->model->getListParts();
		$this->view->render('parts/index');
	}

	function save()
	{
		$this->model->saveDetailParts();
	}

	function updateDetail()
	{
		$this->model->updateDetailParts();
	}

	function delete()
	{
		$this->model->delete();
	}
	// End of Fungsi untuk Master Parts

	
	// Fungsi untuk Purchase Order
	function order()
	{
		$this->view->listOrder = $this->model->getListOrder();
		$this->view->render('parts/order');
	}

	function detailOrder($id)
	{
		$this->view->detailOrder = array_shift($this->model->getDetailOrder($id));
		$this->view->listDetailOrder = $this->model->getListDetailOrder($id);
		$this->view->listParts = $this->model->getListParts();
		$this->view->render('parts/orderdetail', true);
	}

	function addNewOrder()
	{
		$this->model->addNewOrder();
	}

	function addDetailOrder()
	{
		$this->model->addDetailOrder();
	}

	function updateDetailOrder()
	{
		$this->model->updateDetailOrder();
	}

	function approveOrder()
	{
		$this->model->approveOrder();
	}

	function removeOrder($id)
	{
		$this->model->removeOrder($id);
	}

	function removeDetailOrder()
	{
		$this->model->removeDetailOrder();
	}
	// End of Fungsi untuk Purchase Order

	//Fungsi-fungsi Opname
	function opname()
	{
		$this->view->listParts = $this->model->getListParts();
		$this->view->render('parts/opname');
	}

	function updateStock()
	{
		$this->model->updateStock();
	}

	//Fungsi-fungsi Pencairan
	function pencairan()
	{
		$this->view->listPencairan = $this->model->getListPencairan();
		$this->view->render('parts/pencairan');
	}

	function detailPencairan($id)
	{
		$this->view->detailPencairan = array_shift($this->model->getDetailPencairan($id));
		$this->view->listDetailPencairan = $this->model->getListDetailPencairan($id);
		$this->view->render('parts/pencairandetail', true);
	}

	function appPencairan()
	{
		$this->model->appPencairan();
	}

	//Fungsi-fungsi Supply
	function supply()
	{
		$this->view->listSupply = $this->model->getListSupply();
		$this->view->render('parts/supply');
	}

	function detailSupply($id)
	{
		$this->view->detailSupply = array_shift($this->model->getDetailSupply($id));
		$this->view->listDetailSupply = $this->model->getListDetailSupply($id);
		$this->view->render('parts/supplydetail', true);
	}

	function appSupply()
	{
		$this->model->appSupply();
	}
}