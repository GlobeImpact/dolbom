<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/pay/pay_attendance.css">', 0);
?>

<!-- 달력 API -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?php echo G5_JS_URL ?>/jquery-ui.js"></script>

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
            <!-- Left Menu STR -->
            <div class="list_wrap">
                <div class="list_wrap_top">
                    <div class="list_filter_box">
                        <select class="filter_select" id="sch_activity_status">
                            <option value="">활동현황</option>
                            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}); $l++) { ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_activity_status_arr'}[$l] ?></option>
                            <?php } ?>
                        </select>

                        <select class="filter_select" id="sch_service_category">
                            <option value="">서비스구분</option>
                            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}); $l++) { ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_service_category_arr'}[$l] ?></option>
                            <?php } ?>
                        </select>

                        <input type="text" class="filter_input" id="sch_mb_name" value="" placeholder="이름 조회">
                    </div>
                </div>

                <div class="list_wrap_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x100">직원명</th>
                                <th class="x40">팀</th>
                                <th class="x60">파견</th>
                                <th class="x60">근태</th>
                                <th>현황</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="list_wrap_list_box">
                        <table class="list_tbl">
                            <tbody id="pay_attendance_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Left Menu END -->


            <input type="hidden" id="v_set_idx" value="">
            <div class="form_wrap">
                <div class="form_row flex_1">
                    <div class="form_box xp30">
                        <h4 class="sub_tit talign_c">[ 근 태 정 보&nbsp;&nbsp;&nbsp;&nbsp;직 접 수 정 ]</h4>

                        <div class="write_box">
                            <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
                                <table class="form_tbl">
                                    <tbody>
                                        <tr>
                                            <th class="x80">일자</th>
                                            <td colspan="2">
                                                <input type="text" id="" class="form_input x80" value="">
                                            </td>
                                            <td>화요일</td>
                                        </tr>
                                        <tr>
                                            <th>근무</th>
                                            <td class="x60">
                                                <select name="" id="" class="form_select">
                                                    <option value="">출근</option>
                                                </select>
                                            </td>
                                            <th class="x70">지급</th>
                                            <td class="x60">
                                                <select name="" id="" class="form_select">
                                                    <option value="">유료</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>평일</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <th>바우처</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>유료</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <th>쌍생아</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>입주</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <th>큰아이</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>마사지</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <th>주휴</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>연차</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <th>프리미엄</th>
                                            <td>
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>유료[토]</th>
                                            <td colspan="3">
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>바우처[토]</th>
                                            <td colspan="3">
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>장애우</th>
                                            <td colspan="3">
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>휴일</th>
                                            <td colspan="2">
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>고급형</th>
                                            <td colspan="2">
                                                <select name="" id="" class="form_select">
                                                    <option value=""></option>
                                                    <option value="">No</option>
                                                    <option value="">Yes</option>
                                                </select>
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th>지정일수</th>
                                            <td colspan="3">
                                                <input type="text" id="" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>근무시간</th>
                                            <td colspan="3">
                                                <input type="text" id="" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>파견인원</th>
                                            <td colspan="3">
                                                <input type="text" id="" class="form_input x80 talign_r" value="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <a id="pay_attendance_submit_btn">저장하기</a>
                        </div>
                    </div>
                    <div class="form_box xp69">
                        <h4 class="sub_tit" id="">2024년 08월</h4>

                        <div class="calendar_wrap">
                            <table class="calendar_tbl">
                                <thead>
                                    <tr>
                                        <th>일</th>
                                        <th>월</th>
                                        <th>화</th>
                                        <th>수</th>
                                        <th>목</th>
                                        <th>금</th>
                                        <th>토</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div style="display:flex; flex-direction:column; align-items:stretch; justify-content:stretch; margin:0; padding:0; width:100%; height:100%;">
                                                <p class="day_tit" style="text-align:center; font-family:'GmarketSansMedium';">01</p>
                                                <div style="flex:1 1 0%; display:flex; flex-direction:row; align-items:flex-end; justify-content:space-between; margin:0; padding:0; width:100%;">
                                                    <span style="color:#ff0000; font-family:'GmarketSansMedium'; font-weight:100; font-size:14px;">유료</span>
                                                    <span style="color:#ff0000; font-family:'GmarketSansMedium'; font-weight:100; font-size:14px;">주휴</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>6</td>
                                        <td>7</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form_row">
                    <div class="form_box xp100">
                        <h4 class="sub_tit">근태 리스트</h4>
                        <div class="attendance_list_wrap">
                            <table class="attendance_list_hd_tbl">
                                <thead>
                                    <tr>
                                        <th class="x100">일자</th>
                                        <th class="x50">요일</th>
                                        <th class="x50">근무</th>
                                        <th class="x50">지급</th>
                                        <th class="x50">평일</th>
                                        <th class="x60">바우처</th>
                                        <th class="x70">유료[토]</th>
                                        <th class="x80">바우처[토]</th>
                                        <th class="x50">유료</th>
                                        <th class="x60">쌍생아</th>
                                        <th class="x60">삼태아</th>
                                        <th class="x60">장애우</th>
                                        <th class="x50">입주</th>
                                        <th class="x60">고급형</th>
                                        <th class="x60">큰아이</th>
                                        <th class="x60">마사지</th>
                                    </tr>
                                </thead>
                            </table>

                            <table class="attendance_list_tbl">
                                <tbody>
                                    <tr>
                                        <td class="x100">2024/02/02</td>
                                        <td class="x50">금</td>
                                        <td class="x50">출근</td>
                                        <td class="x50">유료</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x70">Yes</td>
                                        <td class="x80">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                    </tr>
                                    <tr>
                                        <td class="x100">2024/02/02</td>
                                        <td class="x50">금</td>
                                        <td class="x50">출근</td>
                                        <td class="x50">유료</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x70">Yes</td>
                                        <td class="x80">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                    </tr>
                                    <tr>
                                        <td class="x100">2024/02/02</td>
                                        <td class="x50">금</td>
                                        <td class="x50">출근</td>
                                        <td class="x50">유료</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x70">Yes</td>
                                        <td class="x80">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                    </tr>
                                    <tr>
                                        <td class="x100">2024/02/02</td>
                                        <td class="x50">금</td>
                                        <td class="x50">출근</td>
                                        <td class="x50">유료</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x70">Yes</td>
                                        <td class="x80">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                    </tr>
                                    <tr>
                                        <td class="x100">2024/02/02</td>
                                        <td class="x50">금</td>
                                        <td class="x50">출근</td>
                                        <td class="x50">유료</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x70">Yes</td>
                                        <td class="x80">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x50">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                        <td class="x60">Yes</td>
                                    </tr>
                                </tbody>
                            </table>

                            <table class="attendance_list_ft_tbl">
                                <thead>
                                    <tr>
                                        <th class="x100">[ 합&nbsp;&nbsp;&nbsp;&nbsp;계 ]</th>
                                        <th class="x50"></th>
                                        <th class="x50"></th>
                                        <th class="x50"></th>
                                        <th class="x50">5</th>
                                        <th class="x60">5</th>
                                        <th class="x70">5</th>
                                        <th class="x80">5</th>
                                        <th class="x50">5</th>
                                        <th class="x60">5</th>
                                        <th class="x60">5</th>
                                        <th class="x60">5</th>
                                        <th class="x50">5</th>
                                        <th class="x60">5</th>
                                        <th class="x60">5</th>
                                        <th class="x60">5</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#sch_activity_status').change(function(){
            list_act('');
        });

        $('#sch_service_category').change(function(){
            list_act('');
        });

        $('#sch_mb_name').on('input', function(){
            list_act('');
        });

        $(document).on('click', '#pay_attendance_list > tr', function(){
            $('#pay_attendance_list > tr').removeClass('list_selected');
            $(this).addClass('list_selected');

            view_act();
        });

        $('#form_submit_btn').click(function(){
            let pay_set_arr = new FormData();
            pay_set_arr.append('set_idx', $('#v_set_idx').val());
            pay_set_arr.append('v_contract_type', $('#v_contract_type').val());
            pay_set_arr.append('v_set_ym', $('#v_set_ym').val());
            pay_set_arr.append('v_payment_ymd', $('#v_payment_ymd').val());
            pay_set_arr.append('v_info_cell1', removeComma($('#v_info_cell1').val()));
            pay_set_arr.append('v_info_cell2', removeComma($('#v_info_cell2').val()));
            pay_set_arr.append('v_info_cell3', removeComma($('#v_info_cell3').val()));
            pay_set_arr.append('v_item_cell1', removeComma($('#v_item_cell1').val()));
            pay_set_arr.append('v_item_cell2', removeComma($('#v_item_cell2').val()));
            pay_set_arr.append('v_item_cell3', removeComma($('#v_item_cell3').val()));
            pay_set_arr.append('v_item_cell4', removeComma($('#v_item_cell4').val()));
            pay_set_arr.append('v_item_cell5', removeComma($('#v_item_cell5').val()));
            pay_set_arr.append('v_item_cell6', removeComma($('#v_item_cell6').val()));
            pay_set_arr.append('v_add_cell1', removeComma($('#v_add_cell1').val()));
            pay_set_arr.append('v_add_cell2', removeComma($('#v_add_cell2').val()));
            pay_set_arr.append('v_add_cell3', removeComma($('#v_add_cell3').val()));
            pay_set_arr.append('v_add_cell4', removeComma($('#v_add_cell4').val()));
            pay_set_arr.append('v_add_cell5', removeComma($('#v_add_cell5').val()));
            pay_set_arr.append('v_add_cell6', removeComma($('#v_add_cell6').val()));
            pay_set_arr.append('v_add_cell7', removeComma($('#v_add_cell7').val()));
            pay_set_arr.append('v_service_cell1', removeComma($('#v_service_cell1').val()));
            pay_set_arr.append('v_service_cell2', removeComma($('#v_service_cell2').val()));
            pay_set_arr.append('v_service_cell3', removeComma($('#v_service_cell3').val()));
            pay_set_arr.append('v_service_cell4', removeComma($('#v_service_cell4').val()));
            pay_set_arr.append('v_service_cell5', removeComma($('#v_service_cell5').val()));
            pay_set_arr.append('v_service_cell6', removeComma($('#v_service_cell6').val()));
            pay_set_arr.append('v_holiday_cell1', removeComma($('#v_holiday_cell1').val()));
            pay_set_arr.append('v_holiday_cell2', removeComma($('#v_holiday_cell2').val()));
            pay_set_arr.append('v_holiday_cell3', removeComma($('#v_holiday_cell3').val()));
            pay_set_arr.append('v_holiday_cell4', removeComma($('#v_holiday_cell4').val()));
            pay_set_arr.append('v_outsourcing_cell1', removeComma($('#v_outsourcing_cell1').val()));
            pay_set_arr.append('v_outsourcing_cell2', removeComma($('#v_outsourcing_cell2').val()));
            pay_set_arr.append('v_outsourcing_cell3', removeComma($('#v_outsourcing_cell3').val()));
            pay_set_arr.append('v_outsourcing_cell4', removeComma($('#v_outsourcing_cell4').val()));
            pay_set_arr.append('v_major4_company_cell1', removeComma($('#v_major4_company_cell1').val()));
            pay_set_arr.append('v_major4_company_cell2', removeComma($('#v_major4_company_cell2').val()));
            pay_set_arr.append('v_major4_company_cell3', removeComma($('#v_major4_company_cell3').val()));
            pay_set_arr.append('v_major4_company_cell4', removeComma($('#v_major4_company_cell4').val()));
            pay_set_arr.append('v_major4_company_cell5', removeComma($('#v_major4_company_cell5').val()));
            pay_set_arr.append('v_major4_staff_cell1', removeComma($('#v_major4_staff_cell1').val()));
            pay_set_arr.append('v_major4_staff_cell2', removeComma($('#v_major4_staff_cell2').val()));
            pay_set_arr.append('v_major4_staff_cell3', removeComma($('#v_major4_staff_cell3').val()));
            pay_set_arr.append('v_major4_staff_cell4', removeComma($('#v_major4_staff_cell4').val()));
            pay_set_arr.append('v_major4_staff_cell5', removeComma($('#v_major4_staff_cell5').val()));

            $.ajax({
                url: g5_bbs_url + '/ajax.pay_set_update.php',
                type: "POST",
                data: pay_set_arr,
                cache: false,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(response) {
                    if(response.code == '0000') {
                        view_act();
                    }else{
                        alert('저장에 실패하였습니다.');
                    }
                },
                error: function(error) {
                    // 전송이 실패한 경우 받는 응답 처리
                }
            });
        });
    });

    // 숫자만 입력 정규식
    function inputNum(id) {
        let element = document.getElementById(id);
        element.value = element.value.replace(/[^0-9]/gi, "");
    }

    // 숫자만 입력 + 소수점 정규식
    function inputNum2(id) {
        let element = document.getElementById(id);
        element.value = element.value.replace(/[^-\.0-9]/g, "");
    }

    // 소수점 콤마 정규식
    function addComma(value) {
        return value.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ',');
    }

    // 콤마 제거 정규식
    function removeComma(value) {
        return value.toString().replace(/,/g, "");
    }

    // 리스트 추출
    function list_act(set_idx) {
        let sch_contract_type = '';
        let sch_year = '';
        let sch_month = '';

        if(set_idx == '') {
            sch_contract_type = $('#sch_contract_type option:selected').val();
            sch_year = $('#sch_year option:selected').val();
            sch_month = $('#sch_month option:selected').val();
        }

        $.ajax({
            url: g5_bbs_url + '/ajax.pay_attendance_list.php',
            type: "POST",
            data: {'sch_contract_type': sch_contract_type, 'sch_year': sch_year, 'sch_month': sch_month, 'set_idx': set_idx},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                // console.log(response);

                $('#pay_attendance_list').empty();
                let datas = '';
                let list_selected = '';
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

                    $('#pay_attendance_list').append(datas);
                }

                view_act();
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function view_act() {
        console.log('view_act');
        /*
        let set_idx = $('.list_selected').attr('set_idx');

        $('#v_set_idx').val(set_idx);
        $('#v_contract_type').val('');
        $('#v_set_ym').val('');
        $('#v_payment_ymd').val('');
        $('#v_info_cell1').val('');
        $('#v_info_cell2').val('');
        $('#v_info_cell3').val('');
        $('#v_item_cell1').val('');
        $('#v_item_cell2').val('');
        $('#v_item_cell3').val('');
        $('#v_item_cell4').val('');
        $('#v_item_cell5').val('');
        $('#v_item_cell6').val('');
        $('#v_add_cell1').val('');
        $('#v_add_cell2').val('');
        $('#v_add_cell3').val('');
        $('#v_add_cell4').val('');
        $('#v_add_cell5').val('');
        $('#v_add_cell6').val('');
        $('#v_add_cell7').val('');
        $('#v_service_cell1').val('');
        $('#v_service_cell2').val('');
        $('#v_service_cell3').val('');
        $('#v_service_cell4').val('');
        $('#v_service_cell5').val('');
        $('#v_service_cell6').val('');
        $('#v_holiday_cell1').val('');
        $('#v_holiday_cell2').val('');
        $('#v_holiday_cell3').val('');
        $('#v_holiday_cell4').val('');
        $('#v_outsourcing_cell1').val('');
        $('#v_outsourcing_cell2').val('');
        $('#v_outsourcing_cell3').val('');
        $('#v_outsourcing_cell4').val('');
        $('#v_major4_company_cell1').val('');
        $('#v_major4_company_cell2').val('');
        $('#v_major4_company_cell3').val('');
        $('#v_major4_company_cell4').val('');
        $('#v_major4_company_cell5').val('');
        $('#v_major4_staff_cell1').val('');
        $('#v_major4_staff_cell2').val('');
        $('#v_major4_staff_cell3').val('');
        $('#v_major4_staff_cell4').val('');
        $('#v_major4_staff_cell5').val('');

        $.ajax({
            url: g5_bbs_url + '/ajax.pay_set_view.php',
            type: "POST",
            data: {'set_idx': set_idx},
            dataType: "json",
            success: function(response) {
                // console.log(response);

                $('#v_contract_type').val(response.v_contract_type);
                $('#v_set_ym').val(response.v_set_ym);
                $('#v_payment_ymd').val(response.v_payment_ymd);
                $('#v_info_cell1').val(addComma(response.v_info_cell1));
                $('#v_info_cell2').val(addComma(response.v_info_cell2));
                $('#v_info_cell3').val(addComma(response.v_info_cell3));
                $('#v_item_cell1').val(addComma(response.v_item_cell1));
                $('#v_item_cell2').val(addComma(response.v_item_cell2));
                $('#v_item_cell3').val(addComma(response.v_item_cell3));
                $('#v_item_cell4').val(addComma(response.v_item_cell4));
                $('#v_item_cell5').val(addComma(response.v_item_cell5));
                $('#v_item_cell6').val(addComma(response.v_item_cell6));
                $('#v_add_cell1').val(addComma(response.v_add_cell1));
                $('#v_add_cell2').val(addComma(response.v_add_cell2));
                $('#v_add_cell3').val(addComma(response.v_add_cell3));
                $('#v_add_cell4').val(addComma(response.v_add_cell4));
                $('#v_add_cell5').val(addComma(response.v_add_cell5));
                $('#v_add_cell6').val(addComma(response.v_add_cell6));
                $('#v_add_cell7').val(addComma(response.v_add_cell7));
                $('#v_service_cell1').val(addComma(response.v_service_cell1));
                $('#v_service_cell2').val(addComma(response.v_service_cell2));
                $('#v_service_cell3').val(addComma(response.v_service_cell3));
                $('#v_service_cell4').val(addComma(response.v_service_cell4));
                $('#v_service_cell5').val(addComma(response.v_service_cell5));
                $('#v_service_cell6').val(addComma(response.v_service_cell6));
                $('#v_holiday_cell1').val(addComma(response.v_holiday_cell1));
                $('#v_holiday_cell2').val(addComma(response.v_holiday_cell2));
                $('#v_holiday_cell3').val(addComma(response.v_holiday_cell3));
                $('#v_holiday_cell4').val(addComma(response.v_holiday_cell4));
                $('#v_outsourcing_cell1').val(addComma(response.v_outsourcing_cell1));
                $('#v_outsourcing_cell2').val(addComma(response.v_outsourcing_cell2));
                $('#v_outsourcing_cell3').val(addComma(response.v_outsourcing_cell3));
                $('#v_outsourcing_cell4').val(addComma(response.v_outsourcing_cell4));
                $('#v_major4_company_cell1').val(addComma(response.v_major4_company_cell1));
                $('#v_major4_company_cell2').val(addComma(response.v_major4_company_cell2));
                $('#v_major4_company_cell3').val(addComma(response.v_major4_company_cell3));
                $('#v_major4_company_cell4').val(addComma(response.v_major4_company_cell4));
                $('#v_major4_company_cell5').val(addComma(response.v_major4_company_cell5));
                $('#v_major4_staff_cell1').val(addComma(response.v_major4_staff_cell1));
                $('#v_major4_staff_cell2').val(addComma(response.v_major4_staff_cell2));
                $('#v_major4_staff_cell3').val(addComma(response.v_major4_staff_cell3));
                $('#v_major4_staff_cell4').val(addComma(response.v_major4_staff_cell4));
                $('#v_major4_staff_cell5').val(addComma(response.v_major4_staff_cell5));
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
        */
    }

    $(document).ready(function(){
        list_act('');
    });
</script>