<?php

class setoranModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	//Fungsi -fungsi Setoran
	function saveSetoran()
	{
		$data = array('sro' => $_POST['sro'],
						'armada' => $_POST['armada'],
						'pengemudi' => $_POST['pengemudi'],
						'pegawai' => $_POST['pegawai'],
						'tglsetoran' => $_POST['tglsetoran'],
						'target' => $_POST['target'],
						'totalsetoran' => $_POST['totalsetoran'],
						'setoran' => $_POST['setoran'],
						'caper' => $_POST['caper'],
						'tabungan' => $_POST['tabungan'],
						'loanlaka' => $_POST['loanlaka'],
						'loanks' => $_POST['loanks'],
						'kurangsetoran' => $_POST['kurangsetoran'],
						'dispensasi' => $_POST['dispensasi']);

		$this->db->insert('setoran', $data);
		$idSetoran = $this->db->lastInsertId();

		$this->updateKeuanganArmada($data['armada'],$data['caper']);
		if($_POST['laka'] != 0 && $data['loanlaka'] > 0):
			$this->bayarLoanLaka($_POST['laka'],$idSetoran,$data['loanlaka']);
		endif;
		$this->updateSaldoPengemudi($data['pengemudi'],$data['loanlaka'],$data['loanks'],$data['kurangsetoran'],$data['tabungan']);
		$this->setSROBayar($_POST['sro']);

		$jsonData = array('id' => $idSetoran);
		echo json_encode($jsonData);
	}

	function generateNomorTransaksi()
	{
		$sth = $this->db->prepare("select id from transaksi order by id desc limit 1");
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$id = $data['id'];
			$id += 1;

			return 'TR-'.$id.'-S';
		}
		else
		{
			return 'TR-1-S';
		}
	}

	function getNomorSRO($sro)
	{
		$sth = $this->db->prepare("select nomor from sro where id = :id");
		$sth->execute(array(':id' => $sro));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			return $data['nomor'];
		}
		else
		{
			return 'Nomor SRO Tidak Ditemukan';
		}
	}

	function updateKeuanganArmada($armada,$caper)
	{
		$sth = $this->db->prepare("select saldocaper from keuanganarmada where armada = :armada");
		$sth->execute(array(':armada' => $armada));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$saldocaper = $data['saldocaper'] + $caper;
			$this->db->update('keuanganarmada', array('saldocaper' => $saldocaper), "armada = $armada");
		}
	}

	function bayarLoanLaka($loanlaka,$setoran,$total)
	{
		$data = array('loanlaka' => $loanlaka,
					'setoran' => $setoran,
					'total' => $total);

		$this->db->insert("bayarloanlaka", $data);
	}

	function updateSaldoPengemudi($pengemudi,$loanlaka,$loanks,$kurangsetoran,$tabungan)
	{
		$sth = $this->db->prepare("select saldoks,saldoloanlaka,saldotabungan from saldopengemudi where pengemudi = :pengemudi");
		$sth->execute(array(':pengemudi' => $pengemudi));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			if($kurangsetoran > 0)
			{
				if($data['saldotabungan'] > 0)
				{
					if($data['saldotabungan'] > $kurangsetoran)
					{
						$nTabungan = $data['saldotabungan'] - $kurangsetoran;
						$nLoanKS = $data['saldoks'] + 0;
					}
					elseif($data['saldotabungan'] == $kurangsetoran)
					{
						$nTabungan = 0;
						$nLoanKS = $data['saldoks'] + 0;
					}
					else
					{
						$nTabungan = 0;
						$nLoanKS = $data['saldoks'] + ($kurangsetoran - $data['saldotabungan']);
					}
				}
				else
				{
					$nTabungan = 0;
					$nLoanKS = $data['saldoks'] + $kurangsetoran;
				}
			}
			else
			{
				$nLoanKS = $data['saldoks'] - $loanks;
				$nTabungan = $data['saldotabungan'] + $tabungan;
			}

			$nLoanLaka = $data['saldoloanlaka'] - $loanlaka;

			$data = array('saldoloanlaka' => $nLoanLaka,
						'saldoks' => $nLoanKS,
						'saldotabungan' => $nTabungan);

			$this->db->update("saldopengemudi", $data, "pengemudi = $pengemudi");
		}

			
	}

	function setSROBayar($id)
	{
		$data = array('bayar' => 1);

		$this->db->update('sro', $data, "id = $id");
	}
	//End of Fungsi-fungsi Setoran

	function getListSRO()
	{
		return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = date_sub(curdate(), interval 1 day) and bayar = 0 order by armada.nomorunit asc");
	}

	function getListSetoran()
	{
		return $this->db->select("select setoran.id,setoran.totalsetoran,setoran.setoran,setoran.caper,setoran.tabungan,setoran.loanks,setoran.loanlaka,
									armada.nomorunit,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from (armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = curdate() order by armada.nomorunit");
	}

	function getDetailSetoran($id)
	{
		return $this->db->select("select armada.nomorunit,pengemudi.id as idpengemudi, pengemudi.nama as namapengemudi,pegawai.nama as namapegawai,
								sro.nomor as nomorsro,sro.tanggal as tglsro,
								setoran.* 
								from (armada,pengemudi,pegawai,sro) inner join setoran on 
								sro.id = setoran.sro and
								armada.id = setoran.armada and
								pengemudi.id = setoran.pengemudi and 
								pegawai.id = setoran.pegawai where setoran.id = :id", array(':id' => $id));
	}

	function getSaldoPengemudi($pengemudi)
	{
		return $this->db->select("select saldoks,saldoloanlaka,saldotabungan from saldopengemudi where pengemudi = :pengemudi", 
							array(':pengemudi' => $pengemudi));
	}

	function getListFilteredSRO($tgl)
	{
		return $this->db->select("select sro.id,sro.nomor,sro.tanggal,
									armada.nomorunit,
									pegawai.nama as pegawai,
									pengemudi.nama as pengemudi from (armada,pengemudi,pegawai)
								inner join sro on 
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai
								where date(sro.tanggal) = date_sub(:tanggal, interval 1 day) and bayar = 0 order by armada.nomorunit asc", array(':tanggal' => $tgl));
	}

	function getListFilteredSetoran($tgl)
	{
		return $this->db->select("select setoran.id,setoran.totalsetoran,setoran.setoran,setoran.caper,setoran.tabungan,setoran.loanks,setoran.loanlaka,
									armada.nomorunit,
									pengemudi.nama as pengemudi,
									pegawai.nama as kasir
									from (armada,pengemudi,pegawai) inner join setoran on
									armada.id = setoran.armada and
									pengemudi.id = setoran.pengemudi and
									pegawai.id = setoran.pegawai
									where date(setoran.tglsetoran) = :tglsetoran order by armada.nomorunit asc", array(':tglsetoran' => $tgl));
	}

	function getDetailSRO($sro)
	{
		return $this->db->select("select pengemudi.id as idpengemudi,pengemudi.nomor as nomorpengemudi, pengemudi.nama as namapengemudi,pengemudi.foto as fotopengemudi,
									detailarmada.id as idarmada,detailarmada.nomorunit,detailarmada.targetsetoran,detailarmada.targetcaper,
									sro.id as sroid, sro.nomor from 	
									((select armada.id,armada.nomorunit,
									keuanganarmada.targetsetoran,keuanganarmada.targetcaper
									from armada inner join keuanganarmada on
									armada.id = keuanganarmada.armada) as detailarmada,pengemudi) inner join sro on
									detailarmada.id = sro.armada and
									pengemudi.id = sro.pengemudi where sro.id = :id", array(':id' => $sro));
	}

	function getListLoanLaka($pengemudi)
	{
		return $this->db->select("select * from loanlaka where pengemudi = :pengemudi and lunas = 0", array(':pengemudi' => $pengemudi));
	}

	//Fungsi-fungsi pembatalan setoran
	function delete()
	{
		$id = $_POST['id'];

		$sth = $this->db->prepare("select sro,pengemudi,armada,caper,tabungan,loanlaka,loanks,kurangsetoran from setoran where id = :id");
		$sth->execute(array(':id' => $id));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$sro = $data['sro'];
			$pengemudi = $data['pengemudi'];
			$armada = $data['armada'];
			$tabungan = $data['tabungan'];
			$loanlaka = $data['loanlaka'];
			$loanks = $data['loanks'];
			$ks = $data['kurangsetoran'];
			$caper = $data['caper'];

			$this->updateSaldoPengemudiForeDelete($pengemudi, $tabungan, $loanlaka, $loanks, $ks);
			$this->updateKeuanganArmadaForeDelete($armada,$caper);
			$this->cancelBayarLoanLaka($id);
			$this->setSROBelumBayar($sro);
		}

		$this->db->delete('setoran', "id = $id");
	}

	function updateSaldoPengemudiForeDelete($pengemudi, $tabungan, $loanlaka, $loanks, $ks)
	{
		$sth = $this->db->prepare("select * from saldopengemudi where pengemudi = :pengemudi");
		$sth->execute(array(':pengemudi' => $pengemudi));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$saldoks = $data['saldoks'];
			$saldoloanlaka = $data['saldoloanlaka'];
			$saldotabungan = $data['saldotabungan'];

			$saldoks = $saldoks - $loanks + $ks;
			$saldoloanlaka = $saldoloanlaka - $loanlaka;
			$saldotabungan = $saldotabungan - $tabungan;

			$uData = array('saldoks' => $saldoks,
						'saldoloanlaka' => $saldoloanlaka,
						'saldotabungan' => $saldotabungan);

			$this->db->update('saldopengemudi', $data, "pengemudi = $pengemudi");
		}
	}

	function updateKeuanganArmadaForeDelete($armada,$caper)
	{
		$sth = $this->db->prepare("select * from keuanganarmada where armada = :armada");
		$sth->execute(array(':armada' => $armada));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$saldocaperlama = $data['saldocaper'];
			$saldocaperbaru = $saldocaperlama - $caper;

			$uData = array('saldocaper' => $saldocaperbaru);
			$this->db->update('keuanganarmada', $data, "armada = $armada"); 
		}
	}

	function cancelBayarLoanLaka($setoran)
	{
		$this->db->delete('bayarloanlaka', "setoran = $setoran");
	}

	function setSROBelumBayar($id)
	{
		$data = array('bayar' => 0);

		$this->db->update('sro', $data, "id = $id");
	}
	//End of Fungsi-fungsi Pembatalan Setoran
}