<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member.css?ver=2">', 0);
?>

<!-- 달력 API -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo G5_JS_URL ?>/jquery-ui.js"></script>

<!-- 다음지도 API -->
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=575b55abed8a1a6c4569d200321142b9&libraries=services"></script>

<!-- 다음주소 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" async></script>

<div id="layer_wrap">
    <div id="layer_box">

        <!-- List Wrap STR -->
        <div class="list_wrap">
            <div class="list_left">
                <div class="list_left_top">
                    <div class="list_left_filter_box">

                        <select class="filter_select" id="sch_activity_status">
                            <option value="">활동현황</option>
                            <option value="활동중">활동중</option>
                            <option value="보류">보류</option>
                            <option value="퇴사">퇴사</option>
                            <option value="휴직">휴직</option>
                        </select>

                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <option value="베이비시터">베이비시터</option>
                            <option value="청소">청소</option>
                            <option value="반찬">반찬</option>
                        </select>

                        <input type="text" class="filter_input" id="sch_mb_name" value="" placeholder="이름 조회">
                        
                    </div>
                    <a id="write_btn">제공인력등록</a>
                </div>
                <div class="list_left_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x45">번호</th>
                                <th class="x60">현황</th>
                                <th class="x80">직원명</th>
                                <th class="x90">서비스</th>
                                <th class="x40">팀</th>
                                <th>행정구역</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="list_left_list_box">
                        <table class="list_tbl">
                            <tbody id="mb_list"></tbody>
                        </table>
                    </div>
                </div>
                <div class="list_left_bottom">
                    <a class="excel_btn" id="member_excel_download_btn">엑셀 다운로드</a>
                </div>
            </div>
            <div class="list_view_box">
                <div class="list_view_top_box">
                <h4 class="view_tit">제공인력 기본정보</h4>
                <a id="del_btn">삭제</a>
                </div>
                <table class="view_tbl">
                    <tbody>
                        <tr>
                            <td class="x150 valign_top" rowspan="6">
                                <div id="profile_wrap">
                                    <img src="" onerror="this.src='<?php echo G5_IMG_URL ?>/profile_noimg.png';">
                                </div>
                                <div id="edit_box">
                                    <input type="hidden" id="v_mb_id" value="">
                                    <a id="edit_btn">수정</a>
                                </div>
                            </td>
                            <th class="x90">서비스구분</th>
                            <td class="x130" id="v_service_category"></td>
                            <th class="x90">성명</th>
                            <td class="x130" id="v_mb_name"></td>
                            <th class="x90">연락처</th>
                            <td id="v_mb_hp"></td>
                        </tr>
                        <tr>
                            <th>주민번호</th>
                            <td id="v_security_number"></td>
                            <th>활동현황</th>
                            <td id="v_activity_status"></td>
                            <th>계약형태</th>
                            <td id="v_contract_type"></td>
                        </tr>
                        <tr>
                            <th>팀구분</th>
                            <td id="v_team_category"></td>
                            <th>프리미엄</th>
                            <td id="v_premium_use"></td>
                            <th>입사일자</th>
                            <td id="v_enter_date"></td>
                        </tr>
                        <tr>
                            <th>취약계층여부</th>
                            <td id="v_vulnerable"></td>
                            <th>반려동물</th>
                            <td id="v_pet_use" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td colspan="5" id="v_mb_addr"></td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="5">
                                <div id="v_mb_memo"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <ul class="menu_box mtop20">
                    <li class="menu_list" id="menu_list_act"><a class="menu_list_btn">급여정보</a></li>
                    <li class="menu_list"><a class="menu_list_btn">교육정보</a></li>
                    <li class="menu_list"><a class="menu_list_btn">건강검진정보</a></li>

                    <li id="certificate_nav">
                        <a id="certificate_nav_btn">증명서</a>
                        <div class="certificate_nav_box"></div>
                    </li>
                </ul>

                <h4 class="view_tit mtop20">제공인력 급여정보</h4>
                <table class="view_tbl">
                    <tbody>
                        <tr>
                            <th class="x100">4대보험</th>
                            <td class="x110" id="v_major4_insurance"></td>
                            <th class="x90">보험상실</th>
                            <td class="x110" id="v_loss_insurance"></td>
                            <th class="x90">퇴사일자</th>
                            <td id="v_quit_date" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>급여</th>
                            <td id="v_basic_price"></td>
                            <th>표준월소득액</th>
                            <td colspan="5" id="v_monthly_income"></td>
                        </tr>
                        <tr>
                            <th>은행</th>
                            <td id="v_bank_name"></td>
                            <th>계좌번호</th>
                            <td id="v_bank_account"></td>
                            <th>예금주</th>
                            <td class="x110" id="v_account_holder"></td>
                            <th class="x90">예금주(기타)</th>
                            <td id="v_account_holder_etc"></td>
                        </tr>
                        <tr>
                            <th>특이사항</th>
                            <td colspan="7">
                                <div id="v_mb_memo2"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- List Wrap END -->

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup"></div>

<script>
$(function(){
    $('#write_btn').click(function(){
        $("#layer_popup").load(g5_bbs_url + "/member_write.php");

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $('#edit_btn').click(function(){
        let mb_id = $('#v_mb_id').val();
        $("#layer_popup").load(g5_bbs_url + "/member_write.php?w=u&mb_id=" + mb_id);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

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
                    console.log(response);

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

    $('#member_excel_download_btn').click(function(){
        let sch_activity_status = $('#sch_activity_status option:selected').val();
        let sch_service_category = $('#sch_service_category option:selected').val();
        let sch_mb_name = $('#sch_mb_name').val();

        window.location.href = g5_bbs_url + '/member_excel_download.php?activity_status=' + sch_activity_status + '&service_category=' + sch_service_category + '&mb_name=' + sch_mb_name;
    });

    $('#certificate_nav_btn').click(function(){
        if($('.certificate_nav_box').css('display') == 'none') {
            $('.certificate_nav_box').css('display', 'block');
        }else{
            $('.certificate_nav_box').css('display', 'none');
        }
    });
});
</script>

<!-- member_write JS -->
<script>
let write_ajax;

$(function(){
    $('html').click(function(e){
        if($(e.target).attr('id') != 'certificate_nav_btn'){
            $('.certificate_nav_box').css('display', 'none');
        }
    });

    $(document).on('click', '#popup_close_btn', function(){
        $('#layer_popup').empty();

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
    $(document).on('click', '#member_submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
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

        let juminRule=/^(?:[0-9]{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[1,2][0-9]|3[0,1]))-[1-8][0-9]{6}$/;
        if(!juminRule.test($('#security_number').val())) {
            alert("주민번호를 형식에 맞게 입력해주세요");
            $('#security_number').focus();
            return false;
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

        if($('#activity_status').val() == '퇴사' && $('#quit_date').val() == '') {
            alert('활동현황이 퇴사일 경우 퇴사일자를 선택/입력해주셔야 합니다.');
            $('#quit_date').focus();
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

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);
        formData.append("mb_profile", mb_profile);

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
                console.log(response);

                if(response.msg != '') {
                    alert(response.msg);
                }
                if(response.code == '0000') {
                    $('#layer_popup').empty();

                    list_act(response.mb_id);

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

    $('#sch_activity_status').change(function(){
        list_act('');
    });

    $('#sch_service_category').change(function(){
        list_act('');
    });

    $('#sch_mb_name').on('input', function(){
        list_act('');
    });

    $(document).on('click', '#mb_list > tr', function(){
        $('#mb_list > tr').removeClass('list_selected');
        $(this).addClass('list_selected');

        view_act();
    });

    $(document).on('click', '.certificate_nav_list', function(){
        let mode = $(this).attr('mode');
        let mb_id = $('#v_mb_id').val();
        
        window.open(g5_bbs_url + '/certificate.php?mode=' + mode + '&mb_id=' + mb_id, '', 'width=800px,height=700px,scrollbars=yes');
    });
});

// 휴번폰 연락처 정규식
function autoHyphen(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

//주민번호 정규식
function autoHyphen2(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,6})(\d{0,7})$/g, "$1-$2").replace(/(\-{1,2})$/g, "");
}

// 날짜 정규식
function autoHyphen3(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,4})(\d{0,2})(\d{0,2})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

// 숫자만 입력 정규식
function inputNum(id) {
    let element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
}

// 리스트 추출
function list_act(mb_id) {
    $(".list_left_list_box").animate({ scrollTop: 0 }, 0); 

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
            // console.log(response);

            $('#mb_list').empty();
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
                    datas += '<td class="x45 talign_c">' + (i+1) + '</td>';
                    datas += '<td class="x60 talign_c">' + response[i].activity_status + '</td>';
                    datas += '<td class="x80 talign_c">' + response[i].mb_name + '</td>';
                    datas += '<td class="x90 talign_c">' + response[i].service_category + '</td>';
                    datas += '<td class="x40 talign_c">' + response[i].team_category + '</td>';
                    datas += '<td class="talign_c">' + response[i].mb_addr + '</td>';
                    datas += '</tr>';
                }

                $('#mb_list').append(datas);
            }

            view_act();
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}

function view_act() {
    let mb_id = $('.list_selected').attr('mb_id');

    $('#v_mb_id').val(mb_id);
    $('#profile_wrap > img').attr('src', '');
    $('#v_mb_name').html('');
    $('#v_mb_hp').html('');
    $('#v_security_number').html('');
    $('#v_activity_status').html('');
    $('#v_contract_type').html('');
    $('#v_premium_use').html('');
    $('#v_service_category').html('');
    $('#v_team_category').html('');
    $('#v_pet_use').html('');
    $('#v_mb_addr').html('');
    $('#v_mb_memo').html('');
    $('#v_training_str_date1').html('');
    $('#v_training_str_date2').html('');
    $('#v_training_str_date3').html('');
    $('#v_training_str_date4').html('');
    $('#v_training_str_date5').html('');
    $('#v_training_str_date6').html('');
    $('#v_training_end_date1').html('');
    $('#v_training_end_date2').html('');
    $('#v_training_end_date3').html('');
    $('#v_training_end_date4').html('');
    $('#v_training_end_date5').html('');
    $('#v_training_end_date6').html('');
    $('#v_training_time1').html('');
    $('#v_training_time2').html('');
    $('#v_training_time3').html('');
    $('#v_training_time4').html('');
    $('#v_training_time5').html('');
    $('#v_training_time6').html('');
    $('#v_major4_insurance').html('');
    $('#v_loss_insurance').html('');
    $('#v_enter_date').html('');
    $('#v_quit_date').html('');
    //$('#v_bank_info').html('');
    $('#v_bank_name').html('');
    $('#v_bank_account').html('');
    $('#v_account_holder').html('');
    $('#v_account_holder_etc').html('');
    $('#v_vulnerable').html('');
    $('#v_basic_price').html('');
    $('#v_monthly_income').html('');
    $('#v_mb_memo2').html('');

    $.ajax({
        url: g5_bbs_url + '/ajax.member_view.php',
        type: "POST",
        data: {'mb_id': mb_id},
        dataType: "json",
        success: function(response) {
            console.log(response);

            $('#profile_wrap > img').attr('src', response.v_mb_profile);
            $('#v_mb_name').html(response.v_mb_name);
            $('#v_mb_hp').html(response.v_mb_hp);
            $('#v_security_number').html(response.v_security_number);
            $('#v_activity_status').html(response.v_activity_status);
            $('#v_contract_type').html(response.v_contract_type);
            $('#v_premium_use').html(response.v_premium_use);
            $('#v_service_category').html(response.v_service_category);
            $('#v_team_category').html(response.v_team_category);
            $('#v_pet_use').html(response.v_pet_use);
            $('#v_mb_addr').html(response.v_mb_addr);
            $('#v_mb_memo').html(response.v_mb_memo);
            $('#v_training_str_date1').html(response.v_training_str_date1);
            $('#v_training_str_date2').html(response.v_training_str_date2);
            $('#v_training_str_date3').html(response.v_training_str_date3);
            $('#v_training_str_date4').html(response.v_training_str_date4);
            $('#v_training_str_date5').html(response.v_training_str_date5);
            $('#v_training_str_date6').html(response.v_training_str_date6);
            $('#v_training_end_date1').html(response.v_training_end_date1);
            $('#v_training_end_date2').html(response.v_training_end_date2);
            $('#v_training_end_date3').html(response.v_training_end_date3);
            $('#v_training_end_date4').html(response.v_training_end_date4);
            $('#v_training_end_date5').html(response.v_training_end_date5);
            $('#v_training_end_date6').html(response.v_training_end_date6);
            $('#v_training_time1').html(response.v_training_time1);
            $('#v_training_time2').html(response.v_training_time2);
            $('#v_training_time3').html(response.v_training_time3);
            $('#v_training_time4').html(response.v_training_time4);
            $('#v_training_time5').html(response.v_training_time5);
            $('#v_training_time6').html(response.v_training_time6);
            $('#v_major4_insurance').html(response.v_major4_insurance);
            $('#v_loss_insurance').html(response.v_loss_insurance);
            $('#v_enter_date').html(response.v_enter_date);
            $('#v_quit_date').html(response.v_quit_date);
            //$('#v_bank_info').html(response.v_bank_info);
            $('#v_bank_name').html(response.v_bank_name);
            $('#v_bank_account').html(response.v_bank_account);
            $('#v_account_holder').html(response.v_account_holder);
            $('#v_account_holder_etc').html(response.v_account_holder_etc);
            $('#v_vulnerable').html(response.v_vulnerable);
            $('#v_basic_price').html(response.v_basic_price);
            $('#v_monthly_income').html(response.v_monthly_income);
            $('#v_mb_memo2').html(response.v_mb_memo2);

            $('.certificate_nav_box').empty();
            if(response.certificate.length > 0) {
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