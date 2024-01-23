<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_complaints.css?ver=1">', 0);
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
                <input type="text" class="filter_input x120" id="sch_date" value="" placeholder="접수일자" readonly>
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="신청자명 입력">
                <a id="filter_submit">검색</a>
            </div>
        </div>

        <div class="list_wrap">
            <div class="list_box">
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
<div id="layer_popup"></div>

<script>
$(function(){
    $('#prev_year_btn, #next_year_btn').click(function(){
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

    $(document).on('click', '#popup_close_btn', function(){
        $('#layer_popup').empty();

        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });
});

function list_act() {
    let now_year = $('#now_year').val();
    let sch_date = $('#sch_date').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
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
            }else{
                datas += '<tr><td colspan="9">접수된 민원이 없습니다.</td></tr>';
            }

            $('#client_rental_list').append(datas);

            return false;
        }
    });
}
</script>

<script>
$(function(){
    $("#sch_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
        showOn: 'button',	// Input 오른쪽 위치에 버튼 생성
        buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif",	// Input 오른쪽 위치에 생성된 버튼의 이미지 경로
        buttonImageOnly: true,	// 버튼을 이미지로 사용할지 유무
        buttonText: "Select date",
        dateFormat: "yy-mm-dd",	// Form에 입력될 Date Type
        prevText: '이전 달',	// ◀ 에 마우스 오버하면 나타나는 타이틀
        nextText: '다음 달',	// ▶ 에 마우스 오버하면 나타나는 타이틀
        changeMonth: true,	// 월 SelectBox 형식으로 선택변경 유무
        changeYear: true,	// 년 SelectBox 형식으로 선택변경 유무
        showMonthAfterYear: true,	// 년도 다음에 월이 나타나게 할지 여부 ( true : 년 월 , false : 월 년 )
        showButtonPanel: true,	// UI 하단에 버튼 사용 유무
        monthNames :  [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
        monthNamesShort: [ "1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월" ],
        dayNames: ['일요일','월요일','화요일','수요일','목요일','금요일','토요일'],	// 요일에 마우스 오버하면 나타나는 타이틀
        dayNamesMin: ['일','월','화','수','목','금','토'],	// 요일 텍스트 값
        // 최소한의 날짜 조건 제한주기
        // new Date(년,월,일)
        // ex) 2016-02-10 이전의 날짜는 선택 안되도록 하려면 new Date(2016, 2-1, 10)
        // d : 일 , m : 월 , y : 년
        // +1d , -1d , +1m , -1m , +1y , -1y
        // ex) minDate: '-100d' 이런 방식도 가능
        minDate: new Date(2016, 2-1, 10),
        // 오늘을 기준으로 선택할 수 있는 최대한의 날짜 조건 제한주기
        // d : 일 , m : 월 , y : 년
        // +1d , -1d , +1m , -1m , +1y , -1y
        maxDate: '+5y',
        duration: 'fast', // 달력 나타나는 속도 ( Slow , normal , Fast )
        // [행(tr),열(td)]
        // [1,2] 이면 한줄에 2개의 월이 나타남
        numberOfMonths: [1,1],
        // 달력 Show/Hide 이벤트
        // 종류 : show , slideDown , fadeIn , blind , bounce , clip , drop , fold , slide ( '' 할경우 애니매이션 효과 없이 작동 )
        showAnim: 'slideDown',
        // 달력에서 좌우 선택시 이동할 개월 수
        stepMonths: 2,
        // 년도 범위 설정
        // minDate , maxDate 사용시 작동 안됨
        //yearRange: '2012:2020',
    });
});
</script>
