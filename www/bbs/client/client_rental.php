<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_rental.css?ver=3">', 0);
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
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="이름 입력">
                <a id="filter_submit">검색</a>
            </div>
        </div>

        <ul class="menu_box">
            <li class="menu_list" id="menu_list_act" set_idx=""><a class="menu_list_btn">전체</a></li>
            <?php
            $set_sql = " select * from g5_client_rental_set where set_mb_menu = '{$_SESSION['this_code']}' and set_hide = '' ";
            $set_qry = sql_query($set_sql);
            $set_num = sql_num_rows($set_qry);
            if($set_num > 0) {
                for($s=0; $set_row = sql_fetch_array($set_qry); $s++) {
            ?>
            <li class="menu_list" set_idx="<?php echo $set_row['set_idx'] ?>"><a class="menu_list_btn"><?php echo $set_row['set_tit'] ?></a></li>
            <?php
                }
            }
            ?>
        </ul>

        <div class="list_wrap">
            <div class="list_box">
                <table class="list_hd_tbl">
                    <thead>
                        <tr>
                            <th class="x60">번호</th>
                            <th class="x200">대여품명</th>
                            <th class="x200">대여품 번호</th>
                            <th class="x140">대여기간</th>
                            <th class="x140">대여자</th>
                            <th class="x140">반납기간</th>
                            <th class="x140">반납자</th>
                            <th>설정</th>
                        </tr>
                    </thead>
                </table>

                <table class="list_tbl">
                    <tbody id="client_rental_list"></tbody>
                </table>
            </div>
        </div>

        <div class="bottom_wrap">
            <?php
            $set_sql = " select * from g5_client_rental_set where set_mb_menu = '{$_SESSION['this_code']}' and set_hide = '' ";
            $set_qry = sql_query($set_sql);
            $set_num = sql_num_rows($set_qry);
            if($set_num > 0) {
                for($s=0; $set_row = sql_fetch_array($set_qry); $s++) {
            ?>
            <a class="write_btn" set_idx="<?php echo $set_row['set_idx'] ?>"><?php echo $set_row['set_tit'] ?> 대여등록</a>
            <?php
                }
            }
            ?>
        </div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup"></div>

<script>
let write_ajax;
$(function(){
    $('#prev_year_btn, #next_year_btn').click(function(){
        let year = $(this).attr('year');
        let prev_year = parseInt(year || 0) - 1;
        let next_year = parseInt(year || 0) + 1;
        
        $('.filter_year_tit').text(year + '년');
        $('#now_year').val(year);
        $('#prev_year_btn').attr('year', prev_year);
        $('#next_year_btn').attr('year', next_year);

        list_act();
    });

    $('#sch_value').on("keyup",function(key){
        if(key.keyCode == 13){
            $('#filter_submit').click();
        }
    });

    $('#filter_submit').click(function(){
        list_act();
    });

    $('.menu_list').click(function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

        list_act();
    });

    $(document).on('click', '.write_btn', function(){
        let set_idx = $(this).attr('set_idx');
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/client_rental_write.php?set_idx=" + set_idx + '&now_year=' + now_year);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.edit_btn', function(){
        let now_year = $('#now_year').val();
        let rent_idx = $(this).attr('rent_idx');
        $("#layer_popup").load(g5_bbs_url + "/client_rental_write.php?w=u&rent_idx=" + rent_idx + '&now_year=' + now_year);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.del_btn', function(){
        let rent_idx = $(this).attr('rent_idx');

        if(confirm('정말 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.client_rental_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'rent_idx': rent_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
                method: "POST",   // HTTP 요청 메소드(GET, POST 등)
                dataType: "json", // 서버에서 보내줄 데이터의 타입
                success: function(response){
                    console.log(response);

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

    $(document).on('click', '#mb_select_btn', function(){
        $('#layer_popup').css('height', '600px');

        let rent_idx = $('#rent_idx').val();
        $("#write_layer_popup").load(g5_bbs_url + "/client_rental_list_write.php?rent_idx=" + rent_idx + '&rent_set=1');

        $('#write_layer_popup').css('display', 'block');
        $('#write_layer_popup_bg').css('display', 'block');

        list_act2_timer = setInterval(function(){
            list_act2();
        }, 800);
    });

    $(document).on('click', '#mb_select_btn2', function(){
        $('#layer_popup').css('height', '600px');

        let rent_idx = $('#rent_idx').val();
        $("#write_layer_popup").load(g5_bbs_url + "/client_rental_list_write.php?rent_idx=" + rent_idx + '&rent_set=2');

        $('#write_layer_popup').css('display', 'block');
        $('#write_layer_popup_bg').css('display', 'block');

        list_act2_timer = setInterval(function(){
            list_act2();
        }, 800);
    });

    $(document).on('click', '#popup_close_btn', function(){
        $('#layer_popup').empty();

        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('click', '#write_popup_close_btn', function(){
        $('#layer_popup').css('height', 'auto');

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

    $(document).on('click', '.select_list_tbl > tbody > tr', function(){
        $('#select_list > tr').removeClass('list_selected');
        $(this).find('.select_check').prop('checked', true);
        $(this).addClass('list_selected');
    });

    $(document).on('click', '.select_check', function(e){
        e.stopPropagation();
    });

    $(document).on('change', '.select_check', function(e){
        $('#select_list > tr').removeClass('list_selected');
        if($(this).is(':checked') == false) {
            $(this).parents('tr').removeClass('list_selected');
        }else{
            $(this).parents('tr').addClass('list_selected');
        }
    });

    $(document).on('click', '#select_submit_btn', function(){
        let rent_set = $('#rent_set').val();
        let mb_id = '';
        let mb_name = '';

        if($('.select_check:checked').length > 0) {
            mb_id = $('.select_check:checked').eq(0).val();
            mb_name = $('.select_check:checked').eq(0).attr('mb_name');
        }
        
        if(rent_set == 1) {
            $('#rent_mb_id').val(mb_id);
            $('#rent_name').val(mb_name);
        }else if(rent_set == 2) {
            $('#rent_return_mb_id').val(mb_id);
            $('#rent_return_name').val(mb_name);
        }

        $('#layer_popup').css('height', 'auto');

        $('#write_layer_popup').empty();

        $('#write_layer_popup').css('display', 'none');
        $('#write_layer_popup_bg').css('display', 'none');
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
                console.log(response);

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
            console.log(response);

            $('#client_rental_list').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<tr class="" rent_idx="' + response[i].rent_idx + '">';
                    datas += '<td class="x60">' + (i+1) + '</td>';
                    datas += '<td class="x200">' + response[i].set_tit + '</td>';
                    datas += '<td class="x200">' + response[i].rent_numb + '</td>';
                    datas += '<td class="x140">' + response[i].rent_date + '</td>';
                    datas += '<td class="x140">' + response[i].rent_name + '</td>';
                    datas += '<td class="x140">' + response[i].rent_return_date + '</td>';
                    datas += '<td class="x140">' + response[i].rent_return_name + '</td>';
                    datas += '<td class=""><div class="btn_flex">';
                    datas += '<a class="edit_btn" rent_idx="' + response[i].rent_idx + '">수정</a>';
                    datas += '<a class="del_btn" rent_idx="' + response[i].rent_idx + '">삭제</a>';
                    datas += '</div></td>';
                    datas += '</tr>';
                }
            }

            $('#client_rental_list').append(datas);

            return false;
        }
    });
}

function list_act2() {
    let rent_idx = $('#rent_idx').val();
    let sch_value2 = $('#sch_value2').val();

    $('.select_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.client_rental_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'rent_idx': rent_idx, 'sch_value2': sch_value2},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            console.log(response);

            $('#select_list').empty();

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
                    datas += '<td class="select_check_td x45">';
                    datas += '<input type="radio" class="select_check" name="select_mb_id" id="select_mb_id' + i + '" value="' + response[i].mb_id + '" ' + list_checked + ' service_category="' + response[i].service_category + '" mb_name="' + response[i].mb_name + '">';
                    datas += '</td>';
                    datas += '<td class="x60">' + response[i].activity_status + '</td>';
                    datas += '<td class="x80">' + response[i].mb_name + '</td>';
                    datas += '<td class="x90">' + response[i].service_category + '</td>';
                    datas += '<td class="x40">' + response[i].team_category + '</td>';
                    datas += '<td>' + response[i].security_number + '</td>';
                    datas += '</tr>';
                }
            }

            $('#select_list').append(datas);
            $('#select_tot').text(response.length);

            clearInterval(list_act2_timer);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act();
});
</script>
