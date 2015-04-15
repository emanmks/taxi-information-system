<!-- Main Row 
=============================================== -->
<div class="container-fluid">
	<div class="row-fluid">
		
		<div class="well">
			<h1 class="text-info">Laporan Setoran Harian</h1>
		</div>

		<div class="well">
			<div class="pull-right">
				<button class="btn btn-primary" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>
			</div>

			<input type="text" id="filterTanggal" placeholder="Pilih Tanggal Untuk Filter" value="<? echo date('Y-m-d'); ?>">

			<select id="filterReport" class="span3" onChange="filterKlasifikasi()">
				<option value="0">--Pilih Klasifikasi</option>
				<option value="1">Armada Umum Gowata</option>
				<option value="2">Armada Umum 3G</option>
				<option value="3">Armada Bandara Gowata</option>
				<option value="4">Armada Bandara 3G</option>
			</select>
			
			<div id="printArea">
				
				<div class="reportTitle">
					<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
					<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
					==============================================
					<p>Laporan Setoran Periode : <? echo date('d-m-Y', strtotime($this->currDate)); ?></p>
					<? switch ($this->currKlasifikasi) {
						case '1':
							?><p>Armada Gowata</p><?
							break;

						case '2':
							?><p>Armada 3G</p><?
							break;
						
						case '3':
							?><p>Armada Bandara Gowata</p><?
							break;

						case '4':
							?><p>Armada Bandara 3G</p><?
							break;

						default:
							?><p>Semua Armada</p><?
							break;
					} ?>
				</div>

				<p>Total Pengemudi yang telah menyetor : <? echo count($this->listSetoran); ?></p>

				<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th width="8%">Armada</th>
						<th width="20%">Pengemudi</th>
						<th>Target Setoran</th>
						<th>Total Setoran</th>
						<th>Setoran</th>
						<th>Caper</th>
						<th>Laka</th>
						<th>Cicil KS</th>
						<th>Kurang Setoran</th>
						<th>Tabungan</th>
						<th>Dispen</th>
					</tr>
				</thead>

				<tbody>
					<? $total = 0; $ks = 0; $kurangsetoran = 0; $dispensasi = 0; $laka = 0; $nomor = 0; $target = 0; $setoran = 0; $caper = 0; $tabungan = 0; ?>
					<? foreach ($this->listSetoran as $key => $value) { ?>
						<? 
							$nomor += 1; 
							$target = $target + $value['target'];
							$total = $total + $value['totalsetoran'];
							$setoran = $setoran + $value['setoran'];
							$caper = $caper + $value['caper'];
							$laka = $laka + $value['loanlaka'];
							$ks = $ks + $value['loanks'];
							$kurangsetoran = $kurangsetoran + $value['kurangsetoran'];
							$tabungan = $tabungan + $value['tabungan']; 
							$dispensasi = $dispensasi + $value['dispensasi']; 
						?>
						<tr>
							<td><? echo $nomor; ?></td>
							<td><? echo $value['nomorunit']; ?></td>
							<td><? echo $value['pengemudi']; ?></td>
							<td><? echo $this->pecah($value['target']); ?></td>
							<td><? echo $this->pecah($value['totalsetoran']); ?></td>
							<td><? echo $this->pecah($value['setoran']); ?></td>
							<td><? echo $this->pecah($value['caper']); ?></td>
							<td><? echo $this->pecah($value['loanlaka']); ?></td>
							<td><? echo $this->pecah($value['loanks']); ?></td>
							<td><? echo $this->pecah($value['kurangsetoran']); ?></td>
							<td><? echo $this->pecah($value['tabungan']); ?></td>
							<td><? echo $this->pecah($value['dispensasi']); ?></td>
						</tr>
					<? } ?>
						<tr style="font-weight:bold;">
							<td colspan="3"><span class="pull-right">Total</span></td>
							<td><? echo $this->pecah($target); ?></td>
							<td><? echo $this->pecah($total); ?></td>
							<td><? echo $this->pecah($setoran); ?></td>
							<td><? echo $this->pecah($caper); ?></td>
							<td><? echo $this->pecah($laka); ?></td>
							<td><? echo $this->pecah($ks); ?></td>
							<td><? echo $this->pecah($kurangsetoran); ?></td>
							<td><? echo $this->pecah($tabungan); ?></td>
							<td><? echo $this->pecah($dispensasi); ?></td>
						</tr>
				</tbody>
				</table>

			</div>
			
		</div>
	</div>
</div>

<script type="text/javascript">
	$(function(){
		$('#filterTanggal').datepicker({
			dateFormat : "yy-mm-dd",
			onSelect : function(){
				filterKlasifikasi();
			}
		});
	})

	function filterKlasifikasi()
	{
		var report = $('#filterReport').val();
		var tanggal = $('#filterTanggal').val();

		load('report/filtersetoran/'+tanggal+'_'+report, '#printArea');
	}
</script>