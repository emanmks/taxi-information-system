<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Perawatan : <? echo $this->tglAwal.' S/D '.$this->tglAkhir; ?></p>
</div>

<p>Total Record Perawatan : <? echo count($this->listPerawatan); ?></p>

<table class="table table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>
		<th>Nomor Unit</th>				
		<th>Tanggal</th>				
		<th>Detail</th>
		<th>Biaya Perawatan</th>
		<th>Biaya Parts</th>
	</tr>
</thead>

<tbody>
	<? $nomor = 0; $biayarawat = 0; $biayaparts = 0; ?>
	<? foreach ($this->listPerawatan as $key => $value) { ?>
		<? 
			$nomor += 1; 
			$biayarawat += $value['biayaperawatan'];
			$biayaparts += $value['biayaparts'];
		?>
		<tr>
			<td><? echo $nomor; ?></td>
			<td><? echo $value['nomorunit']; ?></td>
			<td><? echo date('d-m-Y', strtotime($value['tanggal'])); ?></td>
			<td><? echo $value['detail']; ?></td>
			<td><? echo $this->pecah($value['biayaperawatan']); ?></td>
			<td><? echo $this->pecah($value['biayaparts']); ?></td>
		</tr>
	<? } ?>
		<tr style="font-weight:bold;">
			<td colspan="4"><span class="pull-right">Total</span></td>
			<td><? echo $this->pecah($biayarawat); ?></td>
			<td><? echo $this->pecah($biayaparts); ?></td>
		</tr>
</tbody>
</table>