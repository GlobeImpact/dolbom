<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/pay/pay_attendance.css?ver=1">', 0);

$now_year = date('Y');
$now_month = date('m');

$prev_year = ($now_month == '01')?$now_year-1:$now_year;
$prev_month = ($now_month == '01')?12:(int)$now_month - 1;
if($prev_month < 10) $prev_month = '0'.$prev_month;

$next_year = ($now_month == '12')?$now_year+1:$now_year;
$next_month = ($now_month == '12')?1:(int)$now_month + 1;
if($next_month < 10) $next_month = '0'.$next_month;

$client_service = ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0];
?>

<div id="layer_wrap">
    <div id="layer_box">

        <?php
        $menu_sql = " select * from g5_menu where me_code like '{$_SESSION['this_code']}{$mn_cd}%' and length(me_code) = 6 and me_use = 1 order by me_order asc, me_code asc ";
        $menu_qry = sql_query($menu_sql);
        $menu_num = sql_num_rows($menu_qry);
        if($menu_num > 0) {
        ?>
        <ul class="menu_box">
            <?php
            for($m=0; $menu_row = sql_fetch_array($menu_qry); $m++) {
            ?>
            <li class="menu_list" <?php echo ("{$_SESSION['this_code']}{$mn_cd2}" == $menu_row['me_code'])?'id="menu_list_act"':''; ?>><a class="menu_list_btn" href="<?php echo $menu_row['me_link'] ?>?this_code=<?php echo $_SESSION['this_code'] ?>" target="_<?php echo $menu_row['me_target'] ?>"><?php echo $menu_row['me_name'] ?></a></li>
            <?php
            }
            ?>
        </ul>
        <?php
        }
        ?>

        <div class="sub_wrap">
            <!-- Left Menu STR -->
            <div class="list_wrap">
                <div class="list_wrap_top">
                    <div class="list_filter_box">
                        <select class="filter_select" id="sch_activity_status">
                            <option value="">활동현황</option>
                            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}); $l++) { ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?></option>
                            <?php } ?>
                        </select>

                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                            <?php } ?>
                        </select>

                        <input type="text" class="filter_input" id="sch_mb_name" value="" placeholder="이름 조회">
                    </div>
                </div>

                <div class="list_wrap_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x100">직원명</th>
                                <th class="x40">성별</th>
                                <th class="x40">팀</th>
                                <th class="x60">파견</th>
                                <th>현황</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="list_wrap_list_box">
                        <table class="list_tbl">
                            <tbody id="member_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Left Menu END -->


            <input type="hidden" id="v_set_idx" value="">
            <div class="form_wrap">
                <div class="form_row flex_1">
                    <div class="form_box xp30">
                        <h4 class="sub_tit talign_c">[ 근 태 정 보&nbsp;&nbsp;&nbsp;&nbsp;직 접 수 정 ]</h4>

                        <div class="write_box">
                            <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
                                <input type="hidden" name="at_idx" id="at_idx" value="">
                                <table class="form_tbl">
                                    <tbody>
                                        <tr>
                                            <th class="x80">일자</th>
                                            <td colspan="2">
                                                <input type="text" id="at_date" class="form_input x80" value="" readonly>
                                            </td>
                                            <td id="at_yoil">화요일</td>
                                        </tr>
                                        <tr>
                                            <th>근무</th>
                                            <td class="x60">
                                                <select name="at_work" id="at_work" class="form_select">
                                                    <option value=""></option>
                                                    <option value="출근">출근</option>
                                                </select>
                                            </td>
                                            <th class="x70">지급</th>
                                            <td class="x60">
                                                <select name="at_payments" id="at_payments" class="form_select">
                                                    <option value=""></option>
                                                    <?php
                                                    $service_menu_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 2 and sme_use = 1 order by sme_order asc, sme_code asc ";
                                                    $service_menu_qry = sql_query($service_menu_sql);
                                                    $service_menu_num = sql_num_rows($service_menu_qry);
                                                    if($service_menu_num > 0) {
                                                        for($l=0; $service_menu_row = sql_fetch_array($service_menu_qry); $l++) {
                                                    ?>
                                                    <option value="<?php echo $service_menu_row['sme_code'] ?>" <?php echo ($write['cl_service_cate'] == $service_menu_row['sme_code'])?'selected':''; ?>><?php echo $service_menu_row['sme_name'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>평일</th>
                                            <td>
                                                <select name="at_weekday" id="at_weekday" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <th>바우처</th>
                                            <td>
                                                <select name="at_voucher" id="at_voucher" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>유료</th>
                                            <td>
                                                <select name="at_paid" id="at_paid" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <th>쌍생아</th>
                                            <td>
                                                <select name="at_twins" id="at_twins" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>입주</th>
                                            <td>
                                                <select name="at_move_in" id="at_move_in" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <th>큰아이</th>
                                            <td>
                                                <select name="at_baby_first" id="at_baby_first" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>마사지</th>
                                            <td>
                                                <select name="at_massage" id="at_massage" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <th>주휴</th>
                                            <td>
                                                <select name="at_weekly_holiday" id="at_weekly_holiday" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>연차</th>
                                            <td>
                                                <select name="at_annual" id="at_annual" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <th>프리미엄</th>
                                            <td>
                                                <select name="at_premium" id="at_premium" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>유료[토]</th>
                                            <td colspan="3">
                                                <select name="at_paid_sat" id="at_paid_sat" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>바우처[토]</th>
                                            <td colspan="3">
                                                <select name="at_voucher_sat" id="at_voucher_sat" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>장애우</th>
                                            <td colspan="3">
                                                <select name="at_disabled" id="at_disabled" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>휴일</th>
                                            <td colspan="2">
                                                <select name="at_holiday" id="at_holiday" class="form_select">
                                                    <option value=""></option>
                                                    <option value="n">No</option>
                                                    <option value="y">Yes</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>지정일수</th>
                                            <td colspan="3">
                                                <input type="text" name="at_days" id="at_days" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>근무시간</th>
                                            <td colspan="3">
                                                <input type="text" name="at_hours" id="at_hours" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>파견인원</th>
                                            <td colspan="3">
                                                <input type="text" name="at_work_number" id="at_work_number" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <a id="pay_attendance_submit_btn">저장하기</a>
                        </div>
                    </div>
                    <div class="form_box xp69">
                        <input type="hidden" id="now_year" value="<?php echo $now_year ?>">
                        <input type="hidden" id="now_month" value="<?php echo $now_month ?>">
                        <div class="calendar_top_box">
                            <a class="calendar_move_btn" id="prev_year_btn" year="<?php echo $prev_year ?>" month="<?php echo $prev_month ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_prev.png"></a>
                            <h4 id="pay_attendance_ym_txt"><?php echo $now_year ?>년 <?php echo $now_month ?>월</h4>
                            <a class="calendar_move_btn" id="next_year_btn" year="<?php echo $next_year ?>" month="<?php echo $next_month ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_next.png"></a>
                        </div>

                        <div class="calendar_wrap">
                            <table class="calendar_tbl">
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
                    </div>
                </div>
                <div class="form_row">
                    <div class="form_box xp100">
                        <h4 class="sub_tit">근태 리스트</h4>
                        <div class="attendance_list_wrap">
                            <table class="attendance_list_hd_tbl">
                                <thead>
                                    <tr>
                                        <th class="x100">일자</th>
                                        <th class="x50">요일</th>
                                        <th class="x50">근무</th>
                                        <th class="x50">지급</th>
                                        <th class="x50">평일</th>
                                        <th class="x60">바우처</th>
                                        <th class="x70">유료[토]</th>
                                        <th class="x80">바우처[토]</th>
                                        <th class="x50">유료</th>
                                        <th class="x60">쌍생아</th>
                                        <th class="x50">입주</th>
                                        <th class="x60">큰아이</th>
                                        <th class="x60">마사지</th>
                                        <th class="x70">프리미엄</th>
                                        <th class="x70">근무시간</th>
                                    </tr>
                                </thead>
                            </table>

                            <table class="attendance_list_tbl">
                                <tbody></tbody>
                            </table>

                            <table class="attendance_list_ft_tbl">
                                <thead></thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let write_ajax;
    let mb_list_ajax;
    let view_ajax;
    $(function(){
        $('#sch_activity_status').change(function(){
            list_act('');
        });

        $('#sch_service_category').change(function(){
            list_act('');
        });

        $('#sch_mb_name').on('input', function(){
            list_act('');
        });

        $(document).on('click', '#member_list > tr', function(){
            $('#member_list > tr').removeClass('list_selected');
            $(this).addClass('list_selected');

            calendar_call('');
            setTimeout(function(){
                view_act('');
                form_load();
            }, 400);
        });

        $(document).on('click', '.calendar_td', function(){
            let this_date = $(this).attr('this_date');
            if(this_date == '') return false;

            $('.calendar_td').removeAttr('id');
            $(this).attr('id', 'calendar_td_active');

            $('.attendance_list_tbl > tbody > tr').removeClass('at_list_selected');
            if($('.attendance_list_tbl > tbody > tr[selected_date=' + this_date + ']').length > 0) {
                $('.attendance_list_tbl > tbody > tr[selected_date=' + this_date + ']').last().addClass('at_list_selected');
            }

            form_load();
        });

        // 이전 년도(◀) , 다음 년도(▶) 클릭시
        $(document).on('click', '#prev_year_btn, #next_year_btn', function(){
            let year = $(this).attr('year');
            let month = $(this).attr('month');

            $('#now_year').val(year);
            $('#now_month').val(month);

            let pay_attendance_ym_txt = year + '년 ' + month + '월';
            $('#pay_attendance_ym_txt').text(pay_attendance_ym_txt);

            let prev_year = (month == '01')?parseInt(year) - 1:year;
            let prev_month = (month == '01')?12:parseInt(month) - 1;
            if(prev_month < 10) prev_month = '0' + prev_month;
            $('#prev_year_btn').attr('year', prev_year);
            $('#prev_year_btn').attr('month', prev_month);

            let next_year = (month == '12')?parseInt(year) + 1:year;
            let next_month = (month == '12')?1:parseInt(month) + 1;
            if(next_month < 10) next_month = '0' + next_month;
            $('#next_year_btn').attr('year', next_year);
            $('#next_year_btn').attr('month', next_month);

            list_act('');
        });

        $(document).on('click', '.attendance_list_tbl > tbody > tr', function(){
            $('.attendance_list_tbl > tbody > tr').removeClass('at_list_selected');
            $(this).addClass('at_list_selected');

            calendar_call('at_list_selected');
            setTimeout(function(){
                form_load();
            }, 400);
        });

        $('#pay_attendance_submit_btn').click(function(){
            alert(123);
            /*
            let pay_set_arr = new FormData();
            pay_set_arr.append('set_idx', $('#v_set_idx').val());
            pay_set_arr.append('v_contract_type', $('#v_contract_type').val());
            pay_set_arr.append('v_set_ym', $('#v_set_ym').val());
            pay_set_arr.append('v_payment_ymd', $('#v_payment_ymd').val());
            pay_set_arr.append('v_info_cell1', removeComma($('#v_info_cell1').val()));
            pay_set_arr.append('v_info_cell2', removeComma($('#v_info_cell2').val()));
            pay_set_arr.append('v_info_cell3', removeComma($('#v_info_cell3').val()));
            pay_set_arr.append('v_item_cell1', removeComma($('#v_item_cell1').val()));
            pay_set_arr.append('v_item_cell2', removeComma($('#v_item_cell2').val()));
            pay_set_arr.append('v_item_cell3', removeComma($('#v_item_cell3').val()));
            pay_set_arr.append('v_item_cell4', removeComma($('#v_item_cell4').val()));
            pay_set_arr.append('v_item_cell5', removeComma($('#v_item_cell5').val()));
            pay_set_arr.append('v_item_cell6', removeComma($('#v_item_cell6').val()));
            pay_set_arr.append('v_add_cell1', removeComma($('#v_add_cell1').val()));
            pay_set_arr.append('v_add_cell2', removeComma($('#v_add_cell2').val()));
            pay_set_arr.append('v_add_cell3', removeComma($('#v_add_cell3').val()));
            pay_set_arr.append('v_add_cell4', removeComma($('#v_add_cell4').val()));
            pay_set_arr.append('v_add_cell5', removeComma($('#v_add_cell5').val()));
            pay_set_arr.append('v_add_cell6', removeComma($('#v_add_cell6').val()));
            pay_set_arr.append('v_add_cell7', removeComma($('#v_add_cell7').val()));
            pay_set_arr.append('v_service_cell1', removeComma($('#v_service_cell1').val()));
            pay_set_arr.append('v_service_cell2', removeComma($('#v_service_cell2').val()));
            pay_set_arr.append('v_service_cell3', removeComma($('#v_service_cell3').val()));
            pay_set_arr.append('v_service_cell4', removeComma($('#v_service_cell4').val()));
            pay_set_arr.append('v_service_cell5', removeComma($('#v_service_cell5').val()));
            pay_set_arr.append('v_service_cell6', removeComma($('#v_service_cell6').val()));
            pay_set_arr.append('v_holiday_cell1', removeComma($('#v_holiday_cell1').val()));
            pay_set_arr.append('v_holiday_cell2', removeComma($('#v_holiday_cell2').val()));
            pay_set_arr.append('v_holiday_cell3', removeComma($('#v_holiday_cell3').val()));
            pay_set_arr.append('v_holiday_cell4', removeComma($('#v_holiday_cell4').val()));
            pay_set_arr.append('v_outsourcing_cell1', removeComma($('#v_outsourcing_cell1').val()));
            pay_set_arr.append('v_outsourcing_cell2', removeComma($('#v_outsourcing_cell2').val()));
            pay_set_arr.append('v_outsourcing_cell3', removeComma($('#v_outsourcing_cell3').val()));
            pay_set_arr.append('v_outsourcing_cell4', removeComma($('#v_outsourcing_cell4').val()));
            pay_set_arr.append('v_major4_company_cell1', removeComma($('#v_major4_company_cell1').val()));
            pay_set_arr.append('v_major4_company_cell2', removeComma($('#v_major4_company_cell2').val()));
            pay_set_arr.append('v_major4_company_cell3', removeComma($('#v_major4_company_cell3').val()));
            pay_set_arr.append('v_major4_company_cell4', removeComma($('#v_major4_company_cell4').val()));
            pay_set_arr.append('v_major4_company_cell5', removeComma($('#v_major4_company_cell5').val()));
            pay_set_arr.append('v_major4_staff_cell1', removeComma($('#v_major4_staff_cell1').val()));
            pay_set_arr.append('v_major4_staff_cell2', removeComma($('#v_major4_staff_cell2').val()));
            pay_set_arr.append('v_major4_staff_cell3', removeComma($('#v_major4_staff_cell3').val()));
            pay_set_arr.append('v_major4_staff_cell4', removeComma($('#v_major4_staff_cell4').val()));
            pay_set_arr.append('v_major4_staff_cell5', removeComma($('#v_major4_staff_cell5').val()));

            $.ajax({
                url: g5_bbs_url + '/ajax.pay_set_update.php',
                type: "POST",
                data: pay_set_arr,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if(response.code == '0000') {
                        view_act();
                    }else{
                        alert('저장에 실패하였습니다.');
                    }
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                }
            });
            */
        });
    });

    function calendar_call(mode = '') {
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        let year = $('#now_year').val();
        let month = $('#now_month').val();
        let day = '';
        let mb_id = '';
        if($('.list_selected').length > 0) {
            mb_id = $('.list_selected').attr('mb_id');
        }

        if(mode == 'at_list_selected') {
            year = $('.at_list_selected').attr('selected_year');
            month = $('.at_list_selected').attr('selected_month');
            day = $('.at_list_selected').attr('selected_day');
            
            $('#now_year').val(year);
            $('#now_month').val(month);

            let pay_attendance_ym_txt = year + '년 ' + month + '월';
            $('#pay_attendance_ym_txt').text(pay_attendance_ym_txt);

            let prev_year = (month == '01')?parseInt(year) - 1:year;
            let prev_month = (month == '01')?12:parseInt(month) - 1;
            if(prev_month < 10) prev_month = '0' + prev_month;
            $('#prev_year_btn').attr('year', prev_year);
            $('#prev_year_btn').attr('month', prev_month);

            let next_year = (month == '12')?parseInt(year) + 1:year;
            let next_month = (month == '12')?1:parseInt(month) + 1;
            if(next_month < 10) next_month = '0' + next_month;
            $('#next_year_btn').attr('year', next_year);
            $('#next_year_btn').attr('month', next_month);
        }
        
        write_ajax = $.ajax({
            url: g5_bbs_url + '/ajax.calendar_call.php',
            async: true,
            type: "POST",
            data: {'year': year, 'month': month, 'mb_id': mb_id},
            dataType: "json",
            success: function(rst) {
                let weekend = '';
                let datas = '';
                let calendar_td_active = '';

                let n = 1;
                for(let i=0; i<rst.tweek; i++) {
                    datas += '<tr>';

                    for(let k=0; k<7; k++) {
                        let nn = n;
                        if(nn < 10) nn = '0' + nn;

                        let this_date = '';

                        calendar_td_active = '';
                        if((i == 0 && k < rst.sweek) || (i == rst.tweek-1 && k > rst.lweek)) {
                        }else{
                            this_date = year + '-' + month + '-' + nn;
                            if(day == nn) {
                                calendar_td_active = 'id="calendar_td_active"';
                            }
                        }

                        datas += '<td class="calendar_td" this_date="' + this_date + '" ' + calendar_td_active + '>';
                        datas += '<div class="calendar_td_box">';
                        if((i == 0 && k < rst.sweek) || (i == rst.tweek-1 && k > rst.lweek)) {
                            datas += '</td>';
                            continue;
                        }

                        weekend = '';
                        if(k == 0) weekend = 'sunday';
                        if(k == 6) weekend = 'saturday';
                        if(typeof rst[this_date] != 'undefined') weekend = 'holiday';

                        datas +=  '<p class="day_tit ' + weekend + '">'+ nn + '</p>';
                        datas += '<div class="day_attendance">';
                        datas += '<span class="day_span_l">바우처</span>';
                        datas += '<span class="day_span_r">유료</span>';
                        datas += '</div>';

                        n++;
                        datas += '</div>';
                        datas += '</td>';
                    }

                    datas += '</tr>';
                }

                $('.calendar_tbl > tbody').empty();
                $('.calendar_tbl > tbody').append(datas);
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    }

    // 리스트 추출
    function list_act(mb_id) {
        if (typeof mb_list_ajax !== 'undefined') {
            mb_list_ajax.abort(); // 비동기 실행취소
        }

        // 리스트 스크롤 초기화(맨 위로 이동)
        $(".list_wrap > .list_wrap_list").animate({ scrollTop: 0 }, 0);

        let sch_activity_status = '';
        let sch_service_category = '';
        let sch_mb_name = '';
        let now_year = '';
        let now_month = '';

        sch_activity_status = $('#sch_activity_status option:selected').val();
        sch_service_category = $('#sch_service_category option:selected').val();
        sch_mb_name = $('#sch_mb_name').val();
        now_year = $('#now_year').val();
        now_month = $('#now_month').val();

        mb_list_ajax = $.ajax({
            url: g5_bbs_url + '/ajax.member_list.php',
            type: "POST",
            data: {'sch_activity_status': sch_activity_status, 'sch_service_category': sch_service_category, 'sch_mb_name': sch_mb_name, 'mb_id': mb_id, 'now_year': now_year, 'now_month': now_month},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#member_list').empty();
                let datas = '';
                let list_selected = '';
                let premium = '';
                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(response[i].list_selected == 'y') {
                            list_selected = 'list_selected';

                            $('#v_mb_id').val(response[i].mb_id);
                        }

                        premium = '';
                        if(response[i].premium_use == 'y') {
                            premium = '<span class="premium_icon">P</span>';
                        }

                        datas += '<tr class="' + list_selected + '" mb_id="' + response[i].mb_id + '">';
                        datas += '<td class="x100 talign_c">' + response[i].mb_name + '' + premium + '</td>';
                        datas += '<td class="x40 talign_c">' + response[i].gender + '</td>';
                        datas += '<td class="x40 talign_c">' + response[i].team_category + '</td>';
                        datas += '<td class="x60 talign_c">' + response[i].work_cnt + '</td>';
                        datas += '<td class="talign_c">' + response[i].activity_status + '</td>';
                        datas += '</tr>';
                    }

                    $('#member_list').append(datas);
                }

                calendar_call('');
                setTimeout(function(){
                    view_act('');
                }, 400);
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function view_act() {
        if (typeof view_ajax !== 'undefined') {
            view_ajax.abort(); // 비동기 실행취소
        }

        let mb_id = $('.list_selected').attr('mb_id');

        if(mb_id != '') {
            view_ajax = $.ajax({
                url: g5_bbs_url + '/ajax.pay_attendance_list.php',
                type: "POST",
                data: {'mb_id': mb_id},
                dataType: "json",
                success: function(response) {
                    $('.attendance_list_tbl > tbody').empty();

                    let at_weekday_cnt = 0;
                    let at_voucher_cnt = 0;
                    let at_paid_sat_cnt = 0;
                    let at_voucher_sat_cnt = 0;
                    let at_paid_cnt = 0;
                    let at_twins_cnt = 0;
                    let at_move_in_cnt = 0;
                    let at_baby_first_cnt = 0;
                    let at_massage_cnt = 0;
                    let at_premium_cnt = 0;

                    let datas = '';
                    let list_selected = '';
                    if(response.length > 0) {
                        for(let i=0; i<response.length; i++) {
                            list_selected = '';
                            if(i == 0) {
                                list_selected = 'at_list_selected';

                                if(typeof response[i].selected_date != 'undefined') {
                                    if($(".calendar_td[this_date=" + response[i].selected_date + "]").last().length > 0) {
                                        $('.calendar_td').removeAttr('id');
                                        $(".calendar_td[this_date=" + response[i].selected_date + "]").last().attr('id', 'calendar_td_active');
                                    }
                                }
                            }

                            if(response[i].at_weekday.toUpperCase() == 'Y') at_weekday_cnt++;
                            if(response[i].at_voucher.toUpperCase() == 'Y') at_voucher_cnt++;
                            if(response[i].at_paid_sat.toUpperCase() == 'Y') at_paid_sat_cnt++;
                            if(response[i].at_voucher_sat.toUpperCase() == 'Y') at_voucher_sat_cnt++;
                            if(response[i].at_paid.toUpperCase() == 'Y') at_paid_cnt++;
                            if(response[i].at_twins.toUpperCase() == 'Y') at_twins_cnt++;
                            if(response[i].at_move_in.toUpperCase() == 'Y') at_move_in_cnt++;
                            if(response[i].at_baby_first.toUpperCase() == 'Y') at_baby_first_cnt++;
                            if(response[i].at_massage.toUpperCase() == 'Y') at_massage_cnt++;
                            if(response[i].at_premium.toUpperCase() == 'Y') at_premium_cnt++;

                            datas += '<tr class="' + list_selected + '" idx="' + response[i].idx + '" work_selected_idx="' + response[i].work_selected_idx + '" selected_date="' + response[i].selected_date + '" selected_year="' + response[i].selected_year + '" selected_month="' + response[i].selected_month + '" selected_day="' + response[i].selected_day + '">';
                            datas += '<td class="x100 talign_c">' + response[i].selected_date + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_yoil + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_work + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_payments + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_weekday.toUpperCase() + '</td>';
                            datas += '<td class="x60 talign_c">' + response[i].at_voucher.toUpperCase() + '</td>';
                            datas += '<td class="x70 talign_c">' + response[i].at_paid_sat.toUpperCase() + '</td>';
                            datas += '<td class="x80 talign_c">' + response[i].at_voucher_sat.toUpperCase() + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_paid.toUpperCase() + '</td>';
                            datas += '<td class="x60 talign_c">' + response[i].at_twins.toUpperCase() + '</td>';
                            datas += '<td class="x50 talign_c">' + response[i].at_move_in.toUpperCase() + '</td>';
                            datas += '<td class="x60 talign_c">' + response[i].at_baby_first.toUpperCase() + '</td>';
                            datas += '<td class="x60 talign_c">' + response[i].at_massage.toUpperCase() + '</td>';
                            datas += '<td class="x70 talign_c">' + response[i].at_premium.toUpperCase() + '</td>';
                            datas += '<td class="x70 talign_c">' + response[i].at_hours + '</td>';
                            datas += '</tr>';
                        }

                        $('.attendance_list_tbl > tbody').append(datas);
                    }

                    $('.attendance_list_ft_tbl > thead').empty();
                    datas = '';
                    datas += '<tr>';
                    datas += '<th class="x100">[ 합&nbsp;&nbsp;&nbsp;&nbsp;계 ]</th>';
                    datas += '<th class="x50"></th>';
                    datas += '<th class="x50"></th>';
                    datas += '<th class="x50"></th>';
                    datas += '<th class="x50">' + at_weekday_cnt + '</th>';
                    datas += '<th class="x60">' + at_voucher_cnt + '</th>';
                    datas += '<th class="x70">' + at_paid_sat_cnt + '</th>';
                    datas += '<th class="x80">' + at_voucher_sat_cnt + '</th>';
                    datas += '<th class="x50">' + at_paid_cnt + '</th>';
                    datas += '<th class="x60">' + at_twins_cnt + '</th>';
                    datas += '<th class="x50">' + at_move_in_cnt + '</th>';
                    datas += '<th class="x60">' + at_baby_first_cnt + '</th>';
                    datas += '<th class="x60">' + at_massage_cnt + '</th>';
                    datas += '<th class="x70">' + at_premium_cnt + '</th>';
                    datas += '<th class="x70"></th>';
                    datas += '</tr>';
                    $('.attendance_list_ft_tbl > thead').append(datas);

                    form_load();
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                }
            });
        }
    }

    function form_load() {
        let mb_id = $('.list_selected').attr('mb_id');
        let this_date = $('#calendar_td_active').attr('this_date');
        let idx = '';
        let work_selected_idx = '';
        let selected_date = '';
        if($('.at_list_selected').length > 0) {
            idx = ($('.at_list_selected').attr('idx') != 'null')?$('.at_list_selected').attr('idx'):'';
            work_selected_idx = $('.at_list_selected').attr('work_selected_idx');
            selected_date = $('.at_list_selected').attr('selected_date');

            view_ajax = $.ajax({
                url: g5_bbs_url + '/ajax.pay_attendance_form.php',
                type: "POST",
                data: {'mb_id': mb_id, 'idx': idx, 'work_selected_idx': work_selected_idx, 'selected_date': selected_date},
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    // $('.attendance_list_tbl > tbody').empty();
                }
            });
        }
    }

    $(document).ready(function(){
        list_act('');
    });
</script>