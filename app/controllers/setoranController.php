<?php

class Setoran extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listSRO = $this->model->getListSRO();
		$this->view->listSetoran = $this->model->getListSetoran();
		$this->view->render('setoran/index');
	}

	function save()
	{
		$this->model->saveSetoran();
	}

	function kwitansi($setoran)
	{
		$this->view->detailSetoran = array_shift($this->model->getDetailSetoran($setoran));
		$preSaldo = array_shift($this->model->getDetailSetoran($setoran));
		$this->view->detailSaldo = array_shift($this->model->getSaldoPengemudi($preSaldo['idpengemudi']));
		$this->view->render('setoran/kwitansi', true);
	}

	function filter($tgl)
	{
		if(Session::get('user_akses') == 'root')
		{
			$this->view->buttonStatus = "enable";
		}
		elseif(Session::get('user_akses') != 'root' && $tgl != (date('Y-m-d'))) 
		{
			$this->view->buttonStatus = "disable";
		}
		else
		{
			$this->view->buttonStatus = "enable";
		}
		$this->view->listSRO = $this->model->getListFilteredSRO($tgl);
		$this->view->listSetoran = $this->model->getListFilteredSetoran($tgl);
		$this->view->render('setoran/filter', true);
	}

	function formSetoran($url)
	{
		$param = explode('_', $url);
		$sro = $param[0];
		$tanggal = $param[1];

		if($sro != '' && $tanggal != '')
		{
			$this->view->detailSRO = array_shift($this->model->getDetailSRO($sro));
			$this->view->listLoanLaka = $this->model->getListLoanLaka($this->view->detailSRO['idpengemudi']);
			$this->view->tglSetoran = $tanggal;
			$this->view->render('setoran/formsetoran', true);
		}
	}

	function delete()
	{
		$this->model->delete();
	}
}