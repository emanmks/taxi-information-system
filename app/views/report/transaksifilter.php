<div class="reportTitle">	<h4>PD Perdagangan Umum Unit Taksi Gowata</h4>	<h4>PT. Gempita Gemintang Gemilang (3G)</h4>	==============================================	<p>Laporan Arus Kas Periode : <? echo date('d-m-Y', strtotime($this->currDate)); ?></p></div><p>Jumlah Transaksi Hari ini : <? echo count($this->listTransaksi); ?></p><table class="table table-bordered table-hover">	<thead>		<tr>			<th>Nomor</th>			<th>Nomor Transaksi</th>			<th>Jenis Transaksi</th>			<th>Bentuk</th>			<th>Tanggal</th>			<th>Posting</th>			<th>Nilai</th>		</tr>	</thead>		<tbody id="tbltransaksi">		<? 			$nomor = 0;			$debet = 0;			$kredit = 0; 		?>		<? foreach ($this->listTransaksi as $key => $value) { ?>			<? 				$nomor = $nomor + 1;				if($value['posting'] == 'debet')				{					$debet = $debet + $value['nilai'];				}				else				{					$kredit = $kredit + $value['nilai'];				} 			?>			<tr id="transaksi-<? echo $value['id']; ?>">				<td><? echo $nomor; ?></td>				<td><? echo $value['nomor']; ?></td>				<td><? echo $value['jenis']; ?></td>				<td><? echo $value['bentuk']; ?></td>				<td><? echo date('d-m-Y', strtotime($value['tanggal'])); ?></td>				<td><? echo ucwords($value['posting']); ?></td>				<td><? echo $this->pecah($value['nilai']); ?></td>			</tr>		<? } ?>	</tbody></table><p>Total Mutasi Debet / Pemasukan Hari ini : <? echo $this->pecah($debet); ?></p><p>Total Mutasi Kredit / Pengeluaran Hari ini : <? echo $this->pecah($kredit); ?></p>