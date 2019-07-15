	<div class="modal fade" id="modLogin" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<?php echo form_open('login', 'class="modal-content bg_gray"'); ?>
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">Log in</h3>
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
							<?php echo $loginInfoMessage; ?>
							<div class="form-group col-12">
								<label for="emailLog"><b>Email Address</b></label>
								<input type="email" class="form-control rounded" name="email" id="emailLog" maxlength="50" required>
							</div>
							<div class="form-group col-12">
								<div class="d-flex w-100">
									<label for="passwordLog"><b>Master Password</b></label>
								</div>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="password" id="passwordLog" maxlength="50" required>
									<div class="input-group-append">
										<a href="#" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn_purple text-white shadow" name="b_login" value="Log in"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>