<?php

class sroModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

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
								where date(sro.tanggal) = curdate() order by armada.nomorunit asc");
	}

	function getDetailSRO($id)
	{
		return $this->db->select("select armada.nomorunit,armada.nomorpolisi,
								pengemudi.nomor as idpengemudi,pengemudi.nama as namapengemudi,
								pegawai.nama as namapegawai,
								sro.* 
								from (armada,pengemudi,pegawai) inner join sro on
								armada.id = sro.armada and 
								pengemudi.id = sro.pengemudi and 
								pegawai.id = sro.pegawai where sro.id = :id", array(':id' => $id));
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
								where date(sro.tanggal) = :tanggal order by armada.nomorunit asc", array(':tanggal' => $tgl));
	}

	function checkDouble()
	{
		$armada = $_POST['armada'];
		$pengemudi = $_POST['pengemudi'];
		$tanggal = $_POST['tanggal'];

		if($this->checkArmada($armada,$tanggal) || $this->checkPengemudi($pengemudi,$tanggal))
		{
			echo json_encode(array('double' => 'YA'));
		}
		else
		{
			echo json_encode(array('double' => 'TIDAK'));
		}

	}

	function checkArmada($armada,$tanggal)
	{
		$sth = $this->db->prepare('select id from sro where armada = :armada and date(tanggal) = :tanggal');
		$sth->execute(array(':armada' => $armada, ':tanggal' => $tanggal));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function checkPengemudi($pengemudi,$tanggal)
	{
		$sth = $this->db->prepare('select id from sro where pengemudi = :pengemudi and date(tanggal) = :tanggal');
		$sth->execute(array(':pengemudi' => $pengemudi, ':tanggal' => $tanggal));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	function saveSRO()
	{
		$tgl = $_POST['tanggal'];
		$wkt = date('H:i:s');
		$tanggal = $tgl.' '.$wkt;
		$data = array('armada' => $_POST['armada'],
					'pengemudi' => $_POST['pengemudi'],
					'pegawai' => Session::get('user_idPegawai'),
					'tanggal' => $tanggal);

		$this->db->insert('sro', $data);
		$id = $this->db->lastInsertId();

		$nomorsro = 'SRO'.'/'. $id .'/'. $_POST['nomorunit'] .'/'. $_POST['nomorpengemudi'] .'/'. date('m') .'/'. date('Y');
		$this->inputNomorSRO($id,$nomorsro);

		$jsonData = array('id' => $id);

		echo json_encode($jsonData);
	}

	function inputNomorSRO($id,$nomorsro)
	{
		$data = array('nomor' => $nomorsro);
		$this->db->update('sro', $data, "id = $id");
	}

	function getListArmada()
	{
		$nomor = $_POST['nomor'];
		$jsonData = $this->db->select("select id,nomorunit,kondisi from armada where nomorunit like '%$nomor%'");

		echo json_encode($jsonData);
	}

	function getDetailArmada($nomor)
	{
		$jsonData = $this->db->select("select id,nomorunit,operasional,kondisi from armada where nomorunit = :nomorunit", array(':nomorunit' => $nomor));
		echo json_encode($jsonData);
	}

	function getListPengemudi()
	{
		$param = $_POST['param'];
		$jsonData = $this->db->select("select id,nomor,nama,foto from pengemudi where nomor like '%$param%' or nama like '%$param%'");

		echo json_encode($jsonData);
	}

	function getDetailPengemudi($nomor)
	{
		$jsonData = $this->db->select("select id,nomor,nama from pengemudi where nomor = :nomor", array(':nomor' => $nomor));

		echo json_encode($jsonData);
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('sro', "id = $id");
	}
}