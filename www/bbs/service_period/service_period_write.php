<?php
// 현재년도
$now_year = $_GET['now_year'];
// 이전년도
$prev_year = (int) $now_year - 1;
// 선택된 서비스
$client_service = $_GET['client_service'];
?>

<form id="fregisterform" name="fregisterform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="branch_id" value="<?php echo $_SESSION['this_branch_id'] ?>">
<input type="hidden" name="spp_year" value="<?php echo $now_year ?>">
<input type="hidden" name="client_service" value="<?php echo $client_service ?>">

    <?php if($client_service == '아가마지') { ?>
        <h4 class="layer_popup_form_tit mtop20"><?php echo $client_service ?> 바우처 서비스 금액</h4>
        <?php
        $code1 = 10;
        $mn_sql = " select count(distinct a.spe_cate) as cnt from g5_service_period as a left join g5_service_menu as b on b.sme_id = a.sme_id where a.client_service = '{$client_service}' and a.spe_use = 1 and length(b.sme_code) = 6 and b.sme_code like '{$code1}%' ";
        $mn_row = sql_fetch($mn_sql);
        $hd_colspan = $mn_row['cnt'];
        
        $mn_sql = " select distinct a.spe_cate from g5_service_period as a left join g5_service_menu as b on b.sme_id = a.sme_id where a.client_service = '{$client_service}' and a.spe_use = 1 and length(b.sme_code) = 6 and b.sme_code like '{$code1}%' ";
        $mn_qry = sql_query($mn_sql);
        $mn_num = sql_num_rows($mn_qry);
        $hd_arr = Array();
        if($mn_num > 0) {
            for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                $hd_arr[$i] = $mn_row['spe_cate'];
            }
        }
        ?>
        <table>
            <thead>
                <tr>
                    <th colspan="3" rowspan="2">구분</th>
                    <th <?php echo ($hd_colspan > 1)?'colspan="'.$hd_colspan.'"':''; ?>>서비스 기간</th>
                    <th <?php echo ($hd_colspan > 1)?'colspan="'.$hd_colspan.'"':''; ?>>정부지원금</th>
                    <th <?php echo ($hd_colspan > 1)?'colspan="'.$hd_colspan.'"':''; ?>>본인부담금</th>
                </tr>
                <tr>
                    <?php
                        if(count($hd_arr) > 0) {
                            foreach ($hd_arr as $key => $value) {
                    ?>
                    <th class="x50"><?php echo $value ?></th>
                    <?php
                            }
                        }

                        if(count($hd_arr) > 0) {
                            foreach ($hd_arr as $key => $value) {
                    ?>
                    <th class="x115"><?php echo $value ?></th>
                    <?php
                            }
                        }

                        if(count($hd_arr) > 0) {
                            foreach ($hd_arr as $key => $value) {
                    ?>
                    <th class="x115"><?php echo $value ?></th>
                    <?php
                            }
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 4 and sme_code like '{$code1}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                $mn_qry = sql_query($mn_sql);
                $mn_num = sql_num_rows($mn_qry);
                if($mn_num > 0) {
                    for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                        $mn2_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_code like '{$mn_row['sme_code']}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                        $mn2_qry = sql_query($mn2_sql);
                        $mn2_num = sql_num_rows($mn2_qry);
                        if($mn2_num > 0) {
                            for($j=0; $mn2_row = sql_fetch_array($mn2_qry); $j++) {
                ?>
                <tr>
                    <?php if($j == 0) { ?><th class="x90" <?php echo ($mn2_num > 1)?'rowspan="'.$mn2_num.'"':''; ?>><?php echo $mn_row['sme_name'] ?></th><?php } ?>
                    <th class="x190"><?php echo $mn2_row['sme_info'] ?></th>
                    <th class="x115"><?php echo $mn2_row['sme_name'] ?></th>
                    <?php
                    $ca_sql = " select * from g5_service_period where sme_id = '{$mn2_row['sme_id']}' and spe_week = 'weekdays' and spe_use = 1 ";
                    $ca_qry = sql_query($ca_sql);
                    $ca_num = sql_num_rows($ca_qry);
                    if($ca_num > 0) {
                        for($k=0; $ca_row = sql_fetch_array($ca_qry); $k++) {
                    ?>
                    <th><?php echo $ca_row['spe_period'] ?></th>
                    <?php
                        }
                    }

                    $ca_sql = " select * from g5_service_period where sme_id = '{$mn2_row['sme_id']}' and spe_week = 'weekdays' and spe_use = 1 ";
                    $ca_qry = sql_query($ca_sql);
                    $ca_num = sql_num_rows($ca_qry);
                    if($ca_num > 0) {
                        for($k=0; $ca_row = sql_fetch_array($ca_qry); $k++) {
                            $price_row = null;
                            // 현재년도의 금액을 불러옴
                            if($ca_row['spe_id'] != '') {
                                $price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                $price_row = sql_fetch($price_sql);
                            }

                            // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                            if(date('Y') == $now_year && $price_row['spp_subsiby'] == '') {
                                $call_price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                $call_price_row = sql_fetch($call_price_sql);
                                if($call_price_row['spp_subsiby'] > 0) {
                                    $add_price_sql = " insert into g5_service_period_price set spe_id = '{$ca_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_subsiby = '{$call_price_row['spp_subsiby']}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                    if(sql_query($add_price_sql)) {
                                        $price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                        $price_row = sql_fetch($price_sql);
                                    }
                                }
                            }

                            // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                            $next_price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                            $next_price_row = sql_fetch($next_price_sql);
                            if($next_price_row['spp_subsiby'] == '') {
                                $call_price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                $call_price_row = sql_fetch($call_price_sql);
                                if($call_price_row['spp_subsiby'] > 0) {
                                    $add_price_sql = " insert into g5_service_period_price set spe_id = '{$ca_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_subsiby = '{$call_price_row['spp_subsiby']}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                    if(sql_query($add_price_sql)) {
                                        $price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                        $price_row = sql_fetch($price_sql);
                                    }
                                }
                            }
                    ?>
                    <td>
                        <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $ca_row['spe_id'] ?>">
                        <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $ca_row['spe_name'] ?>">
                        <input type="text" name="spp_subsiby[]" id="spp_subsiby_<?php echo $i ?>_<?php echo $j ?>_<?php echo $k ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_subsiby']) ?>">
                    </td>
                    <?php
                        }
                    }

                    $ca_sql = " select * from g5_service_period where sme_id = '{$mn2_row['sme_id']}' and spe_week = 'weekdays' and spe_use = 1 ";
                    $ca_qry = sql_query($ca_sql);
                    $ca_num = sql_num_rows($ca_qry);
                    if($ca_num > 0) {
                        for($k=0; $ca_row = sql_fetch_array($ca_qry); $k++) {
                            $price_row = null;
                            // 현재년도의 금액을 불러옴
                            if($ca_row['spe_id'] != '') {
                                $price_sql = " select * from g5_service_period_price where spe_id = '{$ca_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                $price_row = sql_fetch($price_sql);
                            }
                    ?>
                    <td>
                        <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>_<?php echo $k ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                    </td>
                    <?php
                        }
                    }
                    ?>
                </tr>
                <?php
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        
        <div class="service_period_flex">
            <div>
                <h4 class="layer_popup_form_tit mtop20"><?php echo $client_service ?> 유료 서비스 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th colspan="2" rowspan="2">구분</th>
                            <th rowspan="2">서비스 기간</th>
                            <th>서비스 금액</th>
                        </tr>
                        <tr>
                            <th>초산</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="4">평일</th>
                        </tr>
                        <?php
                        $code1 = 20;
                        $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 4 and sme_code like '{$code1}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                        $mn_qry = sql_query($mn_sql);
                        $mn_num = sql_num_rows($mn_qry);
                        if($mn_num > 0) {
                            for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                                $rowspan_sql = " select count(*) as cnt from g5_service_period as a left join g5_service_menu as b on b.sme_id = a.sme_id where a.spe_week = 'weekdays' and spe_use = 1 and b.sme_code like '{$mn_row['sme_code']}%' ";
                                $rowspan_row = sql_fetch($rowspan_sql);
                                $rowspan = $rowspan_row['cnt'];

                                $mn2_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_code like '{$mn_row['sme_code']}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                                $mn2_qry = sql_query($mn2_sql);
                                $mn2_num = sql_num_rows($mn2_qry);
                                if($mn2_num > 0) {
                                    for($j=0; $mn2_row = sql_fetch_array($mn2_qry); $j++) {
                                        $pe_sql = " select * from g5_service_period where sme_id = '{$mn2_row['sme_id']}' and spe_week = 'weekdays' and spe_use = 1 ";
                                        $pe_qry = sql_query($pe_sql);
                                        $pe_num = sql_num_rows($pe_qry);
                                        if($pe_num > 0) {
                                            for($k=0; $pe_row = sql_fetch_array($pe_qry); $k++) {
                                                // 현재년도의 금액을 불러옴
                                                if($pe_row['spe_id'] != '') {
                                                    $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                    $price_row = sql_fetch($price_sql);
                                                }

                                                // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                                if(date('Y') == $now_year && $price_row['spp_deductible'] == '') {
                                                    $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                                    $call_price_row = sql_fetch($call_price_sql);
                                                    if($call_price_row['spp_deductible'] > 0) {
                                                        $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                                        if(sql_query($add_price_sql)) {
                                                            $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                            $price_row = sql_fetch($price_sql);
                                                        }
                                                    }
                                                }

                                                // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                                $next_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                                $next_price_row = sql_fetch($next_price_sql);
                                                if($next_price_row['spp_deductible'] == '') {
                                                    $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                                    $call_price_row = sql_fetch($call_price_sql);
                                                    if($call_price_row['spp_deductible'] > 0) {
                                                        $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                                        if(sql_query($add_price_sql)) {
                                                            $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                            $price_row = sql_fetch($price_sql);
                                                        }
                                                    }
                                                }
                        ?>
                        <tr>
                            <?php if($j == 0 && $k == 0) { ?><th class="x90" <?php echo ($rowspan > 1)?'rowspan="'.$rowspan.'"':''; ?>><?php echo $mn_row['sme_name'] ?></th><?php } ?>
                            <?php if($k == 0) { ?><th class="x100" <?php echo ($pe_num > 1)?'rowspan="'.$pe_num.'"':''; ?>><?php echo $mn2_row['sme_name'] ?></th><?php } ?>
                            <th class="x115"><?php echo $pe_row['spe_name'] ?></th>
                            <td class="x115">
                                <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $pe_row['spe_id'] ?>">
                                <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $pe_row['spe_name'] ?>">
                                <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>_<?php echo $k ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                            </td>
                        </tr>
                        <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                        <tr>
                            <th colspan="4">주말</th>
                        </tr>
                        <?php
                        $code1 = 20;
                        $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 4 and sme_code like '{$code1}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                        $mn_qry = sql_query($mn_sql);
                        $mn_num = sql_num_rows($mn_qry);
                        if($mn_num > 0) {
                            for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                                $rowspan_sql = " select count(*) as cnt from g5_service_period as a left join g5_service_menu as b on b.sme_id = a.sme_id where a.spe_week = 'holiday' and spe_use = 1 and b.sme_code like '{$mn_row['sme_code']}%' ";
                                $rowspan_row = sql_fetch($rowspan_sql);
                                $rowspan = $rowspan_row['cnt'];

                                $mn2_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_code like '{$mn_row['sme_code']}%' and sme_use = 1 order by sme_order asc, sme_id asc ";
                                $mn2_qry = sql_query($mn2_sql);
                                $mn2_num = sql_num_rows($mn2_qry);
                                if($mn2_num > 0) {
                                    for($j=0; $mn2_row = sql_fetch_array($mn2_qry); $j++) {
                                        $pe_sql = " select * from g5_service_period where sme_id = '{$mn2_row['sme_id']}' and spe_week = 'holiday' and spe_use = 1 ";
                                        $pe_qry = sql_query($pe_sql);
                                        $pe_num = sql_num_rows($pe_qry);
                                        if($pe_num > 0) {
                                            for($k=0; $pe_row = sql_fetch_array($pe_qry); $k++) {
                                                // 현재년도의 금액을 불러옴
                                                if($pe_row['spe_id'] != '') {
                                                    $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                    $price_row = sql_fetch($price_sql);
                                                }

                                                // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                                if(date('Y') == $now_year && $price_row['spp_deductible'] == '') {
                                                    $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                                    $call_price_row = sql_fetch($call_price_sql);
                                                    if($call_price_row['spp_deductible'] > 0) {
                                                        $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                                        if(sql_query($add_price_sql)) {
                                                            $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                            $price_row = sql_fetch($price_sql);
                                                        }
                                                    }
                                                }

                                                // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                                $next_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                                $next_price_row = sql_fetch($next_price_sql);
                                                if($next_price_row['spp_deductible'] == '') {
                                                    $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                                    $call_price_row = sql_fetch($call_price_sql);
                                                    if($call_price_row['spp_deductible'] > 0) {
                                                        $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                                        if(sql_query($add_price_sql)) {
                                                            $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                            $price_row = sql_fetch($price_sql);
                                                        }
                                                    }
                                                }
                        ?>
                        <tr>
                            <?php if($j == 0 && $k == 0) { ?><th class="x90" <?php echo ($rowspan > 1)?'rowspan="'.$rowspan.'"':''; ?>><?php echo $mn_row['sme_name'] ?></th><?php } ?>
                            <?php if($k == 0) { ?><th class="x100" <?php echo ($pe_num > 1)?'rowspan="'.$pe_num.'"':''; ?>><?php echo $mn2_row['sme_name'] ?></th><?php } ?>
                            <th class="x115"><?php echo $pe_row['spe_name'] ?></th>
                            <td class="x115">
                                <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $pe_row['spe_id'] ?>">
                                <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $pe_row['spe_name'] ?>">
                                <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>_<?php echo $k ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                            </td>
                        </tr>
                        <?php
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div>
                <h4 class="layer_popup_form_tit mtop20">옵션 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="x100">옵션</th>
                            <th class="x115">금액</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $opt_sql = " select * from g5_service_option where client_service = '{$client_service}' and sop_use = 1 order by sop_id asc ";
                        $opt_qry = sql_query($opt_sql);
                        $opt_num = sql_num_rows($opt_qry);
                        if($opt_num > 0) {
                            for($i=0; $opt_row = sql_fetch_array($opt_qry); $i++) {
                                // 현재년도의 금액을 불러옴
                                $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                $price_row = sql_fetch($price_sql);

                                // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                if(date('Y') == $now_year && $price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }

                                // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                $next_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                $next_price_row = sql_fetch($next_price_sql);
                                if($next_price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }
                        ?>
                        <tr>
                            <th><?php echo $opt_row['sop_name'] ?></th>
                            <td>
                                <input type="hidden" name="sop_id[]" class="price_input" value="<?php echo $opt_row['sop_id'] ?>">
                                <input type="hidden" name="option_info[]" class="price_input" value="<?php echo $opt_row['sop_name'] ?>">
                                <input type="text" name="spp_price[]" id="spp_price_<?php echo $i ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_price']) ?>">
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php if($client_service == '베이비시터') { ?>
        <div class="service_period_flex">
            <div>
                <h4 class="layer_popup_form_tit"><?php echo $client_service ?> 서비스 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="x100">구분</th>
                            <?php
                            $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                            $mn_qry = sql_query($mn_sql);
                            $mn_num = sql_num_rows($mn_qry);
                            if($mn_num > 0) {
                                for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                            ?>
                            <th class="x115"><?php echo $mn_row['sme_name'] ?></th>
                            <?php
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cate_sql = " select distinct spe_cate from g5_service_period where client_service = '{$client_service}' and spe_use = 1 ";
                        $cate_qry = sql_query($cate_sql);
                        $cate_num = sql_num_rows($cate_qry);
                        if($cate_num > 0) {
                            for($i=0; $cate_row = sql_fetch_array($cate_qry); $i++) {
                        ?>
                        <tr>
                            <th><?php echo $cate_row['spe_cate'] ?></th>
                            <?php
                            $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                            $mn_qry = sql_query($mn_sql);
                            $mn_num = sql_num_rows($mn_qry);
                            if($mn_num > 0) {
                                for($j=0; $mn_row = sql_fetch_array($mn_qry); $j++) {
                                    // 현재년도의 금액을 불러옴
                                    $pe_sql = " select * from g5_service_period where sme_id = '{$mn_row['sme_id']}' and spe_cate = '{$cate_row['spe_cate']}' and spe_week = 'weekdays' and spe_use = 1 ";
                                    $pe_row = sql_fetch($pe_sql);
                                    if($pe_row['spe_id'] != '') {
                                        $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                        $price_row = sql_fetch($price_sql);
                                    }

                                    // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                    if(date('Y') == $now_year && $price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }

                                    // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                    $next_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                    $next_price_row = sql_fetch($next_price_sql);
                                    if($next_price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }
                            ?>
                            <td>
                                <?php if($pe_row['spe_id'] == '') { ?>
                                <p class="talign_c">-</p>
                                <?php }else{ ?>
                                <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $pe_row['spe_id'] ?>">
                                <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $pe_row['spe_name'] ?>">
                                <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                                <?php } ?>
                            </td>
                            <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
                <h4 class="layer_popup_form_tit">옵션 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="x100">옵션</th>
                            <th class="x115">금액</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $opt_sql = " select * from g5_service_option where client_service = '{$client_service}' and sop_use = 1 order by sop_id asc ";
                        $opt_qry = sql_query($opt_sql);
                        $opt_num = sql_num_rows($opt_qry);
                        if($opt_num > 0) {
                            for($i=0; $opt_row = sql_fetch_array($opt_qry); $i++) {
                                // 현재년도의 금액을 불러옴
                                $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                $price_row = sql_fetch($price_sql);

                                // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                if(date('Y') == $now_year && $price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }

                                // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                $next_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                $next_price_row = sql_fetch($next_price_sql);
                                if($next_price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }
                        ?>
                        <tr>
                            <th><?php echo $opt_row['sop_name'] ?></th>
                            <td>
                                <input type="hidden" name="sop_id[]" class="price_input" value="<?php echo $opt_row['sop_id'] ?>">
                                <input type="hidden" name="option_info[]" class="price_input" value="<?php echo $opt_row['sop_name'] ?>">
                                <input type="text" name="spp_price[]" id="spp_price_<?php echo $i ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_price']) ?>">
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php if($client_service == '청소') { ?>
        <div class="service_period_flex">
            <div>
                <h4 class="layer_popup_form_tit mtop20"><?php echo $client_service ?> 서비스 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="x100">구분</th>
                            <?php
                            $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                            $mn_qry = sql_query($mn_sql);
                            $mn_num = sql_num_rows($mn_qry);
                            if($mn_num > 0) {
                                for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                            ?>
                            <th class="x115"><?php echo $mn_row['sme_name'] ?></th>
                            <?php
                                }
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $cate_sql = " select distinct spe_cate from g5_service_period where client_service = '{$client_service}' and spe_use = 1 order by spe_order asc ";
                        $cate_qry = sql_query($cate_sql);
                        $cate_num = sql_num_rows($cate_qry);
                        if($cate_num > 0) {
                            for($i=0; $cate_row = sql_fetch_array($cate_qry); $i++) {
                        ?>
                        <tr>
                            <th><?php echo $cate_row['spe_cate'] ?></th>
                            <?php
                            $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                            $mn_qry = sql_query($mn_sql);
                            $mn_num = sql_num_rows($mn_qry);
                            if($mn_num > 0) {
                                for($j=0; $mn_row = sql_fetch_array($mn_qry); $j++) {
                                    // 현재년도의 금액을 불러옴
                                    $pe_sql = " select * from g5_service_period where sme_id = '{$mn_row['sme_id']}' and spe_cate = '{$cate_row['spe_cate']}' and spe_week = 'weekdays' and spe_use = 1 ";
                                    $pe_row = sql_fetch($pe_sql);
                                    if($pe_row['spe_id'] != '') {
                                        $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                        $price_row = sql_fetch($price_sql);
                                    }

                                    // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                    if(date('Y') == $now_year && $price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }

                                    // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                    $next_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                    $next_price_row = sql_fetch($next_price_sql);
                                    if($next_price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }
                            ?>
                            <td>
                                <?php
                                if($i == 0 && $j > 0) continue;
                                if($i > 0 && $j == 0) continue;
                                ?>
                                <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $pe_row['spe_id'] ?>">
                                <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $pe_row['spe_name'] ?>">
                                <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                            </td>
                            <?php
                                }
                            }
                            ?>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div>
                <h4 class="layer_popup_form_tit mtop20">옵션 금액</h4>
                <table>
                    <thead>
                        <tr>
                            <th class="x100">옵션</th>
                            <th class="x115">금액</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $opt_sql = " select * from g5_service_option where client_service = '{$client_service}' and sop_use = 1 order by sop_id asc ";
                        $opt_qry = sql_query($opt_sql);
                        $opt_num = sql_num_rows($opt_qry);
                        if($opt_num > 0) {
                            for($i=0; $opt_row = sql_fetch_array($opt_qry); $i++) {
                                // 현재년도의 금액을 불러옴
                                $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                $price_row = sql_fetch($price_sql);

                                // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                if(date('Y') == $now_year && $price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }

                                // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                $next_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                $next_price_row = sql_fetch($next_price_sql);
                                if($next_price_row['spp_price'] == '') {
                                    $call_price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                    $call_price_row = sql_fetch($call_price_sql);
                                    if($call_price_row['spp_price'] > 0) {
                                        $add_price_sql = " insert into g5_service_option_price set sop_id = '{$opt_row['sop_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_price = '{$call_price_row['spp_price']}', spp_info = '{$call_price_row['spp_info']}' ";
                                        if(sql_query($add_price_sql)) {
                                            $price_sql = " select * from g5_service_option_price where sop_id = '{$opt_row['sop_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                            $price_row = sql_fetch($price_sql);
                                        }
                                    }
                                }
                        ?>
                        <tr>
                            <th><?php echo $opt_row['sop_name'] ?></th>
                            <td>
                                <input type="hidden" name="sop_id[]" class="price_input" value="<?php echo $opt_row['sop_id'] ?>">
                                <input type="hidden" name="option_info[]" class="price_input" value="<?php echo $opt_row['sop_name'] ?>">
                                <input type="text" name="spp_price[]" id="spp_price_<?php echo $i ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_price']) ?>">
                            </td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>

    <?php if($client_service == '반찬') { ?>
        <h4 class="layer_popup_form_tit mtop20"><?php echo $client_service ?> 서비스 금액</h4>
        <table>
            <thead>
                <tr>
                    <th class="x100">구분</th>
                    <?php
                    $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                    $mn_qry = sql_query($mn_sql);
                    $mn_num = sql_num_rows($mn_qry);
                    if($mn_num > 0) {
                        for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                    ?>
                    <th class="x190"><?php echo $mn_row['sme_name'] ?></th>
                    <?php
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>서비스요금</th>
                    <?php
                    $mn_sql = " select * from g5_service_menu where client_service = '{$client_service}' and length(sme_code) = 6 and sme_use = 1 order by sme_order asc, sme_code asc ";
                    $mn_qry = sql_query($mn_sql);
                    $mn_num = sql_num_rows($mn_qry);
                    if($mn_num > 0) {
                        for($i=0; $mn_row = sql_fetch_array($mn_qry); $i++) {
                            $pe_sql = " select * from g5_service_period where sme_id = '{$mn_row['sme_id']}' and spe_week = 'weekdays' and spe_use = 1 order by spe_id asc ";
                            $pe_qry = sql_query($pe_sql);
                            $pe_num = sql_num_rows($pe_qry);
                            if($pe_num > 0) {
                                for($j=0; $pe_row = sql_fetch_array($pe_qry); $j++) {
                                    // 현재년도의 금액을 불러옴
                                    $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                    $price_row = sql_fetch($price_sql);

                                    // 현재년도의 값이 비어있을 경우 이전년도의 값을 불러올 수 있도록 설정
                                    if(date('Y') == $now_year && $price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$prev_year}' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '{$now_year}', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }

                                    // 내년도의 값이 비어있을 경우 현재년도의 값을 불러올 수 있도록 설정
                                    $next_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y')+1)."' ";
                                    $next_price_row = sql_fetch($next_price_sql);
                                    if($next_price_row['spp_deductible'] == '') {
                                        $call_price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '".(date('Y'))."' ";
                                        $call_price_row = sql_fetch($call_price_sql);
                                        if($call_price_row['spp_deductible'] > 0) {
                                            $add_price_sql = " insert into g5_service_period_price set spe_id = '{$pe_row['spe_id']}', branch_id = '{$_SESSION['this_branch_id']}', spp_year = '".(date('Y')+1)."', spp_deductible = '{$call_price_row['spp_deductible']}', spp_info = '{$call_price_row['spp_info']}' ";
                                            if(sql_query($add_price_sql)) {
                                                $price_sql = " select * from g5_service_period_price where spe_id = '{$pe_row['spe_id']}' and branch_id = '{$_SESSION['this_branch_id']}' and spp_year = '{$now_year}' ";
                                                $price_row = sql_fetch($price_sql);
                                            }
                                        }
                                    }
                    ?>
                    <td>
                        <input type="hidden" name="spe_id[]" class="price_input" value="<?php echo $pe_row['spe_id'] ?>">
                        <input type="hidden" name="spp_info[]" class="price_input" value="<?php echo $pe_row['spe_name'] ?>">
                        <input type="text" name="spp_deductible[]" id="spp_deductible_<?php echo $i ?>_<?php echo $j ?>" class="price_input" oninput="inputNum(this.id)" value="<?php echo number_format($price_row['spp_deductible']) ?>">
                    </td>
                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    <?php } ?>

</form>

<script>
$(function(){
    if($('.price_input').length > 0) {
        for(let i=0; i<$('.price_input').length; i++) {
            $('.price_input').eq(i).val(addComma($('.price_input').eq(i).val()));
        }
    }

    $('.price_input').on('input', function(){
        $(this).val(addComma($(this).val()));
    });
});
</script>