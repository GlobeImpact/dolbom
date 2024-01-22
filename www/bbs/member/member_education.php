<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member_education.css?ver=2">', 0);
?>

<!-- 달력 API -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo G5_JS_URL ?>/jquery-ui.js"></script>

<!-- 다음지도 API -->
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=575b55abed8a1a6c4569d200321142b9&libraries=services"></script>

<!-- 다음주소 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" async></script>

<input type="hidden" id="now_year" value="<?php echo date('Y') ?>">

<div id="layer_wrap">
    <div id="layer_box">

        <div class="filter_wrap">
            <div class="filter_year">
                <a class="filter_year_btn" id="prev_year_btn" year="<?php echo (int) date('Y') - 1 ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_prev.png"></a>
                <span class="filter_year_tit">2024년</span>
                <a class="filter_year_btn" id="next_year_btn" year="<?php echo (int) date('Y') + 1 ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_next.png"></a>
            </div>
            <div class="filter_box">
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="교육제목 입력">
                <a id="filter_submit">검색</a>
            </div>
        </div>

        <div class="member_education_list_wrap">
            <div class="member_education_list_box"></div>
        </div>

        <div class="bottom_wrap"></div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup"></div>

<script>
let write_ajax;

let list_act2_timer = '';

$(function(){
    $('#prev_year_btn, #next_year_btn').click(function(){
        let year = $(this).attr('year');
        let prev_year = parseInt(year || 0) - 1;
        let next_year = parseInt(year || 0) + 1;
        
        $('.filter_year_tit').text(year + '년');
        $('#now_year').val(year);
        $('#prev_year_btn').attr('year', prev_year);
        $('#next_year_btn').attr('year', next_year);

        button_act();
        list_act();
    });

    $('#sch_value').on("keyup",function(key){
        if(key.keyCode == 13){
            $('#filter_submit').click();
        }
    });

    $('#filter_submit').click(function(){
        button_act();
        list_act();
    });

    $(document).on('click', '.education_write_btn', function(){
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/member_education_write.php?set_idx=" + set_idx + '&now_year=' + now_year);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '#write_set_btn', function(){
        $("#layer_popup").load(g5_bbs_url + "/member_education_set_write.php");

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.edit_set_btn', function(){
        let set_idx = $(this).attr('set_idx');
        $("#layer_popup").load(g5_bbs_url + "/member_education_set_write.php?w=u&set_idx=" + set_idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.del_set_btn', function(){
        let set_idx = $(this).attr('set_idx');

        if(confirm('삭제하시면 등록된 해당 교육일정이 모두 삭제됩니다.\n정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.member_education_set_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'set_idx': set_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    console.log(response);

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

    $(document).on('click', '.edu_edit_btn', function(){
        let edu_idx = $(this).attr('edu_idx');
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/member_education_write.php?w=u&set_idx=" + set_idx + '&now_year=' + now_year + '&edu_idx=' + edu_idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.edu_del_btn', function(){
        let edu_idx = $(this).attr('edu_idx');

        if(confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.member_education_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'edu_idx': edu_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    console.log(response);

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

    $(document).on('click', '#popup_close_btn', function(){
        $('#layer_popup').empty();

        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    // 저장버튼 클릭시
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
                console.log(response);

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

    $(document).on('click', '#mb_select_btn', function(){
        let edu_idx = $('#edu_idx').val();
        $("#write_layer_popup").load(g5_bbs_url + "/member_education_list_write.php?edu_idx=" + edu_idx);

        $('#write_layer_popup').css('display', 'block');
        $('#write_layer_popup_bg').css('display', 'block');

        list_act2_timer = setInterval(function(){
            list_act2();
        }, 800);
    });

    $(document).on('click', '#write_popup_close_btn', function(){
        $('#write_layer_popup').empty();

        $('#write_layer_popup').css('display', 'none');
        $('#write_layer_popup_bg').css('display', 'none');
    });

    $(document).on('keyup', '#sch_value2', function(key){
        if(key.keyCode == 13){
            $('#filter_submit2').click();
        }
    });

    $(document).on('click', '#filter_submit2', function(){
        list_act2();
    });

    $(document).on('change', '.edul_all_check', function(){
        if($(this).is(':checked') == false) {
            $('.edul_check').prop('checked', false);
            $('.edul_list_tbl > tbody > tr').removeClass('list_selected');
        }else{
            $('.edul_check').prop('checked', true);
            $('.edul_list_tbl > tbody > tr').addClass('list_selected');
        }
    });

    $(document).on('click', '.edul_list_tbl > tbody > tr', function(){
        if($(this).find('.edul_check').is(':checked') == false) {
            $(this).find('.edul_check').prop('checked', true);
            $(this).addClass('list_selected');
        }else{
            $(this).find('.edul_check').prop('checked', false);
            $(this).removeClass('list_selected');
        }
    });

    $(document).on('click', '.edul_check', function(e){
        e.stopPropagation();
    });

    $(document).on('change', '.edul_check', function(e){
        if($(this).is(':checked') == false) {
            $(this).parents('tr').removeClass('list_selected');
        }else{
            $(this).parents('tr').addClass('list_selected');
        }
    });

    $(document).on('click', '#edul_submit_btn', function(){
        $('.mb_select_list_box').empty();

        let datas = '';

        if($('.edul_check:checked').length > 0) {
            for(let i=0; i<$('.edul_check:checked').length; i++) {
                console.log(i);
                datas += '<input type="hidden" name="edul_mb_id[]" value="' + $('.edul_check:checked').eq(i).val() + '">';
                datas += '<a class="mb_select_list"><span>' + $('.edul_check:checked').eq(i).attr('mb_name') + '</span><span>(' + $('.edul_check:checked').eq(i).attr('service_category') + ')</span></a>';
            }
            $('.mb_select_list_box').append(datas);

            $('#write_layer_popup').empty();

            $('#write_layer_popup').css('display', 'none');
            $('#write_layer_popup_bg').css('display', 'none');
        }
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
                console.log(response);

                if(response.msg != '') {
                    alert(response.msg);
                }
                if(response.code == '0000') {
                    button_act();
                    list_act();

                    $('#layer_popup').empty();
                    $("#layer_popup").load(g5_bbs_url + "/member_education_view.php?edu_idx=" + response.edu_idx);
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

    $(document).on('click', '.edu_view', function(){
        let edu_idx = $(this).attr('edu_idx');

        $("#layer_popup").load(g5_bbs_url + "/member_education_view.php?edu_idx=" + edu_idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
});

// 날짜 정규식
function autoHyphen3(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,4})(\d{0,2})(\d{0,2})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

// 숫자만 입력 정규식
function inputNum(id) {
    let element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
}

function button_act() {
    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_button.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(rst){
            console.log(rst);

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
            console.log(response);

            $('.member_education_list_box').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<div class="member_education_list">';
                    datas += '<div>';
                    datas += '<p>' + response[i][0].set_tit + '</p>';
                    datas += '<div>';
                    datas += '<a class="edit_btn edit_set_btn" set_idx="' + response[i][0].set_idx + '">수정</a>';
                    datas += '<a class="del_btn del_set_btn" set_idx="' + response[i][0].set_idx + '">삭제</a>';
                    datas += '</div>';
                    datas += '</div>';
                    datas += '<ul>';
                    for(let j=0; j<response[i].length; j++) {
                        if(typeof response[i][j].numb == 'undefined') {
                            datas += '<li>';
                            datas += '<div class="member_education_list_data not_data">작성된 교육이 없습니다.</div>';
                            datas += '</li>';
                        }else{
                            datas += '<li class="edu_view" edu_idx="' + response[i][j].edu_idx + '">';
                            datas += '<label class="member_education_list_numb">' + response[i][j].numb + '</label>';
                            datas += '<div class="member_education_list_data">';
                            datas += '<p class="member_education_list_date">' + response[i][j].edu_date + '</p>';
                            datas += '<p class="member_education_list_tit">' + response[i][j].edu_tit + '</p>';
                            datas += '<p class="member_education_list_counting">' + response[i][j].max_list + ' / ' + response[i][j].edu_list + ' / ' + response[i][j].not_list + '</p>';
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

function list_act2() {
    let edu_idx = $('#edu_idx').val();
    let sch_value2 = $('#sch_value2').val();

    $('.edul_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'edu_idx': edu_idx, 'sch_value2': sch_value2},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            console.log(response);

            $('#edul_list').empty();

            let datas = '';
            let list_selected = '';
            let list_checked = '';
            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    list_selected = '';
                    list_checked = '';
                    if(response[i].list_selected == 'y') {
                        list_selected = 'list_selected';
                        list_checked = 'checked';
                    }

                    datas += '<tr class="' + list_selected + '">';
                    datas += '<td class="edul_check_td x45">';
                    datas += '<input type="checkbox" class="edul_check" name="edul_mb_id[]" id="edul_mb_id' + i + '" value="' + response[i].mb_id + '" ' + list_checked + ' service_category="' + response[i].service_category + '" mb_name="' + response[i].mb_name + '">';
                    datas += '</td>';
                    datas += '<td class="x60">' + response[i].activity_status + '</td>';
                    datas += '<td class="x80">' + response[i].mb_name + '</td>';
                    datas += '<td class="x90">' + response[i].service_category + '</td>';
                    datas += '<td class="x40">' + response[i].team_category + '</td>';
                    datas += '<td>' + response[i].security_number + '</td>';
                    datas += '</tr>';
                }
            }

            $('#edul_list').append(datas);
            $('#edul_tot').text(response.length);

            clearInterval(list_act2_timer);

            return false;
        }
    });
}

$(document).ready(function(){
    button_act();
    list_act();
});
</script>