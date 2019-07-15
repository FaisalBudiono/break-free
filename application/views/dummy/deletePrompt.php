	<div class="modal fade" id="modalUti" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<form class="modal-content bg_gray" id="formAddFolder">
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">Delete Account</h3>
						</div>
						<div class="">
							<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<p>
									Are you sure want to delete <b>[Account Name][Account Name][Account Name]12345678</b> account?
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-danger text-white shadow" id="delYes" value="Yes"/>
					<input type="submit" class="d-none" value="Save"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
<script type="text/javascript">
	$(function(){
		$('#modalUti').modal('show');
	});
</script>