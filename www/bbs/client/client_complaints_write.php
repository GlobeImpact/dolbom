<?php
$w = $_GET['w'];
$idx = $_GET['idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$popup_tit = $set_row['set_tit'].' 민원등록';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 민원수정';

if($w == '') {
    $write['comp_date'] = $now_year.'-'.date('m-d');
}

if($w == 'u' && $idx != '') {
    $sql = " select * from g5_client_complaints where idx = '{$idx}' ";
    $write = sql_fetch($sql);
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">

        <div class="layer_popup_form">
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th>상담구분</th>
                        <td>
                            <div class="td_flex_row">
                                <select name="" id=""></select>
                            </div>
                        </td>
                        <th>조치구분</th>
                        <td>
                            <div class="td_flex_row">
                                <select name="" id=""></select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>고객선택</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                        <th>조치일자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>상담내용</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                        <th>조치내용</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>비고</th>
                        <td colspan="3">
                            <div class="td_flex_row">
                                <textarea name="take_etc" id="take_etc" class="form_textarea"><?php echo $write['take_etc'] ?></textarea>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<div id="write_layer_popup_bg"></div>
<div id="write_layer_popup"></div>

<script>
$(function(){
    $("#comp_date, #rent_return_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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