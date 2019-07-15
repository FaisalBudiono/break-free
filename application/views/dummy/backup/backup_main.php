<?php
	/**
	 * Displaying the folder name first then display the account data inside it.
	 * The id from [Last Modified] is taken from the id_adl to be modified in JQuery.
	 * 
	 * @param array $acc_list Stand for account_list. An array which contain sets of data 
	 *   be fetched and displayed.
	 * @param string $dir_id Stand for [directory id].
	 * @param string $folderName A folder name to be displayed.
	 * 
	 * @return void
	 */
	function showAcc($acc_list, $dir_id = "0", $folderName = "UNCATEGORIZED"){
		/** If there is no data list and with default folderName than the function process will be stoped. */
		if($dir_id == "0" && empty($acc_list) && $folderName === "UNCATEGORIZED") return;

		echo "
			<!-- Account Folder List -->
			<div class=\"col-12 flex-column mb-3\">
				<div class=\"d-flex justify-content-between align-items-center folderName\">
					<a class=\"d-flex align-items-center col text-body text-decoration-none\" data-toggle=\"collapse\" href=\"#directory$dir_id\" role=\"button\" aria-expanded=\"false\" aria-controls=\"directory$dir_id\">
						<h4 class=\"py-2 text_wrap\">$folderName</h4>
						<h4><i class=\"fas fa-caret-down ml-2\" id=\"directoryCaret\"></i></h4>
					</a>
		";
		
		if($dir_id != 0){
				echo "
					<div class=\"d-lg-none col-auto text-right mr-2\" id=\"folderOption\">
						<div class=\"btn-group dropleft\">
							<button type=\"button\" class=\"py-1 px-2 btn rounded shadow\" id=\"dirData$dir_id\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" data-display=\"static\">
								<h4 class=\"m-0\"><i class=\"fas fa-ellipsis-h\"></i></h4>
							</button>
							<div class=\"dropdown-menu\" aria-labelledby=\"dirData$dir_id\" data-dir=\"$dir_id\">
								<a class=\"dropdown-item edtDir\" href=\"javascript:void(0)\">Rename Folder</a>
								<a class=\"dropdown-item delDir\" href=\"javascript:void(0)\">Delete Folder</a>
							</div>
						</div>
					</div>
				";
		}

		echo "
				</div>
				<div class=\"collapse show multi-collapse\" id=\"directory$dir_id\">
				<hr class=\"separator my-2\">
		";
		/** If the $acc_list is not empty then process the account list and display it, if else display none. */
		if(!empty($acc_list)){
			foreach($acc_list as $acc_arr){
				echo "
					<!-- Account Data List -->
					<div class=\"d-flex align-items-center py-2 px-3 mx-2 dataItem\">
						<input type=\"checkbox\" class=\"btn_account col-auto\">
						<div class=\"d-flex flex-column align-items-start mx-2 col-lg-4 col-5\">
							<div class=\"d-inline-block text-truncate w-100\"><big>$acc_arr[name]</big></div>
							<div class=\"d-inline-block text-truncate w-100 userTarget\">$acc_arr[username]</div>
						</div>
						<div class=\"d-sm-flex flex-column align-items-start col-sm-3 d-none px-0\">
							<div class=\"d-sm-none d-md-flex\"><big>Last Modified</big></div>
							<div id=\"lastMod$acc_arr[id_adl]\" class=\"text-muted\">Please wait...</div>
						</div>
						<div class=\"d-flex justify-content-end ml-auto px-0 col-auto\">
							<div class=\"mr-2 dropleft\">
								<a class=\"text-dark text-decoration-none\" id=\"accData$acc_arr[id_adl]\" role=\"button\" href=\"#\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" data-display=\"static\">
									<i class=\"fas fa-edit btn_account\"></i>
								</a>
								<div class=\"dropdown-menu\" aria-labelledby=\"accData$acc_arr[id_adl]\" data-acc=\"$acc_arr[id_adl]\">
									<a class=\"dropdown-item edtAcc\" href=\"javascript:void(0)\">Edit Account</a>
									<div class=\"dropdown-divider\"></div>
									<a class=\"dropdown-item cpyUsername\" href=\"javascript:void(0)\">Copy Username</a>
									<a class=\"dropdown-item cpyPass\" href=\"javascript:void(0)\">Copy Password</a>
									<div class=\"dropdown-divider\"></div>
									<a class=\"dropdown-item text-danger delAcc\" href=\"javascript:void(0)\">Delete Account</a>
								</div>
							</div>
							<a class=\"text-danger text-decoration-none delAcc\" href=\"javascript:void(0)\">
								<div class=\"ml-2\"><i class=\"far fa-trash-alt btn_account\"></i></div>
							</a>
						</div>
					</div>
				";
			}
		}else{
			echo "
					<!-- Account Data List -->
					<div class=\"d-flex justify-content-center py-2 px-3 mx-2\">
						<big class=\"text-muted\">(None)</big>
					</div>
			";
		}
		echo "
				</div>
			</div>
		";
	}
?>
	<div class="container shadow-lg border rounded bg-white py-3 mb-3">
		<div class="row" id="accContainer">

			<?php

			showAcc($acc[0]);
			foreach($dir as $dir_arr){
				showAcc($acc[$dir_arr['id_directory']], $dir_arr['id_directory'], $dir_arr['directory_name']);
			}

			?>

		</div>
	</div>
	<button class="d-none" id="refresh"></button>
	<div class="toast" style="position: fixed; top: 80px; right: 40px;" id="notifToast" data-delay="700">
		<div class="toast-header">
			<strong class="mr-auto" id="notifToastHead">Break Free </strong>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="toast-body d-flex flex-row align-items-center" id="notifToastBody"></div>
	</div>
	<div class="d-none" id="cpyHandler"></div>