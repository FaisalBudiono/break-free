		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<form class="modal-content bg_gray" id="formAddAccount">
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">New Account</h3>
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
							<div class="form-group col-6">
								<label for="accName"><b>Account Name</b></label>
								<input type="text" class="form-control rounded" name="accountName" id="accName" maxlength="50" required>
							</div>
							<div class="form-group col-6">
								<label for="accDirName"><b>Folder</b></label>
								<select class="custom-select" name="accountDirectory" id="accDirName">
									<option value="0">None</option>
									<?php
									foreach ($dir as $value) {
										echo "<option value=\"$value[id_directory]\">$value[directory_name]</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group col-12">
								<label for="accSite"><b>Site</b></label>
								<input type="text" class="form-control rounded" name="accountSite" id="accSite" maxlength="50">
							</div>
							<div class="form-group col-6">
								<label for="accUsername"><b>Username</b></label>
								<input type="text" class="form-control rounded" name="accountUsername" id="accUsername" maxlength="50">
							</div>
							<div class="form-group col-6">
								<div class="d-flex w-100">
									<label for="accPassword"><b>Password</b></label>
									<div class="ml-auto mr-3">
										<a class="justify-content-center text-decoration-none rndPass" href="javascript:void(0)" data-toggle="tooltip" data-placement="left" title="Generate Random Password">
											<i class="fas fa-key text_purple"></i>
										</a>
									</div>
								</div>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="accountPassword" id="accPassword" maxlength="50">
									<div class="input-group-append">
										<a href="javascript:void(0)" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
							</div>
							<div class="form-group col-12">
								<label for="accNote"><b>Note</b></label>
								<textarea class="form-control" name="accountNote" id="accNote"></textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn_purple text-white shadow" id="b_addAccount" name="b_add_account" value="Save"/>
					<input type="submit" class="d-none" name="b_add_account" value="Save"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>