<?php
$client_idx = $_GET['client_idx'];
$this_date = $_GET['this_date'];

$popup_tit = '일정등록';

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

$branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
$branch_row = sql_fetch($branch_sql);

// 서비스분류
$service_menu_sql = " select * from g5_service_menu where sme_code = '{$client_row['cl_service_cate']}' and sme_use = 1 ";
$service_menu_row = sql_fetch($service_menu_sql);

// 서비스구분
$service_menu2_sql = " select * from g5_service_menu where sme_id = '{$client_row['cl_service_cate2']}' and sme_use = 1 ";
$service_menu2_row = sql_fetch($service_menu2_sql);

// 서비스기간
$service_period_sql = " select distinct spe_cate, spe_name, spe_period, spe_info, spe_id from g5_service_period where spe_id = '{$client_row['cl_service_period']}' ";
$service_period_row = sql_fetch($service_period_sql);
$spe_info = '';
if($client_row['cl_service_cate'] == 10 || $client_row['cl_service_cate'] == 20) {
    $spe_info = $service_period_row['spe_info'];
}else if($client_row['cl_service_cate'] == 30) {
    $spe_info = $service_period_row['spe_name'];
}else{
    $spe_info = $service_period_row['spe_cate'];
}

// 추가옵션
$service_option_sql = " select * from g5_service_option where sop_id = '{$client_row['cl_service_option']}' and sop_use = 1 order by sop_id asc ";
$service_option_row = sql_fetch($service_option_sql);

$school_preschool = '';
if($client_row['cl_school'] != '') $school_preschool .= '취학 : '.$client_row['cl_school'].'명';
if($client_row['cl_school'] != '' && $client_row['cl_preschool'] != '') $school_preschool .= ' / ';
if($client_row['cl_preschool'] != '') $school_preschool .= '미취학 : '.$client_row['cl_preschool'].'명';

// 파견정보 불러오기
$work_sql = " select * from g5_work where client_idx = '{$client_idx}' ";
$work_row = sql_fetch($work_sql);

// 파견관리사 정보 불러오기
if($work_row['mb_id'] == '') {
    $work_member = '등록된 파견관리사 없음';
}else{
    $popup_tit = '일정변경';

    $work_mb_sql = " select * from g5_member where mb_id = '{$work_row['mb_id']}' ";
    $work_mb_row = sql_fetch($work_mb_sql);

    $work_member = ($work_mb_row['security_number'] != '')?$work_mb_row['mb_name'].' ('.substr($work_mb_row['security_number'], 0, 8).')':$work_mb_row['mb_name'];

    $mb_id = $work_row['mb_id'];
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="select_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">
        <input type="hidden" name="this_date" id="this_date" value="<?php echo $this_date ?>">

        <div class="layer_popup_form">
            <div class="work_add_form">
                <div>
                    <div class="form_tbl_wrap">
                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th class="x90">시작일자</th>
                                    <td class="x150"><?php echo ($client_row['receipt_date'] == '0000-00-00')?'':$client_row['receipt_date']; ?></td>
                                    <th class="x90">종료일자</th>
                                    <td><?php echo ($client_row['str_date'] == '0000-00-00')?'':$client_row['str_date']; ?></td>
                                </tr>
                                <tr>
                                    <th>서비스구분</th>
                                    <td colspan="3">
                                        <?php echo ($service_menu_row['sme_name'] != '')?'['.$service_menu_row['sme_name'].'] ':''; ?>
                                        <?php echo $service_menu2_row['sme_name'] ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>서비스기간</th>
                                    <td colspan="3"><?php echo $spe_info ?></td>
                                </tr>
                                <tr>
                                    <th>추가옵션</th>
                                    <td colspan="3"><?php echo $service_option_row['sop_name'] ?></td>
                                </tr>

                                <?php if($client_row['client_service'] == '아가마지') { ?>
                                <tr>
                                    <th>취학/미취학</th>
                                    <td><?php echo $school_preschool ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '베이비시터') { ?>
                                <tr>
                                    <th>쌍둥이유무</th>
                                    <td><?php echo ($client_row['cl_twins'] == 'y')?'있음':'없음'; ?></td>
                                    <th>큰아이유무</th>
                                    <td><?php echo ($client_row['cl_baby_first'] == 'y')?'있음':'없음'; ?></td>
                                </tr>
                                <tr>
                                    <th>출산순위</th>
                                    <td><?php echo $client_row['cl_baby_count'] ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '청소') { ?>
                                <tr>
                                    <th>연장근무</th>
                                    <td><?php echo ($client_row['cl_overtime'] == 'y')?'있음':'없음'; ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <?php if($client_row['client_service'] == '반찬') { ?>
                                <tr>
                                    <th>추가요금부담</th>
                                    <td><?php echo $client_row['cl_surcharge'] ?></td>
                                    <th>사전면접</th>
                                    <td><?php echo $client_row['cl_prior_interview']; ?></td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <th>단가구분</th>
                                    <td><?php echo ($client_row['cl_cctv'] == 'y')?'있음':'없음' ?></td>
                                    <th>합계금액</th>
                                    <td><?php echo $client_row['cl_pet'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>

<div id="select_layer_popup_bg"></div>
<div id="select_layer_popup" class="x500"></div>

<script>
let mb_profile;

$(function(){
    $(".date_api").datepicker(datepicker_option);
});

calendar_call();

function mini_calendar_call() {
    /*
    let this_year = $('#this_year').val();
    let this_month = $('#this_month').val();
    let month_val = this_month;
    if(this_month < 10) month_val = '0' + month_val;

    $.ajax({
        url: g5_bbs_url + "/ajax.mini_calendar_call.php", // 클라이언트가 HTTP 요청을 보낼 서버의 URL 주소
        data: {'this_year': this_year, 'this_month': this_month}, // HTTP 요청과 함께 서버로 보낼 데이터
        method: "POST", // HTTP 요청 메소드(GET, POST 등)
        dataType: "json", // 서버에서 보내줄 데이터의 타입 })
        success: function(rst){
            console.log(rst);

            let datas = '';

            let n = 1;
            for(let i=0; i<rst.tweek; i++) {
                datas += '<tr>';

                for(let k=0; k<7; k++) {
                    datas += '<td class="calendar_td">';
                    if((i == 0 && k < rst.sweek) || (i == rst.tweek-1 && k > rst.lweek)) {
                        datas += '</td>';
                        continue;
                    }

                    let nn = n;
                    if(nn < 10) nn = '0' + nn;

                    let this_date = this_year + '-' + month_val + '-' + nn;

                    datas += '<a class="mini_calendar_btn" mini_this_date="' + this_date + '">' + nn + '</a>';

                    n++;
                    datas += '</td>';
                }

                datas += '</tr>';
            }

            $('#mini_calendar_list').empty();
            $('#mini_calendar_list').append(datas);
        }
    });
    */
}
</script>