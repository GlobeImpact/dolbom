<?php
$w = $_GET['w'];
$set_idx = $_GET['set_idx'];
$edu_idx = $_GET['edu_idx'];
$now_year = $_GET['now_year'];
if(!$now_year) $now_year = date('Y');

$set_sql = " select * from g5_member_education_set where set_idx = '{$set_idx}' ";
$set_row = sql_fetch($set_sql);

$popup_tit = $set_row['set_tit'].' 작성';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 수정';

if($w == '') {
    $write['edu_date'] = $now_year.'-'.date('m-d');
    $write['edu_tit'] = $set_row['set_tit'];
}

if($w == 'u' && $edu_idx != '') {
    $sql = " select * from g5_member_education where edu_idx = '{$edu_idx}' ";
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
        <input type="hidden" name="edu_idx" id="edu_idx" value="<?php echo $edu_idx ?>">

        <div class="layer_popup_form">
            <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
            <table class="write_tbl">
                <tbody>
                    <tr>
                        <th class="x100">교육일시<span class="required_txt">*</span></th>
                        <td class="x420">
                            <div class="td_flex_row">
                                <input type="text" name="edu_date" id="edu_date" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="<?php echo $write['edu_date'] ?>">

                                <select name="edu_str_hour" id="edu_str_hour" class="form_select x50">
                                    <?php
                                    for($h=0; $h<24; $h++) {
                                        $h_val = $h;
                                        if($h < 10) $h_val = '0'.$h_val;
                                    ?>
                                    <option value="<?php echo $h_val ?>" <?php echo ($h_val == $write['edu_str_hour'])?'selected':''; ?>><?php echo $h_val ?></option>
                                    <?php
                                    }
                                    ?>
                                </select> : 
                                <select name="edu_str_min" id="edu_str_min" class="form_select x50">
                                    <?php
                                    for($m=0; $m<60; $m++) {
                                        $m_val = $m;
                                        if($m < 10) $m_val = '0'.$m_val;
                                    ?>
                                    <option value="<?php echo $m_val ?>" <?php echo ($m_val == $write['edu_str_min'])?'selected':''; ?>><?php echo $m_val ?></option>
                                    <?php
                                    }
                                    ?>
                                </select> ~ 
                                <select name="edu_end_hour" id="edu_end_hour" class="form_select x50">
                                    <?php
                                    for($h=0; $h<24; $h++) {
                                        $h_val = $h;
                                        if($h < 10) $h_val = '0'.$h_val;
                                    ?>
                                    <option value="<?php echo $h_val ?>" <?php echo ($h_val == $write['edu_end_hour'])?'selected':''; ?>><?php echo $h_val ?></option>
                                    <?php
                                    }
                                    ?>
                                </select> : 
                                <select name="edu_end_min" id="edu_end_min" class="form_select x50">
                                    <?php
                                    for($m=0; $m<60; $m++) {
                                        $m_val = $m;
                                        if($m < 10) $m_val = '0'.$m_val;
                                    ?>
                                    <option value="<?php echo $m_val ?>" <?php echo ($m_val == $write['edu_end_min'])?'selected':''; ?>><?php echo $m_val ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </td>
                        <th class="x100" rowspan="4">교육내용</th>
                        <td rowspan="5">
                            <textarea name="edu_content" id="edu_content" class="form_textarea hp100"><?php echo $write['edu_content'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>교육제목<span class="required_txt">*</span></th>
                        <td>
                            <input type="text" name="edu_tit" id="edu_tit" class="form_input xp100" value="<?php echo $write['edu_tit'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>교육방법<span class="required_txt">*</span></th>
                        <td>
                            <div class="td_flex_row">
                                <?php
                                for($l=0; $l<count($set_edu_method_arr); $l++) {
                                    $edu_method_checked = '';
                                    if($l == 0) {
                                        if($write['edu_method'] == '') $edu_method_checked = 'checked';
                                    }else{
                                        if($write['edu_method'] == $set_edu_method_arr[$l]) $edu_method_checked = 'checked';
                                    }
                                ?>
                                <label class="input_label" for="edu_method<?php echo $l ?>">
                                    <input type="radio" name="edu_method" class="contract_type" id="edu_method<?php echo $l ?>" value="<?php echo $set_edu_method_arr[$l] ?>" <?php echo $edu_method_checked ?>><?php echo $set_edu_method_arr[$l] ?>
                                </label>
                                <?php
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="h311">참석자<br><a id="mb_select_btn">참석자선택</a></th>
                        <td class="h311 valign_top">
                            <div class="mb_select_list_box">
                                <?php
                                $edul_sql = " select b.mb_id, b.mb_name, b.service_category from g5_member_education_list as a left join g5_member as b on b.mb_id = a.edul_mb_id where a.edu_idx = '{$edu_idx}' and b.mb_hide = '' ";
                                $edul_qry = sql_query($edul_sql);
                                $edul_num = sql_num_rows($edul_qry);
                                if($edul_num > 0) {
                                    for($i=0; $edul_row = sql_fetch_array($edul_qry); $i++) {
                                ?>
                                <input type="hidden" name="edul_mb_id[]" value="<?php echo $edul_row['mb_id'] ?>">
                                <a class="mb_select_list"><span><?php echo $edul_row['mb_name'] ?></span><span>(<?php echo $edul_row['service_category'] ?>)</span></a>
                                <?php
                                    }
                                }
                                ?>
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