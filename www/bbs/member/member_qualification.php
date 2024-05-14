<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member_qualification.css?ver=2">', 0);

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
                $set_sql = " select * from g5_member_qualification_set where set_hide = '' order by set_idx asc ";
                $set_qry = sql_query($set_sql);
                $set_num = sql_num_rows($set_qry);
                if($set_num > 0) {
                    for($m=0; $set_row = sql_fetch_array($set_qry); $m++) {
                ?>
                <li class="menu_list" set_idx="<?php echo $set_row['set_idx'] ?>"><a class="menu_list_btn"><?php echo $set_row['set_tit'] ?></a></li>
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
                    <thead></thead>
                </table>

                <table class="layer_list_tbl">
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="qualification"></div>

<script>
let write_ajax;

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

        // 리스트 불러오기
        list_act();
    });

    // 메뉴 선택시 해당 메뉴 활성화 & 리스트 불러오기
    $('.menu_list').click(function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

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
    // 등록/수정 버튼 클릭시 등록/수정 팝업 띄우기
    $(document).on('click', '.write_btn', function(){
        // 현재 년도 Data 불러오기
        let now_year = $('#now_year').val();
        // 회원 아이디 Data 불러오기
        let mb_id = $(this).attr('mb_id');
        // 메뉴 Data 불러오기
        let set_idx = $(this).attr('set_idx');
        // Index Data 불러오기
        let idx = $(this).attr('idx');
        let w = '';
        if(idx != '') w = 'u';

        // Layer Popup : 민원등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/member_qualification_write.php?w=" + w + "&idx=" + idx + "&now_year=" + now_year + "&mb_id=" + mb_id + "&set_idx=" + set_idx);

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    // 등록/수정 저장하기 Submit
    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        // FormData Set
        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        // Ajax Write Update
        write_ajax = $.ajax({
            url: g5_bbs_url + '/member_qualification_write_update.php',
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

                    // Layer Popup 숨기기
                    $('#layer_popup').css('display', 'none');
                    $('#layer_popup_bg').css('display', 'none');
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

    // 엑셀 다운로드 버튼 클릭시
    $('#excel_download_btn').click(function(){
        let now_year = $('#now_year').val();
        let sch_value = $('#sch_value').val();
        let set_idx = '';
        if($('#menu_list_act').length > 0) set_idx = $('#menu_list_act').attr('set_idx');

        window.location.href = g5_bbs_url + '/member_qualification_excel_download.php?now_year=' + now_year + '&sch_value=' + sch_value + '&set_idx=' + set_idx;
    });
});

function list_act() {
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();
    let set_idx = '';
    if($('#menu_list_act').length > 0) set_idx = $('#menu_list_act').attr('set_idx');

    $.ajax({
        url: g5_bbs_url + "/ajax.member_qualification_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'set_idx': set_idx, 'now_year': now_year, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            $('.layer_list_hd_tbl > thead').empty();
            if(typeof response.hd != 'undefined') {
                $('.layer_list_hd_tbl > thead').append(response.hd);
            }

            let cell_width_value = '';

            let datas = '';
            $('.layer_list_tbl > tbody').empty();
            if(response.list.length > 0) {
                for(let i=0; i<response.list.length; i++) {
                    cell_width_value = '';

                    datas += '<tr>';

                    if(set_idx == '') {
                        datas += '<td class="layer_list_numb">'+(i+1)+'</td>';
                        datas += '<td class="layer_list_activity_status">'+response.list[i].activity_status+'</td>';
                        datas += '<td class="layer_list_name">'+response.list[i].mb_name+'</td>';
                        datas += '<td class="layer_list_date">'+response.list[i].birthday+'</td>';
                        datas += '<td class="layer_list_date">'+response.list[i].enter_date+'</td>';

                        cell_width_value = 'style="width:'+response.cell_width+'px;"';
                    }else{
                        datas += '<td class="layer_list_numb">'+(i+1)+'</td>';
                        datas += '<td class="layer_list_activity_status">'+response.list[i].activity_status+'</td>';
                        datas += '<td class="layer_list_name">'+response.list[i].mb_name+'</td>';
                        datas += '<td class="layer_list_date">'+response.list[i].birthday+'</td>';
                        datas += '<td class="layer_list_date">'+response.list[i].enter_date+'</td>';
                        datas += '<td class="layer_list_tel">'+response.list[i].mb_hp+'</td>';
                        datas += '<td class="layer_list_service_category">'+response.list[i].service_category+'</td>';
                        datas += '<td class="layer_list_status">'+response.list[i].contract_type+'</td>';
                        datas += '<td class="layer_list_numb">'+response.list[i].team_category+'</td>';
                    }

                    if(response.cell_count > 0) {
                        for(let j=0; j<response.cell_count; j++) {
                            datas += '<td class="write_btn" mb_id="'+response.list[i].mb_id+'" set_idx="'+response.list[i].qualification[j].set_idx+'" idx="'+response.list[i].qualification[j].idx+'" '+cell_width_value+'>';

                            datas += '<div class="qualification_box">';
                            datas += '<label>진단일자</label>';
                            datas += '<p>'+response.list[i].qualification[j].diagnosis_date+'</p>';
                            datas += '</div>';
                            
                            datas += '<div class="qualification_box">';
                            datas += '<label>판정일자</label>';
                            datas += '<p>'+response.list[i].qualification[j].judgment_date+'</p>';
                            datas += '</div>';
                            
                            datas += '<div class="qualification_box">';
                            datas += '<label>확인일자</label>';
                            datas += '<p>'+response.list[i].qualification[j].confirm_date+'</p>';
                            datas += '</div>';

                            datas += '</td>';
                        }
                    }

                    datas += '</tr>';
                }
            }
            $('.layer_list_tbl > tbody').append(datas);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act();
});
</script>
