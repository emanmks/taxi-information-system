<?php

class Transaksi extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listTransaksi = $this->model->getListTransaksi();
		$this->view->render('transaksi/index');
	}

	function save()
	{
		$this->model->saveTransaksi();
	}

	function update()
	{
		$this->model->updateTransaksi();
	}

	function bukti($transaksi)
	{
		$this->view->detailtransaksi = array_shift($this->model->getDetailTransaksi($transaksi));
		$this->view->render('transaksi/kwitansi', true);
	}

	function filter($tgl)
	{
		$this->view->listTransaksi = $this->model->getListFilteredTransaksi($tgl);
		$this->view->render('transaksi/filter', true);
	}

	function delete()
	{
		$this->model->delete();
	}
}