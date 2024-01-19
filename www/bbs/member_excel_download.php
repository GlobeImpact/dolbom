<?php
include_once('./_common.php');

$activity_status = $_GET['activity_status'];
$service_category = $_GET['service_category'];
$mb_name = $_GET['mb_name'];

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = excel_test.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

$mn_sql = " select * from g5_menu where me_code = '{$_SESSION['this_code']}' ";
$mn_row = sql_fetch($mn_sql);

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}'";

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
            <th colspan="23" style="height:40px;">
                <p style="text-align:center; vertical-align:middle;">[<?php echo $mn_row['me_name'] ?>] 제공인력 리스트</p>
            </th>
        </tr>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:60px;">팀구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">성명</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">계약형태</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">입사일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">프리미엄</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">취약계층여부</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">4대보험</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">보험상실</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">퇴사일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">급여</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">표준월소득액</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">은행</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">계좌번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">예금주</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">예금주(기타)</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">비고</th>
            <th style="height:30px; border:1px solid #000; text-align:center;">특이사항</th>
        </tr>
    </thead>
    <?php
    if($num > 0) {
    ?>
    <tbody>
        <?php
        for($i=0; $row = sql_fetch_array($qry); $i++) {
        ?>
        <tr>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['activity_status'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['service_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['team_category'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['mb_hp'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['security_number'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['contract_type'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <?php
    }
    ?>
</table>