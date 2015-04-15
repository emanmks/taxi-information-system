<?php

class Report extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	//laporan SRO terbit
	function sro()
	{
		$this->view->listSRO = $this->model->getListSRO();
		$this->view->currDate = date('d-m-Y');
		$this->view->currKlasifikasi = "0";
		$this->view->render('report/sro');
	}

	function filterSro($url)
	{
		$param = explode("_", $url);
		$tanggal = $param[0];
		$report = $param[1];

		$this->view->listSRO = $this->model->getListFilteredSRO($tanggal,$report);
		$this->view->currDate = date('d-m-Y', strtotime($tanggal));
		$this->view->currKlasifikasi = $report;
		$this->view->render('report/srofilter', true);
	}

	//laporan armada belum keluar
	function noSro()
	{
		$this->view->listNoSRO = $this->model->getListNoSRO();
		$this->view->currDate = date('d-m-Y');
		$this->view->render('report/nosro');
	}

	function filterNoSro($url)
	{
		$param = explode("_", $url);
		$tanggal = $param[0];
		$report = $param[1];

		$this->view->listNoSRO = $this->model->getListFilteredNoSRO($tanggal,$report);
		$this->view->currDate = date('d-m-Y', strtotime($tanggal));
		$this->view->currKlasifikasi = $report;
		$this->view->render('report/nosrofilter', true);
	}

	//laporan setoran
	function setoran()
	{
		$this->view->listSetoran = $this->model->getListSetoran();
		$this->view->currDate = date('d-m-Y');
		$this->view->render('report/setoran');
	}

	function filterSetoran($url)
	{
		$param = explode("_", $url);
		$tanggal = $param[0];
		$report = $param[1];

		$this->view->listSetoran = $this->model->getListFilteredSetoran($tanggal,$report);
		$this->view->currDate = date('d-m-Y', strtotime($tanggal));
		$this->view->currKlasifikasi = $report;
		$this->view->render('report/setoranfilter', true);
	}

	//laporan belum setor
	function belumSetor()
	{
		$this->view->listSRO = $this->model->getListBelumSetor();
		$this->view->currDate = date('d-m-Y');
		$this->view->render('report/belumsetor');
	}

	function filterBelumSetor($url)
	{
		$param = explode("_", $url);
		$tanggal = $param[0];
		$report = $param[1];

		$this->view->listSRO = $this->model->getListFilteredBelumSetor($tanggal,$report);
		$this->view->currDate = date('d-m-Y', strtotime($tanggal));
		$this->view->currKlasifikasi = $report;
		$this->view->render('report/belumsetorfilter', true);
	}

	//Laporan Kurang Setoran
	function kurangsetoran()
	{
		$this->view->render('report/ks');
	}

	function historyKSPengemudi($pengemudi)
	{
		$this->view->listKS = $this->model->getListKSPengemudi($pengemudi);
		$this->view->listBayarKS = $this->model->getListBayarKSPengemudi($pengemudi);
		$this->view->saldoKS = array_shift($this->model->getSaldoKS($pengemudi));
		$this->view->detailPengemudi = array_shift($this->model->getDetailPengemudi($pengemudi));
		$this->view->render('report/ksfilter', true);
	}

	function saldoKS()
	{
		$this->view->listSaldoKS = $this->model->getListSaldoKS();
		$this->view->render('report/saldoks');
	}

	function rekapKS()
	{
		$this->view->listKS = $this->model->getListKS();
		$this->view->render('report/rekapks');
	}

	function filterRekapKS($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listKS = $this->model->getListFilteredKS($awal, $akhir);
		$this->view->render('report/rekapksfilter', true);
	}

	function bayarKS()
	{
		$this->view->listBayarKS = $this->model->getListBayarKS();
		$this->tglAwal = date('d-m-Y');
		$this->tglAkhir = date('d-m-Y');
		$this->view->render('report/rekapbayarks');
	}

	function filterBayarKS($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listBayarKS = $this->model->getListFilteredBayarKS($awal, $akhir);
		$this->tglAwal = date('d-m-Y', strtotime($awal));
		$this->tglAkhir = date('d-m-Y', strtotime($akhir));
		$this->view->render('report/rekapbayarksfilter', true);
	}

	//laporan loan laka
	function loanLaka()
	{
		$this->view->render('report/loan');
	}

	function historyLoanLakaPengemudi($pengemudi)
	{
		$this->view->listLoanLaka = $this->model->getListLoanLakaPengemudi($pengemudi);
		$this->view->listBayarLoanLaka = $this->model->getListBayarLoanLakaPengemudi($pengemudi);
		$this->view->saldoLoanLaka = array_shift($this->model->getSaldoLoanLaka($pengemudi));
		$this->view->detailPengemudi = array_shift($this->model->getDetailPengemudi($pengemudi));
		$this->view->render('report/loanfilter', true);
	}

	function saldoLaka()
	{
		$this->view->listSaldoLoanLaka = $this->model->getListSaldoLoanLaka();
		$this->view->render('report/loanlaka');
	}

	function rekapLoanLaka()
	{
		$this->view->listLoanLaka = $this->model->getListLoanLaka();
		$this->tglAwal = date('d-m-Y');
		$this->tglAkhir = date('d-m-Y');
		$this->view->render('report/rekaploanlaka');
	}

	function filterRekapLoanLaka($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listLoanLaka = $this->model->getListFilteredLoanLaka($awal, $akhir);
		$this->tglAwal = date('d-m-Y', strtotime($awal));
		$this->tglAkhir = date('d-m-Y', strtotime($akhir));
		$this->view->render('report/rekaploanlakafilter', true);
	}

	function rekapBayarLoanLaka()
	{
		$this->view->listBayarLoanLaka = $this->model->getListBayarLoanLaka();
		$this->tglAwal = date('d-m-Y');
		$this->tglAkhir = date('d-m-Y');
		$this->view->render('report/rekapbayarloanlaka');
	}

	function filterRekapBayarLoanLaka($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listBayarLoanLaka = $this->model->getListFilteredBayarLoanLaka($awal, $akhir);
		$this->tglAwal = date('d-m-Y', strtotime($awal));
		$this->tglAkhir = date('d-m-Y', strtotime($akhir));
		$this->view->render('report/rekapbayarloanlakafilter', true);
	}

	//Tabungan
	function tabungan()
	{
		$this->view->listSaldoTabungan = $this->model->getListSaldoTabungan();
		$this->view->render('report/tabungan');
	}

	//laporan arus kas
	function kas()
	{
		$this->view->listTransaksi = $this->model->getListTransaksi();
		$this->view->currDate = date('d-m-Y');
		$this->view->render('report/transaksi');
	}

	function filterKas($tgl)
	{
		$this->view->listTransaksi = $this->model->getListFilteredTransaksi($tgl);
		$this->view->currDate = date('d-m-Y', strtotime($tgl));
		$this->view->render('report/transaksifilter', true);
	}

	//laporan rekap Pengemudi
	function pengemudi()
	{
		$this->view->render('report/pengemudi');
	}

	function filterpengemudi($url)
	{
		$param = explode("_", $url);
		$pengemudi = $param[0];
		$awal = $param[1];
		$akhir = $param[2];

		$this->view->listSetoran = $this->model->getListSetoranPengemudi($pengemudi,$awal,$akhir);
		$this->view->detailPengemudi = array_shift($this->model->getDetailPengemudi($pengemudi));
		$this->view->awal = $awal;
		$this->view->akhir = $akhir;
		$this->view->render('report/pengemudifilter', true);
	}

	//laporan rekap Armada
	function armada()
	{
		$this->view->render('report/armada');
	}

	function filterarmada($url)
	{
		$param = explode("_", $url);
		$armada = $param[0];
		$bulan = $param[1];

		$this->view->listSetoran = $this->model->getListSetoranArmada($armada,$bulan);
		$this->view->detailArmada = array_shift($this->model->getDetailArmada($armada));
		$this->view->currMonth = $bulan;
		$this->view->render('report/armadafilter', true);
	}

	//laporan parts
	function parts()
	{
		$this->view->listParts = $this->model->getListParts();
		$this->view->render('report/parts');
	}

	//laporan perawatan
	function perawatan()
	{
		$this->view->listPerawatan = $this->model->getListPerawatan();
		$this->tglAwal = date('d-m-Y');
		$this->tglAkhir = date('d-m-Y');
		$this->view->render('report/perawatan');
	}

	function filterPerawatan($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listPerawatan = $this->model->getListFilteredPerawatan($awal, $akhir);
		$this->tglAwal = date('d-m-Y', strtotime($awal));
		$this->tglAkhir = date('d-m-Y', strtotime($akhir));
		$this->view->render('report/perawatanfilter', true);
	}

	//laporan pemakaian parts
	function perawatanParts()
	{
		$this->view->listPerawatanParts = $this->model->getListPerawatanParts();
		$this->tglAwal = date('d-m-Y');
		$this->tglAkhir = date('d-m-Y');
		$this->view->render('report/perawatanparts');
	}

	function filterPerawatanParts($url)
	{
		$param = explode('_', $url);
		$awal = $param[0];
		$akhir = $param[1];

		$this->view->listPerawatanParts = $this->model->getListFilteredPerawatanParts($awal, $akhir);
		$this->tglAwal = date('d-m-Y', strtotime($awal));
		$this->tglAkhir = date('d-m-Y', strtotime($akhir));
		$this->view->render('report/perawatanpartsfilter', true);
	}
}