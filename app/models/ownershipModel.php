<?php

class ownershipModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListOwnership()
	{
		return $this->db->select('select armada.nomorunit,pengemudi.nomor as nomorpengemudi,pengemudi.nama as namapengemudi,ownership.* 
								from (armada,pengemudi) inner join ownership on 
								armada.id = ownership.armada and
								pengemudi.id = ownership.pengemudi order by ownership.id desc');
	}

	function saveDetailownership()
	{
		$data = array('armada' => $_POST['armada'],
					'pengemudi' => $_POST['pengemudi'],
					'nomor' => $_POST['nomor'],
					'tglrequest' => date('Y-m-d', strtotime($_POST['tglrequest'])),
					'harga' => $_POST['harga'],
					'jumlahdp' => $_POST['jumlahdp'],
					'sisa' => $_POST['sisa']);

		$this->db->insert('ownership', $data);
	}
	
	function getDetailownership($id)
	{
		return $this->db->select('select armada.nomorunit,pengemudi.nomor as nomorpengemudi,pengemudi.nama as namapengemudi,ownership.* 
								from (armada,pengemudi) inner join ownership on 
								armada.id = ownership.armada and
								pengemudi.id = ownership.pengemudi where ownership.id = :id', array(':id' => $id));
	}

	function getNomorRequest()
	{
		$sth = $this->db->prepare("select id from ownership order by id desc limit 1");
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$newNumber = $data['id'] + 1;
			return 'RQ-'.$newNumber;
		}
		else
		{
			return 'RQ-1';
		}
	}

	function approveOwnership()
	{
		$id = $_POST['id'];
		$data = array('approve' => 1);
		$this->db->update('ownership', $data, "id = $id");

		$sth = $this->db->prepare("select nomor,tglrequest,jumlahdp from ownership where id = :id");
		$sth->execute(array(':id' => $id));

		$dpData = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$trsData = array('jenistransaksi' => 5,
							'posting' => 'debet',
							'bentuk' => 'TUNAI',
							'nomor' => $this->generateNomorTransaksi(),
							'tanggal' => $dpData['tglrequest'],
							'nilai' => $dpData['jumlahdp'],
							'keterangan' => $dpData['nomor']);
			$this->db->insert('transaksi', $trsData);
		}
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

	function finishOwnershipPayment()
	{
		$id = $_POST['id'];

		$data = array('finished' => 1);

		$this->db->update('ownership', $data, "id = $id");
	}

	function unFinishOwnershipPayment()
	{
		$id = $_POST['id'];

		$data = array('finished' => 0);

		$this->db->update('ownership', $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('ownership', "id = $id");
	}
}