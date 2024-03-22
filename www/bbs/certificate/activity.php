<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/certificate/activity.css?ver=1">', 0);

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
    $period .= ' ~ '.date('Y년 m월 d일');
}else{
    $period .= ' ~ '.$quit_date_arr[0].'년 '.$quit_date_arr[1].'월 '.$quit_date_arr[2].'일';
}

$security_number_txt = $row['security_number'];
if($security_number_set == 'y') {
    $security_number_txt = substr($row['security_number'], 0, 8).'******';
}

$get_branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$get_branch_row = sql_fetch($get_branch_sql);
?>

<div class="activity_wrap">
    <div class="activity_top">
        <a class="print_btn">인쇄하기</a>
    </div>
    <div class="activity_box">
        <h3>활동증명서</h3>

        <table class="activity_tbl">
            <tbody>
                <tr>
                    <th>신&nbsp;&nbsp;청&nbsp;&nbsp;인</th>
                    <td><?php echo $row['mb_name'] ?></td>
                </tr>
                <tr>
                    <th>주민등록번호</th>
                    <td><?php echo $security_number_txt ?></td>
                </tr>
                <tr>
                    <th>활동기간</th>
                    <td><?php echo $period ?></td>
                </tr>
                <tr>
                    <th>기&nbsp;&nbsp;관&nbsp;&nbsp;명</th>
                    <td><?php echo $config['cf_title'] ?></td>
                </tr>
                <tr>
                    <th>담당업무</th>
                    <td><?php echo $service_category_set ?></td>
                </tr>
                <tr>
                    <th>용　　도</th>
                    <td><?php echo $usage_set ?></td>
                </tr>
            </tbody>
        </table>

        <div class="activity_bottom">
            <img src="<?php echo G5_IMG_URL ?>/stamp.png">
            <p class="activity_bottom_p1"><?php echo date('Y') ?>년 <?php echo date('m') ?>월 <?php echo date('d') ?>일</p>
            <p class="activity_bottom_p2">위의 사실을 증명합니다.</p>
            <p class="activity_bottom_p3"><?php echo $config['cf_title'] ?></p>
            <p class="activity_bottom_p4"><?php echo $get_branch_row['branch_addr'] ?></p>
            <p class="activity_bottom_p5">대표자: <?php echo $default['de_admin_company_owner'] ?> (인)</p>
        </div>
    </div>
</div>

<script>
$(function(){
    $('.print_btn').click(function(){ 
        $('.activity_top').css('display', 'none');

        window.print();

        $('.activity_top').css('display', 'flex');
    });
});
</script>