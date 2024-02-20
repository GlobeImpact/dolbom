<?php
include_once('./_common.php');

$list = Array();

$now_year = $_GET['now_year'];
$sch_value = $_GET['sch_value'];
$set_idx = $_GET['set_idx'];

if($set_idx != '') $set_where_str = " and set_idx = '{$set_idx}'";
$set_sql = " select * from g5_member_health_set where set_hide = '' {$set_where_str} ";
$set_qry = sql_query($set_sql);
$set_num = sql_num_rows($set_qry);

$set_qry2 = sql_query($set_sql);
$set_num2 = sql_num_rows($set_qry2);

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = ".date('Ymd')."_excel.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

$mn_sql = " select * from g5_menu where me_code = '{$_SESSION['this_code']}' ";
$mn_row = sql_fetch($mn_sql);

/* List Table HD 추출 STR */
$cols_count = 0;
if($set_idx == '') {
    $cols_count = 5 + $set_num;
}else{
    $cols_count = 9 + $set_num;
}

$menu_cell = '';

switch ($set_idx) {
    case '':
        $menu_cell = '';

        if($set_num > 0) {
            for($m=0; $set_row = sql_fetch_array($set_qry); $m++) {
                $menu_cell .= '<th style="border:1px solid #000;">'.$set_row['set_tit'].'</th>';
            }
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2" style="border:1px solid #000;">번호</th>
            <th class="layer_list_activity_status" rowspan="2" style="border:1px solid #000;">현황</th>
            <th class="layer_list_name" rowspan="2" style="border:1px solid #000;">직원명</th>
            <th class="layer_list_date" rowspan="2" style="border:1px solid #000;">생년월일</th>
            <th class="layer_list_date" rowspan="2" style="border:1px solid #000;">입사일자</th>
            <th colspan="'.$set_num.'" style="border:1px solid #000;">자격관리</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;

    default:
        $menu_cell = '';

        if($set_num > 0) {
            for($m=0; $set_row = sql_fetch_array($set_qry); $m++) {
                $menu_cell .= '<th style="border:1px solid #000;">'.$set_row['set_tit'].'</th>';
            }
        }

        $list['hd'] = '
        <tr>
            <th class="layer_list_numb" rowspan="2" style="border:1px solid #000;">번호</th>
            <th class="layer_list_activity_status" rowspan="2" style="border:1px solid #000;">현황</th>
            <th class="layer_list_name" rowspan="2" style="border:1px solid #000;">직원명</th>
            <th class="layer_list_date" rowspan="2" style="border:1px solid #000;">생년월일</th>
            <th class="layer_list_date" rowspan="2" style="border:1px solid #000;">입사일자</th>
            <th class="layer_list_tel" rowspan="2" style="border:1px solid #000;">연락처</th>
            <th class="layer_list_service_category" rowspan="2" style="border:1px solid #000;">서비스</th>
            <th class="layer_list_status" rowspan="2" style="border:1px solid #000;">계약형태</th>
            <th class="layer_list_numb" rowspan="2" style="border:1px solid #000;">팀</th>
            <th style="border:1px solid #000;">자격관리</th>
        </tr>
        <tr>'.$menu_cell.'</tr>
        ';
    break;
}
/* List Table HD 추출 END */

$where_str = "";
$orderby_str = "";

if($sch_value != '') {
    $where_str .= " and mb_name like '%{$sch_value}%'";
}

$orderby_str .= " activity_status = '활동중' desc, activity_status = '보류' desc, mb_name asc";

$sql = " select * from g5_member where branch_id = '{$_SESSION['this_branch_id']}' and mb_menu = '{$_SESSION['this_code']}' and mb_level = 2 and mb_hide = '' and (activity_status = '보류' or activity_status = '활동중') {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
?>

<table style="margin:0; border-collapse:collapse; border-spacing:0; border:2px solid #000;">
    <thead>
        <tr>
            <th colspan="<?php echo $cols_count ?>" style="border:1px solid #000; height:40px;">
                <p style="text-align:center; vertical-align:middle;">[<?php echo $branch_row['branch_name'] ?>] [<?php echo $mn_row['me_name'] ?>] 건강검진정보관리 리스트</p>
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
            <?php if($set_idx != '') { ?>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_hp'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['service_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['contract_type'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['team_category'] ?></p></td>
            <?php } ?>
        
            <?php
                if($set_num2 > 0) {
                    for($m=0; $set_row2 = sql_fetch_array($set_qry2); $m++) {
                        $health_sql = " select * from g5_member_health where set_idx = '{$set_row2['set_idx']}' and input_year = '{$now_year}' and mb_id = '{$row['mb_id']}' ";
                        $health_row = sql_fetch($health_sql);

                        echo '<td style="width:160px; border:1px solid #000; text-align:left;">';

                        if($health_row['idx'] == '') {
                            $list['list'][$i]['health'][$m]['idx'] = '';
                            $list['list'][$i]['health'][$m]['diagnosis_date'] = '';
                            $list['list'][$i]['health'][$m]['judgment_date'] = '';
                            $list['list'][$i]['health'][$m]['confirm_date'] = '';
                        }else{
                            $list['list'][$i]['health'][$m]['idx'] = $health_row['idx'];
                            $list['list'][$i]['health'][$m]['diagnosis_date'] = $health_row['diagnosis_date'];
                            if($health_row['diagnosis_date'] == '0000-00-00') $list['list'][$i]['health'][$m]['diagnosis_date'] = '';
                            $list['list'][$i]['health'][$m]['judgment_date'] = $health_row['judgment_date'];
                            if($health_row['judgment_date'] == '0000-00-00') $list['list'][$i]['health'][$m]['judgment_date'] = '';
                            $list['list'][$i]['health'][$m]['confirm_date'] = $health_row['confirm_date'];
                            if($health_row['confirm_date'] == '0000-00-00') $list['list'][$i]['health'][$m]['confirm_date'] = '';
                        }

                        echo '<div>진단일자 : '.$list['list'][$i]['health'][$m]['diagnosis_date'].'</div>';
                        echo '<div>판정일자 : '.$list['list'][$i]['health'][$m]['judgment_date'].'</div>';
                        echo '<div>확인일자 : '.$list['list'][$i]['health'][$m]['confirm_date'].'</div>';

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