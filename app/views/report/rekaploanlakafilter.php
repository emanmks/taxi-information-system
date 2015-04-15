<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Akumulasi Tagihan Laka : <? echo $this->tglAwal.' S/D '.$this->tglAkhir; ?></p>
</div>

<p>Total Record : <? echo count($this->listLoanLaka); ?></p>

<table class="table table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>				
		<th>Pengemudi</th>				
		<th>Nomor Laka</th>
		<th>Tanggal Laka</th>
		<th>Nomor Tagihan</th>
		<th>Beban Tagihan</th>
		<th>Lunas</th>
	</tr>
</thead>

<tbody>
	<? $nomor = 0; $total = 0; ?>
	<? foreach ($this->listLoanLaka as $key => $value) { ?>
		<? 
			$nomor += 1; 
			$total = $total + $value['bebanlaka'];
		?>
		<tr>
			<td><? echo $nomor; ?></td>
			<td><? echo $value['namapengemudi']; ?></td>
			<td><? echo $value['nomor']; ?></td>
			<td><? echo $value['tanggal']; ?></td>
			<td><? echo $value['nomorloan']; ?></td>
			<td><? echo $this->pecah($value['bebanlaka']); ?></td>
			<td><? echo $value['lunas'] == 1 ? "Lunas" : "Belum" ?></td>
		</tr>
	<? } ?>
		<tr style="font-weight:bold;">
			<td colspan="5"><span class="pull-right">Total</span></td>
			<td><? echo $this->pecah($total); ?></td>
			<td></td>
		</tr>
</tbody>
</table>