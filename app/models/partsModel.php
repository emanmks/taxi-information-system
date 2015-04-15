<?php

class partsModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	/* Bagian Master Spare Parts*/

	function getListParts()
	{
		return $this->db->select("select parts.id,parts.kode,parts.nama as namaparts,parts.satuan,parts.hargabeli,parts.hargajual,
							stockparts.quantity,stockparts.quantityoh,stockparts.lastopname,stockparts.keterangan,pegawai.nama from (parts,pegawai) inner join stockparts on
								parts.id = stockparts.parts and pegawai.id = stockparts.pegawai order by id desc");
	}

	function saveDetailParts()
	{
		$data = array('kode' => $_POST['kode'],
					'nama' => $_POST['nama'],
					'satuan' => $_POST['satuan'],
					'hargabeli' => $_POST['hargabeli'],
					'hargajual' => $_POST['hargajual']);

		$this->db->insert('parts', $data);

		$id = $this->db->lastInsertId();
		$this->saveFirstStock($id, $_POST['stock']);
	}

	function saveFirstStock($id, $stock)
	{
		$data = array('parts' => $id,
					'quantity' => $stock,
					'quantityoh' => $stock,
					'lastopname' => date('Y-m-d'),
					'pegawai' => Session::get('user_idPegawai'),
					'keterangan' => 'Stock Pertama');
		$this->db->insert('stockparts', $data);
	}

	function updateDetailParts()
	{
		$id = $_POST['id'];

		$data = array('kode' => $_POST['kode'],
					'nama' => $_POST['nama'],
					'satuan' => $_POST['satuan'],
					'hargabeli' => $_POST['hargabeli'],
					'hargajual' => $_POST['hargajual']);

		$this->db->update('parts', $data, "id = $id");
		echo json_encode($data);
	}

	function delete()
	{
		$id = $_POST['id'];
		$this->db->delete('parts', "id = $id");
		$this->db->delete('stockparts', "parts = $id");
	}

	/* End of Bagian Spare Parts */

	/* Bagian Purchase Order */
	function getListOrder()
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where pencairan = 0 order by orderparts.id desc");
	}

	function getDetailOrder($id)
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where orderparts.id = :id", array(':id' => $id));
	}

	function addNewOrder()
	{
		$data = array('pegawai' => Session::get('user_idPegawai'),
					'nomororder' => $this->generateNomorOrder(),
					'tglorder' => date('Y-m-d'),
					'keterangan' => $_POST['keterangan']);

		$this->db->insert('orderparts', $data);	
	}

	function generateNomorOrder()
	{
		$sth = $this->db->prepare('select id from orderparts order by id desc limit 1');
		$sth->execute();

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$nextID = $data['id']+1;
			return 'TG-PO-'.$nextID;
		}
		else
		{
			return 'TG-PO-'.'1';
		}
	}

	function getListDetailOrder($order)
	{
		return $this->db->select("select parts.kode,parts.nama,parts.satuan,parts.hargabeli,
								detailorderparts.* from parts inner join detailorderparts on 
								parts.id = detailorderparts.parts where detailorderparts.orderparts = :orderparts", array(':orderparts' => $order));
	}

	function approveOrder()
	{
		$id = $_POST['id'];
		$data = array('approve' => 1);

		$this->db->update("orderparts", $data, "id = $id");
	}

	function addDetailOrder()
	{
		$data = array('orderparts' => $_POST['orderparts'],
					'parts' => $_POST['parts'],
					'jumlah' => $_POST['jumlah']);

		$this->db->insert("detailorderparts",$data);
	}

	function updateDetailOrder()
	{
		$id = $_POST['id'];
		$data = array('parts' => $_POST['parts'],
					'jumlah' => $_POST['jumlah']);

		$this->db->update('detailorderparts', $data, "id = $id");
	}

	function removeDetailOrder()
	{
		$id = $_POST['id'];
		$this->db->delete('detailorderparts', "id = $id");
	}

	/* End of Bagian Purchase Order */

	// Function Opname
	function updateStock()
	{
		$parts = $_POST['id'];
		$data = array('quantity' => $_POST['quantity'],
					'quantityoh' => $_POST['quantity'],
					'lastopname' => date('Y-m-d'),
					'pegawai' => Session::get('user_idPegawai'));

		$this->db->update('stockparts', $data, "parts = $parts");
	}

	//FUnction Pencairan
	function getListPencairan()
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where approve = 1 order by orderparts.id desc");
	}

	function getDetailPencairan($id)
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where orderparts.id = :id", array(':id' => $id));
	}

	function getListDetailPencairan($order)
	{
		return $this->db->select("select parts.kode,parts.nama,parts.satuan,parts.hargabeli,
								detailorderparts.* from parts inner join detailorderparts on 
								parts.id = detailorderparts.parts where detailorderparts.orderparts = :orderparts", array(':orderparts' => $order));
	}

	function appPencairan()
	{
		$id = $_POST['id'];

		$data = array('pencairan' => 1);

		$this->db->update('orderparts', $data, "id = $id");

		$dataOrder = $this->db->select("select parts.hargabeli,orderparts.nomororder,detailorderparts.* from (parts,orderparts) 
										inner join detailorderparts on 
										parts.id = detailorderparts.parts and
										orderparts.id = detailorderparts.orderparts where detailorderparts.orderparts  = :orderparts", array(':orderparts' => $id));

		$harga = 0;
		$jumlah = 0;

		foreach ($dataOrder as $key => $value) {
			$harga = $harga + $value['hargabeli'];
			$jumlah = $jumlah + $value['jumlah'];
			$nomor = $value['nomororder'];
		}

		$total = $harga * $jumlah;

		$dataTransaksi = array('jenistransaksi' => 2,
							'posting' => 'kredit',
							'bentuk' =>  'TUNAI',
							'nomor' => $this->generateNomorTransaksi(),
							'tanggal' => date('Y-m-d'),
							'nilai' => $total,
							'keterangan' => 'Purchase Order : '.$nomor);
		$this->db->insert('transaksi', $dataTransaksi);
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

	//Bagian Supply Parts
	function getListSupply()
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where pencairan = 1 order by orderparts.id desc");
	}

	function getDetailSupply($id)
	{
		return $this->db->select("select pegawai.nama as namapegawai,orderparts.* from pegawai inner join orderparts on
								pegawai.id = orderparts.pegawai where orderparts.id = :id", array(':id' => $id));
	}

	function getListDetailSupply($order)
	{
		return $this->db->select("select parts.kode,parts.nama,parts.satuan,parts.hargabeli,
								detailorderparts.* from parts inner join detailorderparts on 
								parts.id = detailorderparts.parts where detailorderparts.orderparts = :orderparts", array(':orderparts' => $order));
	}

	function appSupply()
	{
		$id = $_POST['id'];

		$data = array('supply' => 1);

		$this->db->update('orderparts', $data, "id = $id");

		$dataOrder = $this->db->select("select parts,jumlah from detailorderparts where orderparts  = :orderparts", array(':orderparts' => $id));

		foreach ($dataOrder as $key => $value) {
			$parts = $value['parts'];
			$jumlah = $value['jumlah'];
			$sth = $this->db->prepare("update stockparts set quantity = quantity + $jumlah, quantityoh = quantityoh + $jumlah where parts = :parts");
			$sth->execute(array(':parts' => $parts));
		}
	}
}