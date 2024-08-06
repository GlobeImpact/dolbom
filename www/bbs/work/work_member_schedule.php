<?php
$mb_id = $_GET['mb_id'];
$client_idx = $_GET['client_idx'];

$popup_tit = '관리사 일정보기';

$call_mb_sql = " select * from g5_member where mb_id = '{$mb_id}' ";
$call_mb_row = sql_fetch($call_mb_sql);

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

$now_year = date('Y');
$now_month = date('m');
if($client_row['str_date'] != '' && $client_row['str_date'] != '0000-00-00') {
    $client_str_date_arr = explode('-', $client_row['str_date']);
    $now_year = $client_str_date_arr[0];
    $now_month = $client_str_date_arr[1];
}

$prev_year = ($now_month == '01')?$now_year-1:$now_year;
$prev_month = ($now_month == '01')?12:(int)$now_month - 1;
if($prev_month < 10) $prev_month = '0'.$prev_month;

$next_year = ($now_month == '12')?$now_year+1:$now_year;
$next_month = ($now_month == '12')?1:(int)$now_month + 1;
if($next_month < 10) $next_month = '0'.$next_month;
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="scheduleform" name="scheduleform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="mode" id="mode" value="schedule">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">
        <input type="hidden" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" id="now_month" value="<?php echo $now_month ?>">

        <?php if(count($call_mb_row) > 0) { ?>
        <div id="work_member_text_box">
            <p>관리사 : <?php echo $call_mb_row['mb_name'] ?> (<?php echo $call_mb_row['security_number'] ?>) <?php echo $call_mb_row['mb_hp'] ?></p>
        </div>
        <?php } ?>

        <div class="calendar_wrap">
            <div class="calendar_top">
                <div class="calendar_year_box">
                    <a class="calendar_move_btn" id="prev_year_btn" year="<?php echo $prev_year ?>" month="<?php echo $prev_month ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_prev.png"></a>
                    <span class="work_calendar_tit"><?php echo $now_year ?>.<?php echo $now_month ?></span>
                    <a class="calendar_move_btn" id="next_year_btn" year="<?php echo $next_year ?>" month="<?php echo $next_month ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_next.png"></a>
                </div>
            </div>

            <table class="work_calendar_tbl">
                <thead>
                    <tr>
                        <th>일</th>
                        <th>월</th>
                        <th>화</th>
                        <th>수</th>
                        <th>목</th>
                        <th>금</th>
                        <th>토</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </form>
</div>

<script>
$(document).ready(function(){
    calendar_call('schedule');
});
</script>
