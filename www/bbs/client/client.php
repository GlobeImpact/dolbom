<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client.css">', 0);
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
                    <a id="write_btn">고객접수등록</a>
                </div>

                <div class="list_wrap_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x45">번호</th>
                                <th class="x100">신청인</th>
                                <th class="x170">연락처</th>
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
            <div class="sub_box">
                <h4 class="layer_tit">고객접수 기본정보</h4>

                <table class="layer_tbl">
                    <tbody>
                        <tr>
                            <th>접수일자</th>
                            <td>2024/01/06</td>
                            <th>시작일자</th>
                            <td>2024/01/06</td>
                            <th>종료일자</th>
                            <td>2024/01/06</td>
                            <th>취소일자</th>
                            <td>2024/01/06</td>
                        </tr>
                        <tr>
                            <th>신청인</th>
                            <td>우태하</td>
                            <th>주민번호</th>
                            <td>890715-1234567</td>
                            <th>연락처</th>
                            <td>010-5180-2446</td>
                            <th>긴급연락처</th>
                            <td>010-5180-2446</td>
                        </tr>
                        <tr>
                            <th>출산유형</th>
                            <td>자연분만</td>
                            <th>출산예정일</th>
                            <td>2024/01/06</td>
                            <th>출산일</th>
                            <td>2024/01/06</td>
                            <th>바우처</th>
                            <td>바우처#1</td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td colspan="7">수영구 무학로</td>
                        </tr>
                        <tr>
                            <th>특이사항</th>
                            <td colspan="7"></td>
                        </tr>
                        <tr>
                            <th>취소사유</th>
                            <td colspan="7"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Client View Layer END -->

            <?/*
            <div class="sub_box">
                <h4 class="layer_tit">고객접수 기본정보</h4>

                <table class="layer_tbl">
                    <tbody>
                        <tr>
                            <td class="x170 vtop" rowspan="6">
                                <div id="profile_write_wrap">
                                    <img src="" onerror="this.src='<?php echo G5_IMG_URL ?>/profile_noimg.png';">
                                </div>
                            </td>
                            <th class="x100">성명</th>
                            <td id="v_mb_name">
                                홍길동
                            </td>
                            <th class="x100">연락처</th>
                            <td id="v_mb_hp">
                                010-5180-2446
                            </td>
                            <th class="x100">주민번호</th>
                            <td id="v_security_number">
                                890715-1xxxxxx
                            </td>
                        </tr>
                        <tr>
                            <th>활동현황</th>
                            <td id="v_activity_status">
                                활동중
                            </td>
                            <th>계약형태</th>
                            <td id="v_contract_type">
                                프리렌서
                            </td>
                            <th>프리미엄</th>
                            <td id="v_premium_use">
                                미사용
                            </td>
                        </tr>
                        <tr>
                            <th>서비스구분</th>
                            <td id="v_service_category">
                                베이비시터
                            </td>
                            <th>팀구분</th>
                            <td id="v_team_category">
                                4팀
                            </td>
                            <th>입사일자</th>
                            <td id="v_enter_date">
                                2023-12-12
                            </td>
                        </tr>
                        <tr>
                            <th>주소</th>
                            <td colspan="5">
                                <div class="div_flex" id="v_addr">
                                    [11223] 부산 수영구 무학로 123번길 123 땡땡하우스 1001호
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="5">
                                <div id="v_mb_memo">가나다라마바사아자차카타파하<br>가나다라마바사아자차카타파하<br>가나다라마바사아자차카타파하</div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div class="layer_flex">
                    <div class="layer_flex_info">
                        <h4 class="layer_tit mtop20">제공인력 교육정보</h4>

                        <table class="layer_tbl">
                            <thead>
                                <tr>
                                    <th class="xp16">교육</th>
                                    <th class="xp14">기본</th>
                                    <th class="xp14">심화</th>
                                    <th class="xp14">경력자</th>
                                    <th class="xp14">보수</th>
                                    <th class="xp14">아동학대</th>
                                    <th class="xp14">독감예방</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>시작일</th>
                                    <td class="talign_c" id="v_training_str_date1">2024-01-01</td>
                                    <td class="talign_c" id="v_training_str_date2">2024-01-01</td>
                                    <td class="talign_c" id="v_training_str_date3">2024-01-01</td>
                                    <td class="talign_c" id="v_training_str_date4">2024-01-01</td>
                                    <td class="talign_c" id="v_training_str_date5">2024-01-01</td>
                                    <td class="talign_c" id="v_training_str_date6">2024-01-01</td>
                                </tr>
                                <tr>
                                    <th>종료일</th>
                                    <td class="talign_c" id="v_training_end_date1">2024-01-01</td>
                                    <td class="talign_c" id="v_training_end_date2">2024-01-01</td>
                                    <td class="talign_c" id="v_training_end_date3">2024-01-01</td>
                                    <td class="talign_c" id="v_training_end_date4">2024-01-01</td>
                                    <td class="talign_c" id="v_training_end_date5">2024-01-01</td>
                                    <td class="talign_c" id="v_training_end_date6">2024-01-01</td>
                                </tr>
                                <tr>
                                    <th>교육시간</th>
                                    <td class="talign_c" id="v_training_time1">20:20 ~ 22:40</td>
                                    <td class="talign_c" id="v_training_time2">20:20 ~ 22:40</td>
                                    <td class="talign_c" id="v_training_time3">20:20 ~ 22:40</td>
                                    <td class="talign_c" id="v_training_time4">20:20 ~ 22:40</td>
                                    <td class="talign_c" id="v_training_time5">20:20 ~ 22:40</td>
                                    <td class="talign_c" id="v_training_time6">20:20 ~ 22:40</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="layer_flex mbottom70">
                    <div class="layer_flex_info">
                        <h4 class="layer_tit mtop20">제공인력 급여정보</h4>

                        <table class="layer_tbl">
                            <tbody>
                                <tr>
                                    <th class="x100">4대보험가입</th>
                                    <td id="v_major4_insurance">2023-02-02</td>
                                    <th class="x100">보험상실</th>
                                    <td id="v_loss_insurance">2023-02-02</td>
                                    <th class="x100">퇴사일자</th>
                                    <td id="v_quit_date">2024-01-01</td>
                                </tr>
                                <tr>
                                    <th>기본급</th>
                                    <td id="v_basic_price">76,920원</td>
                                    <th>표준월소득액</th>
                                    <td colspan="3" id="v_monthly_income">2,000,000원</td>
                                </tr>
                                <tr>
                                    <th>은행</th>
                                    <td id="v_bank_name">신한 </td>
                                    <th>계좌번호</th>
                                    <td colspan="3" id="v_bank_account">111-22-3333333</td>
                                </tr>
                                <tr>
                                    <th>예금주</th>
                                    <td id="v_account_holder">홍길동</td>
                                    <th>예금주(기타)</th>
                                    <td colspan="3" id="v_account_holder_etc">(주)글로브임펙트</td>
                                </tr>
                                <tr>
                                    <th>취약계층여부</th>
                                    <td id="v_vulnerable">취약계층</td>
                                    <th>반려동물유무</th>
                                    <td colspan="3" id="v_pet_use">애완견</td>
                                </tr>
                                <tr>
                                    <th>특이사항</th>
                                    <td colspan="5">
                                        <div id="v_mb_memo2"></div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            */?>
        </div>                                                                                                            
    </div>
</div>

<script>
    $(function(){
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

                for(let i=0; i<50; i++) {
                    datas += '<tr class="' + list_selected + '" client_idx="">';
                    datas += '<td class="x45 talign_c">1</td>';
                    datas += '<td class="x100 talign_c">홍길동</td>';
                    datas += '<td class="x170 talign_c">010-5180-2446</td>';
                    datas += '<td class="x110 talign_c">2024/01/06</td>';
                    datas += '<td class="talign_c">사용</td>';
                    datas += '</tr>';
                }

                $('#client_list').append(datas);
                /*
                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(response[i].list_selected == 'y') {
                            list_selected = 'list_selected';

                            $('#v_set_idx').val(response[i].set_idx);
                        }

                        datas += '<tr class="' + list_selected + '" set_idx="' + response[i].set_idx + '">';
                        datas += '<td class="x120 talign_c">' + response[i].contract_type + '</td>';
                        datas += '<td class="x80 talign_c">' + response[i].set_year + '/' + response[i].set_month + '</td>';
                        datas += '<td class="talign_c">' + response[i].payment_year + '/' + response[i].payment_month + '/' + response[i].payment_day + '</td>';
                        datas += '</tr>';
                    }

                    $('#pay_set_list').append(datas);
                }

                view_act();
                */
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function view_act() {
    }

    $(document).ready(function(){
        list_act('');
    });
</script>