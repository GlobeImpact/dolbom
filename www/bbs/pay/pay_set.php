<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/pay/pay_set.css">', 0);

/* 현재 날짜의 DB 데이터가 없을 경우 이전 달의 데이터 불러와서 생성 STR */
$check_year = date('Y');
$payment_year = $check_year;
$check_month = date('m');
$payment_month = $check_month + 1;
if($payment_month > 12) {
    $payment_year++;
    $payment_month = '01';
}else if($payment_month < 10) {
    $payment_month = '0'.$payment_month;
}
$pay_set_check_sql = " select * from g5_pay_set where mb_menu = '{$_SESSION['this_code']}' and set_year = '{$check_year}' and set_month = '{$check_month}' ";
$pay_set_check_row = sql_fetch($pay_set_check_sql);
if(!$pay_set_check_row) {
    $prev_check_year = date('Y');
    if(idate('m') == 1) {
        $prev_check_year = $prev_check_year - 1;
        $prev_check_month = 12;
    }else{
        $prev_check_month = idate('m') - 1;
        if($prev_check_month < 10) $prev_check_month = '0'.$prev_check_month;
    }

    if(count(${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}) > 0) {
        $pay_set_prev_check_sql = " select * from g5_pay_set where mb_menu = '{$_SESSION['this_code']}' and set_year = '{$prev_check_year}' and set_month = '{$prev_check_month}' ";
        $pay_set_prev_check_row = sql_fetch($pay_set_prev_check_sql);
        $check_payment_day = $pay_set_prev_check_row['payment_day'];
        if($check_payment_day == '') $check_payment_day = '09';
        for($p=0; $p<count(${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}); $p++) {
            $ins_pay_set_sql = "insert into g5_pay_set set 
                mb_menu = '{$_SESSION['this_code']}', 
                contract_type = '".${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$p]."', 
                set_year = '{$check_year}', 
                set_month = '{$check_month}', 
                payment_year = '{$payment_year}', 
                payment_month = '{$payment_month}', 
                payment_day = '{$check_payment_day}', 
                info_cell1 = '{$pay_set_prev_check_row['info_cell1']}', 
                info_cell2 = '{$pay_set_prev_check_row['info_cell2']}', 
                info_cell3 = '{$pay_set_prev_check_row['info_cell3']}', 
                item_cell1 = '{$pay_set_prev_check_row['item_cell1']}', 
                item_cell2 = '{$pay_set_prev_check_row['item_cell2']}', 
                item_cell3 = '{$pay_set_prev_check_row['item_cell3']}', 
                item_cell4 = '{$pay_set_prev_check_row['item_cell4']}', 
                item_cell5 = '{$pay_set_prev_check_row['item_cell5']}', 
                item_cell6 = '{$pay_set_prev_check_row['item_cell6']}', 
                add_cell1 = '{$pay_set_prev_check_row['add_cell1']}', 
                add_cell2 = '{$pay_set_prev_check_row['add_cell2']}', 
                add_cell3 = '{$pay_set_prev_check_row['add_cell3']}', 
                add_cell4 = '{$pay_set_prev_check_row['add_cell4']}', 
                add_cell5 = '{$pay_set_prev_check_row['add_cell5']}', 
                add_cell6 = '{$pay_set_prev_check_row['add_cell6']}', 
                add_cell7 = '{$pay_set_prev_check_row['add_cell7']}', 
                service_cell1 = '{$pay_set_prev_check_row['service_cell1']}', 
                service_cell2 = '{$pay_set_prev_check_row['service_cell2']}', 
                service_cell3 = '{$pay_set_prev_check_row['service_cell3']}', 
                service_cell4 = '{$pay_set_prev_check_row['service_cell4']}', 
                service_cell5 = '{$pay_set_prev_check_row['service_cell5']}', 
                service_cell6 = '{$pay_set_prev_check_row['service_cell6']}', 
                holiday_cell1 = '{$pay_set_prev_check_row['holiday_cell1']}', 
                holiday_cell2 = '{$pay_set_prev_check_row['holiday_cell2']}', 
                holiday_cell3 = '{$pay_set_prev_check_row['holiday_cell3']}', 
                holiday_cell4 = '{$pay_set_prev_check_row['holiday_cell4']}', 
                outsourcing_cell1 = '{$pay_set_prev_check_row['outsourcing_cell1']}', 
                outsourcing_cell2 = '{$pay_set_prev_check_row['outsourcing_cell2']}', 
                outsourcing_cell3 = '{$pay_set_prev_check_row['outsourcing_cell3']}', 
                outsourcing_cell4 = '{$pay_set_prev_check_row['outsourcing_cell4']}', 
                major4_company_cell1 = '{$pay_set_prev_check_row['major4_company_cell1']}', 
                major4_company_cell2 = '{$pay_set_prev_check_row['major4_company_cell2']}', 
                major4_company_cell3 = '{$pay_set_prev_check_row['major4_company_cell3']}', 
                major4_company_cell4 = '{$pay_set_prev_check_row['major4_company_cell4']}', 
                major4_company_cell5 = '{$pay_set_prev_check_row['major4_company_cell5']}', 
                major4_staff_cell1 = '{$pay_set_prev_check_row['major4_staff_cell1']}', 
                major4_staff_cell2 = '{$pay_set_prev_check_row['major4_staff_cell2']}', 
                major4_staff_cell3 = '{$pay_set_prev_check_row['major4_staff_cell3']}', 
                major4_staff_cell4 = '{$pay_set_prev_check_row['major4_staff_cell4']}'
            ";
            sql_query($ins_pay_set_sql);
        }
    }
}
/* 현재 날짜의 DB 데이터가 없을 경우 이전 달의 데이터 불러와서 생성 END */
?>

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
                        <select class="filter_select" id="sch_contract_type">
                            <option value="">지급구분</option>
                            <?php for($l=0; $l<count(${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}); $l++) { ?>
                            <option value="<?php echo ${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$l] ?>"><?php echo ${'set_mn'.$_SESSION['this_code'].'_contract_type_arr'}[$l] ?></option>
                            <?php } ?>
                        </select>

                        <select class="filter_select" id="sch_year">
                            <option value="">귀속년도</option>
                            <?php
                            $max_year = date('Y');
                            $min_year_sql = " select min(`set_year`) as min_year from g5_pay_set where mb_menu = '{$_SESSION['this_code']}' ";
                            $min_year_row = sql_fetch($min_year_sql);
                            $min_year = date('Y') - 1;
                            if($min_year_row['min_year'] != '') $min_year = $min_year_row['min_year'];
                            for($y=$max_year; $y>=$min_year; $y--) {
                            ?>
                            <option value="<?php echo $y ?>"><?php echo $y ?></option>
                            <?php
                            }
                            ?>
                        </select>

                        <select class="filter_select" id="sch_month">
                            <option value="">귀속월</option>
                            <?php
                            for($l=1; $l<=12; $l++) {
                                $l_txt = $l;
                                if($l_txt < 10) $l_txt = '0'.$l_txt;
                            ?>
                            <option value="<?php echo $l_txt ?>"><?php echo $l_txt ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="list_wrap_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th class="x120">지급구분</th>
                                <th class="x80">귀속년월</th>
                                <th>지급일자</th>
                            </tr>
                        </thead>
                    </table>
                    <div class="list_wrap_list_box">
                        <table class="list_tbl">
                            <tbody id="pay_set_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Left Menu END -->


            <input type="hidden" id="v_set_idx" value="">
            <div class="form_wrap">
                <div class="form_row">
                    <div class="form_box xp18">
                        <h4 class="sub_tit">기본정보</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>지급구분</th>
                                    <td class="x75">
                                        <input type="text" id="v_contract_type" class="form_input xp100" value="" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>귀속년월</th>
                                    <td>
                                        <input type="text" id="v_set_ym" class="form_input xp100" value="" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <th>지급일자</th>
                                    <td>
                                        <input type="text" id="v_payment_ymd" class="form_input xp100" value="">
                                    </td>
                                </tr>
                                <tr>
                                    <th>시급</th>
                                    <td>
                                        <input type="text" id="v_info_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료평일</th>
                                    <td>
                                        <input type="text" id="v_info_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처평일</th>
                                    <td>
                                        <input type="text" id="v_info_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box xp21">
                        <h4 class="sub_tit">기본항목</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>바우처 토요일</th>
                                    <td class="x75">
                                        <input type="text" id="v_item_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료 토요일</th>
                                    <td>
                                        <input type="text" id="v_item_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>연차적립(일단가)</th>
                                    <td>
                                        <input type="text" id="v_item_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>프리미엄수당</th>
                                    <td>
                                        <input type="text" id="v_item_cell4" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>취학수당</th>
                                    <td>
                                        <input type="text" id="v_item_cell5" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>미취학수당</th>
                                    <td>
                                        <input type="text" id="v_item_cell6" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box xp20">
                        <h4 class="sub_tit">추가수당</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>유료수당</th>
                                    <td class="x75">
                                        <input type="text" id="v_add_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>쌍생아(바우처)</th>
                                    <td>
                                        <input type="text" id="v_add_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>쌍생아(유료)</th>
                                    <td>
                                        <input type="text" id="v_add_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>삼태아수당</th>
                                    <td>
                                        <input type="text" id="v_add_cell4" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>장애우산모</th>
                                    <td>
                                        <input type="text" id="v_add_cell5" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>입주단가</th>
                                    <td>
                                        <input type="text" id="v_add_cell6" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>고급형단가</th>
                                    <td>
                                        <input type="text" id="v_add_cell7" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box xp22">
                        <h4 class="sub_tit">서비스수당</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>바우처(큰아이)</th>
                                    <td class="x75">
                                        <input type="text" id="v_service_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처(큰아이2명)</th>
                                    <td>
                                        <input type="text" id="v_service_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처(마사지)</th>
                                    <td>
                                        <input type="text" id="v_service_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료(큰아이)</th>
                                    <td>
                                        <input type="text" id="v_service_cell4" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료(큰아이2명)</th>
                                    <td>
                                        <input type="text" id="v_service_cell5" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료(마사지)</th>
                                    <td>
                                        <input type="text" id="v_service_cell6" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box xp16">
                        <h4 class="sub_tit">휴일수당</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>주차수당</th>
                                    <td class="x75">
                                        <input type="text" id="v_holiday_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>연차수당</th>
                                    <td>
                                        <input type="text" id="v_holiday_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>휴일수당</th>
                                    <td>
                                        <input type="text" id="v_holiday_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>지정수당</th>
                                    <td>
                                        <input type="text" id="v_holiday_cell4" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form_row">
                    <div class="form_box xp18">
                        <h4 class="sub_tit">외주관리사</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>유료(일급)</th>
                                    <td class="x75">
                                        <input type="text" id="v_outsourcing_cell1" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처(일급)</th>
                                    <td>
                                        <input type="text" id="v_outsourcing_cell2" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>입주(일급)</th>
                                    <td>
                                        <input type="text" id="v_outsourcing_cell3" class="form_input xp100" value="" oninput="inputNum(this.id)">
                                    </td>
                                </tr>
                                <tr>
                                    <th>소득세공제</th>
                                    <td>
                                        <input type="text" id="v_outsourcing_cell4" class="form_input xp67" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box xp81_3">
                        <h4 class="sub_tit">4대보험 요율표</h4>

                        <table class="form_tbl2">
                            <thead>
                                <tr>
                                    <th colspan="2">사업자</th>
                                    <th colspan="2">가입자</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th class="x90">국민연금</th>
                                    <td class="x80">
                                        <input type="text" id="v_major4_company_cell1" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>
                                        <input type="text" id="v_major4_staff_cell1" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>[ 표준월소득액 기준 ]</td>
                                </tr>
                                <tr>
                                    <th>건강보험</th>
                                    <td>
                                        <input type="text" id="v_major4_company_cell2" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>
                                        <input type="text" id="v_major4_staff_cell2" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>[ 보수월액 기준 ]</td>
                                </tr>
                                <tr>
                                    <th>장기요양보험</th>
                                    <td>
                                        <input type="text" id="v_major4_company_cell3" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>
                                        <input type="text" id="v_major4_staff_cell3" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>[ 보수월액 기준 ]</td>
                                </tr>
                                <tr>
                                    <th>고용보험</th>
                                    <td>
                                        <input type="text" id="v_major4_company_cell4" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>
                                        <input type="text" id="v_major4_staff_cell4" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>[ 보수월액 기준 ]</td>
                                </tr>
                                <tr>
                                    <th>산재보험</th>
                                    <td>
                                        <input type="text" id="v_major4_company_cell5" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>
                                        <input type="text" id="v_major4_staff_cell5" class="form_input xp65" value="" oninput="inputNum2(this.id)"> (%)
                                    </td>
                                    <td>[ 사업자 전액부담 ]</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form_row">
                    <a id="form_submit_btn">저장</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#sch_contract_type').change(function(){
            list_act('');
        });

        $('#sch_year').change(function(){
            list_act('');
        });

        $('#sch_month').change(function(){
            list_act('');
        });

        $(document).on('click', '#pay_set_list > tr', function(){
            $('#pay_set_list > tr').removeClass('list_selected');
            $(this).addClass('list_selected');

            view_act();
        });

        $('.form_input').on('input', function(){
            $(this).val(addComma($(this).val()));
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
            url: g5_bbs_url + '/ajax.pay_set_list.php',
            type: "POST",
            data: {'sch_contract_type': sch_contract_type, 'sch_year': sch_year, 'sch_month': sch_month, 'set_idx': set_idx},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                // console.log(response);

                $('#pay_set_list').empty();
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

                    $('#pay_set_list').append(datas);
                }

                view_act();
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    function view_act() {
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
    }

    $(document).ready(function(){
        list_act('');
    });
</script>