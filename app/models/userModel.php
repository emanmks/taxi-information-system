<?php

class userModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('pegawai' => $_POST['pegawai'],
					'namauser' => $_POST['namauser'],
					'password' => Hash::create('sha256', $_POST['password'], PASSWORD_HASH_KEY),
					'akses' => $_POST['akses']);
		$this->db->insert('user', $data);
	}

	function updatePassword()
	{
		$data = array('password' => Hash::create('sha256', $_POST['password'], PASSWORD_HASH_KEY));
		$id = $_POST['id'];
		$this->db->update('user', $data, "id = $id");
	}

	function resetPassword()
	{
		$data = array('password' => Hash::create('sha256', 'gowata', PASSWORD_HASH_KEY));
		$id = $_POST['id'];
		$this->db->update('user', $data, "id = $id");
	}

	function setAkses()
	{
		$data = array('akses' => $_POST['akses']);
		$id = $_POST['id'];
		$this->db->update('user', $data, "id = $id");
	}

	function getUserLists()
	{
		return $this->db->select("select pegawai.nama as namapegawai,user.* from pegawai inner join user on pegawai.id = user.pegawai order by user.id asc");
	}

	function getListPegawai()
	{
		return $this->db->select("select id,nomorpegawai,nama from pegawai order by id asc");
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('user', "id = $id");
	}
}