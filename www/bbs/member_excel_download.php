<?php
include_once('./_common.php');

$activity_status = $_GET['activity_status'];
$service_category = $_GET['service_category'];
$mb_name = $_GET['mb_name'];

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = ".date('Ymd')."_excel.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

$mn_sql = " select * from g5_menu where me_code = '{$_SESSION['this_code']}' ";
$mn_row = sql_fetch($mn_sql);

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}'";

if($activity_status != '') {
    $where_str .= " and activity_status = '{$activity_status}'";
}

if($service_category != '') {
    $where_str .= " and service_category = '{$service_category}'";
}

if($mb_name != '') {
    $where_str .= " and mb_name like '%{$mb_name}%'";
}

$orderby_str .= " activity_status = '보류' desc, activity_status = '활동중' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

$sql = " select * from g5_member where (1=1) and mb_level = 2 and mb_hide = '' {$where_str} order by {$orderby_str} ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
?>

<table style="margin:0; border-collapse:collapse; border-spacing:0; border:2px solid #000;">
    <thead>
        <tr>
            <th colspan="27" style="height:40px;">
                <p style="text-align:center; vertical-align:middle;">[<?php echo $branch_row['branch_name'] ?>] [<?php echo $mn_row['me_name'] ?>] 제공인력 리스트</p>
            </th>
        </tr>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">지점</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:60px;">팀구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">성명</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">계약형태</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">입사일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">프리미엄</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">취약계층여부</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:150px;">학력</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:150px;">경력</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">4대보험가입</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">보험상실</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">퇴사일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">급여</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">표준월소득액</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">은행</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:170px;">계좌번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">예금주</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">예금주(기타)</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">비고</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">특이사항</th>
        </tr>
    </thead>
    <?php
    if($num > 0) {
    ?>
    <tbody>
        <?php
        for($i=0; $row = sql_fetch_array($qry); $i++) {
            $v_vulnerable = '';
            if($row['vulnerable'] != '') {
                if($row['vulnerable'] == '기타') {
                    $v_vulnerable .= $row['vulnerable_etc'];
                }else{
                    $v_vulnerable .= $row['vulnerable'];
                }
            }

            $v_mb_addr = '';
            if($row['mb_zip1'] != '' || $row['mb_zip2'] != '') $v_mb_addr .= '['.$row['mb_zip1'].$row['mb_zip2'].'] ';
            if($row['mb_addr1'] != '') {
                if($v_mb_addr != '') $v_mb_addr .= ' ';
                $v_mb_addr .= $row['mb_addr1'];
            }
            if($row['mb_addr2'] != '') {
                if($v_mb_addr != '') $v_mb_addr .= ' ';
                $v_mb_addr .= $row['mb_addr2'];
            }
        ?>
        <tr>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $branch_row['branch_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $mn_row['me_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['activity_status'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['service_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['team_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_hp'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['security_number'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['contract_type'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['enter_date'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['premium_use'] == 'y')?'Y':''; ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $v_vulnerable ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['pet_use'] != '')?$row['pet_use']:''; ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:left;"><p><?php echo $row['education_memo'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:left;"><p><?php echo $row['career_memo'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:left;"><p><?php echo $v_mb_addr ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['major4_insurance'] == '0000-00-00')?'':$row['major4_insurance']; ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['loss_insurance'] == '0000-00-00')?'':$row['loss_insurance']; ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['quit_date'] == '0000-00-00')?'':$row['quit_date']; ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:right;"><p style="padding-left:15px; padding-right:15px;"><?php echo number_format($row['basic_price']) ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:right;"><p style="padding-left:15px; padding-right:15px;"><?php echo number_format($row['monthly_income']) ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['bank_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['bank_account'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['account_holder'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['account_holder_etc'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:left;"><p style="padding-left:15px; padding-right:15px;"><?php echo $row['mb_memo'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:left;"><p style="padding-left:15px; padding-right:15px;"><?php echo $row['mb_memo2'] ?></p></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <?php
    }
    ?>
</table>