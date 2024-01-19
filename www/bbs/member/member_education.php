<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/member/member_education.css?ver=2">', 0);
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
                <input type="text" class="filter_input" id="sch_value" value="" placeholder="교육명 및 강사명 입력">
                <a id="filter_submit">검색</a>
            </div>
        </div>

        <div class="member_education_list_wrap">
            <div class="member_education_list_box">
                <?php for($i=0; $i<3; $i++) { ?>
                <div class="member_education_list">
                    <p>보수교육</p>
                    <ul>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                        <li>
                            <label class="member_education_list_numb">1</label>
                            <div class="member_education_list_data">
                                <p class="member_education_list_date">2024-01-19</p>
                                <p class="member_education_list_tit">가나다라마바사</p>
                                <p class="member_education_list_counting">100 / 90 / 10</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="bottom_wrap">
            <a class="write_btn">보수교육 작성</a>
            <a class="write_btn">아동학대교육 작성</a>
            <a class="write_btn">교육 리스트 추가</a>
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

        button_act();
        list_act();
    });

    $('#sch_value').on("keyup",function(key){
        if(key.keyCode == 13){
            $('#filter_submit').click();
        }
    });

    $('#filter_submit').click(function(){
        button_act();
        list_act();
    });
});

function button_act() {
    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_button.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(rst){
            console.log(rst);
            /*
            if(rst.code == '0000') {
                alert('온라인 사전신청이 완료되었습니다.');
            }else if(rst.code == '1111') {
                alert('이미 온라인 사전신청을 하였습니다.');
            }else{
                alert('온라인 사전신청에 실패하였습니다.');
            }
            */
            return false;
        }
    });
}

function list_act() {
    let now_year = $('#now_year').val();
    let sch_value = $('#sch_value').val();

    $.ajax({
        url: g5_bbs_url + "/ajax.member_education_list.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'now_year': now_year, 'sch_value': sch_value},  // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST",   // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입
        success: function(rst){
            console.log(rst);
            /*
            if(rst.code == '0000') {
                alert('온라인 사전신청이 완료되었습니다.');
            }else if(rst.code == '1111') {
                alert('이미 온라인 사전신청을 하였습니다.');
            }else{
                alert('온라인 사전신청에 실패하였습니다.');
            }
            */
            return false;
        }
    });
}

$(document).ready(function(){
    list_act();
});
</script>