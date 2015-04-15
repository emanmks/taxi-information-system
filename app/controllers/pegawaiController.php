<?php

class Pegawai extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$this->view->listPegawai = $this->model->getListPegawai();
		$this->view->render('pegawai/index');
	}

	function detail($id)
	{
		$this->view->detailPegawai = array_shift($this->model->getDetailPegawai($id));
		$this->view->render('pegawai/detail', true);
	}

	function formAddNew()
	{
		$this->view->render('pegawai/formaddnew', true);
	}

	function formUpdate($id)
	{
		$this->view->detailPegawai = array_shift($this->model->getDetailPegawai($id));
		$this->view->render('pegawai/formupdate', true);
	}

	function save()
	{
		$this->model->saveDetailPegawai();
		$this->index();
	}

	function updateDetail()
	{
		$this->model->updateDetailPegawai();
	}

	function formUploadFoto($id)
	{
		$this->view->ID = $id;
		$this->view->render('pegawai/formuploadfoto',true);
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
						if(move_uploaded_file($tmp, realpath(URL) . "assets/img/pegawai/" . $actual_image_name))
						{
							
							$imagename = $actual_image_name;
							$this->model->updateFotoPegawai($id,$imagename);
							echo "<img src='".URL."assets/img/Pegawai/".$imagename."' class='preview'>";
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

	function delete()
	{
		$this->model->delete();
	}
}