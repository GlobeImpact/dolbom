<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/certificate/career.css?ver=1">', 0);

$security_number_set = $_GET['security_number_set'];
$service_category_set = $_GET['service_category_set'];
$usage_set = $_GET['usage_set'];
$submit_to_set = $_GET['submit_to_set'];

$sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);

$mb_menu_sql = " select * from g5_menu where me_code = '{$row['mb_menu']}' ";
$mb_menu_row = sql_fetch($mb_menu_sql);

$enter_date_arr = explode('-', $row['enter_date']);
$quit_date_arr = explode('-', $row['quit_date']);

$period = '';
$period .= $enter_date_arr[0].'년 '.$enter_date_arr[1].'월 '.$enter_date_arr[2].'일';
if($row['quit_date'] == '' || $row['quit_date'] == '0000-00-00') {
    $period .= ' ~ '.date('Y년 m월 d일 현재까지');
}else{
    $period .= ' ~ '.$quit_date_arr[0].'년 '.$quit_date_arr[1].'월 '.$quit_date_arr[2].'일';
}

$security_number_txt = $row['security_number'];
if($security_number_set == 'y') {
    $security_number_txt = substr($row['security_number'], 0, 8).'******';
}

$addr_sql = " select * from g5_branch_addr where branch_id = '{$_SESSION['this_branch_id']}' and menu_code = '{$_SESSION['this_code']}' ";
$addr_row = sql_fetch($addr_sql);
?>

<div class="enter_wrap">
    <div class="enter_top">
        <a class="print_btn">인쇄하기</a>
    </div>
    <div class="enter_box">
        <table class="enter_tbl">
            <tbody>
                <tr>
                    <td class="enter_tbl_tit" colspan="5"><h3>경력증명서</h3></td>
                </tr>
                <tr>
                    <td class="x40 talign_c lineh_30" rowspan="3">인적사항</td>
                    <td class="talign_c x110">성　　명</td>
                    <td colspan="3"><?php echo $row['mb_name'] ?></td>
                </tr>
                <tr>
                    <td class="talign_c">생년월일</td>
                    <td class="x230"><?php echo wz_get_birth($row['security_number']) ?></td>
                    <td class="talign_c x120">주민등록번호</td>
                    <td><?php echo $security_number_txt ?></td>
                </tr>
                <tr>
                    <td class="talign_c">현&nbsp;&nbsp;주&nbsp;&nbsp;소</td>
                    <td colspan="3"><?php echo $row['mb_addr1'].' '.$row['mb_addr2'] ?></td>
                </tr>
                <tr>
                    <td class="x40 talign_c lineh_30" rowspan="6">근무사항</td>
                    <td class="talign_c">기&nbsp;&nbsp;관&nbsp;&nbsp;명</td>
                    <td colspan="3"><?php echo $config['cf_title'] ?></td>
                </tr>
                <tr>
                    <td class="talign_c">근&nbsp;&nbsp;무&nbsp;&nbsp;처</td>
                    <td colspan="3"><?php echo $mb_menu_row['me_name'] ?></td>
                </tr>
                <tr>
                    <td class="talign_c lineh_15">(재직·경력)<br>기　　간</td>
                    <td class="talign_c" colspan="3"><?php echo $period ?></td>
                </tr>
                <tr>
                    <td class="talign_c">담당업무</td>
                    <td colspan="3"><?php echo $service_category_set ?></td>
                </tr>
                <tr>
                    <td class="talign_c">단체주소</td>
                    <td colspan="3"><?php echo $addr_row['branch_addr'] ?></td>
                </tr>
                <tr>
                    <td class="talign_c">연&nbsp;&nbsp;락&nbsp;&nbsp;처</td>
                    <td class="talign_c" colspan="3">
                        TEL. <?php echo $default['de_admin_company_tel'] ?>&nbsp;&nbsp;/&nbsp;&nbsp;FAX. <?php echo $default['de_admin_company_fax'] ?>
                    </td>
                </tr>
                <tr>
                    <td class="talign_c" colspan="2">제&nbsp;출&nbsp;용&nbsp;도</td>
                    <td><?php echo $usage_set ?></td>
                    <td class="talign_c">제&nbsp;&nbsp;출&nbsp;&nbsp;처</td>
                    <td><?php echo $submit_to_set ?></td>
                </tr>
                <tr>
                    <td class="enter_bottom" colspan="5">
                        <div class="enter_bottom_date">
                            <p><br><br><br>위 내용이 사실임을 증명함.<br><br><?php echo date('Y') ?>년&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('m') ?>월&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('d') ?>일<br><br><br><br><br><br></p>
                            <p class="enter_bottom_p1">"우리는 사람이 행복한 세상을 위해 함께 성장하는 건강한 기업을 만든다."</p>
                            <p class="enter_bottom_p2">사단법인 부산돌봄사회서비스센터</p>
                        </div>

                        <div class="enter_bottom_sign">
                            <p>확인자인</p>
                        </div>

                        <img src="<?php echo G5_IMG_URL ?>/stamp.png">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    $('.print_btn').click(function(){
        $('.enter_top').css('display', 'none');

        window.print();

        $('.enter_top').css('display', 'flex');
    });
});
</script>