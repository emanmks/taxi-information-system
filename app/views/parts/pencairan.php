<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h1 class="text-info">Pencairan PO</h1>		</div>		<div class="well">			<table class="table table-bordered table-hover">				<thead>					<tr>						<th>Nomor Order</th>						<th width="10%">Tgl Order</th>						<th>Yang Mengajukan</th>						<th width="30%">Keterangan</th>						<th>Pencairan</th>						<th width='10%'>Aksi</th>					</tr>				</thead>								<tbody id="tblparts">					<? foreach ($this->listPencairan as $key => $value) { ?>						<tr id="order-<? echo $value['id']; ?>">							<td><? echo $value['nomororder']; ?></td>							<td><? echo date('d-m-Y', strtotime($value['tglorder'])); ?></td>							<td><? echo $value['namapegawai']; ?></td>							<td><? echo $value['keterangan']; ?></td>							<td>								<? echo $value['pencairan'] == 1 ? 								"<span class='label label-success'>Sudah</span>" : 								"<span class='label label-warning'>Belum</span>"; ?>							</td>							<td>								<div class="btn-group">									<a class="btn btn-primary" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>									<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="jvascript:void(0)"><span class="caret"></span></a>									<ul class="dropdown-menu">										<li>											<a href="javascript:void(0)" onClick="return showDetailPencairan(<? echo $value['id']; ?>)">											<i class="icon-pencil"></i> Detail Item</a>										</li>										<? if($value['pencairan'] == 0) : ?>										<li>											<a href="javascript:void(0)" onClick="return cairkan(<? echo $value['id']; ?>)">											<i class="icon-ok"></i> Cairkan Dana</a>										</li>										<? endif; ?>									</ul>								</div>							</td>						</tr>					<? } ?>				</tbody>			</table>		</div>	</div></div><!-- Form Add Order Parts [modal]===================================== --><div id="formAddNew" class="modal hide fade" tabindex="-1" aria-hidden="true">	<div class="modal-header">		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>		<h3 id="myModalLabel">Purchase Order</h3>	</div>	<div class="modal-body">		<form class="form-horizontal">			<div class="control-group">				<label class="control-label" for="inputKeterangan">Masukkan Pesan Order</label>				<div class="controls">					<textarea id="inputKeterangan"></textarea>				</div>			</div>						</form>	</div>	<div class="modal-footer">		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>		<button class="btn btn-primary" onClick="addNew()" data-dismiss="modal" aria-hidden="true">Simpan</button>	</div></div><!-- End of Form Add Parts [modal] --><script type="text/javascript">	function showDetailPencairan(id)	{		load('parts/detailpencairan/'+id, '#content');	}	function cairkan(id)	{		$.post(site+'parts/apppencairan', {id : id}, function(){				window.location = site+"parts/pencairan";			});	}</script>