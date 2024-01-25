<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member_health.css?ver=2">', 0);
?>

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
            $set_sql = " select * from g5_member_health_set where set_hide = '' ";
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
                            <th class="x100">현황</th>
                            <th class="x120">직원명</th>
                            <th class="x60">성별</th>
                            <th class="x120">주민번호</th>
                            <th class="x120">서비스</th>
                            <th class="x100">계약형태</th>
                            <th class="x60">팀</th>
                            <th class="x140">입사일자</th>
                            <th class="x140">퇴사일자</th>
                            <th>건강검진</th>
                        </tr>
                    </thead>
                </table>

                <table class="list_tbl">
                    <tbody id="member_list"></tbody>
                </table>
            </div>
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

    $('.menu_list').click(function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

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

    $(document).on('hover', '.member_health_write_cell', function(){
        let mb_id = $(this).attr('mb_id');
        $('.member_health_write_cell').removeClass('cell_hover');
        $('.member_health_write_cell').filter('[mb_id="' + mb_id + '"]').addClass('cell_hover');
    });

    $(document).on('mouseleave', '.member_health_write_cell', function(){
        $('.member_health_write_cell').removeClass('cell_hover');
    });

    $(document).on('click', '.member_health_write_btn', function(){
        let set_idx = $(this).attr('set_idx');
        let mb_id = $(this).attr('mb_id');
        let heal_idx = $(this).attr('heal_idx');
        let now_year = $('#now_year').val();
        let w = '';
        if(heal_idx != '') w = 'u';

        $("#layer_popup").load(g5_bbs_url + "/member_health_write.php?set_idx=" + set_idx + '&now_year=' + now_year + '&mb_id=' + mb_id + '&w=' + w + '&heal_idx=' + heal_idx);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '#popup_close_btn', function(){
        $('#layer_popup').empty();

        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#heal_date').val() == '') {
            alert('검진날짜를 선택/입력해주세요');
            $('#heal_date').focus();
            return false;
        }

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);

        write_ajax = $.ajax({
            url: g5_bbs_url + '/member_health_write_update.php',
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
    let set_idx = $('#menu_list_act').attr('set_idx');
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        url: g5_bbs_url + "/ajax.member_health_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'set_idx': set_idx, 'now_year': now_year, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            console.log(response);

            $('#member_list').empty();

            let datas = '';

            if(response.length > 0) {
                let rowspan = '';
                for(let i=0; i<response.length; i++) {
                    rowspan = '';
                    if(response[i].set_count > 1) rowspan = 'rowspan="' + response[i].set_count + '"';

                    datas += '<tr class="member_health_write_cell" mb_id="' + response[i].mb_id + '">';
                    datas += '<td class="x60" ' + rowspan + '>' + (i+1) + '</td>';
                    datas += '<td class="x100" ' + rowspan + '>' + response[i].activity_status + '</td>';
                    datas += '<td class="x120" ' + rowspan + '>' + response[i].mb_name + '</td>';
                    datas += '<td class="x60" ' + rowspan + '>' + response[i].gender + '</td>';
                    datas += '<td class="x120" ' + rowspan + '>' + response[i].security_number + '</td>';
                    datas += '<td class="x120" ' + rowspan + '>' + response[i].service_category + '</td>';
                    datas += '<td class="x100" ' + rowspan + '>' + response[i].contract_type + '</td>';
                    datas += '<td class="x60" ' + rowspan + '>' + response[i].team_category + '</td>';
                    datas += '<td class="x140" ' + rowspan + '>' + response[i].enter_date + '</td>';
                    datas += '<td class="x140" ' + rowspan + '>' + response[i].quit_date + '</td>';
                    datas += '<td class="member_health_write_btn" set_idx="' + response[i].health[0].set_idx + '" mb_id="' + response[i].mb_id + '" heal_idx="' + response[i].health[0].heal_idx + '"><div><p>' + response[i].health[0].set_tit + '</p><p>' + response[i].health[0].heal_date + '</p></div></td>';
                    datas += '</tr>';

                    if(response[i].health.length > 1) {
                        for(let j=1; j<response[i].health.length; j++) {
                            datas += '<tr class="member_health_write_cell" mb_id="' + response[i].mb_id + '">';
                            datas += '<td class="member_health_write_btn" set_idx="' + response[i].health[j].set_idx + '" mb_id="' + response[i].mb_id + '" heal_idx="' + response[i].health[j].heal_idx + '"><div><p>' + response[i].health[j].set_tit + '</p><p>' + response[i].health[j].heal_date + '</p></div></td>';
                            datas += '</tr>';
                        }
                    }
                }
            }

            $('#member_list').append(datas);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act();
});
</script>
