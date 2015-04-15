<?php

class reportModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	//Laporan SRO
	function getListSRO()
	{
		return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.nomorpolisi,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = curdate() order by armada.nomorunit asc", array(':tanggal' => date('Y-m-d')));
	}

	function getListFilteredSRO($tanggal,$report)
	{
		switch ($report) {
			case '1':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									tblarmada.id,
									tblarmada.nomorunit,
									tblarmada.nomorpolisi,
									tblarmada.pemilik,
									tblarmada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from 
									((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as tblarmada,
										pengemudi,pegawai)
								inner join sro on 
								tblarmada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and tblarmada.pemilik = 2 and tblarmada.operasional = 'umum' order by tblarmada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
			case '2':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									tblarmada.id,
									tblarmada.nomorunit,
									tblarmada.nomorpolisi,
									tblarmada.pemilik,
									tblarmada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from 
									((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as tblarmada,
										pengemudi,pegawai)
								inner join sro on 
								tblarmada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and tblarmada.pemilik = 1 and tblarmada.operasional = 'umum' order by tblarmada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
			case '3':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									tblarmada.id,
									tblarmada.nomorunit,
									tblarmada.nomorpolisi,
									tblarmada.pemilik,
									tblarmada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from 
									((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as tblarmada,
										pengemudi,pegawai)
								inner join sro on 
								tblarmada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and tblarmada.pemilik = 2 and tblarmada.operasional = 'bandara' order by tblarmada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
			case '4':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									tblarmada.id,
									tblarmada.nomorunit,
									tblarmada.nomorpolisi,
									tblarmada.pemilik,
									tblarmada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from 
									((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as tblarmada,
										pengemudi,pegawai)
								inner join sro on 
								tblarmada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and tblarmada.pemilik = 1 and tblarmada.operasional = 'bandara' order by tblarmada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
			default:
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.nomorpolisi,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi,
									pengemudi.nomor as idpengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal order by sro.id desc", array(':tanggal' => $tanggal));
				break;
		}
	}

	//Laporan Armada Belum Keluar
	function getListNoSRO()
	{
		return $this->db->select("select * from armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where tblsro.armada is null order by nomorunit asc", array(':tanggal' => date('Y-m-d')));
	}

	function getListFilteredNoSRO($tanggal,$report)
	{
		switch ($report) {
			case '1':
				return $this->db->select("select * from (select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where armada.pemilik = 2 and armada.operasional = 'umum' and tblsro.armada is null order by nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '2':
				return $this->db->select("select * from (select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where armada.pemilik = 1 and armada.operasional = 'umum' and tblsro.armada is null order by nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '3':
				return $this->db->select("select * from (select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where armada.pemilik = 2 and armada.operasional = 'bandara' and tblsro.armada is null order by nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '4':
				return $this->db->select("select * from (select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where armada.pemilik = 1 and armada.operasional = 'bandara' and tblsro.armada is null order by nomorunit asc", array(':tanggal' => $tanggal));
				break;
			
			default:
				return $this->db->select("select * from armada left outer join 
								(select armada from sro where date(tanggal) = :tanggal) as tblsro 
								on armada.id = tblsro.armada where tblsro.armada is null order by nomorunit asc", array(':tanggal' => $tgl));
				break;
		}
		
	}

	//Laporan Setoran Masuk
	function getListSetoran()
	{
		return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from (armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = curdate() order by armada.nomorunit asc");
	}

	function getListFilteredSetoran($tanggal,$report)
	{
		switch ($report) {
			case '1':
				return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran and armada.pemilik = 2 and armada.operasional = 'umum'
									order by armada.nomorunit asc", array(':tglsetoran' => $tanggal));
				break;

			case '2':
				return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran and armada.pemilik = 1 and armada.operasional = 'umum'
									order by armada.nomorunit asc", array(':tglsetoran' => $tanggal));
				break;

			case '3':
				return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran and armada.pemilik = 2 and armada.operasional = 'bandara'
									order by armada.nomorunit asc", array(':tglsetoran' => $tanggal));
				break;

			case '4':
				return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran and armada.pemilik = 1 and armada.operasional = 'bandara'
									order by armada.nomorunit asc", array(':tglsetoran' => $tanggal));
				break;
			
			default:
				return $this->db->select("select setoran.id,setoran.target,setoran.totalsetoran,setoran.setoran,setoran.caper,
									setoran.tabungan,setoran.loanks,setoran.loanlaka,setoran.kurangsetoran,setoran.dispensasi,
									armada.nomorunit,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from (armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran order by armada.nomorunit asc", array(':tglsetoran' => $tanggal));
				break;
		}
	}

	//Laporan Belum Setor
	function getListBelumSetor()
	{
		return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = date_sub(curdate(), interval 1 day) and bayar = 0 order by armada.nomorunit asc");
	}

	function getListFilteredBelumSetor($tanggal, $report)
	{
		switch ($report) {
			case '1':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and bayar = 0 and
								armada.pemilik = 2 and armada.operasional = 'umum' order by armada.nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '2':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and bayar = 0 and
								armada.pemilik = 1 and armada.operasional = 'umum' order by armada.nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '3':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and bayar = 0 and
								armada.pemilik = 2 and armada.operasional = 'bandara' order by armada.nomorunit asc", array(':tanggal' => $tanggal));
				break;

			case '4':
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									armada.pemilik,
									armada.operasional,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from ((select armada.id,armada.nomorunit,armada.nomorpolisi,armada.operasional,armada.kondisi,pemilikarmada.pemilik from armada inner join pemilikarmada 
										on armada.id = pemilikarmada.armada) as armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and bayar = 0 and
								armada.pemilik = 1 and armada.operasional = 'bandara' order by armada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
			
			default:
				return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									pegawai.nama as pegawai,
									pengemudi.nomor as idpengemudi, pengemudi.nama as pengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = :tanggal and bayar = 0 order by armada.nomorunit asc", array(':tanggal' => $tanggal));
				break;
		}
	}

	//laporan Kurang Setoran
	function getListKS()
	{
		return $this->db->select("select pengemudi.nama as namapengemudi,tglsetoran,target,totalsetoran,dispensasi,kurangsetoran from 
								pengemudi inner join setoran on pengemudi.id = setoran.pengemudi 
								where setoran.kurangsetoran > 0 and date(setoran.tglsetoran) = curdate()");
	}

	function getListFilteredKS($awal, $akhir)
	{	
		return $this->db->select("select pengemudi.nama as namapengemudi,tglsetoran,target,totalsetoran,dispensasi,kurangsetoran from 
								pengemudi inner join setoran on pengemudi.id = setoran.pengemudi 
								where setoran.kurangsetoran > 0 and date(setoran.tglsetoran) >= :awal and date(setoran.tglsetoran) <= :akhir 
								order by setoran.tglsetoran", 
								array(':awal' => $awal, ':akhir' => $akhir));
	}

	function getListBayarKS()
	{
		return $this->db->select("select pengemudi.nama as namapengemudi,tglsetoran,target,totalsetoran,dispensasi,loanks from 
								pengemudi inner join setoran on pengemudi.id = setoran.pengemudi 
								where setoran.loanks > 0 and date(setoran.tglsetoran) = curdate()");
	}

	function getListFilteredBayarKS($awal, $akhir)
	{	
		return $this->db->select("select pengemudi.nama as namapengemudi, tglsetoran,target,totalsetoran,dispensasi,loanks from 
								pengemudi inner join setoran on pengemudi.id = setoran.pengemudi 
								where setoranloanks > 0 and date(setoran.tglsetoran) >= :awal and date(setoran.tglsetoran) <= :akhir 
								order by setoran.tglsetoran", 
								array(':awal' => $awal, ':akhir' => $akhir));
	}

	function getListKSPengemudi($pengemudi)
	{
		return $this->db->select("select tglsetoran,target,totalsetoran,dispensasi,kurangsetoran from setoran 
								where setoran.pengemudi = :pengemudi and kurangsetoran > 0", array(':pengemudi' => $pengemudi));
	}

	function getListBayarKSPengemudi($pengemudi)
	{
		return $this->db->select("select tglsetoran,target,totalsetoran,dispensasi,loanks from setoran 
								where setoran.pengemudi = :pengemudi and loanks > 0", array(':pengemudi' => $pengemudi));
	}

	function getSaldoKS($pengemudi)
	{
		return $this->db->select("select saldoks from saldopengemudi where pengemudi = :pengemudi", array(':pengemudi' => $pengemudi));
	}

	function getListSaldoKS()
	{
		return $this->db->select("select pengemudi.nomor as idpengemudi,pengemudi.nama as namapengemudi,saldopengemudi.saldoks from pengemudi
								inner join saldopengemudi on pengemudi.id = saldopengemudi.pengemudi where saldopengemudi.saldoks > 0 
								order by pengemudi.nomor asc");
	}

	//laporan Loan Laka
	function getListLoanLaka()
	{
		return $this->db->select("select kecelakaan.namapengemudi,kecelakaan.nomor,kecelakaan.tanggal,nomorloan,bebanlaka,lunas from 
								(select pengemudi.nama as namapengemudi,kecelakaan.id,tanggal,nomorlaka,biayaparts,biayaurus,biayalain from pengemudi inner join kecelakaan on
								pengemudi.id = kecelakaan.pengemudi) as kecelakaan inner join loanlaka on kecelakaan.id = loanlaka.laka where
								kecelakaan.tanggal = curdate()");
	}

	function getListFilteredLoanLaka($awal, $akhir)
	{
		return $this->db->select("select kecelakaan.namapengemudi,kecelakaan.nomor,kecelakaan.tanggal,nomorloan,bebanlaka,lunas from 
								(select pengemudi.nama as namapengemudi,kecelakaan.id,tanggal,nomorlaka,biayaparts,biayaurus,biayalain from pengemudi inner join kecelakaan on
								pengemudi.id = kecelakaan.pengemudi) as kecelakaan inner join loanlaka on kecelakaan.id = loanlaka.laka where
								kecelakaan.tanggal >= :awal and kecelakaan.tanggal <= :akhir", array(':awal' => $awal, ':akhir' => $akhir));
	}

	function getListBayarLoanLaka()
	{
		return $this->db->select("select loanlaka.nomorloan,setoran.tglsetoran,setoran.namapengemudi,total from (loanlaka, (select pengemudi.nama as namapengemudi,setoran.id,tglsetoran from pengemudi inner join setoran on 
								pengemudi.id = setoran.pengemudi) as setoran) inner join bayarloanlaka where bayarloanlaka.total > 0 
								and date(setoran.tglsetoran) = curdate()");
	}

	function getListFilteredBayarLoanLaka($awal, $akhir)
	{
		return $this->db->select("select loanlaka.nomorloan,setoran.tglsetoran,setoran.namapengemudi,total from (loanlaka, (select pengemudi.nama as namapengemudi,setoran.id,tglsetoran from pengemudi inner join setoran on 
								pengemudi.id = setoran.pengemudi) as setoran) inner join bayarloanlaka where 
								bayarloanlaka.total > 0 and date(setoran.tglsetoran) >= :awal and
								date(setoran.tglsetoran) <= :akhir", array(':awal' => $awal, ':akhir' => $akhir));
	}

	function getListLoanLakaPengemudi($pengemudi)
	{
		return $this->db->select("select kecelakaan.nomorlaka,kecelakaan.tanggal,kecelakaan.biayaparts,kecelakaan.biayaurus,kecelakaan.biayalain,
								loanlaka.* from kecelakaan inner join loanlaka on kecelakaan.id = loanlaka.laka where kecelakaan.pengemudi = :pengemudi",
								array(':pengemudi' => $pengemudi));
	}

	function getListBayarLoanLakaPengemudi($pengemudi)
	{
		return $this->db->select("select setoran.pengemudi,setoran.tglsetoran,loanlaka.nomorloan,bayarloanlaka.* from (setoran,loanlaka) inner join bayarloanlaka on
								setoran.id = bayarloanlaka.setoran and loanlaka.id = bayarloanlaka.loanlaka where setoran.pengemudi = :pengemudi",
								array(':pengemudi' => $pengemudi));
	}

	function getSaldoLoanLaka($pengemudi)
	{
		return $this->db->select("select saldoloanlaka from saldopengemudi where pengemudi = :pengemudi", array(':pengemudi' => $pengemudi));
	}

	function getListSaldoLoanLaka()
	{
		return $this->db->select("select pengemudi.nomor as idpengemudi,pengemudi.nama as namapengemudi,saldopengemudi.saldoloanlaka from pengemudi
								inner join saldopengemudi on pengemudi.id = saldopengemudi.pengemudi where saldopengemudi.saldoloanlaka > 0 
								order by pengemudi.nomor asc");
	}

	function getDetailPengemudi($pengemudi)
	{
		return $this->db->select("select nomor,nama from pengemudi where id = :id", array(':id' => $pengemudi));
	}

	//laporan saldo tabungan
	function getListSaldoTabungan()
	{
		return $this->db->select("select pengemudi.nomor as idpengemudi,pengemudi.nama as namapengemudi,saldopengemudi.saldotabungan from pengemudi
								inner join saldopengemudi on pengemudi.id = saldopengemudi.pengemudi where saldopengemudi.saldotabungan > 0 
								order by pengemudi.nomor asc");
	}

	//laporan rekap Pengemudi
	function getListSetoranPengemudi($pengemudi,$awal,$akhir)
	{
		return $this->db->select("select sro.nomor as nomorsro,armada.nomorunit,pegawai.nama as kasir,setoran.* from (sro,armada,pegawai) inner join setoran on
								sro.id = setoran.sro and armada.id = setoran.armada and pegawai.id = setoran.pegawai 
								where setoran.pengemudi = :pengemudi and setoran.tglsetoran between :awal and :akhir order by setoran.tglsetoran asc", 
								array(':pengemudi' => $pengemudi, ':awal' => date('Y-m-d', strtotime($awal)), ':akhir' => date('Y-m-d', strtotime($akhir))));
	}

	//laporan rekap armada
	function getListSetoranArmada($armada,$bulan)
	{
		return $this->db->select("select sro.nomor as nomorsro,pengemudi.nama as namapengemudi,pegawai.nama as kasir,setoran.* from (sro,pengemudi,pegawai) inner join setoran on
								sro.id = setoran.sro and pengemudi.id = setoran.pengemudi and pegawai.id = setoran.pegawai 
								where setoran.armada = :armada and month(setoran.tglsetoran) = :bulan order by setoran.tglsetoran asc", 
								array(':armada' => $armada, ':bulan' => $bulan));
	}

	function getDetailArmada($id)
	{
		return $this->db->select("select nomorunit,nomorpolisi,merek from armada where id = :id", array(':id' => $id));
	}

	//Laporan Arus Kas
	function getListTransaksi()
	{
		return $this->db->select("select jenistransaksi.jenis,transaksi.* from jenistransaksi inner join transaksi on 
								jenistransaksi.id = transaksi.jenistransaksi where transaksi.tanggal = curdate() order by transaksi.id desc");
	}

	function getListFilteredTransaksi($tgl)
	{
		return $this->db->select("select jenistransaksi.jenis,transaksi.* from jenistransaksi inner join transaksi on 
								jenistransaksi.id = transaksi.jenistransaksi where transaksi.tanggal = :tanggal order by transaksi.id desc", 
								array(':tanggal' => $tgl));
	}

	//laporan parts
	function getListParts()
	{
		return $this->db->select("select parts.id,parts.kode,parts.nama as namaparts,parts.satuan,parts.hargabeli,parts.hargajual,
							stockparts.quantity,stockparts.quantityoh,stockparts.lastopname,stockparts.keterangan,pegawai.nama as namapegawai 
							from (parts,pegawai) inner join stockparts on
								parts.id = stockparts.parts and pegawai.id = stockparts.pegawai order by parts.nama asc");
	}

	//laporan perawatan
	function getListPerawatan()
	{
		return $this->db->select("select armada.nomorunit,perawatan.* from armada inner join perawatan on
								armada.id = perawatan.armada where perawatan.tanggal = curdate()");
	}

	function getListFilteredPerawatan($awal, $akhir)
	{
		return $this->db->select("select armada.nomorunit,perawatan.* from armada inner join perawatan on
								armada.id = perawatan.armada where perawatan.tanggal >= :awal and perawatan.tanggal <= :akhir", 
								array(':awal' => $awal, ':akhir' => $akhir));
	}

	//laporan pemakaian parts
	function getListPerawatanParts()
	{
		return $this->db->select("select perawatan.*,parts.kode,parts.nama,parts.hargajual,jumlah from 
								((select pegawai.nama as namapegawai,armada.nomorunit,perawatan.* from (pegawai,armada) inner join perawatan on 
								pegawai.id = perawatan.pegawai and armada.id = perawatan.armada) as perawatan, parts) inner join perawatanparts on 
								perawatan.id = perawatanparts.perawatan and
								parts.id = perawatanparts.parts where perawatan.tanggal = curdate()");
	}

	function getListFilteredPerawatanParts($awal, $akhir)
	{
		return $this->db->select("select perawatan.*,parts.kode,parts.nama,parts.hargajual,jumlah from 
								((select pegawai.nama as namapegawai,armada.nomorunit,perawatan.* from (pegawai,armada) inner join perawatan on 
								pegawai.id = perawatan.pegawai and armada.id = perawatan.armada) as perawatan, parts) inner join perawatanparts on 
								perawatan.id = perawatanparts.perawatan and
								parts.id = perawatanparts.parts where perawatan.tanggal >= :awal and perawatan.tanggal <= :akhir",
								array(':awal' => $awal, ':akhir' => $akhir));
	}
}