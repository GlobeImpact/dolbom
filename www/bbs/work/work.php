<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/work/work.css?ver=8">', 0);

// 등록/수정 권한
$write_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $write_permit = false;
    }
}

// 삭제 권한
$delete_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'delete' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $delete_permit = false;
    }
}

$sch_service_cate = $_GET['sch_service_cate'];
$sch_str_receipt_date = $_GET['sch_str_receipt_date'];
$sch_end_receipt_date = $_GET['sch_end_receipt_date'];
$sch_cl_name = $_GET['sch_cl_name'];
$sch_cl_hp = $_GET['sch_cl_hp'];
$sch_status = $_GET['sch_status'];

$now_date = date('Y-m-d');
?>

<div id="layer_wrap">
    <div id="layer_box">
        <!-- Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="filter_box">
                <select class="filter_select" id="sch_service_cate">
                    <option value="" <?php echo ($sch_service_cate == '')?'selected':''; ?>>서비스분류선택</option>
                    <?php
                    $service_menu_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and length(sme_code) = 2 and sme_use = 1 order by sme_code asc, sme_order asc ";
                    $service_menu_qry = sql_query($service_menu_sql);
                    $service_menu_num = sql_num_rows($service_menu_qry);
                    if($service_menu_num > 0) {
                        for($l=0; $service_menu_row = sql_fetch_array($service_menu_qry); $l++) {
                    ?>
                    <option value="<?php echo $service_menu_row['sme_code'] ?>" <?php echo ($sch_service_cate == $service_menu_row['sme_code'])?'selected':''; ?>><?php echo $service_menu_row['sme_name'] ?></option>
                    <?php
                        }
                    }
                    ?>
                    <?php if($_SESSION['this_code'] == '20') { ?><option value="10|20">바우처+유료</option><?php } ?>
                </select>
                <label>접수기간</label>
                <input type="text" class="filter_input_date date_api" id="sch_str_receipt_date" value="<?php echo $sch_str_receipt_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="접수기간"> ~ 
                <input type="text" class="filter_input_date date_api" id="sch_end_receipt_date" value="<?php echo $sch_end_receipt_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="접수기간">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_name" value="<?php echo $sch_cl_name ?>" placeholder="신청인">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_hp" value="<?php echo $sch_cl_hp ?>" oninput="autoHyphen(this)" maxlength="13" placeholder="연락처">
                <select class="filter_select" id="sch_status">
                    <option value="" <?php echo ($sch_status == '')?'selected':''; ?>>접수상태선택</option>
                    <option value="사용" <?php echo ($sch_status == '사용')?'selected':''; ?>>사용</option>
                    <option value="종료" <?php echo ($sch_status == '종료')?'selected':''; ?>>종료</option>
                    <option value="취소" <?php echo ($sch_status == '취소')?'selected':''; ?>>취소</option>
                </select>
            </div>
        </div>
        <!-- Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <li class="menu_list" id="menu_list_act"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work.php">파견등록</a></li>
                <li class="menu_list"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work_status.php">파견현황</a></li>
            </ul>
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl width_max">
                    <thead>
                        <tr>
                            <th>접수</th>
                            <th class="sort_btn" order_fd="receipt_date" orderby="">접수일<img src="<?php echo G5_IMG_URL ?>/sort_arrow_icon.png"></th>
                            <th>서비스분류</th>
                            <th>서비스구분</th>
                            <th class="sort_btn" order_fd="cl_name" orderby="">신청인<img src="<?php echo G5_IMG_URL ?>/sort_arrow_icon.png"></th>
                            <th>연락처</th>
                            <th>주민번호</th>
                            <th>서비스기간</th>
                            <th>시작일</th>
                            <th>종료일</th>
                            <th>취소일</th>
                            <th>CCTV</th>
                            <th>반려동물</th>
                            <th>사전면접</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl width_max">
                    <tbody id="work_list"></tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->

        <div class="work_wrap">
            <div class="work_box">
                <div class="work_member_box">
                    <div class="work_member_top">
                        <div>
                            <a class="set_btn" id="add_work_btn">일정추가</a>
                        </div>
                        <div>
                            <a class="set_btn" id="member_schedule_btn">관리사 일정보기</a>
                        </div>
                    </div>
                    <div class="layer_list_box">
                        <table class="layer_list_hd_tbl width_max">
                            <thead>
                                <tr>
                                    <th>파견</th>
                                    <th>직원명</th>
                                    <th>팀</th>
                                    <th>연락처</th>
                                    <th>생년월일</th>
                                    <th>행정구역</th>
                                    <th>특이사항</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="layer_list_tbl width_max">
                            <tbody id="work_member_list"></tbody>
                        </table>
                    </div>
                </div>
                <div class="work_link_box">
                    <div class="work_link_top">
                        <div>
                            <a class="set_btn" id="extend_period_btn">기간연장</a>
                        </div>
                        <div>
                            <a class="set_btn" id="change_member_btn">관리사 교체</a>
                        </div>
                    </div>
                    <div class="layer_list_box">
                        <table class="layer_list_hd_tbl width_max">
                            <thead>
                                <tr>
                                    <th>근태적용</th>
                                    <th>요일</th>
                                    <th>주말/공휴일</th>
                                    <th>파견일</th>
                                    <th>도우미</th>
                                    <th>파견인원</th>
                                    <th>바우처</th>
                                    <th>유료</th>
                                    <th>근무시간</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="layer_list_tbl width_max">
                            <tbody id="work_selected_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="work"></div>

<script>
    let write_ajax;
    let list_ajax;

    $(function(){
        $('#sch_service_cate, #sch_str_receipt_date, #sch_end_receipt_date, #sch_status').change(function(){
            list_act();
        });

        $('#sch_cl_name, #sch_cl_hp').on('input', function(){
            list_act();
        });

        $(document).on('click', '.sort_btn', function(){
            if($(this).hasClass('sort_asc') == true) {
                $(this).addClass('sort_desc').removeClass('sort_asc');
                $(this).attr('orderby', 'desc');
                list_act();
                return false;
            }

            if($(this).hasClass('sort_desc') == true) {
                $(this).removeClass('sort_desc');
                $(this).attr('orderby', '');
                list_act();
                return false;
            }

            if(hasAllClasses($(this), ['sort_asc', 'sort_desc']) == false) {
                $(this).addClass('sort_asc');
                $(this).attr('orderby', 'asc');
                list_act();
                return false;
            }
        });

        // 고객 리스트 클릭시
        $(document).on('click', '#work_list tr', function(){
            $('#work_list tr').removeClass('list_selected');
            $(this).addClass('list_selected');
            list_member_act();
            list_work_selected_act();
        });

        $(document).on('click', '#work_member_list tr', function(){
            $('#work_member_list tr').removeClass('list_selected');
            $(this).addClass('list_selected');
        });

        $(document).on('click', '#work_selected_list tr', function(){
            $('#work_selected_list tr').removeClass('list_selected');
            $(this).addClass('list_selected');
        });

        <?php if($write_permit === true) { ?>
        // 관리사 일정보기 버튼 클릭시
        $(document).on('click', '#member_schedule_btn', function(){
            let mb_id = $('#work_member_list > .list_selected').attr('mb_id');
            if(typeof mb_id == 'undefined') mb_id = '';

            let client_idx = $('#work_list > .list_selected').attr('client_idx');
            if(typeof client_idx == 'undefined') client_idx = '';

            if(mb_id == '' || client_idx == '') {
                alert('고객 및 직원을 선택해주세요');
                return false;
            }

            $('#layer_popup').empty();

            $("#layer_popup").load(g5_bbs_url + "/work_member_schedule.php?mb_id=" + mb_id + "&client_idx=" + client_idx);

            // Layer Popup 보이기
            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        // 일정추가 버튼 클릭시
        $(document).on('click', '#add_work_btn', function(){
            if (typeof write_ajax !== 'undefined') {
                write_ajax.abort(); // 비동기 실행취소
            }

            if($('#work_list tr.list_selected').length == 0) {
                alert('고객을 선택해주세요');
                return false;
            }

            if($('#work_member_list tr.list_selected').length == 0) {
                alert('관리사를 선택해주세요');
                return false;
            }

            let client_idx = $('#work_list tr.list_selected').attr('client_idx');
            let mb_id = $('#work_member_list tr.list_selected').attr('mb_id');

            write_ajax = $.ajax({
                url: g5_bbs_url + '/ajax.add_work_check.php',
                async: true,
                type: "POST",
                data: {'client_idx': client_idx, 'mb_id': mb_id},
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    if(response.code == '9999' && response.msg != '') {
                        alert(response.msg);
                    }

                    if(response.code == '0000') {
                        // Layer Popup : 일정추가
                        $("#layer_popup").load(g5_bbs_url + "/work_add.php?client_idx=" + client_idx + '&mb_id=' + mb_id);

                        // Layer Popup 보이기
                        $('#layer_popup').css('display', 'block');
                        $('#layer_popup_bg').css('display', 'block');
                    }
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        });

        // 기간연장 버튼 클릭시
        $(document).on('click', '#extend_period_btn', function(){
            if(confirm('기간을 연장하시겠습니까?')) {
                return false;
            }
        });

        // 관리사 교체 버튼 클릭시
        $(document).on('click', '#change_member_btn', function(){
            let idx = $('#work_selected_list > .list_selected').attr('idx');
            let work_idx = $('#work_selected_list > .list_selected').attr('work_idx');
            let selected_date = $('#work_selected_list > .list_selected').attr('selected_date');

            $('#layer_popup').addClass('selected_member_change');
            $('#layer_popup').empty();

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');

            $("#layer_popup").load(g5_bbs_url + "/work_selected_member_change.php?idx=" + idx + "&work_idx=" + work_idx + "&selected_date=" + selected_date);
        });

        // 파견관리사 선택(변경) 버튼 클릭시
        $(document).on('click', '#work_member_change_btn', function(){
            let client_idx = $('#client_idx').val();
            let client_service = $('#client_service').val();
            let mb_id = $('#mb_id').val();
            let now_year = $('#now_year').val();
            let now_month = $('#now_month').val();

            $('#layer_popup').empty();

            $("#layer_popup").load(g5_bbs_url + "/work_member_change.php?client_idx=" + client_idx + '&client_service=' + client_service + '&mb_id=' + mb_id + '&now_year=' + now_year + '&now_month=' + now_month);
        });
        <?php } ?>

        // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
        $(document).on('click', '#popup_close_btn', function(){
            // Layer Popup 초기화
            $('#layer_popup').removeClass('selected_member_change');
            $('#layer_popup').empty();

            // Layer Popup 숨기기
            $('#layer_popup').css('display', 'none');
            $('#layer_popup_bg').css('display', 'none');
        });

        // Layer Popup 닫기 버튼 클릭시 Layer Popup 일정추가 페이지로 이동
        $(document).on('click', '#popup_back_btn', function(){
            let client_idx = $('#client_idx').val();
            let mb_id = '';

            $('#layer_popup').removeClass('selected_member_change');
            $("#layer_popup").empty();

            $("#layer_popup").load(g5_bbs_url + "/work_add.php?client_idx=" + client_idx + '&mb_id=' + mb_id);
        });

        // 이전 년도(◀) , 다음 년도(▶) 클릭시
        $(document).on('click', '#prev_year_btn, #next_year_btn', function(){
            let year = $(this).attr('year');
            let month = $(this).attr('month');

            $('#now_year').val(year);
            $('#now_month').val(month);

            let work_calendar_tit = year + '.' + month;
            $('.work_calendar_tit').text(work_calendar_tit);

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

            let mode = '';
            if($('#mode').length > 0) {
                mode = $('#mode').val();
            }
            calendar_call(mode);
        });

        // 참석자 리스트 클릭(선택)시
        $(document).on('click', '#work_member_tbl > tbody > tr', function(){
            $('.member_select_check').prop('checked', false);
            if($(this).hasClass('member_select_list_selected') == true) {
                $(this).removeClass('member_select_list_selected');
                return false;
            }
            $(this).find('.member_select_check').prop('checked', true);
            $('#work_member_tbl > tbody > tr').removeClass('member_select_list_selected');
            $(this).addClass('member_select_list_selected');
        });

        // 참석자 리스트 체크박스 클릭(선택)시
        $(document).on('click', '.member_select_check', function(e){
            e.stopPropagation();
        });

        // 참석자 리스트 체크박스 체크상태 변경시
        $(document).on('change', '.member_select_check', function(e){
            $('.member_select_check').parents('tr').removeClass('member_select_list_selected');
            if($(this).is(':checked') == true) {
                $('.member_select_check').prop('checked', false);
                $(this).prop('checked', true);
                $(this).parents('tr').addClass('member_select_list_selected');
            }else{
                $('.member_select_check').prop('checked', false);
            }
        });

        // 관리사 교체 리스트 클릭(선택)시
        $(document).on('click', '.selected_member_change_tbl > tbody > tr', function(){
            //$('.change_check').prop('checked', false);
            if($(this).hasClass('member_select_list_selected') == true) {
                $(this).removeClass('member_select_list_selected');
                $(this).find('.change_check').prop('checked', false);
            }else{
                $(this).find('.change_check').prop('checked', true);
                $(this).addClass('member_select_list_selected');
            }
        });

        // 관리사 교체 리스트 체크박스 클릭(선택)시
        $(document).on('click', '.change_check', function(e){
            e.stopPropagation();
        });

        // 관리사 교체 리스트 체크박스 체크상태 변경시
        $(document).on('change', '.change_check', function(e){
            //$('.change_check').parents('tr').removeClass('member_select_list_selected');
            if($(this).is(':checked') == true) {
                //$('.change_check').prop('checked', false);
                $(this).prop('checked', true);
                $(this).parents('tr').addClass('member_select_list_selected');
            }else{
                $(this).prop('checked', false);
                $(this).parents('tr').removeClass('member_select_list_selected');
            }
        });

        $(document).on('change', '#change_check_all', function(e){
            e.stopPropagation();

            if($(this).is(':checked') == true) {
                $('.change_check').prop('checked', true);
                $('.selected_member_change_tbl > tbody > tr').addClass('member_select_list_selected');
            }else{
                $('.change_check').prop('checked', false);
                $('.selected_member_change_tbl > tbody > tr').removeClass('member_select_list_selected');
            }
        });

        // 파견관리사 선택 저장하기 버튼 클릭시
        $(document).on('click', '#change_submit_btn', function(){
            if (typeof write_ajax !== 'undefined') {
                write_ajax.abort(); // 비동기 실행취소
            }

            if($('.member_select_check').is(':checked') == false) {
                alert('파견관리사를 선택해주세요');
                return false;
            }

            let client_idx = $('#client_idx').val();

            let writeForm = document.getElementById("fregisterform");
            let formData = new FormData(writeForm);

            write_ajax = $.ajax({
                url: g5_bbs_url + '/work_member_change_update.php',
                async: true,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    if(response.msg != '') {
                        alert(response.msg);
                    }

                    let mb_id = '';
                    if(response.mb_id != '') mb_id = response.mb_id;

                    $('#layer_popup').empty();

                    $("#layer_popup").load(g5_bbs_url + "/work_add.php?client_idx=" + client_idx + '&mb_id=' + mb_id);
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        });

        $(document).on('click', '.selected_delete_btn', function(){
            let selected_date = $(this).attr('selected_date');
            if(confirm('선택을 취소하시겠습니까?')) {
                if($('.date_selected[this_date=' + selected_date + ']').length > 0) {
                    $('.date_selected[this_date=' + selected_date + ']').removeClass('date_selected');
                }
                $(this).parents('li').remove();
                tot_price();
            }
            return false;
        });

        $(document).on('click', '.calendar_btn', function(){
            let client_idx = $('#client_idx').val();
            let this_date = $(this).attr('this_date');
            let client_service = $('#client_service').val();
            let weeknum = $(this).attr('weeknum');
            let spe_period = parseInt($('#spe_period').val() || 0);
            let spe_period_hour = parseInt($('#spe_period_hour').val() || 0);
            let datas = '';

            if($(this).hasClass('last_date') == true) {
                alert('지난날은 선택이 불가능합니다.');
                return false;
            }

            if($(this).hasClass('date_selected') == false && spe_period <= $('#date_selected_box .date_selected').length && spe_period_hour == 0) {
                alert('선택 가능한 날짜를 초과하였습니다.');
                return false;
            }

            if($(this).hasClass('date_selected') == true) {
                if(confirm('선택을 취소하시겠습니까?')) {
                    $(this).removeClass('date_selected');
                    $("#date_selected_box .date_selected[selected_date='" + this_date + "']").remove().promise().done(function(){
                        tot_price();
                    });
                    return false;
                }
                return false;
            }

            // 아가마지
            if(client_service == '아가마지') {
                if(weeknum == 0 || weeknum == 6 || $(this).hasClass('holiday') == true) {
                    alert('주말 및 공휴일은 선택이 불가능합니다.');
                    return false;
                }

                if($('#date_selected_box .date_selected').length == 0) {
                    if(spe_period <= 0) {
                        return false;
                    }

                    $(this).addClass('date_selected');
                    datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                    datas += '<input type="hidden" name="date_selected[]" value="' + this_date + '">';
                    datas += '<a>' + this_date + '</a>';
                    datas += '<button type="button" class="selected_delete_btn" selected_date="' + this_date + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                    datas += '</li>';

                    $.ajax({
                        url: g5_bbs_url + '/ajax.selected_date.php',
                        type: "POST",
                        data: {'this_date': this_date, 'spe_period': spe_period},
                        dataType: "json",
                        success: function(response) {
                            // 전송이 성공한 경우 받는 응답 처리
                            if(response.next_date.length > 0) {
                                for(let i=0; i<response.next_date.length; i++) {
                                    $(".calendar_btn[this_date='" + response.next_date[i] + "']").addClass('date_selected');
                                    datas += '<li class="date_selected" selected_date="' + response.next_date[i] + '" style="order:' + response.next_date[i].replaceAll('-', '') + ';">';
                                    datas += '<a>' + response.next_date[i] + '</a>';
                                    datas += '<button type="button" class="selected_delete_btn" selected_date="' + response.next_date[i] + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                                    datas += '</li>';
                                }
                            }
                            $('#date_selected_box').append(datas).promise().done(function(){
                                tot_price();
                            });
                        },
                        error: function(error) {
                            // 전송이 실패한 경우 받는 응답 처리
                        }
                    });
                }else{
                    $(this).addClass('date_selected');
                    datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                    datas += '<a>' + this_date + '</a>';
                    datas += '<button type="button" class="selected_delete_btn" selected_date="' + this_date + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                    datas += '</li>';

                    $('#date_selected_box').append(datas).promise().done(function(){
                        tot_price();
                    });
                }
            }

            // 베이비시터
            if(client_service == '베이비시터') {
                $(this).addClass('date_selected');

                let selected = '';
                let end_hour = 9 + parseInt(spe_period_hour || 0);

                datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                datas += '<input type="hidden" name="date_selected[]" value="' + this_date + '">';
                datas += '<a>' + this_date + '</a>';
                datas += '<select name="str_hour[]" class="str_hour">';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == 9) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '&nbsp;~&nbsp;';
                datas += '<select name="end_hour[]" class="end_hour">';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == end_hour) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '<button type="button" class="selected_delete_btn" selected_date="' + this_date + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                datas += '</li>';

                $('#date_selected_box').append(datas).promise().done(function(){
                    tot_price();
                });
            }

            // 청소
            if(client_service == '청소') {
                $(this).addClass('date_selected');

                let selected = '';
                let end_hour = 9 + parseInt(spe_period_hour || 0);

                datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                datas += '<input type="hidden" name="date_selected[]" value="' + this_date + '">';
                datas += '<a>' + this_date + '</a>';
                datas += '<select name="str_hour[]" class="str_hour">';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == 9) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '&nbsp;~&nbsp;';
                datas += '<select name="end_hour[]" class="end_hour">';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == end_hour) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '<button type="button" class="selected_delete_btn" selected_date="' + this_date + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                datas += '</li>';

                $('#date_selected_box').append(datas).promise().done(function(){
                    tot_price();
                });
            }

            // 반찬
            if(client_service == '반찬') {
                if(weeknum == 0 || weeknum == 6 || $(this).hasClass('holiday') == true) {
                    alert('주말 및 공휴일은 선택이 불가능합니다.');
                    return false;
                }

                $(this).addClass('date_selected');

                let selected = '';
                let end_hour = 9 + parseInt(spe_period_hour || 0);

                datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                datas += '<input type="hidden" name="date_selected[]" value="' + this_date + '">';
                datas += '<a>' + this_date + '</a>';
                datas += '<select name="str_hour[]" class="str_hour">';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == 9) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '&nbsp;~&nbsp;';
                datas += '<select name="end_hour[]" class="end_hour" disabled>';
                for(let h=8; h<=22; h++) {
                    let h_val = h;
                    if(h < 10) h_val = '0' + h_val;
                    selected = '';
                    if(h == end_hour) selected = 'selected';
                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                }
                datas += '</select>';
                datas += '<button type="button" class="selected_delete_btn" selected_date="' + this_date + '"><img src="<?php echo G5_IMG_URL ?>/selected_delete_btn.png"></button>';
                datas += '</li>';

                $('#date_selected_box').append(datas).promise().done(function(){
                    tot_price();
                });
            }
        });

        // Select Layer Popup 닫기 버튼 클릭시 Select Layer Popup 초기화 + 숨기기
        $(document).on('click', '#select_popup_close_btn', function(){
            // Select Layer Popup 초기화
            $('#select_layer_popup').empty();

            // Select Layer Popup 숨기기
            $('#select_layer_popup').css('display', 'none');
            $('#select_layer_popup_bg').css('display', 'none');
        });

        $(document).on('click', '#calendar_filter_btn', function(){
            let spe_period_hour = parseInt($('#spe_period_hour').val() || 0);

            let datas = '';

            let selected = '';
            let end_hour = 9 + parseInt(spe_period_hour || 0);

            if($('.week').is(':checked') == false) {
                alert('요일을 선택해주세요');
                return false;
            }

            if($('#week_count').val() != '') {
                let week_count = 0;
                let this_date = '';
                for(let i=0; i<parseInt($('#week_count').val()); i++) {
                    week_count = parseInt($('#week_count').val() || 0) - 1;
                    for(let j=0; j<$('.week:checked').length; j++) {
                        if($(".work_calendar_tbl > tbody > tr:eq('"+i+"') > td > .calendar_btn[weeknum='"+$('.week:checked').eq(j).val()+"']").hasClass('date_selected') == false) {
                            $(".work_calendar_tbl > tbody > tr:eq('"+i+"') > td > .calendar_btn[weeknum='"+$('.week:checked').eq(j).val()+"']").addClass('date_selected');
                            this_date = $(".work_calendar_tbl > tbody > tr:eq('"+i+"') > td > .calendar_btn[weeknum='"+$('.week:checked').eq(j).val()+"']").attr('this_date');

                            if(typeof this_date != 'undefined') {
                                datas += '<li class="date_selected" selected_date="' + this_date + '" style="order:' + this_date.replaceAll('-', '') + ';">';
                                datas += '<input type="hidden" name="date_selected[]" value="' + this_date + '">';
                                datas += '<a>' + this_date + '</a>';
                                datas += '<select name="str_hour[]" class="str_hour">';
                                for(let h=8; h<=22; h++) {
                                    let h_val = h;
                                    if(h < 10) h_val = '0' + h_val;
                                    selected = '';
                                    if(h == 9) selected = 'selected';
                                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                                }
                                datas += '</select>';
                                datas += '&nbsp;~&nbsp;';
                                datas += '<select name="end_hour[]" class="end_hour">';
                                for(let h=8; h<=22; h++) {
                                    let h_val = h;
                                    if(h < 10) h_val = '0' + h_val;
                                    selected = '';
                                    if(h == end_hour) selected = 'selected';
                                    datas += '<option value="' + h + '" ' + selected + '>' + h_val + '</option>';
                                }
                                datas += '</select>';
                                datas += '</li>';
                            }
                        }
                    }
                }

                $('#date_selected_box').append(datas).promise().done(function(){
                    tot_price();
                });
            }

            $('.week').prop('checked', false);
        });

        $(document).on('change', '#all_check_str', function(){
            let spe_period_hour = $('#spe_period_hour').val();
            let str_hour = $('#all_check_str').val();
            let end_hour = null;

            if(str_hour != '') {
                end_hour = parseInt(str_hour || 0) + parseInt(spe_period_hour || 0);
                if(end_hour > 22) end_hour = 22;

                $('#all_check_end').val(end_hour);
            }
        });

        $(document).on('click', '#all_check_btn', function(){
            let str_hour = $('#all_check_str').val();
            let end_hour = $('#all_check_end').val();

            if(str_hour == '') {
                alert('시간을 선택해주세요');
                return false;
            }

            $('.str_hour').val(str_hour);
            $('.end_hour').val(end_hour);

            tot_price();
        });

        $(document).on('change', '.str_hour, .end_hour', function(){
            let client_service = $('#client_service').val();
            let spe_period_hour = $('#spe_period_hour').val();
            if($(this).hasClass('str_hour') == true && client_service == '반찬') {
                let end_hour = parseInt($(this).val() || 0) + parseInt(spe_period_hour || 0);
                if(end_hour > 22) {
                    $(this).val('9');
                    end_hour = parseInt($(this).val() || 0) + parseInt(spe_period_hour || 0);
                    $(this).next('.end_hour').val(end_hour);
                    alert('종료시간이 초과되었습니다.\n시간을 다시 설정해주세요');
                    return false;
                }
                $(this).next('.end_hour').val(end_hour);
            }

            tot_price();
        });

        $(document).on('click', '#submit_btn', function(){
            if (typeof write_ajax !== 'undefined') {
                write_ajax.abort(); // 비동기 실행취소
            }

            let client_idx = $('#client_idx').val();
            let mb_id = $('#mb_id').val();
            let now_year = $('#now_year').val();
            let now_month = $('#now_month').val();
            let client_service = $('#client_service').val();
            let spe_period = $('#spe_period').val();
            let spe_period_hour = $('#spe_period_hour').val();
            let li_date_selected = document.querySelectorAll('li.date_selected');
            let date_selected = new Array();
            for(let i=0; i<li_date_selected.length; i++) {
                date_selected[i] = li_date_selected[i].getAttribute('selected_date');
            }
            let str_hour_class = document.querySelectorAll('.str_hour');
            let str_hour = new Array();
            for(let i=0; i<str_hour_class.length; i++) {
                str_hour[i] = str_hour_class[i].value;
            }
            let end_hour_class = document.querySelectorAll('.end_hour');
            let end_hour = new Array();
            for(let i=0; i<end_hour_class.length; i++) {
                end_hour[i] = end_hour_class[i].value;
            }

            if(client_idx == '') {
                alert('Error!');
                return false;
            }

            if(mb_id == '') {
                alert('Error!');
                return false;
            }

            if(now_year == '') {
                alert('Error!');
                return false;
            }

            if(date_selected.length == 0) {
                alert('파견 일자를 선택/등록 해주세요');
                return false;
            }

            let filter_msg = $('.work_add_form .filter_box > label').text();

            if(confirm(filter_msg + "\n정말 파견하시겠습니까?")) {

                write_ajax = $.ajax({
                    url: g5_bbs_url + '/work_add_update.php',
                    async: true,
                    type: "POST",
                    data: {'client_idx': client_idx, 'mb_id': mb_id, 'now_year': now_year, 'now_month': now_month, 'client_service': client_service, 'spe_period': spe_period, 'spe_period_hour': spe_period_hour, 'date_selected': date_selected, 'str_hour': str_hour, 'end_hour': end_hour},
                    dataType: "json",
                    success: function(rst) {
                        if(rst.msg != '') {
                            alert(rst.msg);
                        }

                        if(rst.code == '9999') {
                            location.reload();
                            return false;
                        }

                        if(rst.code == '0000') {
                            // Layer Popup 초기화
                            $('#layer_popup').empty();

                            // Layer Popup 숨기기
                            $('#layer_popup').css('display', 'none');
                            $('#layer_popup_bg').css('display', 'none');

                            list_act();
                            holiday_update();
                        }
                    },
                    error: function(error) {
                        // 전송이 실패한 경우 받는 응답 처리
                        location.reload();
                    }
                });

            }
        });

        $(document).on('click', '#selected_member_change_btn', function(){
            $('#member_change_list_wrap').css('display', 'block');
        });

        $(document).on('click', '#member_change_close_btn', function(){
            $('#member_change_list_wrap').css('display', 'none');
        });

        $(document).on('click', '#member_change_submit_btn', function(){
            if($('.member_select_check').is(':checked') == false) {
                alert('변경할 파견관리사를 선택해주세요');
                return false;
            }

            let mb_id = $('.member_select_check:checked').val();
            let mb_name = $('.member_select_check:checked').attr('mb_name');

            $('#change_mb_id').val(mb_id);
            $('#change_mb_name_txt').css('display', 'block').text(mb_name);
            $('#selected_member_change_btn').css('display', 'none');
            $('#member_change_list_wrap').css('display', 'none');
        });

        $(document).on('click', '#selected_change_submit_btn', function(){
            if (typeof write_ajax !== 'undefined') {
                write_ajax.abort(); // 비동기 실행취소
            }

            if($('#change_mb_id').val() == '') {
                alert('변경할 파견사를 선택해주세요');
                return false;
            }

            if($('.change_check').is(':checked') == false) {
                alert('변경할 파견일을 선택해주세요');
                return false;
            }

            let writeForm = document.getElementById("selected_member_change_form");
            let formData = new FormData(writeForm);

            if(confirm('정말 관리사를 교체하시겠습니까?')) {
                write_ajax = $.ajax({
                    url: g5_bbs_url + '/work_selected_member_change_update.php',
                    async: true,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        // 전송이 성공한 경우 받는 응답 처리
                        if(response.msg != '') {
                            alert(response.msg);
                        }

                        $('#layer_popup').empty();

                        // Layer Popup 숨기기
                        $('#layer_popup').css('display', 'none');
                        $('#layer_popup_bg').css('display', 'none');

                        list_act();
                        holiday_update();
                    },
                    error: function(error) {
                        // 전송이 실패한 경우 받는 응답 처리
                        location.reload();
                    }
                });
            }
        });
    });

    // 고객 정보 불러오기
    function list_act() {
        if (typeof list_ajax !== 'undefined') {
            list_ajax.abort(); // 비동기 실행취소
        }
        
        // FIlter : 서비스분류
        let sch_service_cate = $('#sch_service_cate').val();
        // Filter : 접수기간(STR)
        let sch_str_receipt_date = $('#sch_str_receipt_date').val();
        // Filter : 접수기간(END)
        let sch_end_receipt_date = $('#sch_end_receipt_date').val();
        // Filter : 신청인(고객명)
        let sch_cl_name = $('#sch_cl_name').val();
        // Filter : 연락처(고객 연락처)
        let sch_cl_hp = $('#sch_cl_hp').val();
        // 접수상태
        let sch_status = $('#sch_status').val();

        let sort_btn = $('.sort_btn');
        let sort_orderby = '';
        $.each(sort_btn, function(index, className) {
            if($('.sort_btn').eq(index).attr('order_fd') != '' && $('.sort_btn').eq(index).attr('orderby') != '') {
                sort_orderby += ', ' + $('.sort_btn').eq(index).attr('order_fd') + ' ' + $('.sort_btn').eq(index).attr('orderby');
            }
        });

        list_ajax = $.ajax({
            url: g5_bbs_url + '/ajax.work_list.php',
            type: "POST",
            data: {'sch_service_cate': sch_service_cate, 'sch_str_receipt_date': sch_str_receipt_date, 'sch_end_receipt_date': sch_end_receipt_date, 'sch_cl_name': sch_cl_name, 'sch_cl_hp': sch_cl_hp, 'sch_status': sch_status, 'sort_orderby': sort_orderby},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#work_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(i == 0) {
                            list_selected = 'list_selected';
                        }

                        datas += '<tr class="' + response[i].bg_color + ' ' + list_selected + '" client_idx="' + response[i].client_idx + '" area_x="' + response[i].area_x + '" area_y="' + response[i].area_y + '" client_service="' + response[i].client_service_data + '">';
                        datas += '<td>' + response[i].use_status + '</td>';
                        datas += '<td>' + response[i].receipt_date + '</td>';
                        datas += '<td>' + response[i].client_service + '</td>';
                        datas += '<td>' + response[i].cl_service_cate2 + '</td>';
                        datas += '<td>' + response[i].cl_name + '</td>';
                        datas += '<td>' + response[i].cl_hp + '</td>';
                        datas += '<td>' + response[i].cl_security_number + '</td>';
                        datas += '<td>' + response[i].cl_service_period + '</td>';
                        datas += '<td>' + response[i].str_date + '</td>';
                        datas += '<td>' + response[i].end_date + '</td>';
                        datas += '<td>' + response[i].cancel_date + '</td>';
                        datas += '<td>' + response[i].cctv.toUpperCase() + '</td>';
                        datas += '<td>' + response[i].pet + '</td>';
                        datas += '<td>' + response[i].prior_interview + '</td>';
                        datas += '</tr>';
                    }

                    $('#work_list').append(datas);

                    list_member_act();
                    list_work_selected_act();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    // 파견 제공인력 리스트 추출
    function list_member_act() {
        let area_x = $('.layer_list_wrap .list_selected').attr('area_x');
        let area_y = $('.layer_list_wrap .list_selected').attr('area_y');
        let client_idx = $('#work_list > .list_selected').attr('client_idx');
        let client_service = $('#work_list > .list_selected').attr('client_service');

        $.ajax({
            url: g5_bbs_url + '/ajax.work_member_list.php',
            type: "POST",
            data: {'area_x': area_x, 'area_y': area_y, 'client_idx': client_idx, 'client_service': client_service},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#work_member_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(i == 0) {
                            list_selected = 'list_selected';
                        }

                        datas += '<tr class="' + list_selected + '" mb_id="' + response[i].mb_id + '">';
                        datas += '<td>' + response[i].work_stat + '</td>';
                        datas += '<td>' + response[i].mb_name + '</td>';
                        datas += '<td>' + response[i].team_category + '</td>';
                        datas += '<td>' + response[i].mb_hp + '</td>';
                        datas += '<td>' + response[i].birthday + '</td>';
                        datas += '<td class="talign_l">';
                        if(area_x != '' && area_y != '') {
                            datas += '[' + response[i].area + 'km] ';
                        }
                        datas += response[i].mb_addr + '</td>';
                        datas += '<td class="talign_l">' + response[i].mb_memo2 + '</td>';
                        datas += '</tr>';
                    }

                    $('#work_member_list').append(datas);
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function list_work_selected_act() {
        let client_idx = $('.list_selected').attr('client_idx');
        let client_service = $('.list_selected').attr('client_service');

        $.ajax({
            url: g5_bbs_url + '/ajax.work_selected_list.php',
            type: "POST",
            data: {'client_idx': client_idx, 'client_service': client_service},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#work_selected_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(i == 0) {
                            list_selected = 'list_selected';
                        }

                        datas += '<tr class="' + list_selected + '" idx="' + response[i].idx + '" work_idx="' + response[i].work_idx + '" selected_date="' + response[i].selected_date + '" selected_date_mk="' + response[i].selected_date_mk + '" str_hour="' + response[i].str_hour + '" end_hour="' + response[i].end_hour + '">';
                        datas += '<td></td>';
                        datas += '<td>' + response[i].yoil + '요일</td>';
                        datas += '<td>' + response[i].weekend + '</td>';
                        datas += '<td>' + response[i].selected_date + '</td>';
                        datas += '<td>' + response[i].mb_name + '</td>';
                        datas += '<td>' + '1명' + '</td>';
                        datas += '<td></td>';
                        datas += '<td></td>';
                        datas += '<td></td>';
                        // datas += '<td class="talign_l">' + response[i].mb_memo2 + '</td>';
                        datas += '</tr>';
                    }

                    $('#work_selected_list').append(datas);
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function calendar_call(mode = '') {
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        let year = $('#now_year').val();
        let month = $('#now_month').val();
        let mb_id = '';
        if(mode == 'schedule') {
            mb_id = $('#mb_id').val();
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

                let n = 1;
                for(let i=0; i<rst.tweek; i++) {
                    datas += '<tr>';

                    for(let k=0; k<7; k++) {
                        datas += '<td class="calendar_td">';
                        if((i == 0 && k < rst.sweek) || (i == rst.tweek-1 && k > rst.lweek)) {
                            datas += '</td>';
                            continue;
                        }

                        let nn = n;
                        if(nn < 10) nn = '0' + nn;

                        let this_date = year + '-' + month + '-' + nn;

                        weekend = '';
                        if(k == 0) weekend = 'sunday';
                        if(k == 6) weekend = 'saturday';
                        if(typeof rst[this_date] != 'undefined') weekend = 'holiday';

                        if(mode == '') {
                            if(this_date < '<?php echo date('Y-m-d') ?>') {
                                // datas += '<a class="calendar_btn last_date ' + weekend + '" this_date="' + this_date + '">';
                                datas += '<a class="calendar_btn ' + weekend + '" this_date="' + this_date + '" weeknum="' + k + '">';
                            }else{
                                datas += '<a class="calendar_btn ' + weekend + '" this_date="' + this_date + '" weeknum="' + k + '">';
                            }
                            datas +=  '<p>'+ nn + '</p>';
                            datas += '</a>';
                        }else if(mode == 'schedule') {
                            if(this_date < '<?php echo date('Y-m-d') ?>') {
                                datas += '<a class="calendar_schedule_btn last_date ' + weekend + '" this_date="' + this_date + '" weeknum="' + k + '">';
                            }else{
                                datas += '<a class="calendar_schedule_btn ' + weekend + '" this_date="' + this_date + '" weeknum="' + k + '">';
                            }
                            datas += '<p>' + nn + '</p>';
                            if(rst['selected-' + this_date] == 'selected') {
                                datas += '<div><span class="schedule_selected">파견</span></div>';
                            }
                            datas += '</a>';
                        }

                        n++;
                        datas += '</td>';
                    }

                    datas += '</tr>';
                }

                $('.work_calendar_tbl > tbody').empty();
                $('.work_calendar_tbl > tbody').append(datas);

                $('.calendar_btn').removeClass('date_selected');

                for(let i=0; i<$('#date_selected_box > .date_selected').length; i++) {
                    let selected_date = $('#date_selected_box > .date_selected').eq(i).attr('selected_date');
                    $(".calendar_btn[this_date='" + selected_date + "']").addClass('date_selected');
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    }

    // 공휴일 자동 업데이트
    function holiday_update() {
        $.ajax({
            url: g5_bbs_url + '/holiday_update.php',
            type: "POST",
            data: {},
            dataType: "json",
            success: function(rst) {
            },
            error: function(error) {
            }
        });
    }

    // 합계금액
    function tot_price() {
        let client_idx = $('#client_idx').val();
        let client_service = $('#client_service').val();
        let li_date_selected = document.querySelectorAll('li.date_selected');
        if(li_date_selected.length == 0) {
            return false;
        }
        let date_selected = new Array();
        for(let i=0; i<li_date_selected.length; i++) {
            date_selected[i] = li_date_selected[i].getAttribute('selected_date');
        }
        let str_hour_class = document.querySelectorAll('.str_hour');
        let str_hour = new Array();
        for(let i=0; i<str_hour_class.length; i++) {
            str_hour[i] = str_hour_class[i].value;
        }
        let end_hour_class = document.querySelectorAll('.end_hour');
        let end_hour = new Array();
        for(let i=0; i<end_hour_class.length; i++) {
            end_hour[i] = end_hour_class[i].value;
        }

        $.ajax({
            url: g5_bbs_url + '/ajax.work_tot_price.php',
            type: "POST",
            data: {'client_idx': client_idx, 'client_service': client_service, 'date_selected': date_selected, 'str_hour': str_hour, 'end_hour': end_hour},
            dataType: "json",
            success: function(response) {
                if(typeof response.tot_price != 'undefined') {
                    if(response.tot_price == false) {
                        alert('고객 서비스 금액 관리에서 금액 설정이 필요합니다!');
                        $('.tot_price_box > span').text('');
                        return false;
                    }

                    if(response.tot_price == null) response.tot_price = 0;
                    $('.tot_price_box > span').text(response.tot_price);
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    $(document).ready(function(){
        list_act();
        holiday_update();
    });
</script>
