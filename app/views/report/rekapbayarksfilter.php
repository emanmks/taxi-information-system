<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Akumulasi Pembayaran Cicilan KS : <? echo $this->tglAwal.' S/D '.$this->tglAkhir; ?></p>
</div>

<p>Total Record : <? echo count($this->listBayarKS); ?></p>

<table class="table table-bordered table-hover">
<thead>
	<tr>
		<th>No</th>
		<th>Tanggal</th>				
		<th>Pengemudi</th>				
		<th>Target Setoran</th>
		<th>Total Setoran</th>
		<th>Dispensasi</th>
		<th>Bayar Cicilan KS</th>
	</tr>
</thead>

<tbody>
	<? $nomor = 0; $total = 0; $ks = 0; $dispensasi = 0;  $target = 0; $setoran = 0; ?>
	<? foreach ($this->listBayarKS as $key => $value) { ?>
		<? 
			$nomor += 1; 
			$target = $target + $value['target'];
			$total = $total + $value['totalsetoran'];
			$ks = $ks + $value['loanks'];
			$dispensasi = $dispensasi + $value['dispensasi']; 
		?>
		<tr>
			<td><? echo $nomor; ?></td>
			<td><? echo date('d-m-Y', strtotime($value['tglsetoran'])); ?></td>
			<td><? echo $value['namapengemudi']; ?></td>
			<td><? echo $this->pecah($value['target']); ?></td>
			<td><? echo $this->pecah($value['totalsetoran']); ?></td>
			<td><? echo $this->pecah($value['dispensasi']); ?></td>
			<td><? echo $this->pecah($value['loanks']); ?></td>
		</tr>
	<? } ?>
		<tr style="font-weight:bold;">
			<td colspan="3"><span class="pull-right">Total</span></td>
			<td><? echo $this->pecah($target); ?></td>
			<td><? echo $this->pecah($total); ?></td>
			<td><? echo $this->pecah($dispensasi); ?></td>
			<td><? echo $this->pecah($ks); ?></td>
		</tr>
</tbody>
</table>