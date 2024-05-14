<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_rental.css?ver=7">', 0);

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
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="이름 입력">
                <a class="filter_submit" id="filter_submit">검색</a>
            </div>
        </div>
        <!-- Year Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <li class="menu_list" set_idx="" id="menu_list_act"><a class="menu_list_btn">전체</a></li>
                <?php
                $set_sql = " select * from g5_client_rental_set where branch_id = '{$_SESSION['this_branch_id']}' and set_mb_menu = '{$_SESSION['this_code']}' and set_hide = '' ";
                $set_qry = sql_query($set_sql);
                $set_num = sql_num_rows($set_qry);
                if($set_num > 0) {
                    for($s=0; $set_row = sql_fetch_array($set_qry); $s++) {
                ?>
                <li class="menu_list" set_idx="<?php echo $set_row['set_idx'] ?>">
                    <a class="menu_list_btn"><?php echo $set_row['set_tit'] ?></a>
                    <?php if($write_permit === true) { ?><a class="edit_btn edit_set_btn" set_idx="<?php echo $set_row['set_idx'] ?>">수정</a><?php } ?>
                    <?php if($delete_permit === true) { ?><a class="del_btn del_set_btn" set_idx="<?php echo $set_row['set_idx'] ?>">삭제</a><?php } ?>
                </li>
                <?php
                    }
                }
                ?>

                <li class="absolute_nav">
                    <a class="absolute_nav_btn" id="excel_download_btn">엑셀 다운로드</a>
                </li>
            </ul>

            <div class="layer_list_box">
                <table class="layer_list_hd_tbl">
                    <thead>
                        <tr>
                            <th class="layer_list_numb">번호</th>
                            <th class="layer_list_tel">대여품명</th>
                            <th class="layer_list_tel">대여품 번호</th>
                            <th class="layer_list_date">대여기간</th>
                            <th class="layer_list_service_category">대여자</th>
                            <th class="layer_list_date">반납기간</th>
                            <th class="layer_list_service_category">반납자</th>
                            <th>설정</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl">
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->

        <div class="bottom_wrap"></div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup"></div>

<script>
let write_ajax;
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

    // 메뉴 선택시 해당 메뉴 활성화 & 리스트 불러오기
    $('.menu_list').click(function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

        button_act();
        list_act();
    });

    <?php if($write_permit === true) { ?>
    $(document).on('click', '.rental_write_btn', function(){
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/client_rental_write.php?set_idx=" + set_idx + '&now_year=' + now_year);

        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x500');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // 교육 리스트 추가 버튼 클릭시
    $(document).on('click', '#write_set_btn', function(){
        // Layer Popup : 교육 리스트 추가 불러오기
        $("#layer_popup").load(g5_bbs_url + "/client_rental_set_write.php");

        // Layer Popup 보이기
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('set_form');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('keyup', '#set_tit', function(key){
        if(key.keyCode == 13){
            $('#set_submit_btn').click();
        }
    });

    // 대여품 리스트저장버튼 클릭시
    $(document).on('click', '#set_submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#set_tit').val() == '') {
            alert('대여품명을 입력해주세요');
            $('#set_tit').focus();
            return false;
        }

        let writeForm = document.getElementById("set_fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/client_rental_set_write_update.php',
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

                location.reload();
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });

    $(document).on('click', '.list_edit_btn', function(){
        let now_year = $('#now_year').val();
        let rent_idx = $(this).attr('rent_idx');
        let set_idx = $(this).attr('set_idx');
        $("#layer_popup").load(g5_bbs_url + "/client_rental_write.php?w=u&rent_idx=" + rent_idx + '&now_year=' + now_year + '&set_idx=' + set_idx);

        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x500');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.edit_set_btn', function(){
        let set_idx = $(this).attr('set_idx');
        // Layer Popup : 교육 리스트 추가 불러오기
        $("#layer_popup").load(g5_bbs_url + "/client_rental_set_write.php?w=u&set_idx=" + set_idx);

        // Layer Popup 보이기
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('set_form');
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>

    // 참석자 리스트 클릭(선택)시
    $(document).on('click', '.member_select_list_tbl > tbody > tr', function(){
        $('.member_select_check').prop('checked', false);
        $(this).find('.member_select_check').prop('checked', true);
        $('.member_select_list_tbl > tbody > tr').removeClass('member_select_list_selected');
        $(this).addClass('member_select_list_selected');
    });

    // 참석자 리스트 체크박스 클릭(선택)시
    $(document).on('click', '.member_select_check', function(e){
        e.stopPropagation();
    });

    // 참석자 리스트 체크박스 체크상태 변경시
    $(document).on('change', '.member_select_check', function(e){
        $('.member_select_check').prop('checked', false);
        $(this).prop('checked', true);
        $('.member_select_check').parents('tr').removeClass('member_select_list_selected');
        $(this).parents('tr').addClass('member_select_list_selected');
        /*
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
        */
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

    <?php if($delete_permit === true) { ?>
    $(document).on('click', '.list_del_btn', function(){
        let rent_idx = $(this).attr('rent_idx');

        if(confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.client_rental_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'rent_idx': rent_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    if(response.code == '0000') {
                        list_act();
                    }else{
                        location.reload();
                    }
                }
            });
        }
    });

    $(document).on('click', '.del_set_btn', function(event){
        let set_idx = $(this).attr('set_idx');

        if(confirm('삭제하시면 등록된 해당 대여품 정보가 모두 삭제됩니다.\n정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.client_rental_set_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'set_idx': set_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    location.reload();
                }
            });            
        }

        return false;
    });
    <?php } ?>

    // 대여자선택 버튼 클릭시 대여자선택 Layer Popup 띄우기
    $(document).on('click', '#mb_select_btn', function(){
        let idx = $('#idx').val();
        let tit = '대여자';
        $("#select_layer_popup").load(g5_bbs_url + "/member_select_form.php?idx=" + idx + "&tit=" + tit + "&mode=rent");

        $('#select_layer_popup').css('display', 'block');
        $('#select_layer_popup_bg').css('display', 'block');

        member_select_form_timer = setInterval(function(){
            member_select_form();
        }, 600);
    });

    // 반납자선택 버튼 클릭시 반납자선택 Layer Popup 띄우기
    $(document).on('click', '#mb_select_btn2', function(){
        let idx = $('#idx').val();
        let tit = '반납자';
        $("#select_layer_popup").load(g5_bbs_url + "/member_select_form.php?idx=" + idx + "&tit=" + tit + "&mode=return");

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
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x500');
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('click', '#select_submit_btn', function(){
        let select_mode = $('#select_mode').val();
        let mb_id = '';
        let mb_name = '';

        if($('.member_select_check:checked').length > 0) {
            mb_id = $('.member_select_check:checked').eq(0).val();
            mb_name = $('.member_select_check:checked').eq(0).attr('mb_name');
        }

        if(select_mode == 'rent') {
            $('#rent_mb_id').val(mb_id);
            $('#rent_name').val(mb_name);
        }

        if(select_mode == 'return') {
            $('#rent_return_mb_id').val(mb_id);
            $('#rent_return_name').val(mb_name);
        }

        $('#select_layer_popup').empty();

        $('#select_layer_popup').css('display', 'none');
        $('#select_layer_popup_bg').css('display', 'none');
    });

    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#rent_date').val() == '') {
            alert('대여기간을 선택/입력해주세요');
            $('#rent_date').focus();
            return false;
        }

        if($('#rent_mb_id').val() == '') {
            alert('대여자명을 선택/입력해주세요');
            $('#rent_name').focus();
            return false;
        }

        if($('#rent_name').val() == '') {
            alert('대여자명을 선택/입력해주세요');
            $('#rent_name').focus();
            return false;
        }

        if($('#rent_return_date').val() != '') {
            if($('#rent_return_mb_id').val() == '') {
                alert('반납자명을 선택/입력해주세요');
                $('#rent_return_name').focus();
                return false;
            }

            if($('#rent_return_name').val() == '') {
                alert('반납자명을 선택/입력해주세요');
                $('#rent_return_name').focus();
                return false;
            }
        }

        if($('#rent_return_name').val() != '') {
            if($('#rent_return_mb_id').val() == '') {
                alert('반납자명을 선택/입력해주세요');
                $('#rent_return_name').focus();
                return false;
            }

            if($('#rent_return_date').val() == '') {
                alert('반납기간을 선택/입력해주세요');
                $('#rent_return_date').focus();
                return false;
            }
        }

        if($('#rent_return_mb_id').val() != '') {
            if($('#rent_return_name').val() == '') {
                alert('반납자명을 선택/입력해주세요');
                $('#rent_return_name').focus();
                return false;
            }

            if($('#rent_return_date').val() == '') {
                alert('반납기간을 선택/입력해주세요');
                $('#rent_return_date').focus();
                return false;
            }
        }

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/client_rental_write_update.php',
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
});

function button_act() {
    <?php if($write_permit === true) { ?>
    $.ajax({
        url: g5_bbs_url + "/ajax.client_rental_button.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(rst){
            $('.bottom_wrap').empty();

            let datas = '';

            if(rst.length > 0) {
                for(let i=0; i<rst.length; i++) {
                    datas += '<a class="write_btn rental_write_btn" set_idx="' + rst[i].set_idx + '">' + rst[i].set_tit + ' 대여등록</a>';
                }
            }

            datas += '<a class="write_btn" id="write_set_btn">대여품 리스트 추가</a>';

            $('.bottom_wrap').append(datas);

            return false;
        }
    });
    <?php } ?>
}

function list_act() {
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();
    let set_idx = '';
    if($('#menu_list_act').attr('set_idx') != '') set_idx = $('#menu_list_act').attr('set_idx');

    $.ajax({
        url: g5_bbs_url + "/ajax.client_rental_list_all.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_value': sch_value, 'set_idx': set_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            $('.layer_list_tbl > tbody').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<tr class="" rent_idx="' + response[i].rent_idx + '">';
                    datas += '<td class="layer_list_numb">' + (i+1) + '</td>';
                    datas += '<td class="layer_list_tel">' + response[i].set_tit + '</td>';
                    datas += '<td class="layer_list_tel">' + response[i].rent_numb + '</td>';
                    datas += '<td class="layer_list_date">' + response[i].rent_date + '</td>';
                    datas += '<td class="layer_list_service_category">' + response[i].rent_name + '</td>';
                    datas += '<td class="layer_list_date">' + response[i].rent_return_date + '</td>';
                    datas += '<td class="layer_list_service_category">' + response[i].rent_return_name + '</td>';
                    datas += '<td><div class="flex_row flex_row_center">';
                    <?php if($write_permit === true) { ?>
                    datas += '<a class="edit_btn list_edit_btn" rent_idx="' + response[i].rent_idx + '" set_idx="'+response[i].set_idx+'">수정</a>';
                    <?php } ?>
                    <?php if($delete_permit === true) { ?>
                    datas += '<a class="del_btn list_del_btn" rent_idx="' + response[i].rent_idx + '">삭제</a>';
                    <?php } ?>
                    datas += '</div></td>';
                    datas += '</tr>';
                }
            }

            $('.layer_list_tbl > tbody').append(datas);

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
    let user_id = '';
    if($('#select_mode').val() == 'rent') user_id = $('#rent_mb_id').val();
    if($('#select_mode').val() == 'return') user_id = $('#rent_return_mb_id').val();

    // 전체선택 해제
    $('.select_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.member_select_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'idx': idx, 'sch_value2': sch_value2, 'user_id': user_id},  // HTTP 요청과 함께 서버로 보낼 데이터
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
