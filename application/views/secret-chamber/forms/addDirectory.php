		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<form class="modal-content bg_gray" id="formAddFolder">
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">New Folder</h3>
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
							<div class="form-group col-12">
								<label for="dirName"><b>Folder Name</b></label>
								<input type="text" class="form-control rounded" name="directoryName" id="dirName" maxlength="50" required>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn_purple text-white shadow" id="b_addDirectory" name="b_add_directory" value="Save"/>
					<input type="submit" class="d-none" name="b_add_directory" value="Save"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>