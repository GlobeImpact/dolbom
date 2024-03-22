<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/service_period/service_period.css?ver=3">', 0);

$now_year = date('Y');
?>

<input type="hidden" id="now_year" value="<?php echo $now_year ?>">

<div id="layer_wrap">
    <div id="layer_box">
        
        <!-- Year Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="year_box">
                <a class="filter_year_btn" id="prev_year_btn" year="<?php echo (int) $now_year - 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_prev.png">
                </a>
                <span class="filter_year_tit"><?php echo $now_year ?>년</span>
                <a class="filter_year_btn" id="next_year_btn" year="<?php echo (int) $now_year + 1 ?>">
                    <img src="<?php echo G5_IMG_URL ?>/arrow_next.png">
                </a>
            </div>
            <div class="filter_box">
                <a class="filter_submit" id="copy_btn">금액 불러오기</a>
            </div>
        </div>
        <!-- Year Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <?php
                $sme_sql = " select distinct(`client_service`) from g5_service_menu where sme_use = 1 order by sme_order asc, sme_code asc ";
                $sme_qry = sql_query($sme_sql);
                $sme_num = sql_num_rows($sme_qry);
                if($sme_num > 0) {
                    for($m=0; $sme_row = sql_fetch_array($sme_qry); $m++) {
                ?>
                <li class="menu_list" client_service="<?php echo $sme_row['client_service'] ?>" <?php echo ($m == 0)?'id="menu_list_act"':''; ?>><a class="menu_list_btn"><?php echo $sme_row['client_service'] ?></a></li>
                <?php
                    }
                } 
                ?>
            </ul>

            <!-- Layer Form Wrap STR -->
            <div class="layer_list_box" id="layer_form_box"></div>
            <!-- Layer Form Wrap END -->

            <div class="bottom_wrap">
                <a class="submit_btn" id="submit_btn">저장하기</a>
            </div>

        </div>
        <!-- Layer List Wrap END -->

    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="copy_layer"></div>

<script>
let write_ajax;
$(function(){
    // 이전 년도(◀) , 다음 년도(▶) 클릭시
    $('#prev_year_btn, #next_year_btn').click(function(){
        // 현재 년도 Data 불러오기
        let year = $(this).attr('year');
        // 이전 년도
        let prev_year = parseInt(year || 0) - 1;
        // 다음 년도
        let next_year = parseInt(year || 0) + 1;
        
        // 현재 년도 텍스트 출력
        $('.filter_year_tit').text(year + '년');
        // 현재 년도 Data 적용
        $('#now_year').val(year);
        // 이전 년도 Data 적용
        $('#prev_year_btn').attr('year', prev_year);
        // 다음 년도 Data 적용
        $('#next_year_btn').attr('year', next_year);

        // 리스트 불러오기
        list_act();
    });

    // 메뉴 선택시 해당 메뉴 활성화 & 리스트 불러오기
    $('.menu_list').click(function(){
        $('.menu_list').removeAttr('id');
        $(this).attr('id', 'menu_list_act');

        list_act();
    });

    // 저장버튼 클릭시
    $(document).on('click', '#submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        var formData = $("#fregisterform").serialize();

        if(confirm('정말 서비스 금액을 저장하시겠습니까?')) {
            write_ajax = $.ajax({
                url: g5_bbs_url + '/service_price_update.php',
                type: "POST",
                data: formData,
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    console.log(response);

                    if(response.msg != '') {
                        alert(response.msg);
                    }

                    if(response.code == '0000') {
                        list_act();
                    }else{
                        location.reload();
                    }
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        }
    });

    $(document).on('click', '#copy_btn', function(){
        // Layer Popup : 제공인력등록 불러오기
        $("#layer_popup").load(g5_bbs_url + "/service_period_price_load.php");

        // Layer Popup 보이기
        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });

    // Layer Popup 닫기 버튼 클릭시 Layer Popup 초기화 + 숨기기
    $(document).on('click', '#popup_close_btn', function(){
        // Layer Popup 초기화
        $('#layer_popup').empty();

        // Layer Popup 숨기기
        $('#layer_popup').css('display', 'none');
        $('#layer_popup_bg').css('display', 'none');
    });

    $(document).on('change', '#copy_branch_id', function(){
        let branch_id = $(this).val();
        let branch_name = $('#copy_branch_id option:selected').attr('branch_name');
        
        $('#copy_branch').text(branch_name);

        $.ajax({
            url: g5_bbs_url + '/ajax.service_period_copy_year_call.php',
            type: "POST",
            data: {'branch_id': branch_id},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                console.log(response);

                $('#copy_year').empty();

                let datas = '';
                datas += '<option value="">년도 선택</option>';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        datas += '<option value="'+response[i].year+'">'+response[i].year+'</option>';
                    }
                }

                $('#copy_year').append(datas);
                /*
                if(response.msg != '') {
                    alert(response.msg);
                }
                if(response.code == '0000') {
                    list_act('');
                }else{
                    location.reload();
                }
                */
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });

    // 불러오기 저장버튼 클릭시
    $(document).on('click', '#copy_submit_btn', function(){
        if (typeof write_ajax !== 'undefined') {
            write_ajax.abort(); // 비동기 실행취소
        }

        if($('#copy_branch_id').val() == '') {
            alert('지점을 선택해주세요');
            return false;
        }

        if($('#copy_year').val() == '') {
            alert('년도를 선택해주세요');
            return false;
        }

        if($("input:checkbox[name='service_category_arr[]']:checked").length == 0) {
            alert('서비스를 선택해주세요');
            return false;
        }

        $('#paste_year').val($('#now_year').val());

        var formData = $("#copyform").serialize();

        write_ajax = $.ajax({
            url: g5_bbs_url + '/service_price_copy.php',
            type: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                console.log(response);

                if(response.msg != '') {
                    alert(response.msg);
                }

                if(response.code == '0000') {
                    // Layer Popup 초기화
                    $('#layer_popup').empty();

                    // Layer Popup 숨기기
                    $('#layer_popup').css('display', 'none');
                    $('#layer_popup_bg').css('display', 'none');

                    list_act();
                }else{
                    location.reload();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    });
});

// 리스트 추출
function list_act() {
    let now_year = $('#now_year').val();
    let client_service = '';
    if($('#menu_list_act').length > 0) client_service = $('#menu_list_act').attr('client_service');

    $("#layer_form_box").load(g5_bbs_url + "/service_period_write.php?now_year=" + now_year + "&client_service=" + client_service);
}

$(document).ready(function(){
    list_act();
});
</script>