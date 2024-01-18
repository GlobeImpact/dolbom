<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/work/work.css">', 0);
?>

<!-- 달력 API -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo G5_JS_URL ?>/jquery-ui.js"></script>

<!-- 다음주소 API -->
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js" async></script>

<div id="layer_wrap">
    <div id="layer_box">
        <div class="sub_wrap">
            <div class="sub_box">
                <div id="filter_wrap">
                    <div class="filter_box">
                        <label>접수기간</label>
                        <input type="text" id="filter_str_receipt_date" class="form_input x80" value="" oninput="autoHyphen3(this)" maxlength="10"><span>~</span>
                        <input type="text" id="filter_end_receipt_date" class="form_input x80" value="" oninput="autoHyphen3(this)" maxlength="10">
                    </div>
                    <div class="filter_box">
                        <label>신청인</label>
                        <input type="text" id="" class="form_input x100" value="">
                    </div>
                    <div class="filter_box">
                        <label>연락처</label>
                        <input type="text" id="" class="form_input x100" value="" oninput="autoHyphen(this)" maxlength="13">
                    </div>
                    <div class="filter_box">
                        <label>접수상태</label>
                        <select id="" class="form_select">
                            <option value="">전체</option>
                            <option value="">접수</option>
                            <option value="">종료</option>
                            <option value="">취소</option>
                        </select>
                    </div>
                </div>

                <div class="work_wrap">
                    <ul class="work_menu_box">
                        <li class="work_menu_list" id="menu_list_act">
                            <a class="work_menu_list_btn" href="<?php echo G5_BBS_URL ?>/work.php?this_code=<?php echo $_SESSION['this_code'] ?>">파견등록</a>
                        </li>
                        <li class="work_menu_list">
                            <a class="work_menu_list_btn" href="<?php echo G5_BBS_URL ?>/work_status.php?this_code=<?php echo $_SESSION['this_code'] ?>">파견현황</a>
                        </li>
                    </ul>
                    <div class="client_list_box">
                        <table class="client_list_hd_tbl">
                            <thead>
                                <tr>
                                    <th class="x56">접수</th>
                                    <th class="x90">접수일</th>
                                    <th class="x80">서비스구분</th>
                                    <th class="x150">서비스명</th>
                                    <th class="x130">서비스유형</th>
                                    <th class="x100">신청인</th>
                                    <th class="x110">연락처</th>
                                    <th class="x90">주민번호</th>
                                    <th class="x60">예정일</th>
                                    <th class="x60">출생일</th>
                                    <th class="x60">시작일</th>
                                    <th class="x60">종료일</th>
                                    <th class="x70">파견일수</th>
                                    <th class="x70">출산순위</th>
                                    <th class="x120">본인부담금</th>
                                </tr>
                            </thead>
                        </table>

                        <table class="client_list_tbl">
                            <tbody>
                                <?php for($i=0; $i<15; $i++) { ?>
                                <tr>
                                    <td class="x56">접수</td>
                                    <td class="x90">2024/02/02</td>
                                    <td class="x80">바우처</td>
                                    <td class="x150 talign_l">단태아 둘째(기본형)</td>
                                    <td class="x130 talign_l">둘째(기본형)</td>
                                    <td class="x100">황다혜</td>
                                    <td class="x110">010-1111-2222</td>
                                    <td class="x90">891116-2</td>
                                    <td class="x60">10/23</td>
                                    <td class="x60">10/24</td>
                                    <td class="x60">10/25</td>
                                    <td class="x60">10/26</td>
                                    <td class="x70">5</td>
                                    <td class="x70">둘째</td>
                                    <td class="x120 talign_r">1,038,000</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="work_box">
                        <div class="work_member_box">
                            <div class="work_member_top">
                                <div></div>
                                <div>
                                    <a class="set_btn">관리사 일정보기</a>
                                </div>
                            </div>
                            <div class="work_member_list">
                                <table class="work_member_list_hd_tbl">
                                    <thead>
                                        <tr>
                                            <th class="x60">파견</th>
                                            <th class="x100">성명</th>
                                            <th class="x50">팀</th>
                                            <th class="x110">연락처</th>
                                            <th class="x130">행정구역</th>
                                            <th class="x400 talign_l">특이사항</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="work_member_list_tbl">
                                    <tbody>
                                        <tr>
                                            <td class="x60"></td>
                                            <td class="x100">고민성</td>
                                            <td class="x50">1팀</td>
                                            <td class="x110">010-5555-5333</td>
                                            <td class="x130">부산시 수영구</td>
                                            <td class="x400 talign_l">다온근무 및 동래여성 인력센터 근무</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="work_link_box">
                            <div class="work_link_top">
                                <div>
                                    <a class="set_btn">기간연장</a>
                                    <a class="set_btn">일정추가</a>
                                </div>
                                <div>
                                    <a class="set_btn">파견관리사</a>
                                    <a class="set_btn">관리사교체</a>
                                </div>
                            </div>
                            <div class="work_link_list">
                                <table class="work_link_list_hd_tbl">
                                    <thead>
                                        <tr>
                                            <th>근태적용</th>
                                            <th>요일</th>
                                            <th>토요일/평일</th>
                                            <th>파견일</th>
                                            <th>도우미</th>
                                            <th>파견인원</th>
                                            <th>바우처</th>
                                            <th>유료</th>
                                            <th>근무시간</th>
                                            <th>아기</th>
                                            <th>장애우</th>
                                            <th>입주</th>
                                            <th>취학</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="work_link_list_tbl">
                                    <tbody>
                                        <tr>
                                            <td class="x60"></td>
                                            <td class="x100">고민성</td>
                                            <td class="x50">1팀</td>
                                            <td class="x110">010-5555-5333</td>
                                            <td class="x130">부산시 수영구</td>
                                            <td class="x400 talign_l">다온근무 및 동래여성 인력센터 근무</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                                                                                                            
    </div>
</div>

<script>
// 휴번폰 연락처 정규식
function autoHyphen(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

// 날짜 정규식
function autoHyphen3(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,4})(\d{0,2})(\d{0,2})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

// 숫자만 입력 정규식
function inputNum(id) {
    let element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
}

$(function(){
    $("#filter_str_receipt_date, #filter_end_receipt_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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