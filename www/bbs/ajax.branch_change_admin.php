<?php
include_once('./_common.php');

$this_branch_id = $_POST['this_branch_id'];

$list = Array();

$branch_sql = " select * from g5_branch where branch_id = '{$this_branch_id}' ";
$branch_row = sql_fetch($branch_sql);

$_SESSION['this_branch_id'] = $branch_row['branch_id'];
$_SESSION['this_branch_name'] = $branch_row['branch_name'];

$list['branch_name'] = $branch_row['branch_name'];
$list['code'] = '0000';
$list['msg'] = '지점이 변경되었습니다.';

echo json_encode($list);