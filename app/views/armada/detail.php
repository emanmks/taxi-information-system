<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h3 class="text-info">Detail Data Armada</h3>		</div>		<center>			<button class="btn btn-mini btn-info" onClick="showHistorySRO()">Lihat History SRO</button>			<button class="btn btn-mini btn-info" onClick="showHistorySetoran()">Lihat History Setoran</button>			<button class="btn btn-mini btn-info" onClick="showHistoryParts()">Lihat History Perawatan</button>			<button class="btn btn-mini btn-info" onClick="showHistoryLaka()">Lihat History Kecelakaan</button>		</center>		<br>		<div class="span6 well">			<legend>Detail Armada</legend>				<table class="table table-hover">					<tbody>						<tr>							<td width="49%"><div class="pull-right">Nomor Unit</div></td>							<td>:</td>							<td width="49%"><strong class="text-info"><? echo $this->detailArmada['nomorunit']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Merek</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['merek']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Type</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['tipe']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Nomor Polisi</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['nomorpolisi']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Nomor Rangka</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['nomorrangka']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Nomor Mesin</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['nomormesin']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Nomor STNK</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['stnk']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">STNK Expire</div></td>							<td>:</td>							<td><strong class="text-info"><? echo date('d-m-Y', strtotime($this->detailArmada['stnkexpire'])); ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Wilayah Operasi</div></td>							<td>:</td>							<td><strong class="text-info"><? echo ucwords($this->detailArmada['operasional']); ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Kondisi</div></td>							<td>:</td>							<td><? echo $this->detailArmada['kondisi'] == "ready" ? "<strong class='text-info'>Siap Operasi</strong>" : "<strong class='text-error'>Trouble</strong>"; ?></td>						</tr>						<tr>							<td><div class="pull-right">Tanggal Gabung</div></td>							<td>:</td>							<td><strong class="text-info"><? echo date('d-m-Y', strtotime($this->detailArmada['tglgabung'])); ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Keterangan/Deskripsi</div></td>							<td>:</td>							<td><strong class="text-info"><? echo $this->detailArmada['deskripsi']; ?></strong></td>						</tr>					</tbody>				</table>				<center><button class="btn btn-mini btn-info" onClick="showFormUpdateDetail(<? echo $this->detailArmada['id'];?>)">Klik Disin untuk Update Data Diatas</button></center>		</div>		<div class="span5 well">			<legend>Kepemilikan Armada</legend>				<table class="table table-hover">					<tbody>						<tr>							<td width="49%"><div class="pull-right">Kepemilikan</div></td>							<td>:</td>							<td width="49%"><strong class="text-warning"><? echo $this->detailPemilik['pemilik']; ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Peserta Kredit</div></td>							<td>:</td>							<td><strong class="text-warning"><? echo empty($this->detailPengemudi['nama']) ? "Tidak Terdaftar" : $this->detailPengemudi['nama']; ?></strong></td>						</tr>					</tbody>				</table>				<center><button class="btn btn-mini btn-info" onClick="showFormUpdateKepemilikan()">Klik Disin untuk Update Data Diatas</button></center>			<br><br>			<legend>Target</legend>				<table class="table table-hover">					<tbody>						<tr>							<td width="49%"><div class="pull-right">Target Setoran</div></td>							<td>:</td>							<td width="49%"><strong class="text-success"><? echo $this->pecah($this->detailKeuangan['targetsetoran']); ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Target Cadangan Perawatan</div></td>							<td>:</td>							<td><strong class="text-success"><? echo $this->pecah($this->detailKeuangan['targetcaper']); ?></strong></td>						</tr>						<tr>							<td><div class="pull-right">Saldo Cadangan Perawatan</div></td>							<td>:</td>							<td><strong class="text-success"><? echo $this->pecah($this->detailKeuangan['saldocaper'],'.',true); ?></strong></td>						</tr>					</tbody>				</table>				<center><button class="btn btn-mini btn-info" onClick="showFormUpdateKeuangan()">Klik Disin untuk Update Data Diatas</button></center>		</div>	</div></div><!-- Form Add PTN [modal]===================================== --><div id="formUpdateKepemilikan" class="modal hide fade" tabindex="-1" aria-hidden="true">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		<h3 id="myModalLabel">Update Kepemilikan Armada</h3>	</div>	<div class="modal-body">		<form class="form-horizontal">			<div class="control-group">				<label class="control-label" for="inputPemilik">Pilih Kepemilikan</label>				<div class="controls">					<input type="hidden" name="inputPemilik">				    <div class="btn-group" data-toggle="buttons-radio">					    <button id="btn3G" type="button" class="btn btn-primary" onClick="OwnerIs3G()">PT. 3G</button>					    <button id="btnPD" type="button" class="btn btn-primary" onClick="OwnerIsPD()">PD. Gowata</button>				    </div>				</div>			</div>		</form>	</div>	<div class="modal-footer">		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>		<button class="btn btn-primary" onClick="updateKepemilikan(<? echo $this->detailArmada['id'];?>)" data-dismiss="modal" aria-hidden="true">Simpan Perubahan</button>	</div></div><!-- End of Form Add PTN [modal] --><!-- Form Add PTN [modal]===================================== --><div id="formUpdateKeuangan" class="modal hide fade" tabindex="-1" aria-hidden="true">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		<h3 id="myModalLabel">Update Target Setoran Armada</h3>	</div>	<div class="modal-body">		<form class="form-horizontal">			<div class="control-group">					<label class="control-label" for="inputTargetSetoran">Target Setoran</label>					<div class="controls">						<span class="add-on">Rp</span>						<input type="text" name="inputTargetSetoran" class="span2" onkeyup="formatNumber(this)" value="<? echo $this->detailKeuangan['targetsetoran']; ?>">						<br>						<small>Cukup ketikkan digit angka (tidak termasuk "titik" dan "koma")</small>					</div>				</div>				<div class="control-group">					<label class="control-label" for="inputTargetCaper">Target Cadangan Perawatan</label>					<div class="controls">						<span class="add-on">Rp</span>						<input type="text" name="inputTargetCaper" class="span2" onkeyup="formatNumber(this)" value="<? echo $this->detailKeuangan['targetcaper']; ?>">						<br>						<small>Cukup ketikkan digit angka (tidak termasuk "titik" dan "koma")</small>					</div>				</div>				<div class="control-group">					<label class="control-label" for="inputSaldoCaper">Saldo Cadangan Perawatan</label>					<div class="controls">						<input type="hidden" name="posisiSaldoCaper">						<div class="btn-group" data-toggle="buttons-radio">						    <button id="btnPositif" type="button" class="btn btn-mini btn-primary" onClick="isPositif()">+</button>						    <button id="btnNegatif" type="button" class="btn btn-mini btn-primary" onClick="isNegatif()">-</button>					    </div>						<span class="add-on">Rp</span>						<input type="text" name="inputSaldoCaper" class="span2" onkeyup="formatNumber(this)" value="<? echo abs($this->detailKeuangan['saldocaper']); ?>">						<br>						<small>Cukup ketikkan digit angka (tidak termasuk "titik" dan "koma")</small>					</div>				</div>			</form>	</div>	<div class="modal-footer">		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>		<button class="btn btn-primary" onClick="updateKeuangan(<? echo $this->detailArmada['id']; ?>)" data-dismiss="modal" aria-hidden="true">Simpan Perubahan</button>	</div></div><!-- End of Form Add PTN [modal] --><script type="text/javascript">	$(function(){		var iniPemilik = <? echo $this->detailPemilik['id']; ?>;		if(iniPemilik == 1)		{			$('#btn3G').click();		}		else if(iniPemilik == 2)		{			$('#btnPD').click();		} 		var nilaiSaldoCaper = <? echo $this->detailKeuangan['saldocaper']; ?>;		if(nilaiSaldoCaper < 0)		{			$('input[name=posisiSaldoCaper]').val('negatif');			$('#btnNegatif').click();		}		else		{			$('input[name=posisiSaldoCaper]').val('positif');			$('#btnpositif').click();		}	})	function OwnerIs3G()	{		$('input[name=inputPemilik]').val(1);	}	function OwnerIsPD()	{		$('input[name=inputPemilik]').val(2);	}	function isPositif()	{		$('input[name=posisiSaldoCaper]').val("positif");	}	function isNegatif()	{		$('input[name=posisiSaldoCaper]').val("negatif");	}	function showFormUpdateDetail(id)	{		load('armada/formupdate/'+id,'#content');	}	function showFormUpdateKepemilikan()	{		$('#formUpdateKepemilikan').modal('show');	}	function showFormUpdateKeuangan()	{		$('#formUpdateKeuangan').modal('show');	}	function updateKepemilikan(armada)	{		var pemilik  = $('input[name=inputPemilik]').val();		$.post(site+'armada/updatepemilik', {armada : armada, pemilik : pemilik}, function(){			var id = armada;			load('armada/detail/'+id, '#content');		});	}	function updateKeuangan(armada)	{		var targetsetoran = $('input[name=inputTargetSetoran]').val();		targetsetoran = parseInt(replaceAll(targetsetoran,',',''));		var targetcaper = $('input[name=inputTargetCaper]').val();		targetcaper = parseInt(replaceAll(targetcaper,',',''));		var posisiSaldoCaper = $('input[name=posisiSaldoCaper]').val();		if(posisiSaldoCaper == 'positif')		{			var saldocaper = $('input[name=inputSaldoCaper]').val();			saldocaper = parseInt(replaceAll(saldocaper,',',''));		}		else		{			var saldocaper = $('input[name=inputSaldoCaper]').val();			saldocaper = parseInt(replaceAll(saldocaper,',',''));			saldocaper *= -1;		}		$.post(site+'armada/updatekeuangan', {armada : armada, targetsetoran : targetsetoran, targetcaper : targetcaper, saldocaper : saldocaper}, 			function(){			var id = armada;			load('armada/detail/'+id, '#content');		});	}</script>