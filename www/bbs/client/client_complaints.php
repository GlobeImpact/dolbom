<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_complaints.css?ver=1">', 0);
?>

<input type="hidden" id="now_year" value="<?php echo date('Y') ?>">

<div id="layer_wrap">
    <div id="layer_box">

        <div class="filter_year_wrap">
            <div class="year_box">
                <a class="filter_year_btn" id="prev_year_btn" year="<?php echo (int) date('Y') - 1 ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_prev.png"></a>
                <span class="filter_year_tit"><?php echo date('Y') ?>년</span>
                <a class="filter_year_btn" id="next_year_btn" year="<?php echo (int) date('Y') + 1 ?>"><img src="<?php echo G5_IMG_URL ?>/arrow_next.png"></a>
            </div>
            <div class="filter_box">
                <input type="text" class="filter_input_date date_api" id="sch_date" value="" placeholder="접수일자" maxlength="10" oninput="autoHyphen3(this)">
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="신청자명 입력">
                <a class="filter_submit" id="filter_submit">검색</a>
            </div>
        </div>

        <div class="layer_list_wrap">
            <div class="layer_list_box">
                <table class="list_hd_tbl">
                    <thead>
                        <tr>
                            <th class="x60">번호</th>
                            <th class="x150">접수일자</th>
                            <th class="x180">상담구분</th>
                            <th class="x130">신청인</th>
                            <th class="x150">서비스</th>
                            <th class="x180">신청인 연락처</th>
                            <th class="x130">상태</th>
                            <th class="x130">조치일자</th>
                            <th>설정</th>
                        </tr>
                    </thead>
                </table>

                <table class="list_tbl">
                    <tbody id="client_complaints_list">
                        <?php for($i=0; $i<100; $i++) { ?>
                            <tr>
                                <td class="x60">1</td>
                                <td class="x150">2024-01-04</td>
                                <td class="x180">민원(제공인력변경)</td>
                                <td class="x130">우태하</td>
                                <td class="x150">베이비시터</td>
                                <td class="x180">010-5180-2446</td>
                                <td class="x130">접수</td>
                                <td class="x130">2024-01-05</td>
                                <td>
                                    <div class="btn_flex">
                                        <a class="edit_btn">수정</a>
                                        <a class="del_btn">삭제</a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bottom_wrap">
            <a class="write_btn" id="write_btn">민원등록</a>
        </div>

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
$(function(){
    $('#prev_year_btn, #next_year_btn, #take_date').click(function(){
        let year = $(this).attr('year');
        let prev_year = parseInt(year || 0) - 1;
        let next_year = parseInt(year || 0) + 1;
        
        $('.filter_year_tit').text(year + '년');
        $('#now_year').val(year);
        $('#prev_year_btn').attr('year', prev_year);
        $('#next_year_btn').attr('year', next_year);
        $('#sch_date').val('');

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

    $(document).on('click', '#write_btn', function(){
        let now_year = $('#now_year').val();
        $("#layer_popup").load(g5_bbs_url + "/client_complaints_write.php?now_year=" + now_year);

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    $(document).on('click', '#form_select_btn', function(){
        let idx = $('#comp_idx').val();
        let tit = '고객';
        $("#write_layer_popup").load(g5_bbs_url + "/client_select_form.php?idx=" + idx + "&tit=" + tit);

        $('#write_layer_popup').css('display', 'block');
        $('#write_layer_popup_bg').css('display', 'block');

        client_select_form_timer = setInterval(function(){
            client_select_form();
        }, 600);
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
        client_select_form();
    });
});

function list_act() {
    let now_year = $('#now_year').val();
    let sch_date = $('#sch_date').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        /*
        url: g5_bbs_url + "/ajax.client_complaints_list_all.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_value': sch_value, 'set_idx': set_idx},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){
            console.log(response);

            $('#client_rental_list').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<tr class="" comp_idx="' + response[i].comp_idx + '">';
                    datas += '<td class="x60">' + (i+1) + '</td>';
                    datas += '<td class="x200">' + response[i].set_tit + '</td>';
                    datas += '<td class="x200">' + response[i].rent_numb + '</td>';
                    datas += '<td class="x140">' + response[i].rent_date + '</td>';
                    datas += '<td class="x140">' + response[i].rent_name + '</td>';
                    datas += '<td class="x140">' + response[i].rent_return_date + '</td>';
                    datas += '<td class="x140">' + response[i].rent_return_name + '</td>';
                    datas += '<td class=""><div class="btn_flex">';
                    datas += '<a class="edit_btn" comp_idx="' + response[i].comp_idx + '">수정</a>';
                    datas += '<a class="del_btn" comp_idx="' + response[i].comp_idx + '">삭제</a>';
                    datas += '</div></td>';
                    datas += '</tr>';
                }
            }else{
                datas += '<tr><td colspan="9">접수된 민원이 없습니다.</td></tr>';
            }

            $('#client_rental_list').append(datas);

            return false;
        }
        */
    });
}

function client_select_form() {
    let comp_idx = $('#comp_idx').val();
    let sch_value2 = $('#sch_value2').val();

    $('.select_all_check').prop('checked', false);

    $.ajax({
        url: g5_bbs_url + "/ajax.client_select_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'comp_idx': comp_idx, 'sch_value2': sch_value2},  // HTTP 요청과 함께 서버로 보낼 데이터
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

            clearInterval(client_select_form_timer);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act('');
});
</script>
