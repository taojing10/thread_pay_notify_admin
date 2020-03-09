<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$ident  = $plugin['identifier'];
$pmod	= getgpc('pmod','g');
$url	= 'action=plugins&operation=config&do='.$plugin['pluginid'].'&identifier='. $ident.'&pmod='.$pmod;
$action = strtolower(getgpc('act' ,'g'));
$mpurl  = 'admin.php?'.$url;

//
$pvars = $_G['cache']['plugin'][$ident];
$table = '#'.$ident.'#intcdz_thread_tg';

if( $_GET['act'] == 'tgdel' ){
	if(trim($_GET['formhash']) != FORMHASH) dexit();

	$tgid = $_GET['tg'];
	if( $tgid < 1 ) dexit();

	C::t($table)->delete( );

}else{
	//
	$page  = $_GET['page'] ? intval( $_GET['page'] ) : 1;
	$limit = 20;
	$start = ($page - 1) * $limit;

	//
	$author = trim( daddslashes($_POST['username']) );

	$tgList	= C::t($table)->fetch_all_by_author( $author, $start , $limit , 'desc' );
	foreach($tgList as $k=>$tg){
		$thread = C::t('forum_thread')->fetch( $tg['tid'] );
		$tgList[$k]['subject'] = $thread['subject'];
	}

	$count  = C::t($table)->count_by_author( $author );
	$multipage = multi($count, $limit, $page, $mpurl);

	include template($ident.':admin_tg');
}
?>
