<?php

class transaksiModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListTransaksi()
	{
		return $this->db->select("select jenistransaksi.jenis,transaksi.* from jenistransaksi inner join transaksi on 
								jenistransaksi.id = transaksi.jenistransaksi where transaksi.tanggal = curdate() order by transaksi.id desc");
	}

	function getDetailTransaksi($id)
	{
		return $this->db->select("select jenistransaksi.jenis,transaksi.* from jenistransaksi inner join transaksi on 
								jenistransaksi.id = transaksi.jenistransaksi where transaksi.id = :id", array(':id' => $id));
	}

	function getListFilteredTransaksi($tgl)
	{
		return $this->db->select("select jenistransaksi.jenis,transaksi.* from jenistransaksi inner join transaksi on 
								jenistransaksi.id = transaksi.jenistransaksi where transaksi.tanggal = :tanggal order by id desc", array(':tanggal' => date('Y-m-d', strtotime($tgl))));
	}

	function saveTransaksi()
	{
		$data = array('jenistransaksi' => $_POST['jenistransaksi'],
					'posting' => $_POST['posting'],
					'bentuk' => $_POST['bentuk'],
					'nomor' => $this->generateNomorTransaksi(),
					'tanggal' => date('Y-m-d', strtotime($_POST['tanggal'])),
					'nilai' => $_POST['nilai'],
					'keterangan' => $_POST['keterangan']);

		$this->db->insert('transaksi', $data);
	}

	function updateTransaksi()
	{
		$id = $_POST['id'];
		$data = array('jenistransaksi' => $_POST['jenistransaksi'],
					'posting' => $_POST['posting'],
					'bentuk' => $_POST['bentuk'],
					'tanggal' => date('Y-m-d', strtotime($_POST['tanggal'])),
					'nilai' => $_POST['nilai'],
					'keterangan' => $_POST['keterangan']);

		$this->db->update('transaksi', $data, "id = $id");
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

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('transaksi', "id = $id");
	}
}