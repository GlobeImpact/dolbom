<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/20.client.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <div class="sub_wrap">
            <!-- Left Menu STR -->
            <div class="list_wrap">
                <div class="list_wrap_top">
                    <div class="list_filter_box">
                        <input type="checkbox" id="sch_premium">
                        <label class="filter_label" for="sch_premium">프리미엄</label>
                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <option value="바우처">바우처</option>
                            <option value="유료">유료</option>
                            <option value="프리랜서">프리랜서</option>
                            <option value="기타">기타</option>
                        </select>
                        <input type="text" id="sch_cl_name" class="filter_input" value="" placeholder="이름 조회">
                    </div>
                    <a id="write_btn">고객등록</a>
                </div>

                <div class="list_wrap_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x45">번호</th>
                                <th class="x100">신청인</th>
                                <th class="x130">연락처</th>
                                <th class="x110">접수일자</th>
                                <th>현황</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="list_wrap_list_box">
                        <table class="list_tbl">
                            <tbody id="client_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Left Menu END -->

            <!-- Client View Layer STR -->
            <input type="hidden" id="v_client_idx" value="">
            <div class="sub_box">
                <h4 class="layer_tit">고객접수 기본정보</h4>

                <table class="layer_tbl">
                    <tbody>
                        <tr>
                            <th class="x90">접수일자</th>
                            <td class="x160" id="v_receipt_date"></td>
                            <th class="x90">시작일자</th>
                            <td id="v_str_date"></td>
                            <th class="x90">종료일자</th>
                            <td class="x115" id="v_end_date"></td>
                            <th class="x90">취소일자</th>
                            <td class="x115" id="v_cancel_date"></td>
                        </tr>
                        <tr>
                            <th>신청인</th>
                            <td>
                                <div class="v_cl_name_wrap">
                                    <span id="v_cl_name"></span>
                                    <a id="edit_btn">수정</a>
                                </div>
                            </td>
                            <th>주민번호</th>
                            <td id="v_cl_security_number"></td>
                            <th>연락처</th>
                            <td id="v_cl_hp"></td>
                            <th>긴급연락처</th>
                            <td id="v_cl_tel"></td>
                        </tr>
                        <tr>
                            <th>출산유형</th>
                            <td id="v_cl_birth_type"></td>
                            <th>출산예정일</th>
                            <td id="v_cl_birth_due_date"></td>
                            <th>출산일</th>
                            <td id="v_cl_birth_date" colspan="3"></td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td id="v_cl_addr" colspan="7"></td>
                        </tr>
                        <tr>
                            <th>특이사항</th>
                            <td colspan="7">
                                <div class="v_cl_memo" id="v_cl_memo1"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>취소사유</th>
                            <td colspan="7">
                                <div class="v_cl_memo" id="v_cl_memo2"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="flex_row_between">
                    <div>
                        <h4 class="layer_tit mtop20">고객접수 서비스정보</h4>
                        <table class="layer_tbl">
                            <tbody>
                                <tr>
                                    <th class="x110">서비스구분</th>
                                    <td id="v_cl_service_cate" colspan="5"></td>
                                </tr>
                                <tr>
                                    <th class="x110">서비스기간</th>
                                    <td id="v_cl_service_all_date" colspan="3"></td>
                                    <th class="x110">서비스시간</th>
                                    <td id="v_cl_service_time"></td>
                                </tr>
                                <tr>
                                    <th>출산아기</th>
                                    <td class="x80" id="v_cl_baby"></td>
                                    <th class="x90">아기성별</th>
                                    <td class="x80" id="v_cl_baby_gender"></td>
                                    <th class="x80">출산순위</th>
                                    <td class="x80" id="v_cl_baby_count"></td>
                                </tr>
                                <tr>
                                    <th>큰아들 돌보기</th>
                                    <td id="v_cl_baby_first"></td>
                                    <th>취학/미취학</th>
                                    <td id="v_cl_school_preschool" colspan="3"></td>
                                </tr>
                                <tr>
                                    <th>CCTV</th>
                                    <td id="v_cl_cctv"></td>
                                    <th>반려동물</th>
                                    <td id="v_cl_pet"></td>
                                    <th>사전면접</th>
                                    <td id="v_cl_prior_interview"></td>
                                </tr>
                                <tr>
                                    <th>추가요금부담</th>
                                    <td id="v_cl_surcharge"></td>
                                    <th>프리미엄</th>
                                    <td id="v_cl_premium_use" colspan="3"></td>
                                </tr>
                                <tr>
                                    <th>대여물품</th>
                                    <td colspan="5">
                                        <div class="client_view_item_wrap">
                                            <div class="client_view_item_box" id="v_cl_item1"></div>
                                            <div class="client_view_item_box" id="v_cl_item2"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>단가구분</th>
                                    <td id="v_cl_unit_price"></td>
                                    <th>합계금액</th>
                                    <td id="v_cl_tot_price" colspan="3"></td>
                                </tr>
                                <tr>
                                    <th>추가요청사항</th>
                                    <td colspan="5">
                                        <div class="v_cl_memo" id="v_cl_memo3"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex1 mleft10">
                        <h4 class="layer_tit mtop20">고객접수 관리사정보</h4>

                        <table class="layer_tbl">
                            <tbody>
                                <tr>
                                    <th class="x90">지정 관리사</th>
                                    <td>
                                        <ul id="receipt_box">
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span><span>1팀</span><span>부산 해운대구</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>파견 관리사</th>
                                    <td>
                                        <ul id="receipt_box2">
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <th>변경 관리사</th>
                                    <td>
                                        <ul id="receipt_box3">
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                            <li class="receipt_list">
                                                <a>
                                                    <span>우태하</span>
                                                    <span>2024/01/06</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Client View Layer END -->
        </div>                                                                                                            
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup"></div>

<script>
    let write_ajax;

    $(function(){
        $('#write_btn').click(function(){
            $("#layer_popup").load(g5_bbs_url + "/client_write.php");

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        $('#edit_btn').click(function(){
            let client_idx = $('#v_client_idx').val();
            $("#layer_popup").load(g5_bbs_url + "/client_write.php?w=u&client_idx=" + client_idx);

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        $(document).on('click', '#popup_close_btn', function(){
            $('#layer_popup').empty();

            $('#layer_popup').css('display', 'none');
            $('#layer_popup_bg').css('display', 'none');
        });

        $(document).on('click', '#client_list > tr', function(){
            $('#client_list > tr').removeClass('list_selected');
            $(this).addClass('list_selected');

            view_act();
        });

        $('#sch_premium').change(function(){
            list_act('');
        });

        $('#sch_service_category').change(function(){
            list_act('');
        });

        $('#sch_cl_name').on('input', function(){
            list_act('');
        });

        $(document).on('change', '#cl_service_cate', function(){
            if($(this).val() == '바우처') {
                $('#cl_service_cate2').css('display', 'inline-block');
            }else{
                $('#cl_service_cate2').css('display', 'none');
            }
        });

        // 저장버튼 클릭시
        $(document).on('click', '#client_submit_btn', function(){
            if (typeof write_ajax !== 'undefined') {
                write_ajax.abort(); // 비동기 실행취소
            }

            if($('#receipt_date').val() == '') {
                alert('접수일자를 선택/입력해주세요');
                $('#receipt_date').focus();
                return false;
            }

            if($('#cl_name').val() == '') {
                alert('신청인 성명을 입력해주세요');
                $('#cl_name').focus();
                return false;
            }

            if($('#cl_security_number').val() == '') {
                alert('주민번호를 입력해주세요');
                $('#cl_security_number').focus();
                return false;
            }

            let juminRule=/^(?:[0-9]{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[1,2][0-9]|3[0,1]))-[1-8][0-9]{6}$/;
            if(!juminRule.test($('#cl_security_number').val())) {
                alert("주민번호를 형식에 맞게 입력해주세요");
                $('#cl_security_number').focus();
                return false;
            }

            if($('#cl_hp').val() == '') {
                alert('연락처를 입력해주세요');
                $('#cl_hp').focus();
                return false;
            }

            if($('#cl_service_cate').val() == '') {
                alert('서비스구분를 선택해주세요');
                $('#cl_service_cate').focus();
                return false;
            }

            if($('#cl_service_cate').val() == '바우처') {
                if($('#cl_service_cate2').val() == '') {
                    alert('해당 바우처를 선택해주세요');
                    $('#cl_service_cate2').focus();
                    return false;
                }
            }

            let writeForm = document.getElementById("fregisterform");
            let formData = new FormData(writeForm);

            write_ajax = $.ajax({
                url: g5_bbs_url + '/client_write_update.php',
                async: true,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    console.log(response);

                    if(response.msg != '') {
                        alert(response.msg);
                    }

                    if(response.code == '0000') {
                        $('#layer_popup').empty();

                        list_act(response.client_idx);

                        $('#layer_popup').css('display', 'none');
                        $('#layer_popup_bg').css('display', 'none');
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
    function list_act(client_idx) {
        let sch_premium = '';
        let sch_service_category = '';
        let sch_cl_name = '';

        if(client_idx == '') {
            sch_premium = ($('#sch_premium').is(':checked') == true) ? 'y' : '';
            sch_service_category = $('#sch_service_category option:selected').val();
            sch_cl_name = $('#sch_cl_name').val();
        }

        $.ajax({
            url: g5_bbs_url + '/ajax.client_list.php',
            type: "POST",
            data: {'sch_premium': sch_premium, 'sch_service_category': sch_service_category, 'sch_cl_name': sch_cl_name, 'client_idx': client_idx},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                console.log(response);

                $('#client_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(response[i].list_selected == 'y') {
                            list_selected = 'list_selected';

                            $('#v_client_idx').val(response[i].client_idx);
                        }

                        datas += '<tr class="' + list_selected + '" client_idx="' + response[i].client_idx + '">';
                        datas += '<td class="x45 talign_c">' + (i+1) + '</td>';
                        datas += '<td class="x100 talign_c">' + response[i].cl_name + '</td>';
                        datas += '<td class="x130 talign_c">' + response[i].cl_hp + '</td>';
                        datas += '<td class="x110 talign_c">' + response[i].receipt_date + '</td>';
                        datas += '<td class="talign_c">' + response[i].use_status + '</td>';
                        datas += '</tr>';
                    }

                    $('#client_list').append(datas);
                }

                view_act();
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function view_act() {
        let client_idx = $('.list_selected').attr('client_idx');

        $('#v_client_idx').val(client_idx); 
        $('#v_receipt_date').html('');
        $('#v_str_date').html('');
        $('#v_end_date').html('');
        $('#v_cancel_date').html('');
        $('#v_cl_name').html('');
        $('#v_cl_security_number').html('');
        $('#v_cl_hp').html('');
        $('#v_cl_tel').html('');
        $('#v_cl_birth_type').html('');
        $('#v_cl_birth_due_date').html('');
        $('#v_cl_birth_date').html('');
        $('#v_cl_addr').html('');
        $('#v_cl_memo1').html('');
        $('#v_cl_memo2').html('');

        $('#v_cl_service_cate').html('');
        $('#v_cl_service_all_date').html('');
        $('#v_cl_service_time').html('');
        $('#v_cl_baby').html('');
        $('#v_cl_baby_gender').html('');
        $('#v_cl_baby_count').html('');
        $('#v_cl_baby_first').html('');
        $('#v_cl_school_preschool').html('');
        $('#v_cl_cctv').html('');
        $('#v_cl_pet').html('');
        $('#v_cl_prior_interview').html('');
        $('#v_cl_surcharge').html('');
        $('#v_cl_premium_use').html('');
        $('#v_cl_unit_price').html('');
        $('#v_cl_tot_price').html('');
        $('#v_cl_memo3').html('');
        $('#v_cl_item1').html('');
        $('#v_cl_item2').html('');

        $.ajax({
            url: g5_bbs_url + '/ajax.client_view.php',
            type: "POST",
            data: {'client_idx': client_idx},
            dataType: "json",
            success: function(response) {
                console.log(response);

                $('#v_receipt_date').html(response.v_receipt_date);
                $('#v_str_date').html(response.v_str_date);
                $('#v_end_date').html(response.v_end_date);
                $('#v_cancel_date').html(response.v_cancel_date);
                $('#v_cl_name').html(response.v_cl_name);
                $('#v_cl_security_number').html(response.v_cl_security_number);
                $('#v_cl_hp').html(response.v_cl_hp);
                $('#v_cl_tel').html(response.v_cl_tel);
                $('#v_cl_birth_type').html(response.v_cl_birth_type);
                $('#v_cl_birth_due_date').html(response.v_cl_birth_due_date);
                $('#v_cl_birth_date').html(response.v_cl_birth_date);
                $('#v_cl_addr').html(response.v_cl_addr);
                $('#v_cl_memo1').html(response.v_cl_memo1);
                $('#v_cl_memo2').html(response.v_cl_memo2);

                $('#v_cl_service_cate').html(response.v_cl_service_cate);
                $('#v_cl_service_all_date').html(response.v_cl_service_all_date);
                $('#v_cl_service_time').html(response.v_cl_service_time);
                $('#v_cl_baby').html(response.v_cl_baby);
                $('#v_cl_baby_gender').html(response.v_cl_baby_gender);
                $('#v_cl_baby_count').html(response.v_cl_baby_count);
                $('#v_cl_baby_first').html(response.v_cl_baby_first);
                $('#v_cl_school_preschool').html(response.v_cl_school_preschool);
                $('#v_cl_cctv').html(response.v_cl_cctv);
                $('#v_cl_pet').html(response.v_cl_pet);
                $('#v_cl_prior_interview').html(response.v_cl_prior_interview);
                $('#v_cl_surcharge').html(response.v_cl_surcharge);
                $('#v_cl_premium_use').html(response.v_cl_premium_use);
                $('#v_cl_unit_price').html(response.v_cl_unit_price);
                $('#v_cl_tot_price').html(response.v_cl_tot_price);
                $('#v_cl_memo3').html(response.v_cl_memo3);
                $('#v_cl_item1').html(response.v_cl_item1);
                $('#v_cl_item2').html(response.v_cl_item2);
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    $(document).ready(function(){
        list_act('');
    });
</script>