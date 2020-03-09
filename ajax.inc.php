<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(trim($_GET['formhash']) != FORMHASH){ exit; }

$ident = 'thread_tg';
$table = '#'.$ident.'#intcdz_thread_tg';
$act = trim($_GET['act']);
$act = $act ? $act : 'tg';
$pvars = $_G['cache']['plugin'][$ident];


if($act == 'tg'){
	if( !$_G['uid'] ) dexit();
	$tid = intval($_GET['thread']);
	if( $tid < 1 ) dexit();

	$thread = C::t('forum_thread')->fetch( $tid );
	if( empty($thread) ) dexit();

	$userCredit = getuserprofile('extcredits'.$pvars['extcredit']);
	$credit_options = explode("\r\n", $pvars['credit_option']);

	$creditName = $_G['setting']['extcredits'][ $pvars['extcredit'] ]['title'];

	if( $_GET['tgto'] == 1 ){

		$pay = intval( $_GET['tg_pay'] );
		if( !in_array($pay, $credit_options) ){
			jsalert('alert("请正确选择金额");');
		}

		if($userCredit < $pay){
			jsalert('alert("金额不足，无法完成请求");');
		}

		$data_T = array(
				'tid' => $tid,
				'fid' => $thread['fid'],
				'author' => $thread['author'],
				'authorid' => $thread['authorid'],
				'extcredit' => $pvars['extcredit'],
				'pay' => $pay ,
				'dateline' => $_G['timestamp']
		);
		if( C::t($table)->insert( $data_T , true ) ){
			//更新积分
			$data[$pvars['extcredit']] = $pay * -1;
			updatemembercount($_G['uid'], $data , true , '' , $tid , '' , '帖子求推广', $thread['subject'] );
			//
			$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible( $tid , 0 );
			if( $pvars['email'] ){
				$post = C::t('forum_post')->fetch( 0 , $tid );

				require_once libfile('function/mail');
				$message  = '您收到一个求推广信息，支付'.$pay.$creditName;
				$message .= '<br /><br />';
				$message .= '<a href="'.$_G['siteurl'].'forum.php?mod=viewthread&tid='.$thread['tid'].'" target="_blank">'.$thread['subject'].'</a>';

				sendmail($pvars['email'], '【求推广】《'. $thread['subject'] .'》', $message);
			}

			//
			jsalert('alert("求推广成功");hideWindow("tgWin");');
		}

	}else{
		if($tid){

			include template('common/header_ajax');
			include template($ident.':ajax_tg');
			include template('common/footer_ajax');
		}
	}
}

function jsalert($string=''){
	if(!is_string($string)) return;

	$string = '<script type="text/javascript" reload="1">'.$string.'</script>';
	Ajax_e( $string );
}

function Ajax_e( $string='' ){
	if(!is_string($string)) return;

	include template('common/header_ajax');
	echo $string;
	include template('common/footer_ajax');
}
?>
