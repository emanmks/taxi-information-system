<?php

class Pengemudi extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listPengemudi = $this->model->getListPengemudi();
		$this->view->render('pengemudi/index');
	}

	function detail($id)
	{
		$this->view->detailPengemudi = array_shift($this->model->getDetailPengemudi($id));
		$this->view->detailArmada = array_shift($this->model->getDetailArmada($id));
		$this->view->detailSaldo = array_shift($this->model->getDetailSaldo($id));
		$this->view->render('pengemudi/detail', true);
	}

	function formAddNew()
	{
		$this->view->render('pengemudi/formaddnew', true);
	}

	function formUpdate($id)
	{
		$this->view->detailPengemudi = array_shift($this->model->getDetailPengemudi($id));
		$this->view->render('pengemudi/formupdate', true);
	}

	function save()
	{
		$this->model->saveDetailPengemudi();
		$this->index();
	}

	function updateDetail()
	{
		$this->model->updateDetailPengemudi();
	}

	function updateSaldo()
	{
		$this->model->updatesaldoPengemudi();
	}

	function formUploadFoto($id)
	{
		$this->view->ID = $id;
		$this->view->render('pengemudi/formuploadfoto',true);
	}

	function uploadFoto()
	{
		$valid_formats = array("jpg", "png", "gif", "bmp","jpeg");
		if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
		{
			$name = $_FILES['photoimg']['name'];
			$size = $_FILES['photoimg']['size'];
			$id = $_POST['id'];
			if(strlen($name))
			{
				list($txt, $ext) = explode(".", $name);
				if(in_array($ext,$valid_formats))
				{
					if($size<(1024*1024)) // Image size max 1 MB
					{
						$actual_image_name = time().$id.".".$ext;
						$tmp = $_FILES['photoimg']['tmp_name'];
						if(move_uploaded_file($tmp, realpath(URL) . "assets/img/pengemudi/" . $actual_image_name))
						{
							
							$imagename = $actual_image_name;
							$this->model->updateFotoPengemudi($id,$imagename);
							echo "<img src='".URL."assets/img/pengemudi/".$imagename."' class='preview'>";
						}
						else
						echo "Upload Foto Gagal";
					}
					else
					echo "Ukuran Image Max 1 MB";
				}
				else
				echo "Format File Tidak Valid..";
			}
			else
			echo "Silakan Pilih Foto yang akan diupload!";
			exit;
		}
	}

	function aktif()
	{
		$this->model->aktifkanPengemudi();
	}

	function nonaktif()
	{
		$this->model->nonaktifkanPengemudi();
	}

	function delete()
	{
		$this->model->delete();
	}
}