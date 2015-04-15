<!-- Main Row 
=============================================== -->
<div class="container-fluid">
	<div class="row-fluid">
		
		<div class="well">
			<h1 class="text-info">Laporan Rekap Tabungan</h1>
		</div>

		<div class="well">

			<div class="pull-right">
				<button class="btn btn-primary" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>
			</div>

			<br>

			<div id="printArea">

				<div class="reportTitle">
					<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
					<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
					==============================================
					<p>Laporan Rekap Tabungan Pengemudi</p>
				</div>

				<p>Jumlah Pengemudi yang Memiliki Tabungan : <? echo count($this->listSaldoTabungan); ?></p>
				
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>ID Pengemudi</th>
							<th>Pengemudi</th>
							<th>Saldo Tagihan Laka</th>
						</tr>
					</thead>
					
					<tbody id="tblsro">
						<? $nomor = 0; $total = 0; ?>
						<? foreach ($this->listSaldoTabungan as $key => $value) { ?>
							<? $nomor += 1; $total += $value['saldotabungan']; ?>
							<tr id="sro-<? echo $value['id']; ?>">
								<td><? echo $nomor; ?></td>
								<td><? echo $value['idpengemudi']; ?></td>
								<td><? echo $value['namapengemudi']; ?></td>
								<td><? echo $this->pecah($value['saldotabungan']); ?></td>
							</tr>
						<? } ?>
							<tr style="font-weight:bold">
								<td colspan="3"><span class="pull-right">Total Tabungan Pengemudi</span></td>
								<td><? echo $this->pecah($total); ?></td>
							</tr>
					</tbody>
				</table>

			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">

</script>