<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member_education.css?ver=2">', 0);

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
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="교육제목 입력">
                <a class="filter_submit" id="filter_submit">검색</a>
            </div>
        </div>
        <!-- Year Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap">
            <div class="member_education_list_box"></div>
        </div>
        <!-- Layer List Wrap END -->

        <div class="bottom_wrap"></div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
let write_ajax;

let member_select_form_timer = '';

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

        // 하단 등록 버튼 불러오기
        button_act();
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
        button_act();
        list_act();
    });

    <?php if($write_permit === true) { ?>
    // 교육 작성 버튼 클릭시
    $(document).on('click', '.education_write_btn', function(){
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/member_education_write.php?set_idx=" + set_idx + '&now_year=' + now_year);

        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x1050');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // 교육 리스트 추가 버튼 클릭시
    $(document).on('click', '#write_set_btn', function(){
        // Layer Popup : 교육 리스트 추가 불러오기
        $("#layer_popup").load(g5_bbs_url + "/member_education_set_write.php");

        // Layer Popup 보이기
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('set_form');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.list_set_btn', function(){
        let set_idx = $(this).attr('set_idx');

        window.location.href = g5_bbs_url + '/member_education_list.php?set_idx=' + set_idx;
    });

    $(document).on('click', '.edit_set_btn', function(){
        let set_idx = $(this).attr('set_idx');
        // Layer Popup : 교육 리스트 추가 불러오기
        $("#layer_popup").load(g5_bbs_url + "/member_education_set_write.php?w=u&set_idx=" + set_idx);

        // Layer Popup 보이기
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('set_form');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '#edit_btn', function(){
        let idx = $(this).attr('idx');
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/member_education_write.php?w=u&set_idx=" + set_idx + '&now_year=' + now_year + '&idx=' + idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>

    <?php if($delete_permit === true) { ?>
    // 교육 리스트 삭제
    $(document).on('click', '.del_set_btn', function(){
        let set_idx = $(this).attr('set_idx');

        if(confirm('삭제하시면 등록된 해당 교육일정이 모두 삭제됩니다.\n정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.member_education_set_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'set_idx': set_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    if(response.code == '0000') {
                        button_act();
                        list_act();
                    }else{
                        location.reload();
                    }
                }
            });            
        }

        return false;
    });

    $(document).on('click', '#del_btn', function(){
        let idx = $(this).attr('idx');

        if(confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.member_education_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'idx': idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    if(response.code == '0000') {
                        $('#layer_popup').empty();

                        $('#layer_popup').css('display', 'none');
                        $('#layer_popup_bg').css('display', 'none');

                        button_act();
                        list_act();
                    }else{
                        location.reload();
                    }
                }
            });            
        }

        return false;
    });
    <?php } ?>

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x1050');
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('keyup', '#set_tit', function(key){
        if(key.keyCode == 13){
            $('#set_submit_btn').click();
        }
    });

    // 교육 리스트저장버튼 클릭시
    $(document).on('click', '#set_submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#set_tit').val() == '') {
            alert('교육명을 입력해주세요');
            $('#set_tit').focus();
            return false;
        }

        let writeForm = document.getElementById("set_fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/member_education_set_write_update.php',
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
                if(response.code == '0000') {
                    button_act();
                    list_act();

                    $('#layer_popup').empty();
                    $('#layer_popup').css('display', 'none');
                    $('#layer_popup_bg').css('display', 'none');
                }else{
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });

    // 참석자선택 버튼 클릭시 참석자선택 Layer Popup 띄우기
    $(document).on('click', '#form_select_btn', function(){
        let idx = $('#idx').val();
        let tit = '참석자';
        $("#select_layer_popup").load(g5_bbs_url + "/member_select_form.php?idx=" + idx + "&tit=" + tit);

        $('#select_layer_popup').css('display', 'block');
        $('#select_layer_popup_bg').css('display', 'block');

        member_select_form_timer = setInterval(function(){
            member_select_form();
        }, 600);
    });

    // Member Select Layer Popup 닫기 버튼 클릭시 Member Select Layer Popup 초기화 + 숨기기
    $(document).on('click', '#select_popup_close_btn', function(){
        // Member Select Layer Popup 초기화
        $('#select_layer_popup').empty();

        // Member Select Layer Popup 숨기기
        $('#select_layer_popup').css('display', 'none');
        $('#select_layer_popup_bg').css('display', 'none');
    });

    // 참석자 선택 리스트 검색 : sch_value2 엔터키 입력시 검색 버튼 클릭되도록 설정
    $(document).on('keyup', '#sch_value2', function(key){
        if(key.keyCode == 13){
            $('#filter_submit2').click();
        }
    });

    // 고객 선택 리스트 검색 버튼 클릭시 리스트 불러오기
    $(document).on('click', '#filter_submit2', function(){
        member_select_form();
    });

    $(document).on('click', '#select_submit_btn', function(){
        let datas = '';

        if($('.member_select_check:checked').length > 0) {
            for(let i=0; i<$('.member_select_check:checked').length; i++) {
                if($("input[name='edul_mb_id[]'][value='"+$('.member_select_check:checked').eq(i).val()+"']").length == 0) {
                    datas += '<input type="hidden" name="edul_mb_id[]" value="' + $('.member_select_check:checked').eq(i).val() + '">';
                    datas += '<a class="mb_select_list"><span>' + $('.member_select_check:checked').eq(i).attr('mb_name') + '</span><span>(' + $('.member_select_check:checked').eq(i).attr('service_category') + ')</span></a>';
                }
            }
            $('.mb_select_list_box').append(datas);

            $('#select_layer_popup').empty();

            $('#select_layer_popup').css('display', 'none');
            $('#select_layer_popup_bg').css('display', 'none');
        }
    });

    $(document).on('click', '.mb_select_list', function(){
        if($(this).hasClass('not_delete') == true) {
            return false;
        }
        let mb_name = $(this).find('span').text();
        if(confirm('정말 ' + mb_name + ' 참석자를 삭제하시겠습니까?')) {
            $(this).prev().remove();
            $(this).remove();
        }

        return false;
    });

    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#edu_date').val() == '') {
            alert('교육날짜를 선택/입력해주세요');
            $('#edu_date').focus();
            return false;
        }

        if($('#edu_tit').val() == '') {
            alert('교육제목을 입력해주세요');
            $('#edu_tit').focus();
            return false;
        }

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/member_education_write_update.php',
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
                if(response.code == '0000') {
                    button_act();
                    list_act();

                    $('#layer_popup').empty();
                    $("#layer_popup").load(g5_bbs_url + "/member_education_view.php?idx=" + response.idx);
                }else{
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });

    // 참석자 리스트 전체 체크 클릭시
    $(document).on('change', '.select_all_check', function(){
        if($(this).is(':checked') == false) {
            $('.member_select_check').prop('checked', false);
            $('.member_select_list_tbl > tbody > tr').removeClass('member_select_list_selected');
        }else{
            $('.member_select_check').prop('checked', true);
            $('.member_select_list_tbl > tbody > tr').addClass('member_select_list_selected');
        }
    });

    // 참석자 리스트 클릭(선택)시
    $(document).on('click', '.member_select_list_tbl > tbody > tr', function(){
        if($(this).find('.member_select_check').is(':checked') == false) {
            $(this).find('.member_select_check').prop('checked', true);
            $(this).addClass('member_select_list_selected');
        }else{
            $(this).find('.member_select_check').prop('checked', false);
            $(this).removeClass('member_select_list_selected');
        }

        if($('.member_select_check:not(:checked)').length == 0) {
            $('.select_all_check').prop('checked', true);
        }else{
            $('.select_all_check').prop('checked', false);
        }
    });

    // 참석자 리스트 체크박스 클릭(선택)시
    $(document).on('click', '.member_select_check', function(e){
        e.stopPropagation();
    });

    // 참석자 리스트 체크박스 체크상태 변경시
    $(document).on('change', '.member_select_check', function(e){
        if($(this).is(':checked') == false) {
            $(this).parents('tr').removeClass('member_select_list_selected');
        }else{
            $(this).parents('tr').addClass('member_select_list_selected');
        }

        if($('.member_select_check:not(:checked)').length == 0) {
            $('.select_all_check').prop('checked', true);
        }else{
            $('.select_all_check').prop('checked', false);
        }
    });

    $(document).on('click', '.edu_view', function(){
        let idx = $(this).attr('idx');

        $("#layer_popup").load(g5_bbs_url + "/member_education_view.php?idx=" + idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
});

function button_act() {
    <?php if($write_permit === true) { ?>
    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_button.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(rst){
            $('.bottom_wrap').empty();

            let datas = '';

            if(rst.length > 0) {
                for(let i=0; i<rst.length; i++) {
                    datas += '<a class="write_btn education_write_btn" set_idx="' + rst[i].set_idx + '">' + rst[i].set_tit + ' 작성</a>';
                }
            }

            datas += '<a class="write_btn" id="write_set_btn">교육 리스트 추가</a>';

            $('.bottom_wrap').append(datas);

            return false;
        }
    });
    <?php } ?>
}

function list_act() {
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_list_all.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            $('.member_education_list_box').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<div class="member_education_list">';
                    datas += '<div>';
                    datas += '<p>' + response[i][0].set_tit + '</p>';
                    datas += '<div>';
                    datas += '<a class="list_btn list_set_btn" set_idx="' + response[i][0].set_idx + '">회원별보기</a>';
                    <?php if($write_permit === true) { ?>datas += '<a class="edit_btn edit_set_btn" set_idx="' + response[i][0].set_idx + '">수정</a>';<?php } ?>
                    <?php if($delete_permit === true) { ?>datas += '<a class="del_btn del_set_btn" set_idx="' + response[i][0].set_idx + '">삭제</a>';<?php } ?>
                    datas += '</div>';
                    datas += '</div>';
                    datas += '<ul>';
                    for(let j=0; j<response[i].length; j++) {
                        if(typeof response[i][j].numb == 'undefined') {
                            datas += '<li>';
                            datas += '<div class="member_education_list_data not_data">작성된 교육이 없습니다.</div>';
                            datas += '</li>';
                        }else{
                            datas += '<li class="edu_view" idx="' + response[i][j].idx + '">';
                            datas += '<label class="member_education_list_numb">' + response[i][j].numb + '</label>';
                            datas += '<div class="member_education_list_data">';
                            datas += '<p class="member_education_list_date">' + response[i][j].edu_date + '</p>';
                            datas += '<p class="member_education_list_tit">' + response[i][j].edu_tit + '</p>';
                            datas += '<div class="member_education_list_counting">';
                            datas += '<p><span>총원</span><span>' + response[i][j].max_list + '</span></p>';
                            datas += '<p><span>참여</span><span>' + response[i][j].edu_list + '</span></p>';
                            datas += '<p><span>미참여</span><span>' + response[i][j].not_list + '</span></p>';
                            datas += '</div>';
                            datas += '</div>';
                            datas += '</li>';
                        }
                    }
                    datas += '</ul>';
                    datas += '</div>';
                }
            }

            $('.member_education_list_box').append(datas);

            return false;
        }
    });
}

// 고객 선택 리스트 불러오기
function member_select_form() {
    // 선택된 고객 아이디 Data
    let idx = $('#idx').val();
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
                        list_selected = 'member_select_list_selected';
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
    button_act();
    list_act();
});
</script>