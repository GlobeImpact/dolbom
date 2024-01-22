<?php
$edu_idx = $_GET['edu_idx'];

$sql = " select * from g5_member_education where edu_idx = '{$edu_idx}' ";
$view = sql_fetch($sql);

$set_sql = " select * from g5_member_education_set where set_idx = '{$view['set_idx']}' ";
$set_row = sql_fetch($set_sql);

$popup_tit = $set_row['set_tit'].' 조회';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <div class="layer_popup_form">
        <h4 class="layer_popup_tit"><?php echo $set_row['set_tit'] ?></h4>
        <table class="write_tbl">
            <tbody>
                <tr>
                    <th class="x100">교육일시</th>
                    <td class="x420">
                        <div class="td_flex_row">
                            <span>
                            <?php
                            echo $view['edu_date'].' '.$view['edu_str_hour'].':'.$view['edu_str_min'].' ~ '.$view['edu_end_hour'].':'.$view['edu_end_min'];
                            ?>
                            </span>
                            <a class="edit_btn edu_edit_btn" edu_idx="<?php echo $edu_idx ?>" set_idx="<?php echo $set_row['set_idx'] ?>">수정</a>
                            <a class="del_btn edu_del_btn" edu_idx="<?php echo $edu_idx ?>">삭제</a>
                        </div>
                    </td>
                    <th class="x100" rowspan="4">교육내용</th>
                    <td rowspan="5">
                        <div class="view_edu_content"><?php echo nl2br($view['edu_content']) ?></div>
                    </td>
                </tr>
                <tr>
                    <th>교육제목</th>
                    <td><?php echo $view['edu_tit'] ?></td>
                </tr>
                <tr>
                    <th>교육방법</th>
                    <td>
                        <div class="td_flex_row"><?php echo $view['edu_method'] ?></div>
                    </td>
                </tr>
                <tr>
                    <th class="h311">참석자</th>
                    <td class="h311 valign_top">
                        <div class="mb_select_list_box">
                            <?php
                            $edul_view_sql = " select b.mb_name, b.service_category from g5_member_education_list as a left join g5_member as b on b.mb_id = a.edul_mb_id where a.edu_idx = '{$edu_idx}' and b.mb_hide = '' ";
                            $edul_view_qry = sql_query($edul_view_sql);
                            $edul_view_num = sql_num_rows($edul_view_qry);
                            
                            if($edul_view_num > 0) {
                                for($i=0; $edul_view_row = sql_fetch_array($edul_view_qry); $i++) {
                            ?>
                            <a class="mb_select_list"><span><?php echo $edul_view_row['mb_name'] ?></span><span>(<?php echo $edul_view_row['service_category'] ?>)</span></a>
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