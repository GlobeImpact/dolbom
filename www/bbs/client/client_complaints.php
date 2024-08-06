<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_complaints.css?ver=2">', 0);

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

$now_year = date('Y');
?>

<input type="hidden" id="now_year" value="<?php echo $now_year ?>">

<div id="layer_wrap">
    <div id="layer_box">

        <!-- Year Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="year_box">
                <a class="filter_year_btn" id="prev_year_btn" year="<?php echo (int) $now_year - 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_prev.png">
                </a>
                <span class="filter_year_tit"><?php echo $now_year ?>년</span>
                <a class="filter_year_btn" id="next_year_btn" year="<?php echo (int) $now_year + 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_next.png">
                </a>
            </div>
            <div class="filter_box">
                <input type="text" class="filter_input_date date_api" id="sch_date" value="" placeholder="접수일자" maxlength="10" oninput="autoHyphen3(this)">
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="신청자명 입력">
                <a class="filter_submit" id="filter_submit">검색</a>
            </div>
        </div>
        <!-- Year Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap">
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl">
                    <thead>
                        <tr>
                            <th class="layer_list_numb">번호</th>
                            <th class="layer_list_date">접수일자</th>
                            <th class="layer_list_comp_category">상담구분</th>
                            <th class="layer_list_name">신청인</th>
                            <th class="layer_list_service_category">서비스</th>
                            <th class="layer_list_tel">신청인 연락처</th>
                            <th class="layer_list_status">상태</th>
                            <th class="layer_list_date">조치일자</th>
                            <th class="layer_list_name">관리사</th>
                            <th>설정</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl">
                    <tbody id="client_complaints_list"></tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->

        <div class="bottom_wrap">
            <?php if($write_permit === true) { ?><a class="write_btn" id="write_btn">민원등록</a><?php } ?>
        </div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
let write_ajax;
let client_select_form_timer;
let member_select_form_timer;

$(function(){
    // 이전 년도(◀) , 다음 년도(▶) 클릭시
    $('#prev_year_btn, #next_year_btn').click(function(){
        // 현재 년도 Data 불러오기
        let year = $(this).attr('year');
        // 이전 년도
        let prev_year = parseInt(year || 0) - 1;
        // 다음 년도
        let next_year = parseInt(year || 0) + 1;
        
        // 현재 년도 텍스트 출력
        $('.filter_year_tit').text(year + '년');
        // 현재 년도 Data 적용
        $('#now_year').val(year);
        // 이전 년도 Data 적용
        $('#prev_year_btn').attr('year', prev_year);
        // 다음 년도 Data 적용
        $('#next_year_btn').attr('year', next_year);
        // 년도 Data 변경될 경우 검색 : 접수일자 초기화
        $('#sch_date').val('');

        // 리스트 불러오기
        list_act();
    });

    // 검색 : sch_value 엔터키 입력시 검색 버튼 클릭되도록 설정
    $('#sch_value').on("keyup",function(key){
        if(key.keyCode == 13){
            $('#filter_submit').click();
        }
    });

    // 검색 버튼 클릭시 리스트 불러오기
    $('#filter_submit').click(function(){
        list_act();
    });

    <?php if($write_permit === true) { ?>
    // 민원등록 버튼 클릭시 민원등록 팝업 띄우기
    $(document).on('click', '#write_btn', function(){
        // 현재 년도 Data 불러오기
        let now_year = $('#now_year').val();
        // Layer Popup : 민원등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/client_complaints_write.php?now_year=" + now_year);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>

    // 고객선택 버튼 클릭시 고객선택 Layer Popup 띄우기
    $(document).on('click', '#form_select_btn', function(){
        let idx = $('#idx').val();
        let tit = '고객';
        $("#select_layer_popup").load(g5_bbs_url + "/client_select_form.php?idx=" + idx + "&tit=" + tit);

        $('#select_layer_popup').css('display', 'block');
        $('#select_layer_popup_bg').css('display', 'block');

        client_select_form_timer = setInterval(function(){
            client_select_form();
        }, 600);
    });

    // 관리사선택 버튼 클릭시 관리사선택 Layer Popup 띄우기
    $(document).on('click', '#form_select_btn2', function(){
        let idx = $('#idx').val();
        let tit = '관리사';
        $("#select_layer_popup").load(g5_bbs_url + "/member_select_form.php?idx=" + idx + "&tit=" + tit);

        $('#select_layer_popup').css('display', 'block');
        $('#select_layer_popup_bg').css('display', 'block');

        member_select_form_timer = setInterval(function(){
            member_select_form();
        }, 600);
    });

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    // Client Select Layer Popup 닫기 버튼 클릭시 Client Select Layer Popup 초기화 + 숨기기
    $(document).on('click', '#select_popup_close_btn', function(){
        // Client Select Layer Popup 초기화
        $('#select_layer_popup').empty();

        // Client Select Layer Popup 숨기기
        $('#select_layer_popup').css('display', 'none');
        $('#select_layer_popup_bg').css('display', 'none');
    });

    // 고객 선택 리스트 검색 : sch_value2 엔터키 입력시 검색 버튼 클릭되도록 설정
    $(document).on('keyup', '#sch_value2', function(key){
        if(key.keyCode == 13){
            $('#filter_submit2').click();
        }
    });

    // 고객 선택 리스트 검색 버튼 클릭시 리스트 불러오기
    $(document).on('click', '#filter_submit2', function(){
        if($(this).hasClass('client_select_filter_submit') == true) {
            client_select_form();
        }else{
            member_select_form();
        }
    });

    <?php if($write_permit === true) { ?>
    // 민원등록/수정 저장하기 Submit
    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        // 상담구분 Required
        if($('#comp_category').val() == '') {
            alert('상담구분을 선택해주세요');
            $('#comp_category').focus();
            return false;
        }

        // 고객선택 Required
        if($('#comp_client_idx').val() == '') {
            alert('고객을 선택해주세요');
            $('#comp_client_name').focus();
            return false;
        }

        // 조치일자가 등록되어 있고 조치구분을 선택하지 않았을 경우 조치구분 Required
        if($('#take_date').val() != '' && $('#take_category').val() == '') {
            alert('조치구분을 선택해주세요');
            $('#take_category').focus();
            return false;
        }

        // FormData Set
        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        // Ajax Write Update
        write_ajax = $.ajax({
            url: g5_bbs_url + '/client_complaints_write_update.php',
            async: true,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // Ajax Result Message
                if(response.msg != '') {
                    alert(response.msg);
                }

                // code : 0000 성공 / code : 9999 실패
                if(response.code == '0000') {
                    // 리스트 불러오기
                    list_act();

                    // Layer Popup 초기화
                    $('#layer_popup').empty();

                    // Layer Popup : 민원수정 불러오기
                    $("#layer_popup").load(g5_bbs_url + "/client_complaints_write.php?w=u&idx=" + response.idx);
                }else{
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });

        return false;
    });
    <?php } ?>

    // 고객 리스트 클릭(선택)시
    $(document).on('click', '.client_select_list_tbl > tbody > tr', function(){
        // 고객 리스트 선택 활성화 초기화
        $('.client_select_check').prop('checked', false);
        $('.client_select_list_tbl > tbody > tr').removeClass('client_select_list_selected');

        // 클릭한 고객 리스트 선택 활성화
        $(this).find('.client_select_check').prop('checked', true);
        $(this).addClass('client_select_list_selected');
    });

    // 관리사 리스트 클릭(선택)시
    $(document).on('click', '.member_select_list_tbl > tbody > tr', function(){
        // 관리사 리스트 선택 활성화 초기화
        $('.member_select_check').prop('checked', false);
        $('.member_select_list_tbl > tbody > tr').removeClass('member_select_list_selected');

        // 클릭한 관리사 리스트 선택 활성화
        $(this).find('.member_select_check').prop('checked', true);
        $(this).addClass('member_select_list_selected');
    });

    // 고객&관리사 리스트 선택 선택완료 Submit
    $(document).on('click', '#select_submit_btn', function(){
        // 고객 Idx, 고객명 Data 불러오기
        let select_client_idx = $('.client_select_check:checked').val();
        let cl_name = $('.client_select_check:checked').attr('cl_name');

        // 관리사 mb_id, 관리사명 Data 불러오기
        let select_mb_id = $('.member_select_check:checked').val();
        let mb_name = $('.member_select_check:checked').attr('mb_name');

        // 고객 Idx, 고객명 Data 추가
        if(typeof select_client_idx != 'undefined') {
            $('#comp_client_idx').val(select_client_idx);
            $('#comp_client_name').val(cl_name);
        }

        // 관리사 mb_id, 관리사명 Data 추가
        if(typeof select_mb_id != 'undefined') {
            $('#take_mb_id').val(select_mb_id);
            $('#take_mb_name').val(mb_name);
        }

        $('#select_layer_popup').empty();

        $('#select_layer_popup').css('display', 'none');
        $('#select_layer_popup_bg').css('display', 'none');

        return false;
    });

    <?php if($write_permit === true) { ?>
    $(document).on('click', '.edit_btn', function(e){
        e.stopPropagation();

        let idx = $(this).attr('idx');
        
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup : 민원수정 불러오기
        $("#layer_popup").load(g5_bbs_url + "/client_complaints_write.php?w=u&idx=" + idx);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>

    $(document).on('click', '.view_btn', function(e){
        e.stopPropagation();

        let idx = $(this).attr('idx');
        
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup : 민원수정 불러오기
        $("#layer_popup").load(g5_bbs_url + "/client_complaints_view.php?idx=" + idx);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    <?php if($delete_permit === true) { ?>
    $(document).on('click', '.del_btn', function(e){
        e.stopPropagation();

        let idx = $(this).attr('idx');
        if(confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.client_complaints_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'idx': idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    // code : 0000 성공 / code : 9999 실패
                    if(response.code == '0000') {
                        // 리스트 불러오기
                        list_act();
                    }else{
                        // 전송이 실패한 경우 받는 응답 처리
                        location.reload();
                    }

                    return false;
                }
            });
        }
    });
    <?php } ?>
});

// 민원 리스트 불러오기
function list_act() {
    let now_year = $('#now_year').val();
    let sch_date = $('#sch_date').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        url: g5_bbs_url + "/ajax.client_complaints_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_date': sch_date, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            $('#client_complaints_list').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<tr class="view_btn" idx="' + response[i].idx + '">';
                    datas += '<td class="layer_list_numb">' + (i+1) + '</td>';
                    datas += '<td class="layer_list_date">' + response[i].comp_date + '</td>';
                    datas += '<td class="layer_list_comp_category">' + response[i].comp_category + '</td>';
                    datas += '<td class="layer_list_name">' + response[i].comp_client_name + '</td>';
                    datas += '<td class="layer_list_service_category">' + response[i].service_category + '</td>';
                    datas += '<td class="layer_list_tel">' + response[i].tel + '</td>';
                    datas += '<td class="layer_list_status">' + response[i].status + '</td>';
                    datas += '<td class="layer_list_date">' + response[i].take_date + '</td>';
                    datas += '<td class="layer_list_name">' + response[i].take_name + '</td>';
                    datas += '<td class=""><div class="btn_flex">';
                    <?php if($write_permit === true) { ?>
                    datas += '<a class="edit_btn" idx="' + response[i].idx + '">수정</a>';
                    <?php } ?>
                    <?php if($delete_permit === true) { ?>
                    datas += '<a class="del_btn" idx="' + response[i].idx + '">삭제</a>';
                    <?php } ?>
                    datas += '</div></td>';
                    datas += '</tr>';
                }
            }else{
                datas += '<tr><td class="not_list" colspan="9">접수된 민원이 없습니다.</td></tr>';
            }

            $('#client_complaints_list').append(datas);

            return false;
        }
    });
}

// 고객 선택 리스트 불러오기
function client_select_form() {
    // 선택된 고객 아이디 Data
    let idx = $('#comp_client_idx').val();
    // 검색 : sch_value2 Data
    let sch_value2 = $('#sch_value2').val();

    // 전체선택 해제
    $('.select_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.client_select_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'idx': idx, 'sch_value2': sch_value2},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            // 리스트 초기화
            $('#select_list').empty();

            let datas = '';
            let list_selected = '';
            let list_checked = '';
            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    list_selected = '';
                    list_checked = '';
                    if(response[i].list_selected == 'y') {
                        list_selected = 'client_select_list_selected';
                        list_checked = 'checked';
                    }

                    datas += '<tr class="' + list_selected + '">';
                    datas += '<td class="client_select_list_check">';
                    datas += '<input type="checkbox" class="client_select_check" name="select_client_idx" id="select_client_idx' + i + '" value="' + response[i].client_idx + '" cl_name="' + response[i].cl_name + '" ' + list_checked + '>';
                    datas += '</td>';
                    datas += '<td class="client_select_list_name">' + response[i].cl_name + '</td>';
                    datas += '<td class="client_select_list_service_category">' + response[i].client_service + '</td>';
                    datas += '<td class="client_select_list_hp">' + response[i].cl_hp + '</td>';
                    datas += '<td>' + response[i].use_status + '</td>';
                    datas += '</tr>';
                }
            }

            $('#select_list').append(datas);
            $('#select_tot').text(response.length);

            clearInterval(client_select_form_timer);

            return false;
        }
    });
}

// 관리사 선택 리스트 불러오기
function member_select_form() {
    // 선택된 관리사 아이디 Data
    let idx = $('#take_mb_id').val();
    // 검색 : sch_value2 Data
    let sch_value2 = $('#sch_value2').val();

    // 전체선택 해제
    $('.select_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.member_select_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'idx': idx, 'sch_value2': sch_value2},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            // 리스트 초기화
            $('#select_list').empty();

            let datas = '';
            let list_selected = '';
            let list_checked = '';
            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    list_selected = '';
                    list_checked = '';
                    if(response[i].list_selected == 'y') {
                        list_selected = 'client_select_list_selected';
                        list_checked = 'checked';
                    }

                    datas += '<tr class="' + list_selected + '">';
                    datas += '<td class="member_select_list_check">';
                    datas += '<input type="checkbox" class="member_select_check" name="select_mb_id[]" id="select_mb_id' + i + '" value="' + response[i].mb_id + '" service_category="' + response[i].service_category + '" mb_name="' + response[i].mb_name + '" ' + list_checked + '>';
                    datas += '</td>';
                    datas += '<td class="member_select_list_gender">' + response[i].activity_status + '</td>';
                    datas += '<td class="member_select_list_name">' + response[i].mb_name + '</td>';
                    datas += '<td class="member_select_list_gender">' + response[i].gender + '</td>';
                    datas += '<td class="member_select_list_birthday">' + response[i].birthday + '</td>';
                    datas += '<td>' + response[i].enter_date + '</td>';
                    datas += '</tr>';
                }
            }

            $('#select_list').append(datas);
            $('#select_tot').text(response.length);

            clearInterval(member_select_form_timer);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act('');
});
</script>
