<?php

class Sro extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listSRO = $this->model->getListSRO();
		$this->view->render('sro/index');
	}

	function notDouble()
	{
		$this->model->checkDouble();
	}

	function save()
	{
		$this->model->saveSRO();
	}

	function bukti($sro)
	{
		$this->view->detailSRO = array_shift($this->model->getDetailSRO($sro));
		$this->view->render('sro/kwitansi', true);
	}

	function filter($tgl)
	{
		$this->view->listSRO = $this->model->getListFilteredSRO($tgl);
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
		$this->view->render('sro/filter', true);
	}

	function getListArmada()
	{
		$this->model->getListArmada();
	}

	function getDetailArmada($nomor)
	{
		$this->model->getDetailArmada($nomor);
	}

	function getListPengemudi()
	{
		$this->model->getListPengemudi();
	}

	function getDetailPengemudi($nomor)
	{
		$this->model->getDetailPengemudi($nomor);
	}	

	function delete()
	{
		$this->model->delete();
	}
}