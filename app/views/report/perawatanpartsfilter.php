<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Pemakaian Spare Parts Periode : <? echo $this->tglAwal.' S/D '.$this->tglAkhir; ?></p>
</div>

<p>Total Record : <? echo count($this->listPerawatanParts); ?></p>

<table class="table table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>
		<th>Nomor Unit</th>				
		<th>Tanggal</th>				
		<th>Kode Parts</th>
		<th>Nama Spare Parts</th>
		<th>Harga Jual</th>
	</tr>
</thead>

<tbody>
	<? $nomor = 0; $hargajual = 0; ?>
	<? foreach ($this->listPerawatanParts as $key => $value) { ?>
		<? 
			$nomor += 1; 
			$hargajual += $value['hargajual'];
		?>
		<tr>
			<td><? echo $nomor; ?></td>
			<td><? echo $value['nomorunit']; ?></td>
			<td><? echo date('d-m-Y', strtotime($value['tanggal'])); ?></td>
			<td><? echo $value['kode']; ?></td>
			<td><? echo $value['nama']; ?></td>
			<td><? echo $this->pecah($value['hargajual']); ?></td>
		</tr>
	<? } ?>
		<tr style="font-weight:bold;">
			<td colspan="5"><span class="pull-right">Total</span></td>
			<td><? echo $this->pecah($hargajual); ?></td>
		</tr>
</tbody>
</table>