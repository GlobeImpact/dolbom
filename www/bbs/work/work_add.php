<?php
$client_idx = $_GET['client_idx'];
$mb_id = $_GET['mb_id'];

$now_year = date('Y');
$now_month = date('m');

$prev_year = ($now_month == '01')?$now_year-1:$now_year;
$prev_month = ($now_month == '01')?12:(int)$now_month - 1;
if($prev_month < 10) $prev_month = '0'.$prev_month;

$next_year = ($now_month == '12')?$now_year+1:$now_year;
$next_month = ($now_month == '12')?1:(int)$now_month + 1;
if($next_month < 10) $next_month = '0'.$next_month;

$popup_tit = '일정추가';

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

// 서비스분류
$service_menu_sql = " select * from g5_service_menu where sme_code = '{$client_row['cl_service_cate']}' and sme_use = 1 ";
$service_menu_row = sql_fetch($service_menu_sql);

// 서비스구분
$service_menu2_sql = " select * from g5_service_menu where sme_id = '{$client_row['cl_service_cate2']}' and sme_use = 1 ";
$service_menu2_row = sql_fetch($service_menu2_sql);

// 서비스기간
$service_period_sql = " select distinct spe_cate, spe_name, spe_period, spe_period_hour, spe_info, spe_id from g5_service_period where spe_id = '{$client_row['cl_service_period']}' ";
$service_period_row = sql_fetch($service_period_sql);
$spe_info = '';
if($client_row['cl_service_cate'] == 10 || $client_row['cl_service_cate'] == 20) {
    $spe_info = $service_period_row['spe_info'];
}else if($client_row['cl_service_cate'] == 30) {
    $spe_info = $service_period_row['spe_name'];
}else{
    $spe_info = $service_period_row['spe_cate'];
}

// 추가옵션
$service_option_sql = " select * from g5_service_option where sop_id = '{$client_row['cl_service_option']}' and sop_use = 1 order by sop_id asc ";
$service_option_row = sql_fetch($service_option_sql);

$school_preschool = '';
if($client_row['cl_school'] != '') $school_preschool .= '취학 : '.$client_row['cl_school'].'명';
if($client_row['cl_school'] != '' && $client_row['cl_preschool'] != '') $school_preschool .= ' / ';
if($client_row['cl_preschool'] != '') $school_preschool .= '미취학 : '.$client_row['cl_preschool'].'명';

// 파견정보 불러오기
$work_sql = " select * from g5_work where client_idx = '{$client_idx}' ";
$work_row = sql_fetch($work_sql);

// 파견관리사 정보 불러오기
if($work_row['mb_id'] == '') {
    $work_member = '등록된 파견관리사 없음';
}else{
    $popup_tit = '일정변경';

    $work_mb_sql = " select * from g5_member where mb_id = '{$work_row['mb_id']}' ";
    $work_mb_row = sql_fetch($work_mb_sql);

    $work_member = ($work_mb_row['security_number'] != '')?$work_mb_row['mb_name'].' ('.substr($work_mb_row['security_number'], 0, 8).')':$work_mb_row['mb_name'];

    $mb_id = $work_row['mb_id'];
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">

        <input type="hidden" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" id="now_month" value="<?php echo $now_month ?>">
        <input type="hidden" id="client_service" value="<?php echo $client_row['client_service'] ?>">
        <input type="hidden" id="spe_period" value="<?php echo $service_period_row['spe_period'] ?>">
        <input type="hidden" id="spe_period_hour" value="<?php echo $service_period_row['spe_period_hour'] ?>">

        <div class="layer_popup_form">
            <div class="work_add_form">
                <div>
                    <h4 class="layer_popup_form_tit">고객 기본정보</h4>
                    <div class="form_tbl_wrap">
                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>지점</th>
                                    <td colspan="3"><?php echo $branch_row['branch_name'] ?></td>
                                </tr>
                                <tr>
                                    <th class="x90">접수일자</th>
                                    <td class="x150"><?php echo ($client_row['receipt_date'] == '0000-00-00')?'':$client_row['receipt_date']; ?></td>
                                    <th class="x90">시작일자</th>
                                    <td class="x100"><?php echo ($client_row['str_date'] == '0000-00-00')?'':$client_row['str_date']; ?></td>
                                </tr>
                                <tr>
                                    <th>신청인</th>
                                    <td><?php echo $client_row['cl_name'] ?></td>
                                    <th>연락처</th>
                                    <td><?php echo $client_row['cl_hp'] ?></td>
                                </tr>
                                <tr>
                                    <th>출산유형</th>
                                    <td><?php echo $client_row['cl_birth_type'] ?></td>
                                    <th>출산일</th>
                                    <td><?php echo $client_row['cl_birth_date'] ?></td>
                                </tr>
                                <tr>
                                    <th>서비스구분</th>
                                    <td colspan="3">
                                        <?php echo ($service_menu_row['sme_name'] != '')?'['.$service_menu_row['sme_name'].'] ':''; ?>
                                        <?php echo $service_menu2_row['sme_name'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>서비스기간</th>
                                    <td colspan="3"><?php echo $spe_info ?></td>
                                </tr>
                                <tr>
                                    <th>추가옵션</th>
                                    <td colspan="3"><?php echo $service_option_row['sop_name'] ?></td>
                                </tr>

                                <?php if($client_row['client_service'] == '아가마지') { ?>
                                <tr>
                                    <th>취학/미취학</th>
                                    <td><?php echo $school_preschool ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '베이비시터') { ?>
                                <tr>
                                    <th>쌍둥이유무</th>
                                    <td><?php echo ($client_row['cl_twins'] == 'y')?'있음':'없음'; ?></td>
                                    <th>큰아이유무</th>
                                    <td><?php echo ($client_row['cl_baby_first'] == 'y')?'있음':'없음'; ?></td>
                                </tr>
                                <tr>
                                    <th>출산순위</th>
                                    <td><?php echo $client_row['cl_baby_count'] ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '청소') { ?>
                                <tr>
                                    <th>연장근무</th>
                                    <td><?php echo ($client_row['cl_overtime'] == 'y')?'있음':'없음'; ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '반찬') { ?>
                                <tr>
                                    <th>추가요금부담</th>
                                    <td><?php echo $client_row['cl_surcharge'] ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <th>CCTV</th>
                                    <td><?php echo ($client_row['cl_cctv'] == 'y')?'있음':'없음' ?></td>
                                    <th>반려동물</th>
                                    <td><?php echo $client_row['cl_pet'] ?></td>
                                </tr>
                                <tr>
                                    <th>특이사항</th>
                                    <td colspan="3">
                                        <div class="v_cl_memo"><?php echo nl2br($client_row['cl_memo1']) ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>추가요청사항</th>
                                    <td colspan="3">
                                        <div class="v_cl_memo"><?php echo nl2br($client_row['cl_memo3']) ?></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h4 class="layer_popup_form_tit">파견 일자</h4>
                    <?php if($client_row['client_service'] == '베이비시터' || $client_row['client_service'] == '청소') { ?>
                    <div class="calendar_filter">
                        <select id="all_check_str">
                            <option value="">시간</option>
                            <?php
                            for($h=8; $h<=22; $h++) {
                                $h_val = $h;
                                if($h < 10) $h_val = '0'.$h_val;
                            ?>
                            <option value="<?php echo $h ?>"><?php echo $h_val ?></option>
                            <?php
                            }
                            ?>
                        </select> ~ 

                        <select id="all_check_end">
                            <option value="">시간</option>
                            <?php
                            for($h=8; $h<=22; $h++) {
                                $h_val = $h;
                                if($h < 10) $h_val = '0'.$h_val;
                            ?>
                            <option value="<?php echo $h ?>"><?php echo $h_val ?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <a id="all_check_btn">일괄적용</a>
                    </div>
                    <?php } ?>
                    <ul id="date_selected_box"></ul>
                </div>
                <div>
                    <div class="filter_year_wrap">
                        <div class="filter_box">
                            <label>파견관리사 : <?php echo $work_member ?></label>
                            <a class="filter_submit" id="work_member_change_btn">선택</a>
                        </div>
                    </div>

                    <?php if($client_row['client_service'] == '베이비시터' || $client_row['client_service']) { ?>
                    <div class="calendar_filter">
                        <select id="week_count" class="form_select">
                            <?php for($wc=1; $wc<=5; $wc++) { ?>
                            <option value="<?php echo $wc ?>"><?php echo $wc.'주차'; ?></option>
                            <?php } ?>
                        </select>

                        <label class="input_label" for="week_1"><input type="checkbox" class="week" id="week_1" value="1">월</label>
                        <label class="input_label" for="week_2"><input type="checkbox" class="week" id="week_2" value="2">화</label>
                        <label class="input_label" for="week_3"><input type="checkbox" class="week" id="week_3" value="3">수</label>
                        <label class="input_label" for="week_4"><input type="checkbox" class="week" id="week_4" value="4">목</label>
                        <label class="input_label" for="week_5"><input type="checkbox" class="week" id="week_5" value="5">금</label>
                        <label class="input_label" for="week_6"><input type="checkbox" class="week" id="week_6" value="6">토</label>
                        <label class="input_label" for="week_0"><input type="checkbox" class="week" id="week_0" value="0">일</label>

                        <a id="calendar_filter_btn">설정완료</a>
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
                        <div class="work_add_submit_box">
                            <div class="tot_price_box">
                                <label>합계금액&nbsp;:&nbsp;</label>
                                <span>0</span>
                            </div>
                            <a class="add_submit_btn" id="submit_btn">파견저장</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="select_layer_popup_bg"></div>
<div id="select_layer_popup" class="x500"></div>

<script>
$(function(){
    $(".date_api").datepicker(datepicker_option);
});

$(document).ready(function(){
    calendar_call();
    tot_price();
});
</script>