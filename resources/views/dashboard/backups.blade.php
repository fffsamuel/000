<div class="container-fluid" style="width: 800px;">
	<div class="row backup-section">
		<div class="col-lg-6">
			<a class="btn backup-create">
				<i class="fa fa-download"></i>
				Criar Backup
			</a>
		</div>
		<form id="snapshot-form" method="post" enctype="multipart/form-data" style="display: none">
			@csrf
			<input type="file" name="snapshot" >
		</form>
		<div class="col-lg-6">
			<a class="btn backup-load">
				<i class="fa fa-upload"></i>
				Carregar Backup
			</a>
		</div>
	</div>
</div>