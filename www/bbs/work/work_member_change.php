<?php
$client_idx = $_GET['client_idx'];
$mb_id = $_GET['mb_id'];

$now_year = $_GET['now_month'];
$now_month = $_GET['now_month'];

$popup_tit = '파견관리사 선택';

$client_sql = " select * from g5_client where client_idx = '{$client_idx}' ";
$client_row = sql_fetch($client_sql);

$area_x = $client_row['cl_area_x'];
$area_y = $client_row['cl_area_y'];

$where_str = "";
$orderby_str = "";

$where_str .= " and mb_menu = '{$_SESSION['this_code']}' and branch_id = '{$_SESSION['this_branch_id']}' and mb_level = 2 and mb_hide = '' and activity_status = '활동중'";

if($area_x != '' && $area_y != '') {
    $orderby_str .= ", activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select *, 
    ( 6371 * acos( cos( radians( $area_y ) ) * cos( radians( mb_area_y ) ) * cos( radians( mb_area_x ) - radians( $area_x ) ) + sin( radians( $area_y ) ) * sin( radians( mb_area_y ) ) ) ) AS distance
    from g5_member where (1=1) {$where_str} 
    HAVING distance < 100 
    order by distance asc {$orderby_str} ";
}else{
    $orderby_str .= "activity_status = '활동중' desc, activity_status = '보류' desc, activity_status = '휴직' desc, activity_status = '퇴사' desc, mb_name asc";

    $sql = " select * from g5_member where (1=1) {$where_str} order by {$orderby_str} ";
}
$qry = sql_query($sql);
$num = sql_num_rows($qry);
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_back_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="client_idx" id="client_idx" value="<?php echo $client_idx ?>">

        <input type="hidden" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" id="now_month" value="<?php echo $now_month ?>">

        <div class="layer_popup_form">
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl" id="work_member_tbl_hd">
                    <thead>
                        <tr>
                            <th></th>
                            <th>현황</th>
                            <th>직원명</th>
                            <th>팀</th>
                            <th>연락처</th>
                            <th>생년월일</th>
                            <th>파견</th>
                            <th>반려동물</th>
                            <th>행정구역</th>
                            <th>특이사항</th>
                        </tr>
                    </thead>
                </table>
                <table class="layer_list_tbl" id="work_member_tbl">
                    <tbody>
                        <?php
                        if($num > 0) {
                            for($i=0; $row = sql_fetch_array($qry); $i++) {
                                $mb_addr_arr = explode(' ', $row['mb_addr1']);
                                $mb_addr = '';
                                if($row['mb_addr1'] != '') $mb_addr = $mb_addr_arr[1];
                        ?>
                        <tr <?php echo ($row['mb_id'] == $mb_id)?'class="member_select_list_selected"':''; ?>>
                            <td>
                                <input type="checkbox" name="select_mb_id[]" id="select_mb_id<?php echo $i ?>" class="member_select_check" value="<?php echo $row['mb_id'] ?>" <?php echo ($row['mb_id'] == $mb_id)?'checked':''; ?>>
                            </td>
                            <td><?php echo $row['activity_status'] ?></td>
                            <td><?php echo $row['mb_name'] ?></td>
                            <td><?php echo $row['team_category'] ?></td>
                            <td><?php echo $row['mb_hp'] ?></td>
                            <td><?php echo wz_get_birth($row['security_number']) ?></td>
                            <td></td>
                            <td><?php echo $row['pet_use'] ?></td>
                            <td>
                                <?php
                                if($area_x != '' && $area_y != '') echo '['.round($row['distance'], 1).'km] ';
                                echo $mb_addr;
                                ?>
                            </td>
                            <td class="talign_l"><?php echo $row['mb_memo2'] ?></td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="change_submit_btn">저장하기</a>
</div>

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