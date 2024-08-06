<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client.css?ver=7">', 0);


// 등록/수정 권한
$write_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $write_permit = false;
    }
}

// 삭제 권한
$delete_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'delete' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $delete_permit = false;
    }
}
?>

<div id="layer_wrap">
    <div id="layer_box">

        <!-- List & View Wrap STR -->
        <div class="list_view_wrap">
            <!-- List Wrap STR -->
            <div class="list_wrap">
                <div class="list_top">
                    <div class="filter_box">
                        <?php
                        $filter_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and length(sme_code) = 2 and sme_use = 1 order by sme_order asc, sme_code asc ";
                        $filter_qry = sql_query($filter_sql);
                        $filter_num = sql_num_rows($filter_qry);

                        if($filter_num > 1) {
                        ?>
                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <?php for($l=0; $filter_row = sql_fetch_array($filter_qry); $l++) { ?>
                            <option value="<?php echo $filter_row['sme_code'] ?>"><?php echo $filter_row['sme_name'] ?></option>
                            <?php } ?>
                        </select>
                        <?php } ?>
                        <input type="text" class="filter_input" id="sch_cl_name" value="" placeholder="이름, 연락처 조회">
                    </div>
                    <div class="btn_box">
                        <?php if($write_permit === true) { ?><a class="list_top_btn" id="write_btn">고객등록</a><?php } ?>
                    </div>
                </div>

                <div class="list_box">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="left_list_numb">번호</th>
                                <th class="left_list_date">접수일자</th>
                                <th class="left_list_name sort_btn" order_fd="cl_name" orderby="asc">신청인<img src="<?php echo G5_IMG_URL ?>/sort_arrow_icon.png"></th>
                                <th class="left_list_service_category">서비스</th>
                                <th class="left_list_hp">연락처</th>
                                <th class="left_list_status">현황</th>
                                <th class="left_list_addr">주소</th>
                                <th class="left_list_date">시작일자</th>
                                <th class="left_list_date">종료일자</th>
                                <th class="left_list_service_category">연장근무</th>
                                <th class="left_list_service_category">출산순위</th>
                            </tr>
                        </thead>
                        <tbody id="client_list"></tbody>
                    </table>
                </div>

                <div class="list_bottom">
                    <a class="list_bottom_btn" id="excel_download_btn">엑셀 다운로드</a>
                </div>
            </div>
            <!-- List Wrap END -->

            <!-- View Wrap STR -->
            <input type="hidden" id="v_client_idx" value="">
            <div class="view_wrap">
                <div class="view_top">
                    <h4 class="view_tit">고객접수 기본정보</h4>
                    <?php if($delete_permit === true) { ?><a class="view_del_btn" id="del_btn">삭제</a><?php } ?>
                </div>

                <div class="view_box">
                    <table class="view_tbl">
                        <tbody>
                            <tr>
                                <th class="x90">분류</th>
                                <td class="x160 talign_c v_client_service"></td>
                                <th class="x90">신청인</th>
                                <td class="x160">
                                    <div class="v_cl_name_wrap">
                                        <span class="v_cl_name"></span>
                                        <?php if($write_permit === true) { ?><a class="view_edit_btn" id="edit_btn">수정</a><?php } ?>
                                    </div>
                                </td>
                                <th class="x90">접수일자</th>
                                <td class="x110 talign_c v_receipt_date"></td>
                                <th class="x90">시작일자</th>
                                <td class="x110 talign_c v_str_date"></td>
                                <th class="x90">종료일자</th>
                                <td class="x110 talign_c v_end_date"></td>
                                <th class="x90">취소일자</th>
                                <td class="talign_c v_cancel_date"></td>
                            </tr>
                            <!-- 베이비시터 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                                <th>주민번호</th>
                                <td class="talign_c v_cl_security_number"></td>
                                <th>연락처</th>
                                <td class="talign_c v_cl_hp"></td>
                                <th>긴급연락처</th>
                                <td class="talign_c v_cl_tel"></td>
                                <th>가족관계</th>
                                <td class="talign_c v_cl_relationship"></td>
                                <th>아기이름</th>
                                <td class="talign_c v_cl_baby_name"></td>
                                <th>아기생년월일</th>
                                <td class="talign_c v_cl_baby_birth"></td>
                            </tr>
                            <!-- 청소 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[1] ?>">
                                <th>주민번호</th>
                                <td class="talign_c v_cl_security_number"></td>
                                <th>연락처</th>
                                <td class="talign_c v_cl_hp"></td>
                                <th>긴급연락처</th>
                                <td class="talign_c v_cl_tel"></td>
                                <td colspan="6"></td>
                            </tr>
                            <!-- 반찬 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[2] ?>">
                                <th>주민번호</th>
                                <td class="talign_c v_cl_security_number"></td>
                                <th>연락처</th>
                                <td class="talign_c v_cl_hp"></td>
                                <th>긴급연락처</th>
                                <td class="talign_c v_cl_tel"></td>
                                <td colspan="6"></td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td id="v_cl_addr" colspan="11"></td>
                            </tr>
                            <!-- 베이비시터 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                                <th>서비스구분</th>
                                <td class="talign_c">
                                    <?/*<span class="v_cl_service_cate"></span>*/
?>
                                    <span class="v_cl_service_cate2"></span>
                                </td>
                                <th>서비스기간</th>
                                <td class="talign_c v_cl_service_period"></td>
                                <th>추가옵션</th>
                                <td class="talign_c v_cl_service_option"></td>
                                <th>출산순위</th>
                                <td class="talign_c v_cl_baby_count"></td>
                                <th>쌍둥이유무</th>
                                <td class="talign_c v_cl_twins"></td>
                                <th>큰아이유무</th>
                                <td class="talign_c v_cl_baby_first"></td>
                            </tr>
                            <!-- 청소 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[1] ?>">
                                <th>서비스구분</th>
                                <td class="talign_c">
                                    <?/*<span class="v_cl_service_cate"></span>*/
?>
                                    <span class="v_cl_service_cate2"></span>
                                </td>
                                <th>서비스기간</th>
                                <td class="talign_c v_cl_service_period"></td>
                                <th>추가옵션</th>
                                <td class="talign_c v_cl_service_option"></td>
                                <th>평수</th>
                                <td class="v_cl_pyeong" colspan="5"></td>
                            </tr>
                            <!-- 반찬 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[2] ?>">
                                <th>서비스구분</th>
                                <td class="talign_c">
                                    <?/*<span class="v_cl_service_cate"></span>*/
?>
                                    <span class="v_cl_service_cate2"></span>
                                </td>
                                <th>서비스기간</th>
                                <td class="talign_c v_cl_service_period"></td>
                                <td colspan="8"></td>
                            </tr>
                            <!-- 베이비시터 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[0] ?>">
                                <th>추가요금부담</th>
                                <td class="talign_c v_cl_surcharge"></td>
                                <th>연장근무</th>
                                <td class="talign_c v_cl_overtime"></td>
                                <th>CCTV</th>
                                <td class="talign_c v_cl_cctv"></td>
                                <th>반려동물</th>
                                <td class="talign_c v_cl_pet"></td>
                                <th>사전면접</th>
                                <td class="talign_c v_cl_prior_interview"></td>
                                <th>현금영수증</th>
                                <td class="talign_c v_cl_cash_receipt"></td>
                            </tr>
                            <!-- 청소 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[1] ?>">
                                <th>추가요금부담</th>
                                <td class="talign_c v_cl_surcharge"></td>
                                <th>연장근무</th>
                                <td class="talign_c v_cl_overtime"></td>
                                <th>CCTV</th>
                                <td class="talign_c v_cl_cctv"></td>
                                <th>반려동물</th>
                                <td class="talign_c v_cl_pet"></td>
                                <th>사전면접</th>
                                <td class="talign_c v_cl_prior_interview"></td>
                                <th>현금영수증</th>
                                <td class="talign_c v_cl_cash_receipt"></td>
                            </tr>
                            <!-- 반찬 -->
                            <tr class="v_client_service_view" client_service="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[2] ?>">
                                <th>추가요금부담</th>
                                <td class="talign_c v_cl_surcharge"></td>
                                <th>연장근무</th>
                                <td class="talign_c"></td>
                                <th>CCTV</th>
                                <td class="talign_c v_cl_cctv"></td>
                                <th>반려동물</th>
                                <td class="talign_c v_cl_pet"></td>
                                <th>사전면접</th>
                                <td class="talign_c v_cl_prior_interview"></td>
                                <th>현금영수증</th>
                                <td class="talign_c v_cl_cash_receipt"></td>
                            </tr>
                            <tr>
                                <th>단가구분</th>
                                <td class="talign_c v_cl_unit_price"></td>
                                <th>합계금액</th>
                                <td class="talign_c v_cl_tot_price"></td>
                                <th>추천경로</th>
                                <td class="talign_c v_cl_recommended"></td>
                                <th>프뢰벨</th>
                                <td class="talign_c v_cl_froebel_agree"></td>
                                <th>지정관리사</th>
                                <td class="v_cl_work_select_mb_id" colspan="3"></td>
                            </tr>
                            <tr>
                                <th>추가요청사항</th>
                                <td colspan="11">
                                    <div class="v_cl_memo" id="v_cl_memo3"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>특이사항</th>
                                <td colspan="11">
                                    <div class="v_cl_memo" id="v_cl_memo1"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>취소사유</th>
                                <td colspan="11">
                                    <div class="v_cl_memo" id="v_cl_memo2"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- View Wrap END -->
        </div>
        <!-- List & View Wrap END -->
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
    let write_ajax;
    let list_ajax;

    $(function(){
        $(document).on('click', '.sort_btn', function(){
            if($(this).hasClass('sort_asc') == true) {
                $(this).addClass('sort_desc').removeClass('sort_asc');
                $(this).attr('orderby', 'desc');
                list_act();
                return false;
            }

            if($(this).hasClass('sort_desc') == true) {
                $(this).removeClass('sort_desc');
                if($(this).attr('order_fd') == 'cl_name') {
                    $(this).attr('orderby', 'asc');
                }else{
                    $(this).attr('orderby', '');
                }
                list_act();
                return false;
            }

            if(hasAllClasses($(this), ['sort_asc', 'sort_desc']) == false) {
                $(this).addClass('sort_asc');
                $(this).attr('orderby', 'asc');
                list_act();
                return false;
            }
        });

        <?php if($write_permit === true) { ?>
        $(document).on('click', '#write_btn', function(){
            $("#layer_popup").load(g5_bbs_url + "/client_write.php");

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        $(document).on('click', '#edit_btn', function(){
            let client_idx = $('#v_client_idx').val();
            $("#layer_popup").load(g5_bbs_url + "/client_write.php?w=u&client_idx=" + client_idx);

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        $(document).on('change', '#cl_recommended', function(){
            if($(this).val() == '기타') {
                $('#cl_recommended_etc').css('display', 'inline-block');
            }else{
                $('#cl_recommended_etc').css('display', 'none');
            }
        });

        $(document).on('change', '#cl_service_cate', function(){
            let client_service = $('#client_service').val();
            let cl_service_cate = $(this).val();

            $('#cl_service_cate2').empty();
            
            let datas = '';
            datas += '<option value="">서비스구분선택</option>';

            $.ajax({
                url: g5_bbs_url + '/ajax.client_service_cate2.php',
                type: "POST",
                data: {'client_service': client_service, 'cl_service_cate': cl_service_cate},
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    if(response.length > 0) {
                        for(let i=0; i<response.length; i++) {
                            datas += '<optgroup label="'+response[i].group+'">';
                            if(response[i].sme_id.length > 0) {
                                for(let j=0; j<response[i].sme_id.length; j++) {
                                    datas += '<option value="'+response[i].sme_id[j]+'">'+response[i].sme_name[j]+'</option>';
                                }
                            }
                            datas += '</optgroup>';
                        }
                    }

                    $('#cl_service_cate2').append(datas);
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        });

        $(document).on('change', '#cl_service_cate2', function(){
            let client_service = $('#client_service').val();
            let cl_service_cate2 = $('#cl_service_cate2').val();

            $('#cl_service_period').empty();

            let datas = '';
            if(client_service != '반찬') datas += '<option value="">서비스기간선택</option>';

            $.ajax({
                url: g5_bbs_url + '/ajax.client_service_period.php',
                type: "POST",
                data: {'cl_service_cate2': cl_service_cate2},
                dataType: "json",
                success: function(response) {
                    // 전송이 성공한 경우 받는 응답 처리
                    if(response.length > 0) {
                        for(let i=0; i<response.length; i++) {
                            datas += '<option value="'+response[i].spe_id+'">'+response[i].spe_cate+'('+response[i].spe_name+')'+'</option>';
                        }
                    }

                    $('#cl_service_period').append(datas);

                    price_call();
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                    location.reload();
                }
            });
        });

        $(document).on('change', '#cl_service_period', function(){
            price_call();
        });

        // 저장버튼 클릭시
        $(document).on('click', '#submit_btn', function(){
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

            /*
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
            */

            if($('#cl_baby_count').length > 0) {
                if($('#cl_hp').val() == '') {
                    alert('연락처를 입력해주세요');
                    $('#cl_hp').focus();
                    return false;
                }
            }

            if($('#cl_baby_count').length > 0) {
                if($('#cl_baby_count').val() == '') {
                    alert('출산순위를 선택해주세요');
                    $('#cl_baby_count').focus();
                    return false;
                }
            }

            /*
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
            */

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

                        // $("#layer_popup").load(g5_bbs_url + "/client_write.php?w=u&client_idx=" + response.client_idx);
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
        <?php } ?>

        <?php if($delete_permit === true) { ?>
        $(document).on('click', '#del_btn', function(){
            if(confirm('한번 삭제되면 복구가 불가능합니다.\n그래도 삭제하시겠습니까?')) {
                let client_idx = $('#v_client_idx').val();

                $.ajax({
                    url: g5_bbs_url + '/ajax.client_delete.php',
                    type: "POST",
                    data: {'client_idx': client_idx},
                    dataType: "json",
                    success: function(response) {
                        // 전송이 성공한 경우 받는 응답 처리

                        if(response.msg != '') {
                            alert(response.msg);
                        }
                        if(response.code == '0000') {
                            list_act('');
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
            
            return false;
        });
        <?php } ?>

        $(document).on('click', '.client_service_list', function(){
            let client_service = $(this).attr('client_service');
            $('#client_service').val(client_service);

            $("#layer_popup").empty();
            $("#layer_popup").load(g5_bbs_url + "/client_write.php?client_service=" + client_service);
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

        $('#sch_service_category').change(function(){
            list_act('');
        });

        $('#sch_cl_name').on('input', function(){
            list_act('');
        });

        $('#excel_download_btn').click(function(){
            let sch_service_category = $('#sch_service_category option:selected').val();
            let sch_cl_name = $('#sch_cl_name').val();

            window.location.href = g5_bbs_url + '/client_excel_download.php?service_category=' + sch_service_category + '&cl_name=' + sch_cl_name;
        });

        // ㎡ 구하기
        $(document).on('input', '#cl_pyeong', function(){
            if($(this).val() == '') {
                return false;
            }

            let squaremeters = parseInt($(this).val() || 0) * 3.3;
            $('#cl_squaremeters').val(squaremeters.toFixed(0));
        });

        // 평수 구하기
        $(document).on('input', '#cl_squaremeters', function(){
            if($(this).val() == '') {
                return false;
            }

            let pyeong = parseInt($(this).val() || 0) / 3.3;
            $('#cl_pyeong').val(pyeong.toFixed(0));
        });
    });

    // 리스트 추출
    function list_act(client_idx) {
        if (typeof list_ajax !== 'undefined') {
            list_ajax.abort(); // 비동기 실행취소
        }

        let sch_service_category = '';
        let sch_cl_name = '';

        if(client_idx == '') {
            sch_service_category = $('#sch_service_category option:selected').val();
            sch_cl_name = $('#sch_cl_name').val();
        }

        let sort_btn = $('.sort_btn');
        let sort_orderby = '';
        $.each(sort_btn, function(index, className) {
            if($('.sort_btn').eq(index).attr('order_fd') != '' && $('.sort_btn').eq(index).attr('orderby') != '') {
                sort_orderby += ', ' + $('.sort_btn').eq(index).attr('order_fd') + ' ' + $('.sort_btn').eq(index).attr('orderby');
            }
        });

        list_ajax = $.ajax({
            url: g5_bbs_url + '/ajax.client_list.php',
            type: "POST",
            data: {'sch_service_category': sch_service_category, 'sch_cl_name': sch_cl_name, 'client_idx': client_idx, 'sort_orderby': sort_orderby},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
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
                        datas += '<td class="left_list_numb">' + (i+1) + '</td>';
                        datas += '<td class="left_list_date">' + response[i].receipt_date + '</td>';
                        datas += '<td class="left_list_name">' + response[i].cl_name + '</td>';
                        datas += '<td class="left_list_service_category">' + response[i].service_category + '</td>';
                        datas += '<td class="left_list_hp">' + response[i].cl_hp + '</td>';
                        datas += '<td class="left_list_status">' + response[i].use_status + '</td>';
                        datas += '<td class="left_list_addr">' + response[i].cl_addr + '</td>';
                        datas += '<td class="left_list_date">' + response[i].str_date + '</td>';
                        datas += '<td class="left_list_date">' + response[i].end_date + '</td>';

                        datas += '<td class="left_list_service_category">' + response[i].cl_overtime + '</td>';
                        datas += '<td class="left_list_service_category">' + response[i].cl_baby_count + '</td>';
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

        $('.v_client_service').html('');
        $('.v_receipt_date').html('');
        $('.v_str_date').html('');
        $('.v_end_date').html('');
        $('.v_cancel_date').html('');
        $('.v_cl_name').html('');
        $('.v_cl_security_number').html('');
        $('.v_cl_hp').html('');
        $('.v_cl_tel').html('');
        $('.v_cl_birth_type').html('');
        $('.v_cl_birth_due_date').html('');
        $('.v_cl_birth_date').html('');
        $('#v_cl_addr').html('');
        $('.v_cl_service_cate').html('');
        $('.v_cl_service_cate2').html('');
        $('.v_cl_service_period').html('');
        $('.v_cl_service_option').html('');
        $('.v_cl_pyeong').html('');
        $('.v_cl_baby').html('');
        $('.v_cl_baby_gender').html('');
        $('.v_cl_baby_count').html('');
        $('.v_cl_baby_first').html('');
        $('.v_cl_school_preschool').html('');
        $('.v_cl_cctv').html('');
        $('.v_cl_pet').html('');
        $('.v_cl_surcharge').html('');
        $('.v_cl_unit_price').html('');
        $('.v_cl_tot_price').html('');
        $('.v_cl_recommended').html('');
        $('.v_cl_froebel_agree').html('');
        $('.v_cl_cash_receipt').html('');
        $('#v_cl_memo1').html('');
        $('#v_cl_memo2').html('');
        $('#v_cl_memo3').html('');
        $('.v_cl_relationship').html('');
        $('.v_cl_baby_name').html('');
        $('.v_cl_baby_birth').html('');
        $('.v_cl_prior_interview').html('');
        $('.v_cl_overtime').html('');
        $('.v_cl_twins').html('');
        $('.v_cl_work_select_mb_id').html('');

        $.ajax({
            url: g5_bbs_url + '/ajax.client_view.php',
            type: "POST",
            data: {'client_idx': client_idx},
            dataType: "json",
            success: function(response) {
                $('.v_client_service').html(response.v_client_service);
                $('.v_receipt_date').html(response.v_receipt_date);
                $('.v_str_date').html(response.v_str_date);
                $('.v_end_date').html(response.v_end_date);
                $('.v_cancel_date').html(response.v_cancel_date);
                $('.v_cl_name').html(response.v_cl_name);
                $('.v_cl_security_number').html(response.v_cl_security_number);
                $('.v_cl_hp').html(response.v_cl_hp);
                $('.v_cl_tel').html(response.v_cl_tel);
                $('.v_cl_birth_type').html(response.v_cl_birth_type);
                $('.v_cl_birth_due_date').html(response.v_cl_birth_due_date);
                $('.v_cl_birth_date').html(response.v_cl_birth_date);
                $('#v_cl_addr').html(response.v_cl_addr);
                if(response.v_cl_service_cate != '') $('.v_cl_service_cate').html('['+response.v_cl_service_cate+']');
                $('.v_cl_service_cate2').html(response.v_cl_service_cate2);
                $('.v_cl_service_period').html(response.v_cl_service_period);
                $('.v_cl_service_option').html(response.v_cl_service_option);
                $('.v_cl_pyeong').html(response.v_cl_pyeong);
                $('.v_cl_baby').html(response.v_cl_baby);
                $('.v_cl_baby_gender').html(response.v_cl_baby_gender);
                $('.v_cl_baby_count').html(response.v_cl_baby_count);
                $('.v_cl_baby_first').html(response.v_cl_baby_first);
                $('.v_cl_school_preschool').html(response.v_cl_school_preschool);
                $('.v_cl_cctv').html(response.v_cl_cctv);
                $('.v_cl_pet').html(response.v_cl_pet);
                $('.v_cl_surcharge').html(response.v_cl_surcharge);
                $('.v_cl_overtime').html(response.v_cl_overtime);
                $('.v_cl_unit_price').html(response.v_cl_unit_price);
                $('.v_cl_tot_price').html(response.v_cl_tot_price);
                $('.v_cl_recommended').html(response.v_cl_recommended);
                $('.v_cl_froebel_agree').html(response.v_cl_froebel_agree);
                $('.v_cl_cash_receipt').html(response.v_cl_cash_receipt);
                $('#v_cl_memo1').html(response.v_cl_memo1);
                $('#v_cl_memo2').html(response.v_cl_memo2);
                $('#v_cl_memo3').html(response.v_cl_memo3);
                $('.v_cl_relationship').html(response.v_cl_relationship);
                $('.v_cl_baby_name').html(response.v_cl_baby_name);
                $('.v_cl_baby_birth').html(response.v_cl_baby_birth);
                $('.v_cl_prior_interview').html(response.v_cl_prior_interview);
                $('.v_cl_twins').html(response.v_cl_twins);
                $('.v_cl_work_select_mb_id').html(response.v_cl_work_select_mb_id);

                $('.v_client_service_view').css('display', 'none');
                $('.v_client_service_view').filter("[client_service='" + response.v_client_service + "']").css('display', 'table-row');
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function price_call() {
        let cl_service_period = $('#cl_service_period').val();
        let receipt_date = $('#receipt_date').val();
        let str_date = $('#str_date').val();

        $.ajax({
            url: g5_bbs_url + '/ajax.client_price_call.php',
            type: "POST",
            data: {'cl_service_period': cl_service_period, 'receipt_date': receipt_date, 'str_date': str_date},
            dataType: "json",
            success: function(response) {
                $('#cl_unit_price').val(response.cl_unit_price);
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
                location.reload();
            }
        });
    }

    $(document).ready(function(){
        list_act('');
    });
</script>