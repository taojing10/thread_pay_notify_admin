<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_intcdz_thread_tg extends discuz_table
{
	public function __construct() {
		$this->_table = 'intcdz_thread_tg';
		$this->_pk    = 'tgid';

		parent::__construct();
	}

	public function fetch_all_by_author($author='' , $start , $limit , $sort = 'desc'){
		$sql = 'select * from %t where %i %i';
		$arg = array(
				$this->_table,
				$author ? DB::field('author', $author) : 1,
				DB::order($order_field,$order),
				DB::limit($start, $limit)
			);
		return DB::fetch_all($sql , $arg , $this->_pk);
	}
	public function count_by_author($author=''){
		$sql = 'select count(*) from %t where %i';
		$arg = array(
				$this->_table,
				$author ? DB::field('author', $author) : 1
		);
		return DB::result_first( $sql , $arg );
	}

	public function extcredit_name($extcreditsid){
		global $_G;
		return $_G['setting']['extcredits'][$extcreditsid]['title'];
	}

}


?>
