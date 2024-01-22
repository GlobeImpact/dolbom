<?php
$edu_idx = $_GET['edu_idx'];

$popup_tit = '참석자 리스트';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="write_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <input type="hidden" name="edu_idx" id="edu_idx" value="<?php echo $edu_idx ?>">

    <div class="layer_popup_form">
        <div class="filter_wrap">
            <div class="filter_box xp100">
                <input type="text" class="filter_input" id="sch_value2" value="" placeholder="이름 조회">
                <a id="filter_submit2">검색</a>
            </div>
        </div>

        <div class="edul_list_box">
            <table class="edul_list_hd_tbl">
                <thead>
                    <tr>
                        <th class="x45"><input type="checkbox" class="edul_all_check"></th>
                        <th class="x60">현황</th>
                        <th class="x80">직원명</th>
                        <th class="x90">서비스</th>
                        <th class="x40">팀</th>
                        <th>주민번호</th>
                    </tr>
                </thead>
            </table>

            <table class="edul_list_tbl">
                <tbody id="edul_list"></tbody>
            </table>

            <table class="edul_list_ft_tbl">
                <thead>
                    <tr>
                        <th class="xp100">
                            전체 : <span id="edul_tot"></span>명
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div>
        <a class="submit_btn" id="edul_submit_btn">참석자 선택완료</a>
    </div>
</div>

<script>
$(function(){
    $("#edu_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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