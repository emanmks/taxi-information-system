<!-- Main Row =============================================== --><div class="container-fluid">	<div class="row-fluid">				<div class="well">			<h3 class="text-info">Ganti Foto Pegawai</h3>		</div>		<div class="well">			<center>				<form id="imageForm" method="POST" enctype="multipart/form-data" action="<? echo URL; ?>pegawai/uploadfoto">										<input type="hidden" id="id" name="id" value="<? echo $this->ID; ?>">					<input type="file" name="photoimg" id="photoimg">				</form>				<br><br>				<div id="preview"></div>								<br><br>				<button class="btn btn-primary" onClick="details(<? echo $this->ID; ?>)">Simpan Perubahan</button>			</center>		</div>	</div></div><script type="text/javascript" src="<? echo URL; ?>/assets/js/jquery.form.js"></script><script type="text/javascript">	$(function(){		$('#photoimg').live('change', function()		{			$("#preview").html('');			$("#preview").html("<img src='"+site+"assets/img/loading.gif' alt='Uploading....'/>");			$("#imageForm").ajaxForm(			{				target: '#preview'			}).submit();		});	})	function details(id)	{		load('pegawai/detail/'+id,'#content');	}</script>