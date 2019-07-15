	<div class="modal fade" id="modRegister" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<?php echo form_open('register', 'class="modal-content bg_gray"'); ?>
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">Register</h3>
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
							<?php echo $registerInfoMessage; ?>
							<div class="form-group col-12">
								<label for="emailReg"><b>Email Address</b></label>
								<input type="email" class="form-control rounded" name="email" id="emailReg" maxlength="50" required>
								<?php echo form_error('email','<div class="text-danger">','</div>'); ?>
							</div>
							<div class="form-group col-12">
								<div class="d-flex w-100">
									<label for="passwordReg"><b>Master Password</b></label>
									<div class="ml-auto mr-3">
										<a href="#" data-toggle="popover" data-placement="top" title="<div class='text-center'>Password Tips</div>" data-content="<div class='text-justify'>We encourage you to make a strong password that consists alphabet, number, and symbol.</div>">
											<i class="far fa-question-circle text_purple"></i>
										</a>
									</div>
								</div>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="password" id="passwordReg" maxlength="50" minlength="10" required>
									<div class="input-group-append">
										<a href="#" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
								<div class="text-warning" id="passMessage"></div>
								<?php echo form_error('password','<div class="text-danger">','</div>'); ?>
							</div>
							<div class="form-group col-12">
								<label for="passwordConfReg"><b>Confirm Master Password</b></label>
								<div class="input-group">
									<input type="password" class="form-control rounded" name="reenter-password" id="passwordConfReg" maxlength="50" minlength="10" required>
									<div class="input-group-append">
										<a href="#" class="input-group-text password_toggle"><i class="fas fa-eye-slash"></i></a>
									</div>
								</div>
								<div class="text-warning" id="confMessage"></div>
								<?php echo form_error('reenter-password','<div class="text-danger">','</div>'); ?>
								<hr class="mb-1">
							</div>
							<div class="col-12 text_wrap">
								<p class="bg_grayer p-2 text-justify border"><small>All data in your account is encrypted with your master password. We can't retrieve your forgotten master password, give you hint about your master password or take the responsibility about your Break Free account in case you forget your master password.</small></p>
								<div class="form-check">
									<input type="checkbox" class="form-check-input" id="checkAgreeReg" required>
									<label class="form-check-label" for="checkAgreeReg">I have read the statements above and understand the consequences.</label>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn_purple text-white shadow" name="b_register" value="Register" id="b_register" />
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>