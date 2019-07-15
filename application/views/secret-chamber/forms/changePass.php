		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<form class="modal-content bg_gray" id="formUpdate">
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">Change Master Password</h3>
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
								<label for="oldPass"><b>Old Master Password</b></label>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="oldPass" id="oldPass" minlength="10" maxlength="50" required>
									<div class="input-group-append">
										<a href="javascript:void(0)" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
								<div class="text-warning" id="oldPassMessage"></div>
							</div>
							<div class="form-group col-12">
								<label for="newPass"><b>New Master Password</b></label>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="newPass" id="newPass" minlength="10" maxlength="50" required>
									<div class="input-group-append">
										<a href="javascript:void(0)" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
								<div class="text-warning" id="passMessage"></div>
							</div>
							<div class="form-group col-12">
								<label for="newPassConf"><b>Confirm New Master Password</b></label>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="newPassConf" id="newPassConf" minlength="10" maxlength="50" required>
									<div class="input-group-append">
										<a href="javascript:void(0)" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
								<div class="text-warning" id="confMessage"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn_purple text-white shadow" id="b_changePass" name="b_changePass" value="Save" disabled="true">
					<input type="submit" class="d-none" id="sub_changePass" name="b_changePass" value="Save" disabled="true"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>