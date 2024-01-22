<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];
$rent_idx = $_GET['rent_idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$set_sql = " select * from g5_client_rental_set where set_idx = '{$set_idx}' ";
$set_row = sql_fetch($set_sql);

$popup_tit = $set_row['set_tit'].' 대여등록';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 대여수정';

if($w == '') {
    $write['rent_date'] = $now_year.'-'.date('m-d');
}

if($w == 'u' && $rent_idx != '') {
    $sql = " select * from g5_client_rental where rent_idx = '{$rent_idx}' ";
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
        <input type="hidden" name="set_idx" id="set_idx" value="<?php echo $set_idx ?>">
        <input type="hidden" name="rent_idx" id="rent_idx" value="<?php echo $rent_idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th>대여품 번호</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_numb" id="rent_numb" class="form_input x150" value="<?php echo $write['rent_numb'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">대여기간<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_date" id="rent_date" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['rent_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">대여자<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <input type="hidden" name="rent_mb_id" id="rent_mb_id" value="<?php echo $write['rent_mb_id'] ?>">
                                <input type="text" name="rent_name" id="rent_name" class="form_input x80" value="<?php echo $write['rent_name'] ?>">
                                <a id="mb_select_btn">대여자선택</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">반납기간</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="text" name="rent_return_date" id="rent_return_date" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['rent_return_date'] ?>">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="x100">반납자</th>
                        <td>
                            <div class="td_flex_row">
                                <input type="hidden" name="rent_return_mb_id" id="rent_return_mb_id" value="<?php echo $write['rent_return_mb_id'] ?>">
                                <input type="text" name="rent_return_name" id="rent_return_name" class="form_input x80" value="<?php echo $write['rent_return_name'] ?>">
                                <a id="mb_select_btn2">반납자선택</a>
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
    $("#rent_date, #rent_return_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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