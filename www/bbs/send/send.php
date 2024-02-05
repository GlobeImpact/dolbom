<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/send/send.css">', 0);
?>

<script>
function byte_check(send_message, sms_bytes)
{
    var conts = document.getElementById(send_message);
    var bytes = document.getElementById(sms_bytes);
    var max_bytes = document.getElementById("sms_max_bytes");
    var lms_max_length = <?php echo G5_ICODE_LMS_MAX_LENGTH;?>

    var i = 0;
    var cnt = 0;
    var exceed = 0;
    var ch = '';

    for (i=0; i<conts.value.length; i++)
    {
        ch = conts.value.charAt(i);
        if (escape(ch).length > 4) {
            cnt += 2;
        } else {
            cnt += 1;
        }
    }

    bytes.innerHTML = cnt;

    <?php if($config['cf_sms_type'] == 'LMS') { ?>
    if(cnt > 90)
        max_bytes.innerHTML = lms_max_length;
    else
        max_bytes.innerHTML = 90;

    if (cnt > lms_max_length)
    {
        exceed = cnt - lms_max_length;
        alert('메시지 내용은 '+ lms_max_length +'바이트를 넘을수 없습니다.\n\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\n\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = conts.value;
        for (i=0; i<tmp.length; i++)
        {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > lms_max_length) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        conts.value = tmp;
        bytes.innerHTML = xcnt;
        return;
    }
    <?php } else { ?>
    if (cnt > 80)
    {
        exceed = cnt - 80;
        alert('메시지 내용은 80바이트를 넘을수 없습니다.\n\n작성하신 메세지 내용은 '+ exceed +'byte가 초과되었습니다.\n\n초과된 부분은 자동으로 삭제됩니다.');
        var tcnt = 0;
        var xcnt = 0;
        var tmp = conts.value;
        for (i=0; i<tmp.length; i++)
        {
            ch = tmp.charAt(i);
            if (escape(ch).length > 4) {
                tcnt += 2;
            } else {
                tcnt += 1;
            }

            if (tcnt > 80) {
                tmp = tmp.substring(0,i);
                break;
            } else {
                xcnt = tcnt;
            }
        }
        conts.value = tmp;
        bytes.innerHTML = xcnt;
        return;
    }
    <?php } ?>
}

byte_check('send_message', 'sms_bytes');
</script>

<div id="layer_wrap">
    <div id="layer_box">
        

        <div class="flex_row">
            <div class="flex_sub1">
                <h4 class="sub_tit">발송대상자 선택</h4>

                <ul class="menu_box">
                    <li class="menu_list" user_category="member" id="menu_list_act"><a class="menu_list_btn">제공인력</a></li>
                    <li class="menu_list" user_category="client"><a class="menu_list_btn">고객</a></li>
                    <li class="menu_list" user_category="manager"><a class="menu_list_btn">매니저</a></li>
                </ul>

                <div class="list_wrap">
                    <div class="list_wrap_top">
                        <div class="list_filter_box">
                            <select class="filter_select member" id="filter_activity_status">
                                <option value="">활동현황</option>
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}); $l++) { ?>
                                <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                            <select class="filter_select member" id="filter_service_category">
                                <option value="">서비스구분</option>
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
                                <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                            <select class="filter_select client" id="filter_client_service">
                                <option value="">서비스구분</option>
                                <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
                                <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                                <?php } ?>
                            </select>
                            <select class="filter_select client" id="filter_service_cate">
                                <option value="">이용종류</option>
                                <?php for($l=0; $l<count($set_client_service_cate_arr); $l++) { ?>
                                <option value="<?php echo $set_client_service_cate_arr[$l] ?>"><?php echo $set_client_service_cate_arr[$l] ?></option>
                                <?php } ?>
                            </select>
                            <input type="text" class="filter_input" id="filter_user_name" value="" placeholder="이름 조회">
                        </div>
                    </div>

                    <div class="user_list_wrap">
                        <table class="list_tbl member">
                            <thead>
                                <tr>
                                    <th class="left_list_numb">번호</th>
                                    <th class="left_list_status">현황</th>
                                    <th class="left_list_name">직원명</th>
                                    <th class="left_list_gender">성별</th>
                                    <th class="left_list_birth">생년월일</th>
                                    <th class="left_list_date">입사일자</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="list_tbl client">
                            <thead>
                                <tr>
                                    <th class="left_list_numb">번호</th>
                                    <th class="left_list_status">현황</th>
                                    <th class="left_list_name">신청인</th>
                                    <th class="left_list_hp">연락처</th>
                                    <th class="left_list_service">서비스</th>
                                </tr>
                            </thead>
                        </table>
                        <table class="list_tbl manager">
                            <thead>
                                <tr>
                                    <th class="left_list_numb">번호</th>
                                    <th class="left_list_id">아이디</th>
                                    <th class="left_list_name">매니저명</th>
                                    <th class="left_list_birth">생년월일</th>
                                    <th class="left_list_hp">연락처</th>
                                </tr>
                            </thead>
                        </table>

                        <div class="user_list_box">
                            <table class="list_tbl">
                                <tbody id="user_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex_sub2">
                <h4 class="sub_tit">발송대상자 확인</h4>

                <div class="to_wrap">
                    <h4 class="to_tit">받는사람 (총 0명)</h4>
                    <div class="to_add_box">
                        <input type="text" class="to_add_input" id="to_add_name" value="" placeholder="이름">
                        <input type="text" class="to_add_input" id="to_add_hp" value="" oninput="autoHyphen(this)" maxlength="13" placeholder="휴대폰번호">
                        <a class="to_add_btn">추가</a>
                    </div>
                    <div class="to_list_box"></div>
                    <a class="to_list_all_del_btn">전체삭제</a>
                </div>
            </div>
            <div class="flex_sub3">
                <h4 class="sub_tit">문자 내용</h4>

                <div class="sms_send_wrap">
                    <div class="message_box">
                        <div id="sms_byte"><span id="sms_bytes">0</span> / <span id="sms_max_bytes"><?php echo ($config['cf_sms_type'] == 'LMS' ? 90 : 80); ?></span> byte</div>
                        <?/*
                        <p style="margin-right:8px; font-size:13px;">현재잔여건수 : 0건</p>
                        <a style="display:flex; flex-direction:row; align-items:center; justify-content:center; margin:0; padding:4px 8px; background:#6d9ac4; border:1px solid #1469b9; border-radius:4px; color:#fff;">충전하기</a>
                        */?>
                    </div>

                    <textarea name="send_message" id="send_message" onkeyup="byte_check('send_message', 'sms_bytes');" accesskey="m"></textarea>

                    <div class="message_box">
                        <label for="booking">
                            <input type="checkbox" id="booking"> 예약발송
                        </label>
                        <input type="text" class="date_api" id="booking_date" value="<?php echo date('Y-m-d') ?>" maxlength="10" oninput="autoHyphen3(this);">
                        <select id="booking_time">
                            <?php
                            for($h=6; $h<22; $h++) {
                                $h_val = $h;
                                if($h<10) $h_val = '0'.$h;
                            ?>
                            <option value="<?php echo $h_val ?>:00"><?php echo $h_val ?>:00</option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <a class="submit_btn" id="submit_btn">문자발송</a>
                </div>

                <h4 class="sub_tit">발송 문자 선택</h4>

                <div class="sms_message_wrap">
                    <p class="sms_message_sbj">문자 내용</p>
                    <div class="sms_message_box">
                        <?php
                        $sms_msg_sql = " select * from g5_sms_message where message_hide = '' order by idx desc ";
                        $sms_msg_qry = sql_query($sms_msg_sql);
                        $sms_msg_num = sql_num_rows($sms_msg_qry);
                        if($sms_msg_num > 0) {
                            for($i=0; $sms_msg_row = sql_fetch_array($sms_msg_qry); $i++) {
                        ?>
                        <p class="sms_message_list"><?php echo nl2br($sms_msg_row['message']) ?></p>
                        <?php
                            }
                        }else{
                        ?>
                        <p class="sms_message_list">등록된 발송 문자가 없습니다.</p>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let write_ajax;

$(function(){
    // 발송대상자 메뉴 선택
    $(document).on('click', '.menu_list', function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

        filter_act();
    });

    $(document).on('change', '.filter_select', function(){
        list_act();
    });

    $(document).on('input', '.filter_input', function(){
        list_act();
    });

    $(document).on('keyup', '#to_add_hp', function(key){
        if(key.keyCode == 13){
            $('.to_add_btn').click();
        }
    });

    $(document).on('click', '.to_add_btn', function(){
        if($('#to_add_name').val() == '') {
            alert('받는사람 이름을 입력해주세요');
            $('#to_add_name').focus();
            return false;
        }

        if($('#to_add_hp').val() == '') {
            alert('받는사람 휴대폰번호를 입력해주세요');
            $('#to_add_hp').focus();
            return false;
        }

        let to_recv_name = $('#to_add_name').val();
        let to_recv_hp = $('#to_add_hp').val();

        if($(".to_list[to_recv_hp='"+to_recv_hp+"']").length > 0) {
            alert('이미 등록된 연락처입니다.');
            $('#to_add_name').val('');
            $('#to_add_hp').val('');
            return false;
        }

        let datas = '';
        datas += '<div class="to_list" to_user_category="etc" to_recv_id="" to_recv_name="'+to_recv_name+'" to_recv_hp="'+to_recv_hp+'">';
        datas += '<p class="to_list_cate">기타</p>';
        datas += '<p class="to_list_name">'+to_recv_name+'</p>';
        datas += '<p class="to_list_hp">'+to_recv_hp+'</p>';
        datas += '<a class="to_list_del_btn">지움</a>';
        datas += '</div>';

        $('.to_list_box').append(datas);

        $('#to_add_name').val('');
        $('#to_add_hp').val('');

        to_count_act();
    });

    $(document).on('click', '.to_list_all_del_btn', function(){
        if(confirm('정말 발송대상자 목록을 비우시겠습니까?')) {
            $('.to_list_box').empty();
            $("#user_list > tr").removeClass('list_selected');

            to_count_act();
            return false;
        }
    });

    $(document).on('click', '.to_list_del_btn', function(){
        let to_recv_id = $(this).parents('div.to_list').attr('to_recv_id');

        if(confirm('정말 선택된 발송대상자를 삭제하시겠습니까?')) {
            $(this).parents('div.to_list').remove();
            $("#user_list > tr[recv_id='"+to_recv_id+"']").removeClass('list_selected');

            to_count_act();
            return false;
        }
    });

    $(document).on('click', '#user_list > tr', function(){
        if($(this).hasClass('list_selected') == true) {
            return false;
        }

        let user_category = $(this).attr('user_category');
        let recv_id = $(this).attr('recv_id');
        let recv_name = $(this).attr('recv_name');
        let recv_hp = $(this).attr('recv_hp');
        let cate = '';
        switch (user_category) {
            case 'member':
                cate = '제공인력';
            break;

            case 'client':
                cate = '고객';
            break;

            case 'manager':
                cate = '매니저';
            break;

            default:
            break;
        }

        if($(".to_list[to_recv_id='"+recv_id+"']").length > 0) {
            alert('이미 등록된 대상자입니다.');
            return false;
        }

        let datas = '';
        datas += '<div class="to_list" to_user_category="'+user_category+'" to_recv_id="'+recv_id+'" to_recv_name="'+recv_name+'" to_recv_hp="'+recv_hp+'">';
        datas += '<p class="to_list_cate">'+cate+'</p>';
        datas += '<p class="to_list_name">'+recv_name+'</p>';
        datas += '<p class="to_list_hp">'+recv_hp+'</p>';
        datas += '<a class="to_list_del_btn">지움</a>';
        datas += '</div>';

        $('.to_list_box').append(datas);

        $(this).addClass('list_selected');

        to_count_act();
    });

    $(document).on('click', '.sms_message_list', function(){
        let message = $(this).text();
        $('#send_message').val(message);

        byte_check('send_message', 'sms_bytes');
    });

    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('.to_list').length == 0) {
            alert('발송대상자를 추가해주세요');
            return false;
        }

        if($('#send_message').val() == '') {
            alert('문자 내용을 입력해주세요');
            return false;
        }

        let datas = '';
        let list = [];
        if($('.to_list').length > 0) {
            for(let i=0; i<$('.to_list').length; i++) {
                list = [
                    {
                        'user_category': $('.to_list').eq(i).attr('to_user_category'),
                        'recv_id': $('.to_list').eq(i).attr('to_recv_id'),
                        'recv_name': $('.to_list').eq(i).attr('to_recv_name'),
                        'recv_hp': $('.to_list').eq(i).attr('to_recv_hp')
                    },
                ];
            }
        }
        let send_message = $('#send_message').val();
        let booking = '';
        let booking_date = $('#booking_date').val();
        let booking_time = $('#booking_time').val();

        let msg = "문자를 발송하시겠습니까?";

        if($('#booking').is(':checked') == true) {
            if($('#booking_date').val() == '') {
                alert('예약 날짜를 입력/선택해주세요');
                $('#booking_date').focus();
                return false;
            }

            booking = 'y';

            msg = "예약 문자를 선택하셨습니다.\n"+booking_date+" "+booking_time+" 예약 문자를 발송하시겠습니까?";
        }

        datas = {
            'send_list': list,
            'send_message': send_message,
            'booking': booking,
            'booking_date': booking_date,
            'booking_time': booking_time
        };

        if(confirm(msg)) {
            write_ajax = $.ajax({
                url: g5_bbs_url + '/send_update.php',
                type: "POST",
                data: datas,
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리

                    if(response.msg != '') {
                        alert(response.msg);
                    }else{
                        alert('Error!');
                    }

                    window.location.reload();
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                }
            });
        }

        return false;
    });
});

// 검색 세팅
function filter_act() {
    let user_category = $('#menu_list_act').attr('user_category');

    $('.filter_select').val('').prop('selected', true);
    $('.filter_input').val('');

    $('.filter_select').css('display', 'none');
    $('.user_list_wrap > .list_tbl').css('display', 'none');

    switch (user_category) {
        case 'member':
            $('.list_filter_box .member').css('display', 'block');
            $('.list_tbl.member').css('display', 'table');
        break;
        
        case 'client':
            $('.list_filter_box .client').css('display', 'block');
            $('.list_tbl.client').css('display', 'table');
        break;

        case 'manager':
            $('.list_filter_box.manager').css('display', 'block');
            $('.list_tbl.manager').css('display', 'table');
        break;

        default:
        break;
    }

    list_act();
}

// 리스트 추출
function list_act() {
    if (typeof write_ajax !== 'undefined') {
        write_ajax.abort(); // 비동기 실행취소
    }

    let user_category = $('#menu_list_act').attr('user_category');

    let filter_activity_status = '';
    let filter_service_category = '';
    let filter_client_service = '';
    let filter_service_cate = '';
    let filter_user_name = '';
    filter_user_name = $('#filter_user_name').val();

    let datas = '';

    switch (user_category) {
        case 'member':
            let filter_activity_status = $('#filter_activity_status').val();
            let filter_service_category = $('#filter_service_category').val();
            datas = {'user_category': user_category, 'filter_user_name': filter_user_name, 'filter_activity_status': filter_activity_status, 'filter_service_category': filter_service_category};
        break;
        
        case 'client':
            let filter_client_service = $('#filter_client_service').val();
            let filter_service_cate = $('#filter_service_cate').val();
            datas = {'user_category': user_category, 'filter_user_name': filter_user_name, 'filter_client_service': filter_client_service, 'filter_service_cate': filter_service_cate};
        break;

        case 'manager':
            datas = {'user_category': user_category, 'filter_user_name': filter_user_name};
        break;

        default:
        break;
    }

    write_ajax = $.ajax({
        url: g5_bbs_url + '/ajax.sms_recv_list.php',
        type: "POST",
        data: datas,
        dataType: "json",
        success: function(response) {
            // 전송이 성공한 경우 받는 응답 처리

            $('#user_list').empty();
            let datas = '';
            let list_selected = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {

                    list_selected = '';
                    if($(".to_list[to_recv_id='"+response[i].recv_id+"']").length > 0) {
                        list_selected = 'class="list_selected"';
                    }

                    datas += '<tr user_category="'+user_category+'" recv_id="'+response[i].recv_id+'" recv_name="'+response[i].recv_name+'" recv_hp="'+response[i].recv_hp+'" '+list_selected+'>';

                    if(user_category == 'member') {
                        datas += '<td class="left_list_numb">'+(i+1)+'</td>';
                        datas += '<td class="left_list_status">'+response[i].status+'</td>';
                        datas += '<td class="left_list_name">'+response[i].recv_name+'</td>';
                        datas += '<td class="left_list_gender">'+response[i].gender+'</td>';
                        datas += '<td class="left_list_birth">'+response[i].birth+'</td>';
                        datas += '<td class="left_list_date">'+response[i].date+'</td>';
                    }else if(user_category == 'client') {
                        datas += '<td class="left_list_numb">' + (i+1) + '</td>';
                        datas += '<td class="left_list_status">'+response[i].status+'</td>';
                        datas += '<td class="left_list_name">'+response[i].recv_name+'</td>';
                        datas += '<td class="left_list_hp">'+response[i].recv_hp+'</td>';
                        datas += '<td class="left_list_service">'+response[i].service+'</td>';
                    }else if(user_category == 'manager') {
                        datas += '<td class="left_list_numb">' + (i+1) + '</td>';
                        datas += '<td class="left_list_id">'+response[i].recv_id+'</td>';
                        datas += '<td class="left_list_name">'+response[i].recv_name+'</td>';
                        datas += '<td class="left_list_birth">'+response[i].birth+'</td>';
                        datas += '<td class="left_list_hp">'+response[i].recv_hp+'</td>';
                    }

                    datas += '</tr>';
                }

                $('#user_list').append(datas);
            }
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}

// 받는 사람 카운팅
function to_count_act() {
    let to_count = $('.to_list').length;
    $('.to_tit').text('받는사람 (총 '+to_count+'명)');
    return false;
}

$(document).ready(function(){
    filter_act();
});
</script>
