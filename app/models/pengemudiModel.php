<?php

class pengemudiModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListPengemudi()
	{
		return $this->db->select('select * from pengemudi order by id desc');
	}

	function saveDetailPengemudi()
	{
		$data = array('nomor' => $_POST['nomor'],
					'nama' => ucwords($_POST['nama']),
					'alamat' => $_POST['alamat'],
					'status' => $_POST['status'],
					'tgllahir' => $_POST['tgllahir'],
					'agama' => $_POST['agama'],
					'pendidikan' => $_POST['pendidikan'],
					'nomorktp' => $_POST['nomorktp'],
					'expirektp' => date('Y-m-d', strtotime($_POST['expirektp'])),
					'jenissim' => $_POST['jenissim'],
					'nomorsim' => $_POST['nomorsim'],
					'simexpire' => date('Y-m-d', strtotime($_POST['simexpire'])),
					'tipe' => $_POST['tipe'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])));
		$this->db->insert('pengemudi', $data);

		$id = $this->db->lastInsertId();

		$this->addSaldoPengemudi($id,$_POST['saldoks'],$_POST['saldoloanlaka'],$_POST['saldotabungan']);
	}

	function updateDetailPengemudi()
	{
		$id = $_POST['id'];
		$data = array('nomor' => $_POST['nomor'],
					'nama' => ucwords($_POST['nama']),
					'alamat' => $_POST['alamat'],
					'status' => $_POST['status'],
					'tgllahir' => $_POST['tgllahir'],
					'agama' => $_POST['agama'],
					'pendidikan' => $_POST['pendidikan'],
					'nomorktp' => $_POST['nomorktp'],
					'expirektp' => date('Y-m-d', strtotime($_POST['expirektp'])),
					'jenissim' => $_POST['jenissim'],
					'nomorsim' => $_POST['nomorsim'],
					'simexpire' => date('Y-m-d', strtotime($_POST['simexpire'])),
					'tipe' => $_POST['tipe'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])));

		$this->db->update('pengemudi', $data, "id = $id");
	}

	function addSaldoPengemudi($pengemudi,$saldoks,$saldoloanlaka,$saldotabungan)
	{
		$data = array('pengemudi' => $pengemudi,
					'saldoks' => $saldoks,
					'saldoloanlaka' => $saldoloanlaka,
					'saldotabungan' => $saldotabungan);
		$this->db->insert('saldopengemudi', $data);
	}

	function updateSaldoPengemudi()
	{
		$pengemudi = $_POST['pengemudi'];
		$data = array('saldoks' => $_POST['saldoks'],
					'saldoloanlaka' => $_POST['saldoloanlaka'],
					'saldotabungan' => $_POST['saldotabungan']);
		$this->db->update('saldopengemudi', $data, "pengemudi = $pengemudi");
	}

	function updateFotoPengemudi($id,$imagename)
	{
		$data = array('foto' => $imagename);

		$this->db->update('pengemudi', $data, "id = $id");
	}

	function getDetailPengemudi($id)
	{
		return $this->db->select('select * from pengemudi where id = :id', array(':id' => $id));
	}

	function getDetailArmada($id)
	{
		return $this->db->select("select armada.nomorunit,armada.nomorpolisi,armada.operasional from armada inner join pemilikarmada on
								armada.id = pemilikarmada.armada where pemilikarmada.pengemudi = :pengemudi", array(':pengemudi' => $id));
	}

	function getDetailSaldo($id)
	{
		return $this->db->select("select * from saldopengemudi where pengemudi = :pengemudi", array(':pengemudi' => $id));
	}

	function aktifkanPengemudi()
	{
		$id = $_POST['id'];
		$data = array('aktif' => 1);

		$this->db->update('pengemudi', $data, "id = $id");
	}

	function nonaktifkanPengemudi()
	{
		$id = $_POST['id'];
		$data = array('aktif' => 0);

		$this->db->update('pengemudi', $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('pengemudi', "id = $id");
		$this->db->delete('saldopengemudi', "pengemudi = $id");
	}
}