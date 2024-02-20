<?php
include_once('./_common.php');

$list = Array();

$now_year = $_GET['now_year'];
$sch_value = $_GET['sch_value'];
$set_idx = $_GET['set_idx'];
$idx = $_GET['idx'];

$set_sql = " select * from g5_member_education_set where set_idx = '{$set_idx}' and set_hide = '' ";
$set_row = sql_fetch($set_sql);

if($idx != '') $where_str = " and idx = '{$idx}'";
$sql = " select * from g5_member_education where set_branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_idx}' and edu_year = '{$now_year}' {$where_str} order by edu_date desc, edu_str_hour desc, edu_tit asc ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = ".date('Ymd')."_excel.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

/* List Table HD 추출 STR */
$menu_cell = '';
$cell_width_tot = 725.88;
$cell_width = $cell_width_tot / $num;

$list['cell_count'] = $num;
$list['cell_width'] = $cell_width;

switch ($idx) {
    case '':
        if($num > 0) {
            for($m=0; $row = sql_fetch_array($qry); $m++) {
                $menu_cell .= '<th>'.$row['edu_tit'].'</th>';
            }
        }
        
        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2">번호</th>
            <th class="layer_list_activity_status" rowspan="2">현황</th>
            <th class="layer_list_name" rowspan="2">직원명</th>
            <th class="layer_list_date" rowspan="2">생년월일</th>
            <th class="layer_list_date" rowspan="2">입사일자</th>
            <th colspan="'.$num.'">'.$set_row['set_tit'].'</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;

    default:
        $menu_cell = '';

        if($num > 0) {
            $row = sql_fetch_array($qry);
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb">번호</th>
            <th class="layer_list_activity_status">현황</th>
            <th class="layer_list_name">직원명</th>
            <th class="layer_list_date">생년월일</th>
            <th class="layer_list_date">입사일자</th>
            <th class="layer_list_tel">연락처</th>
            <th class="layer_list_service_category">서비스</th>
            <th class="layer_list_status">계약형태</th>
            <th class="layer_list_numb">팀</th>
            <th>'.$row['edu_tit'].'</th>
        </tr>
        ';
    break;
}

$cols_count = 0;
if($idx == '') {
    $cols_count = 5 + $num;
}else{
    $cols_count = 9 + $num;
}

$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

$mn_sql = " select * from g5_menu where me_code = '{$_SESSION['this_code']}' ";
$mn_row = sql_fetch($mn_sql);
/* List Table HD 추출 END */

/* 회원 리스트 불러오기 STR */
$mb_where_str = "";
$mb_orderby_str = "";

if($sch_value != '') {
    $mb_where_str .= " and mb_name like '%{$sch_value}%'";
}

$mb_orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, mb_name asc";

$sql = " select * from g5_member where branch_id = '{$_SESSION['this_branch_id']}' and mb_menu = '{$_SESSION['this_code']}' and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$mb_where_str} order by {$mb_orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);
/* 회원 리스트 불러오기 END */

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
?>
<table style="margin:0; border-collapse:collapse; border-spacing:0; border:2px solid #000;">
    <thead>
        <tr>
            <th colspan="<?php echo $cols_count ?>" style="border:1px solid #000; height:40px;">
                <p style="text-align:center; vertical-align:middle;">[<?php echo $branch_row['branch_name'] ?>] [<?php echo $mn_row['me_name'] ?>] 교육정보관리 리스트</p>
            </th>
        </tr>
        <?php echo $list['hd'] ?>
    </thead>
    <?php
    if($num > 0) {
    ?>
    <tbody>
        <?php
        for($i=0; $row = sql_fetch_array($qry); $i++) {
        ?>
        <tr>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($i+1) ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['activity_status'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo wz_get_birth($row['security_number']) ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['enter_date'] != '0000-00-00')?$row['enter_date']:''; ?></p></td>
            <?php if($idx != '') { ?>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_hp'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['service_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['contract_type'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['team_category'] ?></p></td>
            <?php } ?>

            <?php
            $sql2 = " select * from g5_member_education where set_branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_idx = '{$set_idx}' and edu_year = '{$now_year}' {$where_str} order by edu_date desc, edu_str_hour desc, edu_tit asc ";
            $qry2 = sql_query($sql2);
            $num2 = sql_num_rows($qry2);

            if($num2 > 0) {
                for($m=0; $row2 = sql_fetch_array($qry2); $m++) {
                    echo '<td style="width:160px; border:1px solid #000; text-align:left;">';

                    $edu_list_sql = " select * from g5_member_education_list where idx = '{$row2['idx']}' and edul_mb_id = '{$row['mb_id']}' ";
                    $edu_list_row = sql_fetch($edu_list_sql);
                    if($edu_list_row['edul_idx'] == '') {
                        echo '<p>미참여</p>';
                    }else{
                        echo '<p>참여</p>';
                    }

                    echo '</td>';
                }
            }
            ?>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <?php
    }
    ?>
</table>
