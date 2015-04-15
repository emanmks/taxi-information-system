<?php

class indexModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function login()
	{
		$sth = $this->db->prepare("select pegawai.nama,user.* from pegawai inner join user on pegawai.id = user.pegawai where user.namauser = :namauser and user.password = :password");
		$sth->execute(array(':namauser' => $_POST['username'], 
			':password' => Hash::create('sha256', $_POST['password'], PASSWORD_HASH_KEY)));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			Session::init();
			Session::set('user_id', $data['id']);
			Session::set('user_idPegawai', $data['pegawai']);
			Session::set('user_namaUser', $data['namauser']);
			Session::set('user_namaLengkap', $data['nama']);
			Session::set('user_akses', $data['akses']);
			Session::set('user_loggedIn', true);

			echo json_encode(array('status' => 'GRANTED'));
		}
		else
		{
			echo json_encode(array('status' => 'DENIED'));
		}
	}

	function getTotalArmada()
	{
		return $this->db->select("select count(nomorunit) as total from armada");
	}

	function getTotalArmadaReady()
	{
		return $this->db->select("select count(id) as total from armada where kondisi = 'ready'");
	}

	function getTotalArmadaTrouble()
	{
		return $this->db->select("select count(id) as total from armada where kondisi = 'trouble'");
	}

	function getTotalSRO()
	{
		return $this->db->select("select count(id) as total from sro where date(tanggal) = curdate()");
	}

	function getLastSRO()
	{
		return $this->db->select("select armada.nomorunit,armada.kondisi,
								pengemudi.nomor as nomorpengemudi,pengemudi.nama,pengemudi.foto,
								sro.nomor 
								from (armada,pengemudi) inner join sro on
								armada.id = sro.armada and
								pengemudi.id = sro.pengemudi where date(tanggal) = curdate() order by sro.id desc limit 1");
	}
}