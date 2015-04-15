<div class="container-fluid">
	<div class="row-fluid">
		<div class="well">
			<h1 class="text-info">Data User</h1>
		</div>
	</div>
	
	<div class="pull-right"> 
	<button class="btn btn-success" onClick="showFormAddUser()">Tambah Baru</button> 
	</div> <br><br>

	<div id="dataview">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Nama Pegawai</th>
					<th>Nama User</th>
					<th>Hak Akses</th>
					<th width="10%">Aksi</th>
				</tr>	
			</thead>
			<tbody>
				<? foreach ($this->userLists as $key => $value) { ?>
					<tr>
						<td><? echo $value['employeename']; ?></td>
						<td><? echo $value['namauser']; ?></td>
						<td>
							<? switch ($value['akses']) {
								case 'admin':
									echo 'Administrator';
									break;
								case 'cashier':
									echo 'Kasir';
									break;
								case 'inventory':
									echo 'Inventory';
									break;
								default:
									echo 'Tidak Diketahui';
									break;
							} ?>
						</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-primary" href="javascript:void(0)"><i class="icon-edit icon-white"></i> Aksi</a>
								<a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="javascript:void(0)"><span class="caret"></span></a>
								<ul class="dropdown-menu">
									<li>
										<a href="javascript:void(0)" onClick="showFormUpdatePassword(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Update Password</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="resetPassword(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Reset Password</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="showFormSetAkses(<? echo $value['id']; ?>)">
										<i class="icon-list-alt"></i> Set Hak Akses</a>
									</li>
									<li>
										<a href="javascript:void(0)" onClick="remove(<? echo $value['id']; ?>)">
										<i class="icon-remove"></i> Hapus</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>	
				<? } ?>
			</tbody>
		</table>
	</div>	
		
</div>

<!-- Form Update Password [modal]
===================================== -->
<div id="formUpdatePassword" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Update Password</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<input type="hidden" name="inputUserID">

			<div class="control-group">
				<label class="control-label" for="inputUserPassword">Password Baru</label>
				<div class="controls">
					<input type="password" name="inputUserPassword" class="span2">
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="gantiPassword()" data-dismiss="modal" aria-hidden="true">Update Password!!</button>
	</div>
</div>
<!-- End of Form Reset Password [modal] -->

<!-- Form Set Akses [modal]
===================================== -->
<div id="formSetAkses" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Set Hak Ases</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<input type="hidden" name="inputHUserID">

			<div class="control-group">
				<label class="control-label" for="inputAkses">Hak Akses</label>
				<div class="controls">
					<select name="inputAkses">
						<option value="">--Pilih</option>
						<option value="admin">Administrator</option>
						<option value="cashier">Kasir</option>
						<option value="inventory">Inventory</option>
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="setAkses()" data-dismiss="modal" aria-hidden="true">Terapkan</button>
	</div>
</div>
<!-- End of Form Reset Password [modal] -->

<!-- Form Add User [modal]
===================================== -->
<div id="formAddNewUser" class="modal hide fade" tabindex="-1" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3 id="myModalLabel">Tambah User</h3>
	</div>

	<div class="modal-body">
		<form class="form-horizontal">
			<div class="control-group">
				<label class="control-label" for="inputNewPegawai">Pegawai</label>
				<div class="controls">
					<select name="inputNewPegawai" class="span3">
						<option value="0">--Pilih Pegawai</option>
						<? foreach ($this->listPegawai as $key => $value) { ?>
							<option value="<? echo $value['id']; ?>"><? echo $value['nomorpegawai'].'-'.$value['nama']; ?></option>
						<? } ?>
					</select>
				</div>
			</div>	

			<div class="control-group">
				<label class="control-label" for="inputNewUserName">Nama User</label>
				<div class="controls">
					<input name="inputNewUserName" class="span2" type="text">
				</div>
			</div>	

			<div class="control-group">
				<label class="control-label" for="inputNewUserPassword">Password</label>
				<div class="controls">
					<input type="password" name="inputNewUserPassword" class="span2">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="inputNewAkses">Hak Akses</label>
				<div class="controls">
					<select name="inputNewAkses">
						<option value="">--Pilih</option>
						<option value="root">Super Admin</option>
						<option value="operation">Operasional</option>
						<option value="parts">Perawatan</option>
						<option value="loket">Loket/Kasir</option>
						<option value="money">Keuangan</option>
					</select>
				</div>
			</div>
		</form>
	</div>

	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Batal</button>
		<button class="btn btn-primary" onClick="addNew()" data-dismiss="modal" aria-hidden="true">Tambah User</button>
	</div>
</div>
<!-- End of Add User [modal] -->

<script type="text/javascript">
	function addNew()
	{
		var pegawai = $('select[name=inputNewPegawai]').val();
		var namauser = $('input[name=inputNewUserName]').val();
		var password = $('input[name=inputNewUserPassword]').val();
		var akses = $('select[name=inputNewAkses]').val();

		if(pegawai != 0 || namauser != '' || password != '' || akses != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/addnew',
				data:{pegawai : pegawai, namauser : namauser, password : password, akses : akses},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
		
	}

	function gantiPassword()
	{
		var id = $('input[name=inputUserID]').val();
		var password = $('input[name=inputUserPassword]').val();

		if(id != '' || password != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/updatepassword',
				data:{id : id, password : password},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
	}

	function setAkses()
	{
		var id = $('input[name=inputHUserID]').val();
		var akses = $('select[name=inputAkses]').val();

		if(id != '' || akses != '')
		{
			$.ajax({
				type:'POST',
				url:site+'/user/setakses',
				data:{id : id, akses : akses},
				dataType:'json',
				cache:false,
				success:function()
				{
					window.location = site+"user";
				}
			});
		}
		else
		{
			window.alert('Mohon Lengkapi Data yang harus Diinput');
		}
	}

	function resetPassword(id)
	{
		$.ajax({
			type:'POST',
			url:site+'/user/resetpassword',
			data:{id : id},
			dataType:'json',
			cache:false,
			success:function()
			{
				window.location = site+"user";
			}
		});
	}

	function remove(id)
	{
		$.ajax({
			type:'POST',
			url:site+'/user/delete',
			data:{id : id},
			dataType:'json',
			cache:false,
			success:function()
			{
				window.location = site+"user";
			}
		});
	}

	function showFormUpdatePassword(id)
	{
		$('#formUpdatePassword').modal('show');
		$('input[name=inputUserID]').val(id);
	}

	function showFormSetAkses(id)
	{
		$('#formSetAkses').modal('show');
		$('input[name=inputHUserID]').val(id);
	}

	function showFormAddUser()
	{
		$('#formAddNewUser').modal('show');
	}
</script>