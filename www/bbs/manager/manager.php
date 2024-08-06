<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/manager/manager.css?ver=2">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        
        <!-- List & View Wrap STR -->
        <div class="list_view_wrap">

            <!-- List Wrap STR -->
            <div class="list_wrap">
                <div class="list_top">
                    <div class="filter_box">
                        <select class="filter_select" id="sch_branch">
                            <option value="">지점</option>
                            <?php
                            $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_name asc ";
                            $branch_qry = sql_query($branch_sql);
                            $branch_num = sql_num_rows($branch_qry);
                            if($branch_num > 0) {
                                for($i=0; $branch_row = sql_fetch_array($branch_qry); $i++) {
                            ?>
                            <option value="<?php echo $branch_row['branch_id'] ?>"><?php echo $branch_row['branch_name'] ?></option>
                            <?php
                                }
                            }
                            ?>
                        </select>
                        <input type="text" class="filter_input" id="sch_mb_name" value="" placeholder="이름 조회">
                    </div>
                    <div class="btn_box">
                        <a class="list_top_btn" id="write_btn">매니저등록</a>
                    </div>
                </div>
                <div class="list_box">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="left_list_numb_mng">번호</th>
                                <th class="left_list_status_mng">현황</th>
                                <th class="left_list_name">매니저명</th>
                                <th class="left_list_branch_mng">지점</th>
                                <th class="left_list_birth_mng">생년월일</th>
                                <th class="left_list_date_mng">입사일자</th>
                                <th class="left_list_date_mng">퇴사일자</th>
                            </tr>
                        </thead>
                        <tbody id="manager_list"></tbody>
                    </table>
                </div>
            </div>
            <!-- List Wrap END -->

            <!-- View Wrap STR -->
            <div class="view_wrap">
                <div class="view_top">
                    <h4 class="view_tit">매니저 기본정보</h4>
                    <a class="view_del_btn" id="del_btn">삭제</a>
                </div>
                <div class="view_box">
                    <table class="view_tbl">
                        <tbody>
                            <tr>
                                <th class="x90">지점</th>
                                <td class="x100" id="v_branch_id"></td>
                                <th class="x90">성명</th>
                                <td class="x160">
                                    <div class="view_tbl_name">
                                        <span id="v_mb_name"></span>
                                        <input type="hidden" id="v_mb_id" value="">
                                        <a class="view_edit_btn" id="edit_btn">수정</a>
                                    </div>
                                </td>
                                <th class="x90">연락처</th>
                                <td class="x110 talign_c" id="v_mb_hp"></td>
                                <th class="x90">활동현황</th>
                                <td class="talign_c" id="v_activity_status"></td>
                            </tr>
                            <tr>
                                <th>아이디</th>
                                <td id="v_id"></td>
                                <th>주민번호</th>
                                <td class="talign_c" id="v_security_number"></td>
                                <th>입사일자</th>
                                <td class="talign_c" id="v_enter_date"></td>
                                <th>퇴사일자</th>
                                <td class="talign_c" id="v_quit_date"></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td colspan="7" id="v_addr"></td>
                            </tr>
                            <tr>
                                <th>비고</th>
                                <td colspan="7">
                                    <div class="view_tbl_memo" id="v_mb_memo"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="view_top mtop20">
                    <h4 class="view_tit">매니저 업무권한</h4>
                </div>

                <div id="v_management_wrap"></div>
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

    // 매니저등록 버튼 클릭시 매니저등록 팝업 띄우기
    $(document).on('click', '#write_btn', function(){
        // Layer Popup : 매니저등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/manager_write.php");

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('change', '.management_checkbox', function(){
        let parent = $(this).parent('li');
        let prev = parent.prevAll('li');

        if($(this).is(':checked') == true) {
            prev.find('input').prop('checked', true);
        }else{
            prev.find('input').prop('checked', false);
        }
    });

    $(document).on('change', '.management_checkbox_all', function(){
        let parent = $(this).parent('h4');
        let next = parent.next('div.form_tbl_wrap');

        if($(this).is(':checked') == true) {
            next.find('input').prop('checked', true);
        }else{
            next.find('input').prop('checked', false);
        }
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

        if($('#mb_name').val() == '') {
            alert('매니저 성명을 입력해주세요');
            $('#mb_name').focus();
            return false;
        }

        if($('#mb_hp').val() == '') {
            alert('연락처를 입력해주세요');
            $('#mb_hp').focus();
            return false;
        }

        if($('#mb_id').val() == '') {
            alert('아이디를 입력해주세요');
            $('#mb_id').focus();
            return false;
        }

        if($('#w').val() == '' && $('#mb_password').val() == '') {
            alert('비밀번호를 입력해주세요');
            $('#mb_password').focus();
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

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/manager_write_update.php',
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

                    $("#layer_popup").load(g5_bbs_url + "/manager_write.php?w=u&mb_id=" + response.mb_id);
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

    // 매니저수정 버튼 클릭시 매니저수정 팝업 띄우기
    $('#edit_btn').click(function(){
        // 매니저 아이디 값
        let mb_id = $('#v_mb_id').val();
        // Layer Popup : 매니저등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/manager_write.php?w=u&mb_id=" + mb_id);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // 삭제버튼 클릭시
    $('#del_btn').click(function(){
        if(confirm('한번 삭제되면 복구가 불가능합니다.\n그래도 삭제하시겠습니까?')) {
            let mb_id = $('#v_mb_id').val();

            $.ajax({
                url: g5_bbs_url + '/ajax.manager_delete.php',
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

    $(document).on('click', '#manager_list > tr', function(){
        let mb_id = $(this).attr('mb_id');

        $('#v_mb_id').val(mb_id);
        $('#manager_list > tr').removeClass('list_selected');
        $(this).addClass('list_selected');

        view_act();
    });
});

// 리스트 추출
function list_act(mb_id) {
    // 리스트 스크롤 초기화(맨 위로 이동)
    $(".list_wrap > .list_box").animate({ scrollTop: 0 }, 0);

    let sch_branch = '';
    let sch_mb_name = '';

    sch_branch = $('#sch_branch option:selected').val();
    sch_mb_name = $('#sch_mb_name').val();

    $.ajax({
        url: g5_bbs_url + '/ajax.manager_list.php',
        type: "POST",
        data: {'sch_branch': sch_branch, 'sch_mb_name': sch_mb_name, 'mb_id': mb_id},
        dataType: "json",
        success: function(response) {
            // 전송이 성공한 경우 받는 응답 처리

            $('#manager_list').empty();
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
                    datas += '<td class="left_list_numb_mng">' + (i+1) + '</td>';
                    datas += '<td class="left_list_status_mng">' + response[i].activity_status + '</td>';
                    datas += '<td class="left_list_name">' + response[i].mb_name + '</td>';
                    datas += '<td class="left_list_branch_mng">' + response[i].branch + '</td>';
                    datas += '<td class="left_list_birth_mng">' + response[i].birthday + '</td>';
                    datas += '<td class="left_list_date_mng">' + response[i].enter_date + '</td>';
                    datas += '<td class="left_list_date_mng">' + response[i].quit_date + '</td>';
                    datas += '</tr>';
                }

                $('#manager_list').append(datas);
            }

            view_act();
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}

// View 추출
function view_act() {
    // 매니저 아이디 값 불러오기
    let mb_id = $('.list_selected').attr('mb_id');

    $('#v_mb_id').val(mb_id);

    $('#v_branch_id').html('');
    $('#v_mb_name').html('');
    $('#v_mb_hp').html('');
    $('#v_activity_status').html('');
    $('#v_id').html('');
    $('#v_security_number').html('');
    $('#v_enter_date').html('');
    $('#v_quit_date').html('');
    $('#v_addr').html('');
    $('#v_mb_memo').html('');

    $('#v_management_wrap').empty();

    $.ajax({
        url: g5_bbs_url + '/ajax.manager_view.php',
        type: "POST",
        data: {'mb_id': mb_id},
        dataType: "json",
        success: function(response) {

            $('#v_branch_id').html(response.v_branch_id);
            $('#v_mb_name').html(response.v_mb_name);
            $('#v_mb_hp').html(response.v_mb_hp);
            $('#v_activity_status').html(response.v_activity_status);
            $('#v_id').html(response.v_id);
            $('#v_security_number').html(response.v_security_number);
            $('#v_enter_date').html(response.v_enter_date);
            $('#v_quit_date').html(response.v_quit_date);
            $('#v_addr').html(response.v_addr);
            $('#v_mb_memo').html(response.v_mb_memo);

            let management_datas = '';
            let rowspan = '';
            let management_code3 = '';
            let management_json = '';
            if(response.me_code1.length > 0) {
                for(let i=0; i<response.me_code1.length; i++) {
                    management_datas += '<h4 class="management_tit">'+response.me_code1[i].me_name+'</h4>';
                    if(response.me_code2[response.me_code1[i].me_code].length > 0) {
                        management_datas += '<div class="view_box">';
                        management_datas += '<table class="view_tbl">';
                        management_datas += '<tbody>';
                        for(let j=0; j<response.me_code2[response.me_code1[i].me_code].length; j++) {
                            rowspan = '';
                            if(response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code].length > 1) {
                                rowspan += 'rowspan="'+response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code].length+'"';
                            }

                            if(response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code].length > 0) {
                                for(let k=0; k<response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code].length; k++) {
                                    management_datas += '<tr>';
                                    if(k == 0) management_datas += '<th class="x120" '+rowspan+'>'+response.me_code2[response.me_code1[i].me_code][j].me_name+'</th>';
                                    management_datas += '<td class="x140">'+response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code][k].me_name+'</td>';
                                    management_datas += '<td>';
                                    management_code3 = '';
                                    if(response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code][k].me_code != '') management_code3 = response.me_code3[response.me_code2[response.me_code1[i].me_code][j].me_code][k].me_code;
                                    management_json = response.management[management_code3];
                                    if(Object.keys(management_json).length > 0) {
                                        management_datas += '<ul class="management_box">';
                                        $.each(response.management[management_code3], function(key, value){
                                            if(value != '') {
                                                management_datas += '<li class="management_list"><label class="permit">'+value+' 허용</label></li>';
                                            }
                                        });
                                        management_datas += '</ul>';
                                    }
                                    management_datas += '</td>';
                                    management_datas += '</tr>';
                                }
                            }
                        }
                        management_datas += '</tbody>';
                        management_datas += '</table>';
                        management_datas += '</div>';
                    }
                }
            }
            $('#v_management_wrap').append(management_datas);
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