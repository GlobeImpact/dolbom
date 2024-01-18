<?php
$popup_tit = '고객접수등록';
if($w == 'u') $popup_tit = '고객접수수정';
?>

<script>
$(function(){
    $("#mb_name, #enter_date, #training_str_date1, #training_str_date2, #training_str_date3, #training_str_date4, #training_str_date5, #training_str_date6, #training_end_date1, #training_end_date2, #training_end_date3, #training_end_date4, #training_end_date5, #training_end_date6, #major4_insurance, #loss_insurance, #quit_date").datepicker({	// UI 달력을 사용할 Class / Id 를 콤마(,) 로 나누어서 다중으로 가능
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

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="w" value="">
    <input type="hidden" name="prev_mb_id" value="">

        <h4 class="layer_tit">고객접수 기본정보</h4>

        <table class="layer_tbl">
            <tbody>
                <tr>
                    <th class="x100">접수일자</th>
                    <td>
                        <input type="text" name="mb_name" id="mb_name" class="form_input x80" maxlength="10" value="">
                    </td>
                    <th class="x100">신청인</th>
                    <td>
                        <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="">
                    </td>
                    <th class="x100">바우처</th>
                    <td>
                        <select name="activity_status" id="activity_status" class="form_select">
                            <option value="">바우처</option>
                            <option value="바우처#1">바우처#1</option>
                            <option value="바우처#2">바우처#2</option>
                            <option value="바우처#3">바우처#3</option>
                            <option value="바우처#4">바우처#4</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>주민번호</th>
                    <td>
                        <input type="text" name="security_number" id="security_number" class="form_input x130" oninput="autoHyphen2(this)" maxlength="14" value="">
                    </td>
                    <th>연락처</th>
                    <td>
                        <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="">
                    </td>
                    <th>긴급연락처</th>
                    <td>
                        <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="">
                    </td>
                </tr>
                <tr>
                    <th>주소</th>
                    <td colspan="5">
                        <div class="div_flex">
                            <input type="text" name="mb_zip" value="" id="reg_mb_zip" class="form_input" size="5" maxlength="6"  placeholder="우편번호">
                            <button type="button" class="btn_frm_addr" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">주소 검색</button>

                            <input type="text" name="mb_addr1" value="" id="reg_mb_addr1" class="form_input frm_address full_input" placeholder="기본주소">
                            <input type="text" name="mb_addr2" value="" id="reg_mb_addr2" class="form_input frm_address full_input" placeholder="상세주소">
                            <input type="hidden" name="mb_addr3" value="" id="reg_mb_addr3">
                            <input type="hidden" name="mb_addr_jibeon" value="">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>출산유형</th>
                    <td>
                        <select name="activity_status" id="activity_status" class="form_select">
                            <option value="자연분만">자연분만</option>
                            <option value="수술">수술</option>
                        </select>
                    </td>
                    <th>출산예정일</th>
                    <td>
                        <input type="text" name="major4_insurance" id="major4_insurance" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                    </td>
                    <th>출산일</th>
                    <td>
                        <input type="text" name="loss_insurance" id="loss_insurance" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                    </td>
                </tr>
                <tr>
                    <th>시작일자</th>
                    <td>
                        <input type="text" name="training_str_date1" id="training_str_date1" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                    </td>
                    <th>종료일자</th>
                    <td>
                        <input type="text" name="training_str_date2" id="training_str_date2" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                    </td>
                    <th>취소일자</th>
                    <td>
                        <input type="text" name="training_str_date3" id="training_str_date3" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                    </td>
                </tr>
                <tr>
                    <th>취소사유</th>
                    <td colspan="5">
                        <textarea name="mb_memo" id="mb_memo" class="form_textarea"></textarea>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="layer_flex mbottom70">
            <div>
                <h4 class="layer_tit mtop20">고객접수 서비스정보</h4>

                <table class="layer_tbl">
                    <tbody>
                        <tr>
                            <th class="x100">서비스구분</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">서비스구분</option>
                                    <option value="바우처">바우처</option>
                                    <option value="유료">유료</option>
                                    <option value="프리랜서">프리랜서</option>
                                    <option value="기타">기타</option>
                                </select>
                            </td>
                            <th class="x100">출산아기</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">단태아</option>
                                    <option value="바우처">쌍생아</option>
                                    <option value="유료">삼태아이상</option>
                                    <option value="프리랜서">장애아</option>
                                </select>
                            </td>
                            <th class="x100">아기성별</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">여자</option>
                                    <option value="바우처">남자</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="x100">큰아들돌보기</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">없음</option>
                                    <option value="필요">필요</option>
                                </select>
                            </td>
                            <th class="x100">출산순위</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">첫째</option>
                                    <option value="필요">둘째</option>
                                </select>
                            </td>
                            <th class="x100">추가요금부담</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">불가능</option>
                                    <option value="필요">가능</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>취학/미취학</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">취학선택</option>
                                    <option value="필요">가능</option>
                                </select>

                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">미취학선택</option>
                                    <option value="필요">가능</option>
                                </select>
                            </td>
                            <th>프리미엄</th>
                            <td colspan="3">
                                <label for="aaa">
                                    <input type="checkbox" name="aaa" id="aaa"> 프리미엄
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th>단가구분</th>
                            <td>
                                <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="">
                            </td>
                            <th>합계금액</th>
                            <td colspan="3">
                                <input type="text" name="mb_hp" id="mb_hp" class="form_input x130" oninput="autoHyphen(this)" maxlength="13" value="">
                            </td>
                        </tr>
                        <tr>
                            <th>대여물품</th>
                            <td colspan="5">
                                <label for=""><input type="checkbox" name="" id="">유축기</label>
                                <label for=""><input type="checkbox" name="" id="">좌욕기</label>
                            </td>
                        </tr>
                        <tr>
                            <th>추가요청사항</th>
                            <td colspan="5">
                                <textarea name="mb_memo2" id="mb_memo2" class="form_textarea"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="flex:1 1 0%; margin-left:8px;">
                <h4 class="layer_tit mtop20">고객접수 관리사정보</h4>

                <table class="layer_tbl">
                    <tbody>
                        <tr>
                            <th class="x100">지정 관리사</th>
                            <td>
                                <button type="button" class="btn_frm_addr" onclick="win_zip('fregisterform', 'mb_zip', 'mb_addr1', 'mb_addr2', 'mb_addr3', 'mb_addr_jibeon');">관리사 선택</button>
                                <div style="margin-top:8px;">
                                    <a class="btn_frm_addr" style="border:1px solid #1469b9; border-radius:4px; background:#6d9ac4;">
                                        홍길동
                                    </a>
                                    <a class="btn_frm_addr" style="border:1px solid #1469b9; border-radius:4px; background:#6d9ac4;">
                                        홍길동1
                                    </a>
                                    <a class="btn_frm_addr" style="border:1px solid #1469b9; border-radius:4px; background:#6d9ac4;">
                                        홍길동2
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="x100">파견 관리사</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">홍길동</option>
                                    <option value="필요">홍길동1</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th class="x100">변경 관리사</th>
                            <td>
                                <select name="activity_status" id="activity_status" class="form_select">
                                    <option value="">홍길동</option>
                                    <option value="필요">홍길동1</option>
                                </select>

                                <input type="text" name="major4_insurance" id="major4_insurance" class="form_input x80" oninput="autoHyphen3(this)" maxlength="10" value="">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="submit_wrap">
            <a class="member_submit_btn">저장하기</a>
        </div>

    </form>

</div>

<script>
let imageFile;

$(function(){
    $('#profile_write_btn').click(function(){
        $('#mb_profile').click();
    });

    $("#mb_profile").change(function(event){
        const file = event.target.files;
        imageFile = event.target.files[0];

        var image = new Image();
        var ImageTempUrl = window.URL.createObjectURL(file[0]);

        $("#profile_write_wrap > img").attr('src', ImageTempUrl);
    });

    $('#profile_delete_btn').click(function(){
        $('#mb_profile_del').prop('checked', true);
        $("#profile_write_wrap > img").attr('src', '');
        $('#mb_profile').val('');
    });

    $('.member_submit_btn').click(function(){
        if($('#mb_name').val() == '') {
            alert('성명을 입력해주세요');
            $('#mb_name').focus();
            return false;
        }

        if($('#mb_hp').val() == '') {
            alert('연락처를 입력해주세요');
            $('#mb_hp').focus();
            return false;
        }

        if($('#security_number').val() == '') {
            alert('주민번호를 입력해주세요');
            $('#security_number').focus();
            return false;
        }

        let juminRule=/^(?:[0-9]{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[1,2][0-9]|3[0,1]))-[1-8][0-9]{6}$/;
        if(!juminRule.test($('#security_number').val())) {
            alert("주민번호를 형식에 맞게 입력해주세요");
            $('#security_number').focus();
            return false;
        }

        if($('#contract_type1').is(':checked') == false && $('#contract_type2').is(':checked') == false) {
            alert('계약형태를 선택해주세요');
            return false;
        }

        if($('#enter_date').val() == '') {
            alert('입사일자를 선택해주세요');
            $('#enter_date').focus();
            return false;
        }

        if($('#mb_id').val() == '') {
            alert('아이디를 입력해주세요');
            $('#mb_id').focus();
            return false;
        }

        if($('#w').val() == '') {
            if($('#mb_password').val() == '') {
                alert('비밀번호를 입력해주세요');
                $('#mb_password').focus();
                return false;
            }

            if($('#mb_password_re').val() == '') {
                alert('비밀번호 확인을 입력해주세요');
                $('#mb_password_re').focus();
                return false;
            }

            if($('#mb_password').val() != $('#mb_password_re').val()) {
                alert('비밀번호와 비밀번호 확인이 불일치합니다.');
                $('#mb_password').focus(); 
                return false;
            }
        }else{
            if($('#mb_password').val() != '' && $('#mb_password_re').val() == '') {
                alert('비밀번호 확인을 입력해주세요');
                $('#mb_password_re').focus();
                return false;
            }

            if($('#mb_password').val() != '' && $('#mb_password_re').val() != '') {
                if($('#mb_password').val() != $('#mb_password_re').val()) {
                    alert('비밀번호와 비밀번호 확인이 불일치합니다.');
                    $('#mb_password').focus();
                    return false;
                }
            }
        }

        if($('#basic_price').val() == '') {
            alert('기본급을 입력해주세요');
            $('#basic_price').focus();
            return false;
        }

        if($('#monthly_income').val() == '') {
            alert('표준월소득액을 입력해주세요');
            $('#monthly_income').focus();
            return false;
        }

        let writeForm = document.getElementById("fregisterform");
        let formData = new FormData(writeForm);
        formData.append("mb_profile", imageFile);

        $.ajax({
            url: g5_bbs_url + '/work_write_update.php',
            async: true,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                console.log(response);
                if(response.code == '0000') {
                    alert(response.msg);
                    $('#fregisterform')[0].reset();
                    $('#layer_popup').css('display', 'none');
                    $('#layer_popup_bg').css('display', 'none');
                    list_act();
                    view_act('', response.mb_id);
                }else{
                    alert(response.msg);
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    });
});

function autoHyphen(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,3})(\d{0,4})(\d{0,4})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

function autoHyphen2(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,6})(\d{0,7})$/g, "$1-$2").replace(/(\-{1,2})$/g, "");
}

function autoHyphen3(target) {
    target.value = target.value.replace(/[^0-9]/g, '').replace(/^(\d{0,4})(\d{0,2})(\d{0,2})$/g, "$1-$2-$3").replace(/(\-{1,2})$/g, "");
}

function inputNum(id) {
    let element = document.getElementById(id);
    element.value = element.value.replace(/[^0-9]/gi, "");
}
</script>