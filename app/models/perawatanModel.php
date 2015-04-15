<?php

class perawatanModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListPerawatan()
	{
		return $this->db->select("select armada.nomorunit,pegawai.nama as namapegawai,perawatan.* from (armada,pegawai) inner join perawatan on
								armada.id = perawatan.armada and pegawai.id = perawatan.pegawai where perawatan.tanggal = curdate() order by id desc");
	}

	function getListFilteredPerawatan($tgl)
	{
		return $this->db->select("select armada.nomorunit,pegawai.nama as namapegawai,perawatan.* from (armada,pegawai) inner join perawatan on
								armada.id = perawatan.armada and pegawai.id = perawatan.pegawai where perawatan.tanggal = :tanggal order by id desc", array(':tanggal' => $tgl));
	}

	function getListParts($perawatan)
	{	
		
		return $this->db->select("select parts.kode,parts.nama,parts.hargajual,perawatanparts.* from parts inner join perawatanparts on
								parts.id = perawatanparts.parts where perawatanparts.perawatan = :perawatan", array(':perawatan' => $perawatan));
	}

	function getDetailPerawatan($id)
	{
		return $this->db->select("select armada.nomorunit,pegawai.nama as namapegawai,perawatan.* from (armada,pegawai) inner join perawatan on
								armada.id = perawatan.armada and pegawai.id = perawatan.pegawai where perawatan.id = :id", array(':id' => $id));
	}

	function addNew()
	{
		$data = array('armada' => $_POST['armada'],
					'pegawai' => Session::get('user_idPegawai'),
					'nomor' => $this->generateNomor(),
					'tanggal' => date('Y-m-d', strtotime($_POST['tanggal'])),
					'detail' => $_POST['detail'],
					'biayaperawatan' => $_POST['biayaperawatan'],
					'biayaparts' => 0);

		$this->db->insert('perawatan', $data);
	}

	function generateNomor()
	{
		$sth = $this->db->prepare("select id from perawatan order by id desc limit 1");
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$id = $data['id']+1;
			return 'PRW - '.$id;
		}
		else
		{
			return 'PRW - 1';
		}
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('detail' => $_POST['detail'],
					'biayaperawatan' => $_POST['biayaperawatan']);

		$this->db->update('perawatan', $data, "id = $id");
	}

	function getParts()
	{
		$param = $_POST['param'];
		$jsonData = $this->db->select("select id,kode,nama from parts where kode like '%$param%' or nama like '%$param%'");

		echo json_encode($jsonData);
	}

	function addParts()
	{
		$data = array('perawatan' => $_POST['perawatan'],
				'parts' => $_POST['parts'],
				'jumlah' => $_POST['jumlah']);

		$this->db->insert('perawatanparts', $data);

		$this->updateBiayaParts($_POST['perawatan'],$_POST['parts'],$_POST['jumlah']);
	}

	function updateBiayaParts($perawatan,$parts,$jumlah)
	{
		$sthParts = $this->db->prepare('select hargajual from parts where id = :id');
		$sthParts->execute(array(':id' => $parts));

		$dataParts = $sthParts->fetch();

		$sthPerawatan = $this->db->prepare('select biayaparts from perawatan where id = :id');
		$sthPerawatan->execute(array(':id' => $perawatan));

		$dataPerawatan = $sthPerawatan->fetch();
		$countBiayaParts = $sthPerawatan->rowCount();

		if($countBiayaParts > 0)
		{
			$tambahanBiaya = $dataPerawatan['biayaparts'] + ($dataParts['hargajual'] * $jumlah);
			$uData = array('biayaparts' => $tambahanBiaya);

			$this->db->update('perawatan', $uData, "id = $perawatan");
		}
	}

	function updateParts()
	{
		$id = $_POST['perawatanparts'];
		$data = array('parts' => $_POST['parts'],
					'jumlah' => $_POST['jumlah']);

		$this->db->update('perawatanparts', $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('perawatan', "id = $id");
	}

	function deleteParts()
	{
		$id = $_POST['id'];

		$this->deleteBiayaParts($id);
		$this->db->delete('perawatanparts', "id = $id");
	}

	function deleteBiayaParts($id)
	{
		$sthParts = $this->db->prepare('select parts.hargajual,perawatanparts.perawatan,perawatanparts.jumlah from parts 
										inner join perawatanparts on parts.id = perawatanparts.parts
										where perawatanparts.id = :id');
		$sthParts->execute(array(':id' => $id));

		$dataParts = $sthParts->fetch();

		$sthPerawatan = $this->db->prepare('select biayaparts from perawatan where id = :id');
		$sthPerawatan->execute(array(':id' => $dataParts['perawatan']));

		$dataPerawatan = $sthPerawatan->fetch();
		$countBiayaParts = $sthPerawatan->rowCount();

		if($countBiayaParts > 0)
		{
			$tambahanBiaya = $dataPerawatan['biayaparts'] - ($dataParts['hargajual'] * $dataParts['jumlah']);
			$uData = array('biayaparts' => $tambahanBiaya);

			$id = $dataParts['perawatan'];
			$this->db->update('perawatan', $uData, "id = $id");
		}
	}
}