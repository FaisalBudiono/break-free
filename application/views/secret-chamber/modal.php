	<div class="modal fade" id="modalUti" tabindex="-1" role="dialog" aria-hidden="true">
	</div>
	<div class="modal fade" id="modalRndPass" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 1051;">
		<div class="modal-dialog modal-dialog-centered modal" role="document">
			<div class="modal-content bg_gray" id="formAddFolder">
				<div class="modal-header bg_purple text-white">
					<div class="d-flex flex-row justify-content-center w-100">
						<div class="pl-4 mx-auto">
							<h3 class="">Generate Random Password</h3>
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
								<label for="rndPass"><b>Password</b></label>
								<div class="input-group">
									<input type="text" class="form-control rounded" name="accountPassword" id="rndPass" maxlength="50" readonly="true">
									<div class="input-group-append">
										<a href="javascript:void(0)" class="input-group-text text-decoration-none text_purple" id="rndButton" data-toggle="tooltip" data-placement="Top" title="Randomize Password"><i class="fas fa-random"></i></a>
									</div>
								</div>
							</div>
							<div class="form-group col-12">
								<div class="d-flex flex-column">
									<div class="col-12 mb-1"><b>Option:</b></div>
									<div class="col-12">
										<div class="d-flex flex-row align-items-center">
											<div class="col-6">
												<input type="checkbox" class="btn_checkbox rounded mr-2 opRnd" id="opLow" checked="checked">
												<label for="opLow" class="pointer">
													Lowercase
													<div class="text-muted">[a-z]</div>
												</label>
											</div>
											<div class="col-6">
												<input type="checkbox" class="btn_checkbox rounded mr-2 opRnd" id="opUpp" checked="checked">
												<label for="opUpp" class="pointer">
													Uppercase
													<div class="text-muted">[A-Z]</div>
												</label>
											</div>
										</div>
										<div class="d-flex flex-row align-items-center mt-2">
											<div class="col-6">
												<input type="checkbox" class="btn_checkbox rounded mr-2 opRnd" id="opNum" checked="checked">
												<label for="opNum" class="pointer">
													Number
													<div class="text-muted">[0-9]</div>
												</label>
											</div>
											<div class="col-6">
												<input type="checkbox" class="btn_checkbox rounded mr-2 opRnd" id="opSym">
												<label for="opSym" class="pointer">
													Symbol
													<div class="text-muted">[!%@#]</div>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-12">
								<label for="rndLeng"><b>Length</b></label>
								<input type="number" class="form-control rounded" name="accountPassword" id="rndLeng" max="50" value="12">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn_purple text-white shadow" id="rndCopy" value="Copy"/>
					<button type="button" class="btn btn-secondary shadow" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
