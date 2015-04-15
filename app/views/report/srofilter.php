<div class="reportTitle">
	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>
	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>
	==============================================
	<p>Laporan Armada Keluar Periode : <? echo date('d-m-Y', strtotime($this->currDate)); ?></p>
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

<p>Total Armada Keluar : <? echo count($this->listSRO); ?></p>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nomor</th>
			<th width="25%">Nomor SRO</th>
			<th>Tanggal</th>
			<th>Nomor Unit</th>
			<th>ID Pengemudi</th>
			<th>Nama Pengemudi</th>
			<th>Jam Keluar</th>
		</tr>
	</thead>
	
	<tbody>
		<? $nomor = 0; ?>
		<? foreach ($this->listSRO as $key => $value) { ?>
		<? $nomor += 1; ?>
			<tr id="sro-<? echo $value['id']; ?>">
				<td><? echo $nomor; ?></td>
				<td><? echo $value['nomor']; ?></td>
				<td><? echo date('d-m-Y', strtotime($value['tanggal'])); ?></td>
				<td><? echo $value['nomorunit']; ?></td>
				<td><? echo $value['idpengemudi'];?></td>
				<td><? echo $value['pengemudi']; ?></td>
				<td><? echo date('H:i:s', strtotime($value['tanggal'])); ?></td>
			</tr>
		<? } ?>
	</tbody>
</table>