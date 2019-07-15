	<div class="container shadow-lg border rounded bg-white py-3 mb-3">
		<div class="row">
			<!-- Account Folder List -->
			<div class="col-12 flex-column mb-3">
				<div class="d-flex justify-content-between align-items-center folderName">
					<a class="d-flex align-items-center col text-body text-decoration-none" data-toggle="collapse" href="#directoryX" role="button" aria-expanded="false" aria-controls="directoryX">
						<h4 class="py-2 text_wrap">Folder Name</h4>
						<h4><i class="fas fa-caret-down ml-2" id="directoryCaret"></i></h4>
					</a>
					<div class="d-lg-none col-auto text-right mr-2" id="folderOption">
						<div class="btn-group dropleft">
							<button type="button" class="py-1 px-2 btn rounded shadow" id="dirDataX" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
								<h4 class="m-0"><i class="fas fa-ellipsis-h"></i></h4>
							</button>
							<div class="dropdown-menu" aria-labelledby="dirDataX" data-dir="[idDirX]">
								<a class="dropdown-item edtDir" href="#">Rename Folder</a>
								<a class="dropdown-item delDir" href="#">Delete Folder</a>
							</div>
						</div>
					</div>
				</div>
				<div class="collapse show multi-collapse" id="directoryX">
					<hr class="separator my-2">
					<!-- Account Data List -->
					<div class="d-flex align-items-center py-2 px-3 mx-2 dataItem">
						<input type="checkbox" class="btn_account col-auto">
						<div class="d-flex flex-column align-items-start mx-2 col-lg-4 col-5">
							<div class="d-inline-block text-truncate w-100"><big>Account Name</big></div>
							<div class="d-inline-block text-truncate w-100 userTarget">Username</div>
						</div>
						<div class="d-sm-flex flex-column align-items-start col-sm-3 d-none px-0">
							<div class="d-sm-none d-md-flex"><big>Last Modified</big></div>
							<div id="lastMod[idDataX]" class="text-muted">23 minutes ago</div>
						</div>
						<div class="d-flex justify-content-end ml-auto px-0 col-auto">
							<div class="mr-2 dropleft">
								<a class="text-dark text-decoration-none" id="accDataX" role="button" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
									<i class="fas fa-edit btn_account"></i>
								</a>
								<div class="dropdown-menu" aria-labelledby="accDataX" data-acc="[idDataX]">
									<a class="dropdown-item edtAcc" href="#">Edit Account</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item cpyUsername" href="#">Copy Username</a>
									<a class="dropdown-item cpyPass" href="#">Copy Password</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item text-danger delAcc" href="#">Delete Account</a>
								</div>
							</div>
							<a class="text-danger text-decoration-none delAcc" href="javascript:void(0)">
								<div class="ml-2"><i class="far fa-trash-alt btn_account"></i></div>
							</a>
						</div>
					</div>

					<!-- Account Data List -->
					<div class="d-flex align-items-center py-2 px-3 mx-2 dataItem">
						<input type="checkbox" class="btn_account col-auto">
						<div class="d-flex flex-column align-items-start mx-2 col-lg-4 col-5">
							<div class="d-inline-block text-truncate w-100"><big>Account Name</big></div>
							<div class="d-inline-block text-truncate w-100 userTarget">Usernameeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee</div>
						</div>
						<div class="d-sm-flex flex-column align-items-start col-sm-3 d-none px-0">
							<div class="d-sm-none d-md-flex"><big>Last Modified</big></div>
							<div id="lastMod[idDataY]" class="text-muted">3 years ago</div>
						</div>
						<div class="d-flex justify-content-end ml-auto px-0 col-auto">
							<div class="mr-2 dropleft">
								<a class="text-dark text-decoration-none" id="accDataY" role="button" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
									<i class="fas fa-edit btn_account"></i>
								</a>
								<div class="dropdown-menu" aria-labelledby="accDataY" data-acc="[idDataY]">
									<a class="dropdown-item edtAcc" href="#">Edit Account</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item cpyUsername" href="#">Copy Username</a>
									<a class="dropdown-item cpyPass" href="#">Copy Password</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item text-danger delAcc" href="#">Delete Account</a>
								</div>
							</div>
							<a class="text-danger text-decoration-none delAcc" href="javascript:void(0)">
								<div class="ml-2"><i class="far fa-trash-alt btn_account"></i></div>
							</a>
						</div>
					</div>
				</div>
			</div>

			<!-- Account Folder List -->
			<div class="col-12 flex-column mb-3">
				<div class="d-flex justify-content-between align-items-center folderName">
					<a class="d-flex align-items-center col text-body text-decoration-none" data-toggle="collapse" href="#directoryY" role="button" aria-expanded="false" aria-controls="directoryX">
						<h4 class="py-2 text_wrap">FolderNameThatTooLong to be contained but still can</h4>
						<h4><i class="fas fa-caret-down ml-2" id="directoryCaret"></i></h4>
					</a>
					<div class="d-lg-none col-auto text-right mr-2" id="folderOption">
						<div class="btn-group dropleft">
							<button type="button" class="py-1 px-2 btn rounded shadow" id="dirDataY" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
								<h4 class="m-0"><i class="fas fa-ellipsis-h"></i></h4>
							</button>
							<div class="dropdown-menu" aria-labelledby="dirDataY" data-dir="[idDirY]">
								<a class="dropdown-item edtDir" href="#">Rename Folder</a>
								<a class="dropdown-item delDir" href="#">Delete Folder</a>
							</div>
						</div>
					</div>
				</div>
				<div class="collapse show multi-collapse" id="directoryY">
					<hr class="separator my-2">
					<!-- Account Data List -->
					<div class="d-flex justify-content-center py-2 px-3 mx-2">
						<big class="text-muted">(None)</big>
					</div>
				</div>
			</div>
		</div>
	</div>