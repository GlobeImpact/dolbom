<?php
include_once('./_common.php');

$service_category = $_GET['service_category'];
$cl_name = $_GET['cl_name'];

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename = ".date('Ymd')."_excel.xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );

echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";

// 서비스구분 불러오기
$filter_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and length(sme_code) = 2 and sme_use = 1 order by sme_order asc, sme_code asc ";
$filter_qry = sql_query($filter_sql);
$filter_num = sql_num_rows($filter_qry);

// 지점명 불러오기
$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

// 분류명 불러오기
$mn_sql = " select * from g5_menu where me_code = '{$_SESSION['this_code']}' ";
$mn_row = sql_fetch($mn_sql);

if($filter_num > 0) {
    for($i=0; $filter_row = sql_fetch_array($filter_qry); $i++) {
        $colspan = '';
        if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) $colspan = 34;
        if($filter_row['sme_code'] == 40) $colspan = 34;
        if($filter_row['sme_code'] == 50) $colspan = 27;
        if($filter_row['sme_code'] == 30) $colspan = 26;
?>
<table style="margin:0; border-collapse:collapse; border-spacing:0; border:2px solid #000;">
    <thead>
        <tr>
            <th colspan="<?php echo $colspan ?>" style="height:40px; border:1px solid #000; background:#ffff00;">
                <p style="text-align:center; vertical-align:middle;">[<?php echo $branch_row['branch_name'] ?>] [<?php echo $mn_row['me_name'] ?>] [<?php echo $filter_row['sme_name'] ?>] 고객 리스트</p>
            </th>
        </tr>
        <?php if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) { // 아가마지[바우처|유료] ?>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">지점</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:200px;">서비스기간</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">추가옵션</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">접수일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">시작일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">종료일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">취소일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">신청인</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">긴급연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">출산유형</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">출산예정일</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">출산일</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">출산아기</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">아기성별</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">출산순위</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">취학</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">미취학</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">추가요금부담</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">CCTV</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">사전면접</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">단가구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">합계금액</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">현금영수증</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">특이사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">추가요청사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">취소사유</th>
        </tr>
        <?php } ?>

        <?php if($filter_row['sme_code'] == 40) { // 가사서비스[베이비시터] ?>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">지점</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:200px;">서비스기간</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">추가옵션</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">접수일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">시작일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">종료일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">취소일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">신청인</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">긴급연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">가족관계</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">아기이름</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">아기생년월일</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">아기성별</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">출산순위</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">쌍둥이유무</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">큰아이유무</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">추가요금부담</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">연장근무</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">CCTV</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">사전면접</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">단가구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">합계금액</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">현금영수증</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">특이사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">추가요청사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">취소사유</th>
        </tr>
        <?php } ?>

        <?php if($filter_row['sme_code'] == 50) { // 가사서비스[청소] ?>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">지점</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:200px;">서비스기간</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">추가옵션</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">접수일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">시작일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">종료일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">취소일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">신청인</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">긴급연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">추가요금부담</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">연장근무</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">CCTV</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">사전면접</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">단가구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">합계금액</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">현금영수증</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">특이사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">추가요청사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">취소사유</th>
        </tr>
        <?php } ?>

        <?php if($filter_row['sme_code'] == 30) { // 가사서비스[반찬] ?>
        <tr>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">지점</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">활동현황</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스분류</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">서비스구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:200px;">서비스기간</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">추가옵션</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">접수일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">시작일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">종료일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">취소일자</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">신청인</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">주민번호</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:130px;">긴급연락처</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">주소</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:70px;">추가요금부담</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">CCTV</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">반려동물</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:80px;">사전면접</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">단가구분</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:120px;">합계금액</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:100px;">현금영수증</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">특이사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">추가요청사항</th>
            <th style="height:30px; border:1px solid #000; text-align:center; width:300px;">취소사유</th>
        </tr>
        <?php } ?>
    </thead>
    <?php
    $where_str = "";
    $orderby_str = "";
    
    $where_str .= " and client_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}'";
    
    if($service_category != '') {
        $where_str .= " and cl_service_cate = '{$service_category}'";
    }
    
    if($cl_name != '') {
        $where_str .= " and cl_name like '%{$cl_name}%'";
    }

    if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) {
        $where_str .= " and cl_service_cate = '{$filter_row['sme_code']}'";
    }else{
        $where_str .= " and client_service = '{$filter_row['sme_name']}'";
    }
    
    $orderby_str .= " cl_name asc";
    
    $sql = " select * from g5_client where (1=1) and cl_hide = '' {$where_str} order by {$orderby_str} ";
    $qry = sql_query($sql);
    $num = sql_num_rows($qry);

    if($num > 0) {
    ?>
    <tbody>
        <?php
        for($j=0; $row = sql_fetch_array($qry); $j++) {
            $use_status = '사용';
            if($row['end_date'] == '' || $row['end_date'] != '0000-00-00') $use_status = '종료';
            if($row['cancel_date'] == '' || $row['cancel_date'] != '0000-00-00') $use_status = '취소';

            $menu_where_str = "";
            if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) {
                $menu_where_str .= "(1=1)";
            }else{
                $menu_where_str .= "(1=1) and client_service = '{$filter_row['sme_name']}'";
            }

            // 서비스분류
            $service_menu_sql = " select * from g5_service_menu where {$menu_where_str} and length(sme_code) = 2 and sme_code = '{$row['cl_service_cate']}' and sme_use = 1 order by sme_order asc, sme_code asc ";
            $service_menu_row = sql_fetch($service_menu_sql);

            // 서비스구분
            $service_menu2_sql = " select * from g5_service_menu where {$menu_where_str} and length(sme_code) = 6 and sme_id = '{$row['cl_service_cate2']}' and sme_use = 1 order by sme_order asc, sme_code asc ";
            $service_menu2_row = sql_fetch($service_menu2_sql);

            // 서비스기간
            $service_period_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where spe_id = '{$row['cl_service_period']}' and sme_id = '{$row['cl_service_cate2']}' order by spe_period asc ";
            $service_period_row = sql_fetch($service_period_sql);

            // 추가옵션
            $service_option_sql = " select * from g5_service_option where (sop_cate = 'select' or sop_cate = 'premium' or sop_cate = 'service') and sop_id = '{$row['cl_service_option']}' and sop_use = 1 order by sop_id asc ";
            $service_option_row = sql_fetch($service_option_sql);
        ?>
        <tr>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $branch_row['branch_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $mn_row['me_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $use_status ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $service_menu_row['sme_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $service_menu2_row['sme_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;">
                <p>
                    <?php
                    if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) {
                        echo $service_period_row['spe_info'];
                    }else if($filter_row['sme_code'] == 30) {
                        echo $service_period_row['spe_name'];
                    }else{
                        echo $service_period_row['spe_cate'];
                    }
                    ?>
                </p>
            </td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $service_option_row['sop_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['receipt_date'] == '0000-00-00')?'':$row['receipt_date'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['str_date'] == '0000-00-00')?'':$row['str_date'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['end_date'] == '0000-00-00')?'':$row['end_date'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cancel_date'] == '0000-00-00')?'':$row['cancel_date'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_name'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_security_number'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_hp'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_tel'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo '['.$row['cl_zip'].'] '.$row['cl_addr1'].' '.$row['cl_addr2'] ?></p></td>

            <?php if($filter_row['sme_code'] == 10 || $filter_row['sme_code'] == 20) { ?>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_birth_type'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_birth_due_date'] == '0000-00-00')?'':$row['cl_birth_due_date'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_birth_date'] == '0000-00-00')?'':$row['cl_birth_date'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby_gender'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby_count'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_school'] > 0)?'취학 '.$row['cl_school'].'명':''; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_preschool'] > 0)?'미취학 '.$row['cl_preschool'].'명':''; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_surcharge'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_cctv'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_pet'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_prior_interview'] ?></p></td>
            <?php } ?>

            <?php if($filter_row['sme_code'] == 40) { ?>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_relationship'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby_name'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_baby_birth'] == '0000-00-00')?'':$row['cl_baby_birth'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby_gender'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_baby_count'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_twins'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_baby_first'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_surcharge'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_overtime'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_cctv'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_pet'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_prior_interview'] ?></p></td>
            <?php } ?>

            <?php if($filter_row['sme_code'] == 50) { ?>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_surcharge'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_overtime'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_cctv'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_pet'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_prior_interview'] ?></p></td>
            <?php } ?>

            <?php if($filter_row['sme_code'] == 30) { ?>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_surcharge'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo ($row['cl_cctv'] == 'y')?'있음':'없음'; ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_pet'] ?></p></td>
                <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_prior_interview'] ?></p></td>
            <?php } ?>

            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_unit_price'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_tot_price'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_cash_receipt'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_memo1'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_memo3'] ?></p></td>
            <td style="height:26px; border:1px solid #000; text-align:center;"><p><?php echo $row['cl_memo2'] ?></p></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
    <?php
    }
    ?>
</table><br><br><br>
<?php
    }
}
?>
