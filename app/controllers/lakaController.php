<?php

class Laka extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listLaka = $this->model->getListLaka();
		$this->view->render('laka/index');
	}

	function detail($id)
	{
		$this->view->detailLaka = array_shift($this->model->getDetailLaka($id));
		$this->view->detailLoanLaka = array_shift($this->model->getDetailLoanLaka($id));
		$this->view->render('laka/detail', true);
	}

	function formAddNew()
	{
		$this->view->render('laka/formaddnew', true);
	}

	function save()
	{
		$this->model->saveDetailLaka();
	}

	function update()
	{
		$this->model->updateDetailLaka();
	}

	function lunasLoanLaka()
	{
		$this->model->lunasLoanLaka();
	}

	function delete()
	{
		$this->model->delete();
	}
}