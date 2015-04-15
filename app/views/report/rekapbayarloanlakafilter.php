<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Akumulasi Pembayaran Tagihan Laka : <? echo $this->tglAwal.' S/D '.$this->tglAkhir; ?></p>
</div>

<p>Total Record : <? echo count($this->listBayarLoanLaka); ?></p>

<table class="table table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>				
		<th>Tanggal Setoran</th>				
		<th>Nomor Tagihan</th>				
		<th>Pengemudi</th>
		<th>Jumlah Bayar</th>
	</tr>
</thead>

<tbody>
	<? $nomor = 0; $total = 0; ?>
	<? foreach ($this->listBayarLoanLaka as $key => $value) { ?>
		<? 
			$nomor += 1; 
			$total = $total + $value['total'];
		?>
		<tr>
			<td><? echo $nomor; ?></td>
			<td><? echo date('d-m-Y', strtotime($value['tglsetoran'])); ?></td>
			<td><? echo $value['nomorloan']; ?></td>
			<td><? echo $value['namapengemudi']; ?></td>
			<td><? echo $this->pecah($value['total']); ?></td>
		</tr>
	<? } ?>
		<tr style="font-weight:bold;">
			<td colspan="4"><span class="pull-right">Total</span></td>
			<td><? echo $this->pecah($total); ?></td>
			<td></td>
		</tr>
</tbody>
</table>