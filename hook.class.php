<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_thread_tg {
	protected $_pvars = array();
	protected $_ident = 'thread_tg';

	public function __construct(){
		global $_G;
		$this->_pvars = $_G['cache']['plugin'][$this->_ident];
	}

	protected function _get_table($table){
		return '#'.$this->_ident.'#intcdz_'.$table;
	}
}

class plugin_thread_tg_forum extends plugin_thread_tg{
	function viewthread_title_extra() {
		global $_G;

		if($_G['thread']['authorid'] == $_G['uid']){
			$str  = '<link rel="stylesheet" type="text/css" href="./source/plugin/'.$this->_ident.'/template/style.css">';
			$str .= '<a href="javascript:;" class="orangebut a_to_but" onclick="showWindow(\'tgWin\' , \'plugin.php?id='.$this->_ident.':ajax&formhash='.FORMHASH.'&thread='.$_G['thread']['tid'] .'\')">ว๓อฦนใ</a>';

			return $str;
		}
	}
}

?>
