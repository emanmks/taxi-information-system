<!-- Main Row 
=============================================== -->
<div class="container-fluid">
	<div class="row-fluid">
		
		<div class="well">
			<h1 class="text-info">Laporan Perawatan</h1>
		</div>

		<div class="well">
			<div class="pull-right">
				<button class="btn btn-primary" onClick="printArea()"><i class="icon-print icon-white"></i> Cetak</button>
			</div>

			<button class="btn btn-success" onClick="showFormFilter()"><i class="icon-filter icon-white"></i> Filter</button>

			<br><br>
			
			<div id="printArea">
				
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

			</div>
			
		</div>
	</div>
</div>

<!-- Form Filter Laporan [modal]
===================================== -->
<div id="formFilter" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Filter Laporan</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<input type="hidden" name="inputHUserID">

			<div class="control-group">
				<label class="control-label" for="inputAkses">Batas Awal</label>
				<div class="controls">
					<input type="text" id="tglAwal" value="<? echo date('Y-m-d'); ?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="inputAkses">Batas Akhir</label>
				<div class="controls">
					<input type="text" id="tglAkhir" value="<? echo date('Y-m-d'); ?>">
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="filterTanggal()" data-dismiss="modal" aria-hidden="true">Filter</button>
	</div>
</div>
<!-- End of Form Filter Laporan [modal] -->

<script type="text/javascript">
	$(function(){
		$('#tglAwal').datepicker({
			dateFormat : "yy-mm-dd"});

		$('#tglAkhir').datepicker({
			dateFormat : "yy-mm-dd"});
	})

	function filterTanggal()
	{
		var awal = $('#tglAwal').val();
		var akhir = $('#tglAkhir').val();

		load('report/filterperawatan/'+awal+'_'+akhir, '#printArea');
	}

	function showFormFilter()
	{
		$('#formFilter').modal('show');
	}
</script>