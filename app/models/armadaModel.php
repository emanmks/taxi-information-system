<?php

class armadaModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListArmada()
	{
		return $this->db->select('select * from armada order by id desc');
	}

	function saveDetailArmada()
	{
		$data = array('nomorunit' => $_POST['nomorunit'],
					'merek' => $_POST['merek'],
					'tipe' => $_POST['tipe'],
					'nomorpolisi' => $_POST['nomorpolisi'],
					'nomorrangka' => $_POST['nomorrangka'],
					'nomormesin' => $_POST['nomormesin'],
					'stnk' => $_POST['stnk'],
					'stnkexpire' => date('Y-m-d', strtotime($_POST['stnkexpire'])),
					'operasional' => $_POST['operasional'],
					'kondisi' => $_POST['kondisi'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])),
					'deskripsi' => $_POST['deskripsi']);
		$this->db->insert('armada', $data);

		$id = $this->db->lastInsertId();

		$this->addKeuanganArmada($id,$_POST['targetsetoran'],$_POST['targetcaper'],$_POST['saldocaper']);
		$this->addPemilikArmada($id,$_POST['pemilik']);
	}

	function updateDetailArmada()
	{
		$id = $_POST['id'];
		$data = array('nomorunit' => $_POST['nomorunit'],
					'merek' => $_POST['merek'],
					'tipe' => $_POST['tipe'],
					'nomorpolisi' => $_POST['nomorpolisi'],
					'nomorrangka' => $_POST['nomorrangka'],
					'nomormesin' => $_POST['nomormesin'],
					'stnk' => $_POST['stnk'],
					'stnkexpire' => date('Y-m-d', strtotime($_POST['stnkexpire'])),
					'operasional' => $_POST['operasional'],
					'kondisi' => $_POST['kondisi'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])),
					'deskripsi' => $_POST['deskripsi']);

		$this->db->update('armada', $data, "id = $id");
	}

	function addKeuanganArmada($armada,$targetsetoran,$targetcaper,$saldocaper)
	{
		$data = array('armada' => $armada,
					'targetsetoran' => $targetsetoran,
					'targetcaper' => $targetcaper,
					'saldocaper' => $saldocaper);
		$this->db->insert('keuanganarmada', $data);
	}

	function updateKeuanganArmada()
	{
		$armada = $_POST['armada'];
		$data = array('targetsetoran' => $_POST['targetsetoran'],
					'targetcaper' => $_POST['targetcaper'],
					'saldocaper' => $_POST['saldocaper']);
		$this->db->update('keuanganarmada', $data, "armada = $armada");
	}

	function addPemilikArmada($armada,$pemilik)
	{
		$data = array('armada' => $armada, 'pemilik' => $pemilik);

		$this->db->insert('pemilikarmada', $data);
	}

	function updatePemilikArmada()
	{
		$armada = $_POST['armada'];
		$data = array('pemilik' => $_POST['pemilik']);

		$this->db->update('pemilikarmada', $data, "armada = $armada");
	}	

	function getDetailArmada($id)
	{
		return $this->db->select('select * from armada where id = :id', array(':id' => $id));
	}

	function getDetailPemilik($id)
	{
		return $this->db->select("select pemilik.id,pemilik.pemilik from pemilik inner join pemilikarmada on
								pemilik.id = pemilikarmada.pemilik
								where pemilikarmada.armada = :armada", array(':armada' => $id));
	}

	function getDetailKeuangan($id)
	{
		return $this->db->select("select * from keuanganarmada where armada = :armada", array(':armada' => $id));
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('armada', "id = $id");
	}
}