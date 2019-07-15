	<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg_purple">
		<div class="navbar-brand" href="#">
			<img class="mini_logo" alt="Logo" src="<?php echo base_url('assets/logo/logo.png'); ?>">
			Break Free
		</div>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<div class="form mt-2 mx-lg-5 mt-lg-0 flex-fill">
				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text pointer bg-light" for="searchAccount" id="bSearchAccount">
							<i class="fas fa-search"></i>
						</label>
					</div>
					<input type="text" class="form-control" id="searchAccount"></input>
				</div>
			</div>
			<ul class="navbar-nav">
				<li class="navbar-item dropdown mt-2 mt-lg-0 w-100">
					<a class="navbar-link dropdown-toggle text-decoration-none text-white" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-user mr-1"></i>
						<?php echo $email; ?>
					</a>
					<div class="dropdown-menu" aria-labelledby="profileDropdown">
						<a class="dropdown-item" href="javascript:void(0)" id="chPass">Change Password</a>
						<a class="dropdown-item" href="<?php echo site_url('logout'); ?>">Logout</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>