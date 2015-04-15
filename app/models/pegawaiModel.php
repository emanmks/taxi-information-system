<?php

class pegawaiModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListPegawai()
	{
		return $this->db->select('select * from pegawai order by id desc');
	}

	function saveDetailPegawai()
	{
		$data = array('nomorpegawai' => $_POST['nomorpegawai'],
					'nama' => $_POST['nama'],
					'alamat' => $_POST['alamat'],
					'status' => $_POST['status'],
					'tgllahir' => date('Y-m-d', strtotime($_POST['tgllahir'])),
					'agama' => $_POST['agama'],
					'pendidikan' => $_POST['pendidikan'],
					'posisi' => $_POST['posisi'],
					'jabatan' => $_POST['jabatan'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])));

		$this->db->insert('pegawai', $data);
	}

	function updateDetailPegawai()
	{
		$id = $_POST['id'];

		$data = array('nomorpegawai' => $_POST['nomorpegawai'],
					'nama' => $_POST['nama'],
					'alamat' => $_POST['alamat'],
					'status' => $_POST['status'],
					'tgllahir' => date('Y-m-d', strtotime($_POST['tgllahir'])),
					'agama' => $_POST['agama'],
					'pendidikan' => $_POST['pendidikan'],
					'posisi' => $_POST['posisi'],
					'jabatan' => $_POST['jabatan'],
					'tglgabung' => date('Y-m-d', strtotime($_POST['tglgabung'])));

		$this->db->update('pegawai', $data, "id = $id");
	}

	function updateFotopegawai($id,$imagename)
	{
		$data = array('foto' => $imagename);

		$this->db->update('pegawai', $data, "id = $id");
	}

	function getDetailPegawai($id)
	{
		return $this->db->select('select * from pegawai where id = :id', array(':id' => $id));
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('pegawai', "id = $id");
	}
}