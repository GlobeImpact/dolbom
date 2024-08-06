<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/pay/pay_ledger.css">', 0);

$sch_ym = $_GET['sch_ym'];
?>

<script>
let datepicker_option2 = {	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
    // showOn: 'button',	// Input 오른쪽 위치에 버튼 생성
    // buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif",	// Input 오른쪽 위치에 생성된 버튼의 이미지 경로
    buttonImageOnly: false,	// 버튼을 이미지로 사용할지 유무
    buttonText: "Select date",
    dateFormat: "yy-mm",	// Form에 입력될 Date Type
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
    minDate: new Date(1990, 2-2, 1),
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
};
$(function(){
    $(".date_api2").datepicker(datepicker_option2);
});
</script>

<div id="layer_wrap">
    <div id="layer_box">

        <?php
        $menu_sql = " select * from g5_menu where me_code like '{$_SESSION['this_code']}{$mn_cd}%' and length(me_code) = 6 and me_use = 1 order by me_order asc, me_code asc ";
        $menu_qry = sql_query($menu_sql);
        $menu_num = sql_num_rows($menu_qry);
        if($menu_num > 0) {
        ?>
        <ul class="menu_box">
            <?php
            for($m=0; $menu_row = sql_fetch_array($menu_qry); $m++) {
            ?>
            <li class="menu_list" <?php echo ("{$_SESSION['this_code']}{$mn_cd2}" == $menu_row['me_code'])?'id="menu_list_act"':''; ?>><a class="menu_list_btn" href="<?php echo $menu_row['me_link'] ?>?this_code=<?php echo $_SESSION['this_code'] ?>" target="_<?php echo $menu_row['me_target'] ?>"><?php echo $menu_row['me_name'] ?></a></li>
            <?php
            }
            ?>
        </ul>
        <?php
        }
        ?>

        <div class="sub_wrap">
            <!-- Filter Layer STR -->
            <div class="filter_year_wrap">
                <div class="filter_box">
                    <label>귀속년월</label>
                    <input type="text" class="filter_input_date date_api2" id="sch_ym" value="<?php echo $sch_ym ?>" maxlength="7" oninput="autoHyphen3(this)" placeholder="귀속년월">
                </div>
            </div>
            <!-- Filter Layer END -->

            <!-- Layer List Wrap STR -->
            <div class="layer_list_wrap layer_list_wrap_flex_column">
                <div class="layer_list_top">
                    <div></div>
                    <div>
                        <a class="set_btn">급여명세서출력</a>
                    </div>
                </div>
                <div class="layer_list_box">
                    <table class="layer_list_hd_tbl width_max">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="collect_all_check" value="all"></th>
                                <th>관리사</th>
                                <th>주민등록번호</th>
                                <th>생년월일</th>
                                <th>팀구분</th>
                                <th>급여총액</th>
                                <th>실수령액</th>
                                <th>건강보험</th>
                                <th>국민연금</th>
                                <th>고용보험</th>
                                <th>장기요양</th>
                                <th>갑근세</th>
                                <th>주민세</th>
                                <th>회비</th>
                                <th>상조비</th>
                                <th>가입비</th>
                                <th>소득세</th>
                                <th>공제합계액</th>
                                <th>은행</th>
                                <th>계좌번호</th>
                                <th>예금주</th>
                                <th>비고</th>
                                <th>월 근무시간</th>
                                <th>월 근무일수</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Layer List Wrap END -->
        </div>
    </div>
</div>

<script>
    $(function(){
    });
</script>