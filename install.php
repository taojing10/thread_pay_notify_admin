<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

global $_G;
$tablePre = $_G['config']['db'][1]['tablepre'];

$sql = <<<EOF
create table if not exists `{$tablePre}intcdz_thread_tg`(
    tgid int(10) unsigned auto_increment primary key,
    tid int(10) unsigned default 0,
    fid mediumint(8) unsigned default 0,
    author varchar(25) null,
    authorid mediumint(8) unsigned default 0,
	extcredit tinyint(2) unsigned null,
	pay smallint(6) unsigned default 0,
    dateline int(10) unsigned null
) ENGINE = MYISAM CHARACTER SET gbk COLLATE gbk_chinese_ci;
EOF;

runquery($sql);

$finish = TRUE;

?>
