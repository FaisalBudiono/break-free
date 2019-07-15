<?php
	/**
	 * Displaying the folder name first then display the account data inside it.
	 * The id from [Last Modified] is taken from the id_adl to be modified in JQuery.
	 * 
	 * @param array $acc_list Stand for account_list. An array which contain sets of data 
	 *   be fetched and displayed.
	 * @param string $dir_id Stand for directory_id. It contains directory id.
	 * @param string $folderName A folder name to be displayed.
	 * 
	 * @return void
	 */
	function showAcc($acc_list, $dir_id = "0", $folderName = "Uncategorized"){
		/** If there is no data list and with default folderName than the function process will be stoped. */
		if(empty($acc_list) && $folderName === "Uncategorized") return;

		echo "
			<div class=\"folderBox\">
				<div class=\"folderName\">$folderName</div>
		";
		/** If the $acc_list is not empty then process the account list and display it, if else display none. */
		if(!empty($acc_list)){
			foreach($acc_list as $acc_arr){
				echo "
					<hr class=\"tebal\">
					<div>Name: <input type=\"text\" value=\"$acc_arr[name]\" readonly></div>
					<div>Site: <input type=\"text\" value=\"$acc_arr[site]\" readonly></div>
					<div>Username: <input type=\"text\" value=\"$acc_arr[username]\" readonly></div>
					<div>Password: <input type=\"text\" value=\"$acc_arr[password]\" readonly></div>
					<div>Note: <textarea readonly>$acc_arr[note]</textarea></div>
					<div id=\"lastMod$acc_arr[id_adl]\">Last Modified: Please Wait</div>
				";
			}
		}else{
			echo "
				<div>(None)</div>
			";
		}
		echo "
			</div>
		";
	}
?>
<style type="text/css">
	.folderBox{
		border: 1px solid red;
		margin: 15px 5px;
	}
	.folderBox div{
		margin: 4px 8px;	
	}
	.folderName{
		font-weight: bold;
	}
	.tebal{
		border-top: 1px solid black;
	}
</style>

<?php
	showAcc($acc[0]);
	foreach($dir as $key_arr => $dir_arr){
		showAcc($acc[$dir_arr['id_directory']], $key_arr, $dir_arr['directory_name']);
	}
?>