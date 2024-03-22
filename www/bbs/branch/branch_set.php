<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/branch/branch_set.css?ver=3">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <div class="layer_list_wrap">
            <div class="branch_list_box" id="branch_list"></div>
        </div>

        <div class="bottom_wrap">
            <a class="write_btn" id="write_btn">지점등록</a>
        </div>
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x500"></div>

<script>
let write_ajax;

$(function(){
    // 민원등록 버튼 클릭시 민원등록 팝업 띄우기
    $(document).on('click', '#write_btn', function(){
        // Layer Popup : 민원등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/branch_set_write.php");

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // 민원등록/수정 저장하기 Submit
    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        // 상담구분 Required
        if($('#branch_name').val() == '') {
            alert('지점명을 입력해주세요');
            $('#branch_name').focus();
            return false;
        }

        if($('.branch_addr').length > 0) {
            let me_name = '';
            for(let mn = 0; mn < $('.branch_addr').length; mn++) {
                me_name = $('.branch_addr').eq(mn).attr('me_name');
                if($('.branch_addr').eq(mn).val() == '') {
                    alert(me_name+' 주소를 입력해주세요\n주소는 증명서 출력에 사용됩니다.');
                    $('.branch_addr').eq(mn).focus();
                    return false;
                }
            }
        }

        // FormData Set
        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        // Ajax Write Update
        write_ajax = $.ajax({
            url: g5_bbs_url + '/branch_set_write_update.php',
            async: true,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리

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
                    $("#layer_popup").load(g5_bbs_url + "/branch_set_write.php?w=u&branch_id=" + response.branch_id);
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

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });
});

function list_act() {
    $.ajax({
        url: g5_bbs_url + "/ajax.branch_set_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            console.log(response);

            $('#branch_list').empty();

            let datas = '';
            let menu10, menu20 = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    let menu10 = response[i].branch_menu10 == 'y' ? 'class="branch_menu_label_active"' : 'class="branch_menu_label"';
                    let menu20 = response[i].branch_menu20 == 'y' ? 'class="branch_menu_label_active"' : 'class="branch_menu_label"';

                    datas += '<div class="branch_list">';
                    datas += '<h3>'+response[i].branch_name+'</h3>';
                    datas += '<div class="flex_row mtop20">';
                    datas += '<label '+menu10+'>가사서비스</label>';
                    datas += '<label '+menu20+'>아가마지</label>';
                    datas += '</div>';
                    datas += '<div class="flex_row mtop10">';
                    datas += '<label class="list_tit">연락처</label>';
                    datas += '<span class="list_txt">'+response[i].branch_tel+'</span>';
                    datas += '</div>';
                    datas += '<div class="flex_row mtop10">';
                    datas += '<label class="list_tit">FAX</label>';
                    datas += '<span class="list_txt">'+response[i].branch_fax+'</span>';
                    datas += '</div>';
                    datas += '<div class="flex_row mtop10">';
                    datas += '<label class="list_tit">주소</label>';
                    datas += '<span class="list_txt">'+response[i].branch_addr+'</span>';
                    datas += '</div>';
                    /*
                    datas += '<div>';
                    if(response[i].me_name.length > 0) {
                        for(let j=0; j<response[i].me_name.length; j++) {
                            datas += '<p>';
                            datas += '<label>'+response[i].me_name[j]+'</label>';
                            datas += '<span>'+response[i].branch_addr[j]+'</span>';
                            datas += '</p>';
                        }
                    }
                    datas += '</div>';
                    */
                    datas += '<p class="edit_box">';
                    datas += '<a class="edit_btn" branch_id="'+response[i].branch_id+'">수정</a>';
                    datas += '</p>';
                    datas += '<a class="del_btn" branch_id="'+response[i].branch_id+'">삭제</a>';
                    datas += '</div>';
                }
            }else{
                datas += '<div class="branch_list branch_list_empty"><h3>등록된 지점이 없습니다.</h3></div>';
            }

            $('#branch_list').append(datas);

            return false;
        }
    });

    $(document).on('click', '.edit_btn', function(e){
        e.stopPropagation();

        let branch_id = $(this).attr('branch_id');
        
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup : 민원수정 불러오기
        $("#layer_popup").load(g5_bbs_url + "/branch_set_write.php?w=u&branch_id=" + branch_id);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '.del_btn', function(e){
        e.stopPropagation();

        let branch_id = $(this).attr('branch_id');
        if(confirm('한번 삭제되면 복구가 불가능합니다.\n그래도 삭제하시겠습니까?')) {
            $.ajax({
                url: g5_bbs_url + "/ajax.branch_set_delete.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
                data: {'branch_id': branch_id},  // HTTP 요청과 함께 서버로 보낼 데이터
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
}

$(document).ready(function(){
    list_act();
});
</script>