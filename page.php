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
define("CLIENTAREA", true);
//define("FORCESSL", true); // Uncomment to force the page to use https://
 
require("init.php");
 
$ca = new WHMCS_ClientArea();
 
// get setting
$where = array("setting"=>'option');
$result = select_query('mod_venon_pgmngr','*',$where);
$settings = mysql_fetch_array($result);

// values
$table = "mod_venon_pgmngr_pages";

// get content
$id = $_GET['id'];
settype($id, 'integer');
$where = array("id"=> $id);
$result = select_query($table,'*',$where);
$data = mysql_fetch_array($result);

// views number
$viewnum = $data['views'];
$viewnum++;
$update = array("views"=>$viewnum);
$where = array("id"=>$id);
update_query($table,$update,$where);

// conditions
if ($data['published'] === 'on') {$published = true;} else {$published = false;}
if ($data['clientonly'] === 'on') {$clientonly = true;} else {$clientonly = false;}
if ($settings['sharekeys'] == 1) {$sharekeys = true;} else {$sharekeys = false;}
if ($settings['showdate'] == 1) {$showdate = true;} else {$showdate = false;}
if ($settings['showviews'] == 1) {$showviews = true;} else {$showviews = false;}

// content
if (empty ($data) or $published == false){$pagetitle = 'This page is not available';} else {$pagetitle = $data['pagetitle'];}

//seo
if(isset($data['seokeywords']) or isset($data['seodescription'])){$seometa = true;} else {$seometa = false;}

$ca->setPageTitle($pagetitle);
if($settings['seourl'] == 1) {
	$ca->addToBreadCrumb('../index.php', $whmcs->get_lang('globalsystemname'));
} else {
	$ca->addToBreadCrumb('index.php', $whmcs->get_lang('globalsystemname'));
}
$ca->addToBreadCrumb('page.php', $pagetitle);
$ca->initPage();

# smarty value
$ca->assign('pagecontent', $data['pagecontent']);
$ca->assign('published', $published);
$ca->assign('clientonly', $clientonly);
$ca->assign('seometa', $seometa);
$ca->assign('sharekeys', $sharekeys);
$ca->assign('pgmngrkeywords', $data['seokeywords']);
$ca->assign('pgmngrdescb', $data['seodescription']);
$ca->assign('pagedate', fromMySQLDate($data['date'],$data['date']));
$ca->assign('pageviews', $data['views']);
$ca->assign('showdate', $showdate);
$ca->assign('showviews', $showviews);

$ca->setTemplate('page');
 
$ca->output();
?>