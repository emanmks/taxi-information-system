<?php		//Data	$tanggal = date("d-m-Y", strtotime($this->detailSRO['tanggal']));	$jam = date("H:i:s", strtotime($this->detailSRO['tanggal']));	$nomorsro = $this->detailSRO['nomor'];	$pengemudi = $this->detailSRO['namapengemudi'];	$idPengemudi = $this->detailSRO['idpengemudi'];	$armada = $this->detailSRO['nomorunit'];	$noPolisi = $this->detailSRO['nomorpolisi'];	$namaPegawai = $this->detailSRO['namapegawai'];	//Pilih Printer	$printer = printer_open("\\\\GOWATA-KSR\\Epson LX-300+1");	printer_set_option($printer, PRINTER_MODE, "RAW");	//Inisiasi	printer_start_doc($printer);	printer_start_page($printer);	//Menentukan Font dan Ukurannya	$hrf = printer_create_font("Arial", 10, 10, 10, 0, 0, 0, 0);	printer_select_font($printer, $hrf);	//Layout	printer_draw_text($printer, "PD. Perdagangan Umum Unit Taksi Gowata",100,10);	printer_draw_text($printer, "PT. Gempita Gemintang Gemilang (3G)",100,20);	printer_draw_text($printer, "===============================================",100,30);	printer_draw_text($printer, "",100,40);	printer_draw_text($printer, "SURAT REKOMENDASI OPERASI  ",350,50);	printer_draw_text($printer, "--------------------------------------------------------------------------------",100,60);	printer_draw_text($printer, "No. SRO : ".$nomorsro,300,70);	printer_draw_text($printer, "--------------------------------------------------------------------------------",100,80);	printer_draw_text($printer, "",100,90);	printer_draw_text($printer, "Diberikan Rekomendasi Untuk Operasi Kepada:",100,100);	printer_draw_text($printer, "Nama							: ".$pengemudi,100,110);	printer_draw_text($printer, "ID Pengemudi					: ".$idPengemudi,100,120);	printer_draw_text($printer, "",100,130);	printer_draw_text($printer, "No Unit						: ".$armada,100,140);	printer_draw_text($printer, "No. Polisi						: ".$noPolisi,100,150);	printer_draw_text($printer, "",100,160);	printer_draw_text($printer, "Tanggal Orientasi 				: ".$tanggal,100,170);	printer_draw_text($printer, "Jam Orientasi					: ".$jam,100,180);	printer_draw_text($printer, "",100,190);	printer_draw_text($printer, "--------------------------------------------------------------------------------",100,200);	printer_draw_text($printer, "",100,210);	printer_draw_text($printer, "Sungguminasa, ".$tanggal,100,220);	printer_draw_text($printer, "Bagian SRO",100,230);	printer_draw_text($printer, "",100,240);	printer_draw_text($printer, "",100,250);	printer_draw_text($printer, "",100,260);	printer_draw_text($printer, $namaPegawai,100,270);														//Finishing Printing	printer_end_page($printer);	printer_end_doc($printer);	printer_close($printer);	?><!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h3 class="text-info">SRO</h3>		</div>		<br>		<div id="bodyPrint" class="well span8">			<div style="margin-left:60px">PD. Perdagangan Umum Unit Taksi Gowata</div>			<div style="margin-left:70px">PT. Gempita Gemintang Gemilang (3G)</div> 			==================================================<br>			<div style="margin-left:90px">SURAT REKOMENDASI OPERASI</div>			--------------------------------------------------------------------------------<br>			<div style="margin-left:70px">No. SRO : <? echo $nomorsro; ?></div>			--------------------------------------------------------------------------------<br>			Diberikan Rekomendasi Untuk Operasi Kepada:<br>			Nama							: <? echo $pengemudi; ?><br>			ID Pengemudi					: <? echo $idPengemudi; ?><br>			<br>			No Unit							: <? echo $armada; ?><br>			No. Polisi						: <? echo $noPolisi; ?><br>			<br>			Tanggal Orientasi 				: <? echo $tanggal; ?><br>			Jam Orientasi					: <? echo $jam; ?><br>			--------------------------------------------------------------------------------<br>			<div style="margin-left:200px">Sungguminasa, <? echo $tanggal; ?></div>			<div style="margin-left:200px">Bagian SRO</div>			<br>			<br>			<br>			<div style="margin-left:200px"><? echo $namaPegawai; ?></div>						<center>				<button class="btn btn-mini btn-info" onClick="kembali()">Kembali</button>			</center>		</div>	</div></div><script type="text/javascript">	function kembali()	{		window.location = site+"sro";	}</script>