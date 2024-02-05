<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/send/send_history.css">', 0);
?>

<input type="hidden" id="now_year" value="<?php echo date('Y') ?>">

<div id="layer_wrap">
    <div id="layer_box">
        
        <div class="filter_year_wrap">
            <div class="year_box">
                <a class="filter_year_btn" id="prev_year_btn" year="<?php echo (int) date('Y') - 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_prev.png">
                </a>
                <span class="filter_year_tit"><?php echo date('Y') ?>년</span>
                <a class="filter_year_btn" id="next_year_btn" year="<?php echo (int) date('Y') + 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_next.png">
                </a>
            </div>
            <div class="filter_box">
                <input type="text" class="filter_input" id="sch_value" value="" oninput="autoHyphen(this)" placeholder="휴대폰번호 입력" maxlength="13">
                <a class="filter_submit" id="filter_submit">검색</a>
            </div>
        </div>

        <div class="layer_list_wrap">
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl">
                    <thead>
                        <tr>
                            <th class="layer_list_numb">번호</th>
                            <th class="layer_list_sms_category">분류</th>
                            <th class="layer_list_name">성명</th>
                            <th class="layer_list_tel">연락처</th>
                            <th class="layer_list_booking">예약</th>
                            <th class="layer_list_date">예약일자</th>
                            <th class="">내용</th>
                            <th class="layer_list_date">접수일자</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl">
                    <tbody id="send_history_list">
                        <tr>
                            <td class="layer_list_numb"></td>
                            <td class="layer_list_sms_category"></td>
                            <td class="layer_list_name"></td>
                            <td class="layer_list_tel"></td>
                            <td class="layer_list_booking"></td>
                            <td class="layer_list_date"></td>
                            <td class=""></td>
                            <td class="layer_list_date"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
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
        // 년도 Data 변경될 경우 검색 : 접수일자 초기화
        $('#sch_date').val('');

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
        list_act();
    });
});

// 민원 리스트 불러오기
function list_act() {
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        url: g5_bbs_url + "/ajax.send_history_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(response){

            $('#send_history_list').empty();

            let datas = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    datas += '<tr class="view_btn" idx="' + response[i].idx + '">';
                    datas += '<td class="layer_list_numb">' + (i+1) + '</td>';
                    datas += '<td class="layer_list_sms_category">' + response[i].sms_category + '</td>';
                    datas += '<td class="layer_list_name">' + response[i].recv_name + '</td>';
                    datas += '<td class="layer_list_tel">' + response[i].recv_hp + '</td>';
                    datas += '<td class="layer_list_booking">' + response[i].booking + '</td>';
                    datas += '<td class="layer_list_date">' + response[i].booking_date + '</td>';
                    datas += '<td class=""><div class="sms_message_box">' + response[i].send_message + '</div></td>';
                    datas += '<td class="layer_list_date">' + response[i].reg_date + '</td>';
                    datas += '</tr>';
                }
            }else{
                datas += '<tr><td class="not_list" colspan="8">전송된 문자 내역이 없습니다.</td></tr>';
            }

            $('#send_history_list').append(datas);

            return false;
        }
    });
}

$(document).ready(function(){
    list_act();
});
</script>
