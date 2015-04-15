<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h1 class="text-info">Setoran Harian</h1>		</div>		<input type="text" id="filterTanggal" value="<? echo date('Y-m-d'); ?>" class="span2">		<div id="dataview">			<div class="span5">				<table class="table table-bordered table-hover">					<thead>						<tr>							<th>Nomor SRO</th>							<th>Armada</th>							<th>Pengemudi</th>							<th width='15%'>Aksi</th>						</tr>					</thead>										<tbody>						<? foreach ($this->listSRO as $key => $value) { ?>							<tr>								<td><strong><small><? echo $value['nomor']; ?></small></strong></td>								<td><strong class="text-info"><? echo $value['nomorunit']; ?></strong></td>								<td><strong class="text-success"><? echo $value['pengemudi']; ?></strong></td>								<td>									<div class="btn-group">										<a class="btn btn-primary" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>										<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>										<ul class="dropdown-menu">											<li>												<a href="javascript:void(0)" onClick="loadFormSetoran(<? echo $value['id']; ?>)">												<i class="icon-tags"></i> Bayar Setoran</a>											</li>										</ul>									</div>								</td>							</tr>						<? } ?>					</tbody>				</table>			</div>			<div class="span6">				<table class="table table-bordered table-hover">					<thead>						<tr>							<th>Armada</th>							<th>Pengemudi</th>							<th>Total Setoran (Rp)</th>							<th width='15%'>Aksi</th>						</tr>					</thead>										<tbody>						<? foreach ($this->listSetoran as $key => $value) { ?>							<tr id="setoran-<? echo $value['id']; ?>">								<td><strong class="text-info"><? echo $value['nomorunit']; ?></strong></td>								<td><strong class="text-success"><? echo $value['pengemudi']; ?></strong></td>								<td>									<strong class="text-info">										<? echo $this->pecah($value['totalsetoran']); ?>									</strong>								</td>								<td>									<div class="btn-group">										<a class="btn btn-primary" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>										<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>										<ul class="dropdown-menu">											<li>												<a href="javascript:void(0)" onClick="kwitansi(<? echo $value['id']; ?>)">												<i class="icon-print"></i> Bukti Setoran</a>											</li>											<? if(Session::get('user_akses') == 'root'): ?>											<li>												<a href="javascript:void(0)" onClick="batalkan(<? echo $value['id']; ?>)">												<i class="icon-remove"></i> Batalkan</a>											</li>											<? endif; ?>										</ul>									</div>								</td>							</tr>						<? } ?>					</tbody>				</table>			</div>			<br><br>		</div>	</div></div><script type="text/javascript">	$(function(){		$('#filterTanggal').datepicker({			dateFormat : "yy-mm-dd",			onSelect : function(date){				load('setoran/filter/'+date,'#dataview');			}		});	})	function loadFormSetoran(id)	{		var status = $('#statusButton').val();		var tanggal = $('#filterTanggal').val();		if(status == 'disable')		{			window.alert("Tidak Dapat Menginput Setoran Beda Tanggal, \nSilakan Melapor ke user dengan Level Admin");			return false;		}		else		{			load('setoran/formsetoran/'+id+'_'+tanggal,'#content');		}	}	function details(id)	{		load('setoran/detail/'+id,'#content');	}	function kwitansi(id)	{		load('setoran/kwitansi/'+id,'#content');	}	function batalkan(id)	{		if(confirm("Anda Yakin Akan Menghapus Data Ini? \nSemua Data Berkaitan dengan Data ini Akan Ikut Terhapus."))		{			$.post(site+'setoran/delete', {id : id}, function(){				var tanggal = $('#filterTanggal').val();				load('setoran/filter/'+tanggal, '#dataview');			});		}	}</script>