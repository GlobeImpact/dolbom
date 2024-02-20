<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member.css?ver=2">', 0);


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
?>

<div id="layer_wrap">
    <div id="layer_box">

        <!-- List & View Wrap STR -->
        <div class="list_view_wrap">

            <!-- List Wrap STR -->
            <div class="list_wrap">
                <div class="list_top">
                    <div class="filter_box">
                        <select class="filter_select" id="sch_activity_status">
                            <option value="">활동현황</option>
                            <?php
                            for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}); $l++) {
                            ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?>" <?php echo ($l == 0)?'selected':''; ?>><?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php if(count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}) > 1) { ?>
                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <?php
                            for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) {
                            ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <?php } ?>
                        <input type="text" class="filter_input" id="sch_mb_name" value="" placeholder="이름 조회">
                    </div>
                    <div class="btn_box">
                        <?php if($write_permit === true) { ?><a class="list_top_btn" id="write_btn">제공인력등록</a><?php } ?>
                    </div>
                </div>
                <div class="list_box">
                    <table class="list_tbl">
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
                        <tbody id="member_list"></tbody>
                    </table>
                </div>
                <div class="list_bottom">
                    <a class="list_bottom_btn" id="excel_download_btn">엑셀 다운로드</a>
                </div>
            </div>
            <!-- List Wrap END -->
            
            <!-- View Wrap STR -->
            <div class="view_wrap">
                <div class="view_top">
                    <h4 class="view_tit">제공인력 기본정보</h4>
                    <?php if($delete_permit === true) { ?><a class="view_del_btn" id="del_btn">삭제</a><?php } ?>
                </div>
                <div class="view_box">
                    <table class="view_tbl">
                        <tbody>
                            <tr>
                                <td class="x150 valign_t" rowspan="8">
                                    <div id="profile_wrap">
                                        <img src="<?php echo G5_IMG_URL ?>/profile_noimg.png" onerror="this.src='<?php echo G5_IMG_URL ?>/profile_noimg.png';">
                                    </div>
                                    <div class="view_tbl_name">
                                        <input type="hidden" id="v_mb_id" value="">
                                        <?php if($write_permit === true) { ?><a class="view_edit_btn xp100 mtop5" id="edit_btn">수정</a><?php } ?>
                                    </div>
                                </td>
                                <th class="x100">서비스구분</th>
                                <td class="x130" id="v_service_category"></td>
                                <th class="x100">성명</th>
                                <td class="x130" id="v_mb_name"></td>
                                <th class="x100">연락처</th>
                                <td class="talign_c" id="v_mb_hp"></td>
                            </tr>
                            <tr>
                                <th>활동현황</th>
                                <td class="talign_c" id="v_activity_status"></td>
                                <th>주민번호</th>
                                <td class="talign_c" id="v_security_number"></td>
                                <th>계약형태</th>
                                <td class="talign_c" id="v_contract_type"></td>
                            </tr>
                            <tr>
                                <th>팀구분</th>
                                <td class="talign_c" id="v_team_category"></td>
                                <th>프리미엄</th>
                                <td class="talign_c" id="v_premium_use"></td>
                                <th>입사일자</th>
                                <td class="talign_c" id="v_enter_date"></td>
                            </tr>
                            <tr>
                                <th>취약계층여부</th>
                                <td class="talign_c" id="v_vulnerable"></td>
                                <th>반려동물</th>
                                <td colspan="3" id="v_pet_use"></td>
                            </tr>
                            <tr>
                                <th>학력</th>
                                <td colspan="5" id="v_education_memo"></td>
                            </tr>
                            <tr>
                                <th>경력</th>
                                <td colspan="5" id="v_career_memo"></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td colspan="5" id="v_mb_addr"></td>
                            </tr>
                            <tr>
                                <th>비고</th>
                                <td colspan="5">
                                <div class="view_tbl_memo" id="v_mb_memo"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="view_top mtop20">
                    <h4 class="view_tit">제공인력 급여정보</h4>
                </div>
                <ul class="menu_box">
                    <li class="menu_list" id="menu_list_act"><a class="menu_list_btn">급여정보</a></li>
                    <li id="certificate_nav">
                        <a id="certificate_nav_btn">증명서</a>
                        <div class="certificate_nav_box"></div>
                    </li>
                </ul>
                <div class="view_box">
                    <table class="view_tbl">
                        <tbody>
                            <tr>
                                <th class="x100">4대보험</th>
                                <td class="x160" id="v_major4_insurance"></td>
                                <th class="x100">보험상실</th>
                                <td class="x160" id="v_loss_insurance"></td>
                                <th class="x100">퇴사일자</th>
                                <td id="v_quit_date"></td>
                            </tr>
                            <tr>
                                <th>급여</th>
                                <td id="v_basic_price"></td>
                                <th>표준월소득액</th>
                                <td colspan="3" id="v_monthly_income"></td>
                            </tr>
                            <tr>
                                <th>은행</th>
                                <td id="v_bank_name"></td>
                                <th>계좌번호</th>
                                <td id="v_bank_account"></td>
                                <th>예금주</th>
                                <td id="v_account_holder"></td>
                            </tr>
                            <tr>
                                <th>특이사항</th>
                                <td colspan="5">
                                    <div class="view_tbl_memo" id="v_mb_memo2"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- View Wrap END -->

        </div>
        <!-- List & View Wrap END -->

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
let write_ajax;
$(function(){
    $(document).on('change', '.filter_select', function(){
        list_act();
    });

    $(document).on('keyup', '.filter_input', function(){
        list_act();
    });

    // 제공인력등록 버튼 클릭시 제공인력등록 팝업 띄우기
    $(document).on('click', '#write_btn', function(){
        // Layer Popup : 제공인력등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/member_write.php");

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

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

    // 이미지 삭제버튼 클릭시
    $(document).on('click', '#profile_delete_btn', function(){
        $('#mb_profile_del').prop('checked', true);
        $("#profile_write_wrap > img").attr('src', '');
        $('#mb_profile').val('');
    });

    // 저장버튼 클릭시
    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#branch_id').val() == '') {
            alert('지점을 선택해주세요');
            $('#branch_id').focus();
            return false;
        }

        if($('#service_category').val() == '') {
            alert('서비스구분을 선택해주세요');
            $('#service_category').focus();
            return false;
        }

        if($('#mb_name').val() == '') {
            alert('성명을 입력해주세요');
            $('#mb_name').focus();
            return false;
        }

        if($('#mb_hp').val() == '') {
            alert('연락처를 입력해주세요');
            $('#mb_hp').focus();
            return false;
        }

        if($('#security_number').val() == '') {
            alert('주민번호를 입력해주세요');
            $('#security_number').focus();
            return false;
        }

        if($('#security_number').val() != '') {
            let juminRule=/^(?:[0-9]{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[1,2][0-9]|3[0,1]))-[1-8][0-9]{6}$/;
            if(!juminRule.test($('#security_number').val())) {
                alert("주민번호를 형식에 맞게 입력해주세요");
                $('#security_number').focus();
                return false;
            }
        }

        if($('.contract_type').is(':checked') == false) {
            alert('계약형태를 선택해주세요');
            return false;
        }

        if($('#enter_date').val() == '') {
            alert('입사일자를 선택/입력해주세요');
            $('#enter_date').focus();
            return false;
        }

        if($('#basic_price').val() == '') {
            alert('급여를 입력해주세요');
            $('#basic_price').focus();
            return false;
        }

        if($('#monthly_income').val() == '') {
            alert('표준월소득액을 입력해주세요');
            $('#monthly_income').focus();
            return false;
        }

        if($('#activity_status').val() == '퇴사' && $('#quit_date').val() == '') {
            alert('활동현황이 퇴사일 경우 퇴사일자를 선택/입력해주셔야 합니다.');
            $('#quit_date').focus();
            return false;
        }

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/member_write_update.php',
            async: true,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리

                if($('#w').val() == '' && response.msg != '') {
                    alert(response.msg);
                }

                if(response.code == '0000') {
                    $('#layer_popup').empty();

                    list_act(response.mb_id);

                    $("#layer_popup").load(g5_bbs_url + "/member_write.php?w=u&mb_id=" + response.mb_id);
                }else{
                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });

    // 제공인력수정 버튼 클릭시 제공인력수정 팝업 띄우기
    $('#edit_btn').click(function(){
        // 제공인력 아이디 값
        let mb_id = $('#v_mb_id').val();
        // Layer Popup : 제공인력등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/member_write.php?w=u&mb_id=" + mb_id);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // 삭제버튼 클릭시
    $('#del_btn').click(function(){
        if(confirm('한번 삭제되면 복구가 불가능합니다.\n그래도 삭제하시겠습니까?')) {
            let mb_id = $('#v_mb_id').val();

            $.ajax({
                url: g5_bbs_url + '/ajax.member_delete.php',
                type: "POST",
                data: {'mb_id': mb_id},
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리

                    if(response.msg != '') {
                        alert(response.msg);
                    }
                    if(response.code == '0000') {
                        list_act('');
                    }else{
                        location.reload();
                    }
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        }

        return false;
    });

    $(document).on('click', '#member_list > tr', function(){
        let mb_id = $(this).attr('mb_id');

        $('#v_mb_id').val(mb_id);
        $('#member_list > tr').removeClass('list_selected');
        $(this).addClass('list_selected');

        view_act();
    });

    $('#certificate_nav_btn').click(function(){
        if($('.certificate_nav_box').css('display') == 'none') {
            $('.certificate_nav_box').css('display', 'block');
        }else{
            $('.certificate_nav_box').css('display', 'none');
        }
    });

    $(document).on('click', '.certificate_nav_list', function(){
        let mode = $(this).attr('mode');
        let mb_id = $('#v_mb_id').val();

        if(mode == 'quit') {
            window.open(g5_bbs_url + '/certificate.php?mode=' + mode + '&mb_id=' + mb_id, '', 'width=800px,height=700px,scrollbars=yes');
        }else{
            // Layer Popup : 제공인력등록 불러오기
            $("#layer_popup").load(g5_bbs_url + "/certificate_select.php?mode="+mode+"&mb_id=" + mb_id);

            // Layer Popup 보이기
            $('#layer_popup').removeClass();
            $('#layer_popup').addClass('certificate_select');
            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        }
    });

    $(document).on('click', '#certificate_submit_btn', function(){
        let mode = $('#mode').val();
        let mb_id = $('#mb_id').val();

        let security_number_set = '';
        if($('#security_number_set').length > 0) security_number_set = $('#security_number_set:checked').val();
        if(typeof security_number_set == 'undefined') security_number_set = '';

        let service_category_set = '';
        if($('#service_category_set').length > 0) service_category_set = $('#service_category_set').val();

        let usage_set = '';
        if($('#usage_set').length > 0) usage_set = $('#usage_set').val();

        let submit_to_set = '';
        if($('#submit_to_set').length > 0) submit_to_set = $('#submit_to_set').val();

        window.open(g5_bbs_url + '/certificate.php?mode=' + mode + '&mb_id=' + mb_id + '&security_number_set=' + security_number_set + '&service_category_set=' + service_category_set + '&usage_set=' + usage_set + '&submit_to_set=' + submit_to_set, '', 'width=800px,height=700px,scrollbars=yes');

        // Layer Popup 초기화
        $('#layer_popup').empty();
        $('#layer_popup').removeClass();
        $('#layer_popup').addClass('x1050');

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $('#excel_download_btn').click(function(){
        let sch_activity_status = $('#sch_activity_status option:selected').val();
        let sch_service_category = $('#sch_service_category option:selected').val();
        let sch_mb_name = $('#sch_mb_name').val();

        window.location.href = g5_bbs_url + '/member_excel_download.php?activity_status=' + sch_activity_status + '&service_category=' + sch_service_category + '&mb_name=' + sch_mb_name;
    });

    $('html').click(function(e){
        if($(e.target).attr('id') != 'certificate_nav_btn'){
            $('.certificate_nav_box').css('display', 'none');
        }
    });
});

// 리스트 추출
function list_act(mb_id) {
    // 리스트 스크롤 초기화(맨 위로 이동)
    $(".list_wrap > .list_box").animate({ scrollTop: 0 }, 0);

    let sch_activity_status = '';
    let sch_service_category = '';
    let sch_mb_name = '';

    sch_activity_status = $('#sch_activity_status option:selected').val();
    sch_service_category = $('#sch_service_category option:selected').val();
    sch_mb_name = $('#sch_mb_name').val();

    $.ajax({
        url: g5_bbs_url + '/ajax.member_list.php',
        type: "POST",
        data: {'sch_activity_status': sch_activity_status, 'sch_service_category': sch_service_category, 'sch_mb_name': sch_mb_name, 'mb_id': mb_id},
        dataType: "json",
        success: function(response) {
            // 전송이 성공한 경우 받는 응답 처리

            $('#member_list').empty();
            let datas = '';
            let list_selected = '';
            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    list_selected = '';
                    if(response[i].list_selected == 'y') {
                        list_selected = 'list_selected';

                        $('#v_mb_id').val(response[i].mb_id);
                    }

                    datas += '<tr class="' + list_selected + '" mb_id="' + response[i].mb_id + '">';
                    datas += '<td class="left_list_numb">' + (i+1) + '</td>';
                    datas += '<td class="left_list_status">' + response[i].activity_status + '</td>';
                    datas += '<td class="left_list_name">' + response[i].mb_name + '</td>';
                    datas += '<td class="left_list_gender">' + response[i].gender + '</td>';
                    datas += '<td class="left_list_birth">' + response[i].birthday + '</td>';
                    datas += '<td class="left_list_date">' + response[i].enter_date + '</td>';
                    datas += '</tr>';
                }

                $('#member_list').append(datas);
            }

            view_act();
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}

function view_act() {
    // 제공인력 아이디 값 불러오기
    let mb_id = $('.list_selected').attr('mb_id');

    $('#v_mb_id').val(mb_id);

    $('#profile_wrap > img').attr('src', g5_url + '/img/profile_noimg.png');
    $('#v_service_category').html('');
    $('#v_mb_name').html('');
    $('#v_mb_hp').html('');
    $('#v_activity_status').html('');
    $('#v_security_number').html('');
    $('#v_contract_type').html('');
    $('#v_team_category').html('');
    $('#v_premium_use').html('');
    $('#v_enter_date').html('');
    $('#v_vulnerable').html('');
    $('#v_pet_use').html('');
    $('#v_mb_addr').html('');
    $('#v_mb_memo').html('');
    $('#v_major4_insurance').html('');
    $('#v_loss_insurance').html('');
    $('#v_quit_date').html('');
    $('#v_basic_price').html('');
    $('#v_monthly_income').html('');
    $('#v_bank_name').html('');
    $('#v_bank_account').html('');
    $('#v_account_holder').html('');
    $('#v_mb_memo2').html('');

    $('#v_education_memo').html('');
    $('#v_career_memo').html('');

    $.ajax({
        url: g5_bbs_url + '/ajax.member_view.php',
        type: "POST",
        data: {'mb_id': mb_id},
        dataType: "json",
        success: function(response) {
            if(response.v_mb_profile != '') $('#profile_wrap > img').attr('src', response.v_mb_profile);
            $('#v_mb_name').html(response.v_mb_name);
            $('#v_mb_hp').html(response.v_mb_hp);
            $('#v_security_number').html(response.v_security_number);
            $('#v_activity_status').html(response.v_activity_status);
            $('#v_contract_type').html(response.v_contract_type);
            $('#v_premium_use').html(response.v_premium_use);
            $('#v_service_category').html(response.v_service_category);
            $('#v_team_category').html(response.v_team_category);
            $('#v_vulnerable').html(response.v_vulnerable);
            $('#v_pet_use').html(response.v_pet_use);
            $('#v_mb_addr').html(response.v_mb_addr);
            $('#v_mb_memo').html(response.v_mb_memo);
            $('#v_major4_insurance').html(response.v_major4_insurance);
            $('#v_loss_insurance').html(response.v_loss_insurance);
            $('#v_enter_date').html(response.v_enter_date);
            $('#v_quit_date').html(response.v_quit_date);
            $('#v_bank_name').html(response.v_bank_name);
            $('#v_bank_account').html(response.v_bank_account);
            $('#v_account_holder').html(response.v_account_holder);
            $('#v_basic_price').html(response.v_basic_price);
            $('#v_monthly_income').html(response.v_monthly_income);
            $('#v_mb_memo2').html(response.v_mb_memo2);

            $('#v_education_memo').html(response.v_education_memo);
            $('#v_career_memo').html(response.v_career_memo);

            $('.certificate_nav_box').empty();

            if(typeof response.certificate != 'undefined' && response.certificate.length > 0) {
                for(let i=0; i<response.certificate.length; i++) {
                    $('.certificate_nav_box').append(response.certificate[i]);
                }
            }
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}

$(document).ready(function(){
    list_act('');
});
</script>