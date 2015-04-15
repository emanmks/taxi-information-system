<?php

class lakaModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getListLaka()
	{
		return $this->db->select('select armada.nomorunit,pengemudi.nama as namapengemudi,kecelakaan.*
								from (armada,pengemudi) inner join kecelakaan 
								on armada.id = kecelakaan.armada and pengemudi.id = kecelakaan.pengemudi order by kecelakaan.id desc');
	}

	function saveDetailLaka()
	{
		$data = array('armada' => $_POST['armada'],
					'pengemudi' => $_POST['pengemudi'],
					'pegawai' => Session::get('user_idPegawai'),
					'nomorlaka' => $this->generateNomorLaka(),
					'tanggal' => date('Y-m-d', strtotime($_POST['tanggal'])),
					'biayaparts' => $_POST['biayaparts'],
					'biayaurus' => $_POST['biayaurus'],
					'biayalain' => $_POST['biayalain'],
					'kejadian' => $_POST['kejadian']);

		$this->db->insert('kecelakaan', $data);

		$id = $this->db->lastInsertId();

		$this->insertLoanLaka($data['pengemudi'],$data['pegawai'],$id,$data['biayaparts']+$data['biayaurus']+$data['biayalain']);
		$this->updateSaldoPengemudi($data['pengemudi'],$data['biayaparts']+$data['biayaurus']+$data['biayalain']);
	}

	function generateNomorLaka()
	{
		$sth = $this->db->prepare('select id from kecelakaan order by id desc limit 1');
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$id = $data['id']+1;
			return $nomorLaka = 'KL-'.$id;
		}
		else{
			return $nomorLaka = 'KL-1';
		}
	}

	function insertLoanLaka($pengemudi,$pegawai,$laka,$beban)
	{
		$data = array('pengemudi' => $pengemudi,
					'pegawai' => $pegawai,
					'laka' => $laka,
					'nomorloan' => $this->generateNomorLoanLaka(),
					'bebanlaka' => $beban);

		$this->db->insert('loanlaka', $data);
	}

	function generateNomorLoanLaka()
	{
		$sth = $this->db->prepare('select id from loanlaka order by id desc limit 1');
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$id = $data['id']+1;
			return $nomorLoanLaka = 'LK-'.$id;
		}
		else{
			return $nomorLoanLaka = 'LK-1';
		}
	}

	function updateSaldoPengemudi($pengemudi,$loanlaka)
	{
		$sth = $this->db->prepare("select saldoloanlaka from saldopengemudi where pengemudi = :pengemudi");
		$sth->execute(array(':pengemudi' => $pengemudi));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$nLoanLaka = $data['saldoloanlaka'] + $loanlaka;

			$data = array('saldoloanlaka' => $nLoanLaka);
			$this->db->update("saldopengemudi", $data, "pengemudi = $pengemudi");
		}
	}

	function getDetailLaka($id)
	{
		return $this->db->select('select armada.nomorunit,pengemudi.nama as namapengemudi,kecelakaan.*
								from (armada,pengemudi,sro) inner join kecelakaan 
								on armada.id = kecelakaan.armada and  pengemudi.id = kecelakaan.pengemudi
								where kecelakaan.id = :id', array(':id' => $id));
	}

	function getDetailLoanLaka($laka)
	{
		return $this->db->select("select * from loanlaka where laka = :laka", array(':laka' => $laka));
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('kecelakaan', "id = $id");

		$sth = $this->db->prepare('select pengemudi,bebanlaka from loanlaka where laka = :laka');
		$sth->execute(array(':laka' => $id));

		$data = $sth->fetch();
		$this->kurangiSaldoLoanLaka($data['pengemudi'],$data['bebanlaka']);

		$this->db->delete('loanlaka', "laka = $id");
	}

	function kurangiSaldoLoanLaka($pengemudi,$bebanlaka)
	{
		$sth = $this->db->prepare('select saldoloanlaka from saldopengemudi where pengemudi = :pengemudi');
		$sth->execute(array(':pengemudi' => $pengemudi));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$this->db->update("saldopengemudi",array('saldoloanlaka' => $data['saldoloanlaka'] - $bebanlaka),"pengemudi = $pengemudi");
		}
	}

	function lunasLoanLaka()
	{
		$id = $_POST['id'];
		$data = array('lunas' => 1);
		$this->db->update("loanlaka", $data, "id = $id");
	}
}