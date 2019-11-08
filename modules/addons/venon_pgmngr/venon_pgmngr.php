<?php
/* ========================================
						   _
	 _ _ ___ ___ ___ ___  |_|___
	| | | -_|   | . |   |_| |  _|
	 \_/|___|_|_|___|_|_|_|_|_|

Venon Web Developers, venon.ir
201508
version 2.0
=========================================*/

if (!defined("WHMCS"))
	die("This file cannot be accessed directly");

function venon_pgmngr_config() {
    $configarray = array(
    "name" => "Venon Page Manager",
    "description" => "Venon page manager allow you to create custom pages inside WHMCS without editing any files.",
    "version" => "2.0",
    "author" => "Venon Web Developers. Venon.ir",
    "language" => "farsi",
    "fields" => array(
        // "License" => array ("FriendlyName" => "License", "Type" => "text", "Size" => "25", "Description" => "Enter your venon_pgmngr License number", "Default" => "venon-", ),
    ));
    return $configarray;
}

function venon_pgmngr_activate() {

    # Create Custom DB Table
    $query = "CREATE TABLE `mod_venon_pgmngr` (`setting` text NOT NULL, `seourl` int(11) NOT NULL, `sharekeys` int(11) NOT NULL, `showdate` int(11) NOT NULL, `showviews` int(11) NOT NULL, `status` text, `localkey` text);";
	$result = mysql_query($query);

	$query = "CREATE TABLE IF NOT EXISTS `mod_venon_pgmngr_pages` (`id` int(10) NOT NULL AUTO_INCREMENT, `date` datetime DEFAULT NULL,  `pagetitle` text CHARACTER SET utf8 COLLATE utf8_bin NULL,  `pagecontent` text CHARACTER SET utf8 COLLATE utf8_bin NULL,  `published` text NULL,  `clientonly` text NULL,  `views` int(15) NOT NULL, `seourl` text CHARACTER SET utf8 COLLATE utf8_bin NULL, `seokeywords` text CHARACTER SET utf8 COLLATE utf8_bin NULL,  `seodescription` text CHARACTER SET utf8 COLLATE utf8_bin NULL,  PRIMARY KEY (`id`))";
	$result = mysql_query($query);

    # Insert deafualt options
	$query = "INSERT INTO  `mod_venon_pgmngr` (`setting` ,`seourl` ,`sharekeys` , `showdate`, `showviews`, `status` ,`localkey`)VALUES ('option', '0', '1', '0', '0', NULL , NULL);";
	$result = mysql_query($query);

    # Return Result
    return array('status'=>'success','description'=>'Venon page manager addon successfully installed');
    return array('status'=>'error','description'=>'Error: For further assistance, please contact us at venon.ir');
    return array('status'=>'info','description'=>'Select your options below');

}

function venon_pgmngr_deactivate() {

    # Remove Custom DB Table
    $query = "DROP TABLE `mod_venon_pgmngr`";
	$result = mysql_query($query);

    # Return Result
    return array('status'=>'success','description'=>'Venon page manager addon successfully uninstalled');
    return array('status'=>'error','description'=>'Error: For further assistance, please contact us at venon.ir');
    return array('status'=>'info','description'=>'');

}

function venon_pgmngr_upgrade($vars) {

    $version = $vars['version'];

    # Run SQL Updates for V1.0 to V1.1
}


/* generate_seo_link */
function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
	//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
	//$return = trim(ereg_replace(' +', ' ', preg_replace('/[^a-zA-Z0-9-\s]/', '', strtolower($input))));

	$return = trim(preg_replace(' +', ' ', preg_replace("/[^A-Za-z0-9- \ا\ب\پ\ت\ث\ج\چ\ح\خ\د\ذ\ر\ز\ژ\س\ش\ص\ض\ط\ظ\ع\غ\ف\ق\ک\گ\ل\م\ن\و\ه\ی\ك\آ\ي\ئ\_\s]/", '', strtolower($input))));

	//remove words, if not helpful to seo
	//i like my defaults list in remove_words(), so I wont pass that array
	if($remove_words) {$return = remove_words($return, $replace, $words_array); }

	//convert the spaces to whatever the user wants
	//usually a dash or underscore..
	//...then return the value.
	return str_replace(' ', $replace, $return);
}

/* takes an input, scrubs unnecessary words */
function remove_words($input,$replace,$words_array = array(),$unique_words = true)
{
	//separate all words based on spaces
	$input_array = explode(' ',$input);

	//create the return array
	$return = array();

	//loops through words, remove bad words, keep good ones
	foreach($input_array as $word)
	{
		//if it's a word we should add...
		if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
		{
			$return[] = $word;
		}
	}

	//return good words separated by dashes
	return implode($replace,$return);
}

function venon_pgmngr_output($vars) {



    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $LANG = $vars['_lang'];

	echo '<div class="contexthelp"><a href="http://www.venon.ir" target="_blank"><img src="images/icons/help.png" border="0" align="absmiddle">'.$LANG['venonhelp'].'</a></div>';
    echo '<p>'.$LANG['intro'].'</p>';
	echo '<p>'.$LANG['desc'].'</p>';

	if ($results["status"]=="Active") {
	// tabs
	echo '<div id="clienttabs">
			<ul class="nav nav-tabs admin-tabs">
				<li class="'; if ($_GET['go']=="dashboard" or empty($_GET['go'])){ echo "tabselected active";} else {echo "tab";}; echo'"><a href="addonmodules.php?module=venon_pgmngr&go=dashboard">'.$LANG['tabdashboard'].'</a></li>
				<li class="'; if ($_GET['go']=="manage" or $_GET['go']=="edit"){ echo "tabselected active";} else {echo "tab";}; echo'"><a href="addonmodules.php?module=venon_pgmngr&go=manage">'.$LANG['tabmanage'].'</a></li>
				<li class="'; if ($_GET['go']=="addnew"){ echo "tabselected active";} else {echo "tab";}; echo'"><a href="addonmodules.php?module=venon_pgmngr&go=addnew">'.$LANG['tabaddnew'].'</a></li>
				<li class="'; if ($_GET['go']=="setting"){ echo "tabselected active";} else {echo "tab";}; echo'"><a href="addonmodules.php?module=venon_pgmngr&go=setting">'.$LANG['tabsetting'].'</a></li>
			</ul>
		</div>
		<div id="tab0box" class="tabbox tab-content admin-tabs">
			<div id="tab_content" class="tab-pane active" style="text-align:right;">';

	// tabscontent

	// dashboard
	if ($_GET['go']=="dashboard" or empty($_GET['go'])) {
		$table = "mod_venon_pgmngr_pages";

		// get setting
		$gsetting = select_query('mod_venon_pgmngr','*',array("setting"=>'option'));
		$settings = mysql_fetch_array($gsetting);

		echo '<table width="100%">
			<tbody>
				<tr>
					<td width="30%" valign="top">
						<div class="clientssummarybox">
						<div class="title">'.$LANG['titlelast5'].'</div>
						<table class="clientssummarystats" cellspacing="0" cellpadding="2"><tbody>';

						$fields = "id,pagetitle,date,seourl";
						$sort = "date";
						$sortorder = "DESC";
						$limits = "0,5";
						$result = select_query($table,$fields,$where,$sort,$sortorder,$limits);
						while ($data = mysql_fetch_array($result)) {
							print '<tr><td><a href="';
							if ($settings['seourl'] == 1) {
								echo '../page/';
								if (isset ($data['seourl'])) {
									echo $data['seourl'];
								}
								echo '-'.$data['id'].'.html';
							} else {
								echo '../page.php?id='.$data['id'];
							}
						echo '" target="_blank">'.$data['pagetitle'].'</a></td><td title="'.$LANG['mdate'].'">'.fromMySQLDate($data['date'],$data['date']).'</td></tr>';
						}
						$num_rows = mysql_num_rows($result);
						if ($num_rows == 0) {
							echo '<tr><td colspan="9">'.$LANG['nothingfound'].'</td></tr>';}
						echo '</tbody></table>
						</div>
						</td>
					<td width="30%" valign="top">
						<div class="clientssummarybox">
						<div class="title">'.$LANG['titletop5'].'</div>
						<table class="clientssummarystats" cellspacing="0" cellpadding="2"><tbody>';

						$fields = "id,pagetitle,views,seourl";
						$sort = "views";
						$sortorder = "DESC";
						$limits = "0,5";
						$result = select_query($table,$fields,$where,$sort,$sortorder,$limits);
						while ($data = mysql_fetch_array($result)) {
							print '<tr><td><a href="';
							if ($settings['seourl'] == 1) {
								echo '../page/';
								if (isset ($data['seourl'])) {
									echo $data['seourl'];
								}
								echo '-'.$data['id'].'.html';
							} else {
								echo '../page.php?id='.$data['id'];
							}
						echo '" target="_blank">'.$data['pagetitle'].'</a></td><td title="'.$LANG['mviews'].'">'.$data['views'].'</td></tr>';
						}
						$num_rows = mysql_num_rows($result);
						if ($num_rows == 0) {
							echo '<tr><td colspan="9">'.$LANG['nothingfound'].'</td></tr>';}
						echo '</tbody></table>
						</div>
					</td>
					<td width="30%" valign="top">
						<div class="clientssummarybox">
						<div class="title">'.$LANG['titlebtns'].'</div>
						<ul>
							<li><a href="addonmodules.php?module=venon_pgmngr&go=manage"><img src="images/icons/ticketspredefined.png" border="0" align="absmiddle"> '.$LANG['tabmanage'].'</a></li>
							<li><a href="addonmodules.php?module=venon_pgmngr&go=addnew"><img src="images/icons/add.png" border="0" align="absmiddle"> '.$LANG['tabaddnew'].'</a></li>
							<li><a href="addonmodules.php?module=venon_pgmngr&go=setting"><img src="images/icons/quotes.png" border="0" align="absmiddle"> '.$LANG['tabsetting'].'</a></li>
						</ul>
						</td></tr>
						</div>
					</td>
				</tr>
			</tbody>
		</table>';
	};
	// manage
	if ($_GET['go']=="manage"){
		$table = "mod_venon_pgmngr_pages";
		// add new page to sql
		if (isset ($_POST['date']) and !isset($_GET[update])){
			$table = "mod_venon_pgmngr_pages";
			$seourl = generate_seo_link($_POST['seourl'], '-', false, $bad_words);
			$publishdate = toMySQLDate($_POST['date']);
			$values = array("date"=>$publishdate, "pagetitle"=>$_POST['pagetitle'], "pagecontent"=>$_POST['pagecontent'], "seourl"=>$seourl, "seokeywords"=>$_POST['seokeywords'], "seodescription"=>$_POST['seodescb'], "published"=>$_POST['published'], "clientonly"=>$_POST['clientsonly'], "views"=>$_POST['views']);
			$newid = insert_query($table,$values);
			echo '<div class="infobox">'.$LANG['notsuc'].'</div>';
		}
		// remove page sql
		if (isset ($_GET[remove]) and isset ($_GET[id])) {
			mysql_query("DELETE FROM `mod_venon_pgmngr_pages` WHERE id=$_GET[id]");
			echo '<div class="infobox">'.$LANG['deleteinfo'].'</div>';
		}
		// update page
		if (isset ($_POST['date']) and isset($_GET[update])) {
			$table = "mod_venon_pgmngr_pages";
			$publishdate = toMySQLDate($_POST['date']);
			$seourl = generate_seo_link($_POST['seourl'], '-', false, $bad_words);
			$update = array("date"=>$publishdate, "pagetitle"=>$_POST['pagetitle'], "pagecontent"=>$_POST['pagecontent'], "seourl"=>$seourl, "seokeywords"=>$_POST['seokeywords'], "seodescription"=>$_POST['seodescb'], "published"=>$_POST['published'], "clientonly"=>$_POST['clientsonly'], "views"=>$_POST['views']);
			$where = array("id"=>"$_GET[id]");
			update_query($table,$update,$where);
			echo '<div class="infobox">'.$LANG['updateinfo'].'</div>';
		}
		// get setting
		$result = select_query('mod_venon_pgmngr','*',array("setting"=>'option'));
		$settings = mysql_fetch_array($result);
		echo '<table width="100%">
				<tbody>
					<tr>
						<td>
							<table width="100%" class="form">
							<tbody><tr><td colspan="2" class="fieldarea" style="text-align:center;"><strong>'.$LANG['mpagelist'].'</strong></td></tr>
							<tr><td align="center">
							<div class="tablebg">
							<table class="datatable" width="100%" border="0" cellspacing="1" cellpadding="3">
							<tbody><tr><th>'.$LANG['mid'].'</th><th>'.$LANG['mdate'].'</th><th>'.$LANG['mtitle'].'</th><th>'.$LANG['mpulished'].'</th><th>'.$LANG['mclient'].'</th><th>'.$LANG['mviews'].'</th><th width="20"></th><th width="20"></th></tr>';
							$fields = "id, date, pagetitle, published, clientonly, views, seourl";
							$sort = "id";
							$sortorder = "ASC";
							$result = select_query($table,$fields,$where,$sort,$sortorder,$limits);
							while ($data = mysql_fetch_array($result)) {
							print '<tr><td><a href="';
							if ($settings['seourl'] == 1) {
								echo '../page/';
								if (isset ($data['seourl'])) {
									echo $data['seourl'];
								}
								echo '-'.$data['id'].'.html';
							} else {
								echo '../page.php?id='.$data['id'];
							}
							echo '" target="_blank">'.$data['id'] .'</a></td>
								<td>'. fromMySQLDate($data['date'],$data['date']) .'</td>
								<td style="padding-left:5px;padding-right:5px">';
							print '<a href="';
							if ($settings['seourl'] == 1) {
								echo '../page/';
								if (isset ($data['seourl'])) {
									echo $data['seourl'];
								}
								echo '-'.$data['id'].'.html';
							} else {
								echo '../page.php?id='.$data['id'];
							}
							echo '" target="_blank">'. $data['pagetitle'] .'</a></td>
								<td>'; if (empty ($data['published'])){echo '<img src="images/icons/disabled.png"/>';} else {echo '<img src="images/icons/tick.png"/>';} echo'</td>
								<td>'; if (empty ($data['clientonly'])){echo '<img src="images/icons/disabled.png"/>';} else {echo '<img src="images/icons/tick.png"/>';} echo'</td>
								<td>'. $data['views'] .'</td>
								<td><a href="addonmodules.php?module=venon_pgmngr&go=edit&id='. $data['id'] .'"><img src="images/edit.gif" width="16" height="16" border="0" alt="Edit" title="'.$LANG['editpage'].'"></a></td><td><a href="addonmodules.php?module=venon_pgmngr&go=manage&remove&id='. $data['id'] .'"><img src="images/icons/accessdenied.png" width="16" height="16" border="0" alt="delete" title="'.$LANG['deletepage'].'"></a></td></tr>'
								;}


							$num_rows = mysql_num_rows($result);
							if ($num_rows == 0) {
							echo '<tr><td colspan="9">'.$LANG['nothingfound'].'</td></tr>';}
							echo'</tbody></table>
							</div>
							</td></tr></tbody></table>
						</td>
					</tr>
				</tbody>
			</table>';
	};
	// addnew
	if ($_GET['go']=="addnew"){
		echo '<p>'.$LANG['addnewpage'].'</p>';
		echo '<form method="post" action="addonmodules.php?module=venon_pgmngr&go=manage">
			<input type="hidden" name="views" value="0">
			<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
			<tr><td width="15%" class="fieldlabel">'.$LANG['datetime'].'</td><td class="fieldarea"><input type="text" name="date" value="'; echo date("Y/m/d G:i"); echo'" size="25"></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagetitle'].'</td><td class="fieldarea"><input type="text" name="pagetitle" value="" size="70"></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagecontent'].'</td><td class="fieldarea"><textarea id="pgcontent" name="pagecontent" rows=20 style="width:100%"><p></p></textarea></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pageseourl'].'</td><td class="fieldarea"><input type="text" name="seourl" value="" size="100" style="direction:ltr;"><br/>'.$LANG['pageseourlhint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagekeywords'].'</td><td class="fieldarea"><input type="text" name="seokeywords" value="" size="100"><br/>'.$LANG['pagekeywordshint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagedesc'].'</td><td class="fieldarea"><input type="text" name="seodescb" value="" size="100"><br/>'.$LANG['pagedeschint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['published'].'</td><td class="fieldarea"><input type="checkbox" name="published" onchecked></td></tr>
			<tr><td class="fieldlabel">'.$LANG['clientsonly'].'</td><td class="fieldarea"><input type="checkbox" name="clientsonly" onchecked></td></tr>
		</table>
		<p align="center"><input type="submit" value="'.$LANG['submitt'].'" class="btn btn-primary" ></p>
		</form>';
		echo '<script language="javascript" type="text/javascript" src="../modules/addons/venon_pgmngr/editor/tinymce.min.js"></script>
		<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			directionality : "rtl",
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons paste textcolor"
			],
			toolbar1: "insertfile undo redo | styleselect formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
			toolbar2: " ltr rtl | link unlink anchor image media code | forecolor backcolor emoticons | print preview code",
			image_advtab: true,
		});
		</script>﻿';
	};
	// setting
	if ($_GET['go']=="setting"){
		if (isset($_POST['seourl'])) {
			$table = "mod_venon_pgmngr";
			$update = array("seourl"=>$_POST['seourl'], "sharekeys"=>$_POST['sharekeys'], "showdate"=>$_POST['showdate'], "showviews"=>$_POST['showviews'], );
			$where = array("setting"=>"option");
			update_query($table,$update,$where);
		}
		$result = mysql_query('SELECT * FROM `mod_venon_pgmngr` WHERE setting =  "option"');
		$data = mysql_fetch_array($result);

		echo '<form method="post" action="addonmodules.php?module=venon_pgmngr&go=setting">
		<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
			<tr><td class="fieldlabel">'.$LANG['seourl'].'</td><td class="fieldarea"><label><input type="radio" name="seourl" value="1"'; if ($data['seourl'] == '1') {echo 'checked';} echo '/>'.$LANG['yes'].'</label>	<label><input type="radio" name="seourl" value="0" '; if ($data['seourl'] == '0') {echo 'checked';} echo ' />'.$LANG['no'].'</label></td></tr>
			<tr><td class="fieldlabel">'.$LANG['sharekeys'].'</td><td class="fieldarea"><label><input type="radio" name="sharekeys" value="1" '; if ($data['sharekeys'] == '1') {echo 'checked';} echo ' />'.$LANG['yes'].'</label>	<label><input type="radio" name="sharekeys" value="0" '; if ($data['sharekeys'] == '0') {echo 'checked';} echo ' />'.$LANG['no'].'</label></td></tr>
			<tr><td class="fieldlabel">'.$LANG['showdate'].'</td><td class="fieldarea"><label><input type="radio" name="showdate" value="1" '; if ($data['showdate'] == '1') {echo 'checked';} echo ' />'.$LANG['yes'].'</label>	<label><input type="radio" name="showdate" value="0" '; if ($data['showdate'] == '0') {echo 'checked';} echo ' />'.$LANG['no'].'</label></td></tr>
			<tr><td class="fieldlabel">'.$LANG['showviews'].'</td><td class="fieldarea"><label><input type="radio" name="showviews" value="1" '; if ($data['showviews'] == '1') {echo 'checked';} echo ' />'.$LANG['yes'].'</label>	<label><input type="radio" name="showviews" value="0" '; if ($data['showviews'] == '0') {echo 'checked';} echo ' />'.$LANG['no'].'</label></td></tr>
		</table>
		<p align="center"><input type="submit" value="'.$LANG['submitt'].'" class="btn btn-primary" ></p>
		</form>
		';
	};
	// edit
	if ($_GET['go']=="edit"){
		$table = "mod_venon_pgmngr_pages";
		$fields = "*";
		$where = array("id"=>$_GET['id']);
		$result = select_query($table,$fields,$where);
		$data = mysql_fetch_array($result);

		echo '<form method="post" action="addonmodules.php?module=venon_pgmngr&go=manage&update&id='.$data['id'].'">
			<input type="hidden" name="views" value="'.$data['views'].'">
			<table class="form" width="100%" border="0" cellspacing="2" cellpadding="3">
			<tr><td width="15%" class="fieldlabel">'.$LANG['datetime'].'</td><td class="fieldarea"><input type="text" name="date" value="'; echo fromMySQLDate($data['date'],$data['date']); echo'" size="25"></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagetitle'].'</td><td class="fieldarea"><input type="text" name="pagetitle" value="'; echo $data['pagetitle']; echo'" size="70"></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagecontent'].'</td><td class="fieldarea"><textarea id="pgcontent" name="pagecontent" rows=20 style="width:100%; direction: rtl;">'; echo $data['pagecontent']; echo'</textarea></td></tr>
			<tr><td class="fieldlabel">'.$LANG['pageseourl'].'</td><td class="fieldarea"><input type="text" name="seourl" value="'; echo $data['seourl']; echo'" size="100" style="direction:ltr;"><br/>'.$LANG['pageseourlhint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagekeywords'].'</td><td class="fieldarea"><input type="text" name="seokeywords" value="'; echo $data['seokeywords']; echo'" size="100"><br/>'.$LANG['pagekeywordshint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['pagedesc'].'</td><td class="fieldarea"><input type="text" name="seodescb" value="'; echo $data['seodescription']; echo'" size="100"><br/>'.$LANG['pagedeschint'].'</td></tr>
			<tr><td class="fieldlabel">'.$LANG['published'].'</td><td class="fieldarea"><input type="checkbox" name="published" '; if ($data['published']=='on'){echo 'checked';} else {echo 'onchecked';}; echo'></td></tr>
			<tr><td class="fieldlabel">'.$LANG['clientsonly'].'</td><td class="fieldarea"><input type="checkbox" name="clientsonly" '; if ($data['clientonly']=='on'){echo 'checked';} else {echo 'onchecked';}; echo'></td></tr>
		</table>
		<p align="center"><input type="submit" value="'.$LANG['submitt'].'" class="btn btn-primary" ></p>
		</form>';
		echo '<script language="javascript" type="text/javascript" src="../modules/addons/venon_pgmngr/editor/tinymce.min.js"></script>
		<script type="text/javascript">
		tinymce.init({
			selector: "textarea",
			directionality : "rtl",
			theme: "modern",
			plugins: [
				"advlist autolink lists link image charmap print preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars code fullscreen",
				"insertdatetime media nonbreaking save table contextmenu directionality",
				"emoticons paste textcolor"
			],
			toolbar1: "insertfile undo redo | styleselect formatselect fontselect fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
			toolbar2: " ltr rtl | link unlink anchor image media code | forecolor backcolor emoticons | print preview code",
			image_advtab: true,
		});
		</script>﻿';
	};
			echo '</div>
		</div>';
}

function venon_pgmngr_sidebar($vars) {

    $modulelink = $vars['modulelink'];
    $version = $vars['version'];
    $LANG = $vars['_lang'];

    $sidebar = '<span class="header"><img src="images/icons/addonmodules.png" class="absmiddle" width="16" height="16" /> Venon page manager</span>
<ul class="menu">
        <li><a href="addonmodules.php?module=venon_pgmngr">'.$LANG['venonpgmngr'].'</a></li>
		<li><a href="addonmodules.php?module=venon_pgmngr&go=manage">'.$LANG['tabmanage'].'</a></li>
		<li><a href="addonmodules.php?module=venon_pgmngr&go=addnew">'.$LANG['tabaddnew'].'</a></li>
		<li><a href="addonmodules.php?module=venon_pgmngr&go=setting">'.$LANG['tabsetting'].'</a></li>
        <li><a href="#">'.$LANG['pgmngrversion'].': '.$version.'</a></li>
    </ul>';
    return $sidebar;

}
?>
