<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/head.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    define('G5_IS_COMMUNITY_PAGE', true);
    include_once(G5_THEME_SHOP_PATH.'/shop.head.php');
    return;
}
include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 달력 API -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo G5_JS_URL ?>/jquery-ui.js"></script>
<script>
let datepicker_option = {	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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
    minDate: new Date(2023, 2-2, 1),
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
    $(".date_api").datepicker(datepicker_option);
});
</script>

<!-- 다음지도 API -->
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=575b55abed8a1a6c4569d200321142b9&libraries=services"></script>

<!-- 다음주소 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" async></script>

<!-- 상단 시작 { -->
<div id="hd">
    <h1 id="hd_h1"><?php echo $g5['title'] ?></h1>
    <div id="skip_to_container"><a href="#container">본문 바로가기</a></div>

    <?php
    if(defined('_INDEX_')) { // index에서만 실행
        include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어
    }
    ?>
    <div id="tnb">
        <div>
            <h4><?php echo $g5['title'] ?></h4>
            <?php
            if($is_admin) {
            ?>
            <select class="form_select x140" id="this_branch_id">
                <option value="">지점선택</option>
                <?php
                $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_name asc, branch_id desc ";
                $branch_qry = sql_query($branch_sql);
                $branch_num = sql_num_rows($branch_qry);
                if($branch_num > 0) {
                    for($b=0; $branch_row = sql_fetch_array($branch_qry); $b++) {
                ?>
                <option value="<?php echo $branch_row['branch_id'] ?>" <?php echo ($branch_row['branch_id'] == $this_branch_id)?'selected':''; ?>><?php echo $branch_row['branch_name'] ?></option>
                <?php
                    }
                }
                ?>
            </select>
            <?php
            }
            ?>
        </div>
        <script>
        $(function(){
            $('#this_branch_id').change(function(){
                let this_branch_id = $(this).val();

                $.ajax({
                    url: g5_bbs_url + '/ajax.branch_change_admin.php',
                    type: "POST",
                    data: {'this_branch_id': this_branch_id},
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        window.location.reload();
                    },
                    error: function(error) {
                        // 전송이 실패한 경우 받는 응답 처리
                    }
                });
            });
        });
        </script>

        <?php $yoil = array("일","월","화","수","목","금","토"); ?>
        <p id="now_time"><?php echo date('Y년 m월 d일') ?> (<?php echo $yoil[date('w', strtotime(date('Y-m-d')))] ?>) <?php echo date('H:i') ?></p>

        <ul>
            <li><span>[<?php echo $_SESSION['this_branch_name'] ?>]</span> <span><?php echo $member['mb_name'] ?>님 로그인하였습니다.</span></li>
            <li>
                <a class="tnb_btn" href="">출퇴근관리</a>
                <a class="tnb_logout_btn" href="<?php echo G5_BBS_URL ?>/logout.php">로그아웃</a>
            </li>
        </ul>
    </div>
    <script>
        $(function(){
            let tnb_timer = setInterval(function(){
                $.ajax({
                    type : 'post',           // 타입 (get, post, put 등등)
                    url : g5_bbs_url + '/ajax.time.php',           // 요청할 서버url
                    async : true,            // 비동기화 여부 (default : true)
                    dataType : 'json',       // 데이터 타입 (html, xml, json, text 등등)
                    success : function(result) { // 결과 성공 콜백함수
                        $('#now_time').text(result);
                    },
                    error : function(request, status, error) { // 결과 에러 콜백함수
                        console.log(error)
                    }
                });
            }, 1000);
        });
    </script>
</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">

    <div id="container">