<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/certificate/quit.css?ver=1">', 0);

$sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$row = sql_fetch($sql);

$mb_menu_sql = " select * from g5_menu where me_code = '{$row['mb_menu']}' ";
$mb_menu_row = sql_fetch($mb_menu_sql);

$enter_date_arr = explode('-', $row['enter_date']);
$quit_date_arr = explode('-', $row['quit_date']);

$enter_date_txt = '';
$quit_date_txt = '';
if($row['enter_date']) $enter_date_txt .= $enter_date_arr[0].'년 '.$enter_date_arr[1].'월 '.$enter_date_arr[2].'일';
if($row['quit_date']) $quit_date_txt .= $quit_date_arr[0].'년 '.$quit_date_arr[1].'월 '.$quit_date_arr[2].'일';

// print_r($row);
// print_r($config);
// print_r($default);
?>

<div class="quit_wrap">
    <div class="quit_top">
        <a class="print_btn">인쇄하기</a>
    </div>
    <div class="quit_box">
        <table class="quit_tbl">
            <tbody>
                <tr>
                    <td class="talign_c" colspan="4">
                        <h3>퇴직증명서</h3>
                    </td>
                </tr>
                <tr>
                    <td class="x150">기관명</td>
                    <td colspan="3"><?php echo $config['cf_title'] ?></td>
                </tr>
                <tr>
                    <td>근무처</td>
                    <td colspan="3"><?php echo $row['service_category'] ?></td>
                </tr>
                <tr>
                    <td>성　명</td>
                    <td class="x200"><?php echo $row['mb_name'] ?></td>
                    <td class="x150">생년월일</td>
                    <td><?php echo wz_get_birth($row['security_number']) ?></td>
                </tr>
                <tr>
                    <td>입사년월일</td>
                    <td><?php echo $enter_date_txt ?></td>
                    <td>퇴사년월일</td>
                    <td><?php echo $quit_date_txt ?></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div class="quit_bottom">
                            <p class="quit_bottom_p1">위 사람은 상기와 같이 퇴직하였음으로 확인함.</p>
                            <p class="quit_bottom_p2"><?php echo date('Y') ?>년&nbsp;&nbsp;<?php echo date('m') ?>월&nbsp;&nbsp;<?php echo date('d') ?>일</p>
                            <p class="quit_bottom_p3"><?php echo $config['cf_title'] ?></p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
$(function(){
    $('.print_btn').click(function(){ 
        $('.quit_top').css('display', 'none');

        window.print();

        $('.quit_top').css('display', 'flex');
    });
});
</script>