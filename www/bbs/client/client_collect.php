<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/client/client_collect.css?ver=2">', 0);

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

$sch_service_cate = $_GET['sch_service_cate'];
$sch_status = $_GET['sch_status'];
$sch_deposit_status = $_GET['sch_deposit_status'];
$sch_str_selected_date = $_GET['sch_str_selected_date'];
$sch_end_selected_date = $_GET['sch_end_selected_date'];
$sch_cl_name = $_GET['sch_cl_name'];
$sch_cl_hp = $_GET['sch_cl_hp'];
?>

<input type="hidden" id="now_year" value="<?php echo $now_year ?>">

<div id="layer_wrap">
    <div id="layer_box">
        <!-- Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="filter_box">
                <select class="filter_select" id="sch_service_cate">
                    <option value="" <?php echo ($sch_service_cate == '')?'selected':''; ?>>서비스분류선택</option>
                    <?php
                    $service_menu_sql = " select * from g5_service_menu where client_menu = '{$_SESSION['this_code']}' and length(sme_code) = 2 and sme_use = 1 order by sme_code asc, sme_order asc ";
                    $service_menu_qry = sql_query($service_menu_sql);
                    $service_menu_num = sql_num_rows($service_menu_qry);
                    if($service_menu_num > 0) {
                        for($l=0; $service_menu_row = sql_fetch_array($service_menu_qry); $l++) {
                    ?>
                    <option value="<?php echo $service_menu_row['sme_code'] ?>" <?php echo ($sch_service_cate == $service_menu_row['sme_code'])?'selected':''; ?>><?php echo $service_menu_row['sme_name'] ?></option>
                    <?php
                        }
                    }
                    ?>
                    <?php if($_SESSION['this_code'] == '20') { ?><option value="10|20">바우처+유료</option><?php } ?>
                </select>
                <label>진행상태</label>
                <select class="filter_select" id="sch_status">
                    <option value="" <?php echo ($sch_status == '')?'selected':''; ?>>전체</option>
                    <option value="대기" <?php echo ($sch_status == '대기')?'selected':''; ?>>대기</option>
                    <option value="진행" <?php echo ($sch_status == '진행')?'selected':''; ?>>진행</option>
                    <option value="완료" <?php echo ($sch_status == '완료')?'selected':''; ?>>완료</option>
                </select>
                <label>입금상태</label>
                <select class="filter_select" id="sch_deposit_status">
                    <option value="" <?php echo ($sch_deposit_status == '')?'selected':''; ?>>전체</option>
                    <option value="입금완료" <?php echo ($sch_deposit_status == '입금완료')?'selected':''; ?>>입금완료</option>
                </select>
                <label>파견일자</label>
                <input type="text" class="filter_input_date date_api" id="sch_str_selected_date" value="<?php echo $sch_str_selected_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="파견일자"> ~ 
                <input type="text" class="filter_input_date date_api" id="sch_end_selected_date" value="<?php echo $sch_end_selected_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="파견일자">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_name" value="<?php echo $sch_cl_name ?>" placeholder="신청인">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_hp" value="<?php echo $sch_cl_hp ?>" oninput="autoHyphen(this)" maxlength="13" placeholder="연락처">
            </div>
        </div>
        <!-- Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <li class="menu_list" id="menu_list_act"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/client_collect.php">수급관리</a></li>
            </ul>
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl width_max">
                    <thead>
                        <tr>
                            <th>파견</th>
                            <th>입금</th>
                            <th>바우처</th>
                            <th>유료추가</th>
                            <th>신청인</th>
                            <th>생년월일</th>
                            <th>연락처</th>
                            <th>시작일</th>
                            <th>종료일</th>
                            <th>파견일수</th>
                            <th>입금자명</th>
                            <th>수금액</th>
                            <th>잔액</th>
                            <th>현금영수증번호</th>
                            <th>관리사</th>
                            <th>바우처단가</th>
                            <th>정부지원금</th>
                            <th>본인부담금</th>
                            <th>유료추가금</th>
                        </tr>
                    </thead>
                </table>

                <table class="layer_list_tbl width_max">
                    <tbody id="client_list">
                        <tr class="list_selected" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                        <tr class="deposit_status" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                        <tr class="" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                        <tr class="" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                        <tr class="deposit_status" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                        <tr class="deposit_status" client_idx="15" work_idx="1">
                            <td>파견</td>
                            <td>입금완료</td>
                            <td>바우처</td>
                            <td>유료추가</td>
                            <td>신청인신청인</td>
                            <td>1990-06-23</td>
                            <td>010-9999-9999</td>
                            <td>2024-07-22</td>
                            <td>2024-07-25</td>
                            <td>100</td>
                            <td>신청인</td>
                            <td class="talign_r">55,555,555</td>
                            <td class="talign_r">55,555,555</td>
                            <td>010-9999-9999</td>
                            <td>관리사관리사</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                            <td class="talign_r">5,555,555</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->

        <div class="collect_wrap">
            <div class="collect_box">
                <div class="collect_list_box">
                    <div class="collect_list_top">
                        <div>
                            <a class="set_btn" id="add_collect_btn">수금등록</a>
                        </div>
                        <div></div>
                    </div>
                    <div class="layer_list_box">
                        <table class="layer_list_hd_tbl width_max">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="collect_all_check" value="all">
                                    </th>
                                    <th>No.</th>
                                    <th>신청인</th>
                                    <th>수금일자</th>
                                    <th>수금구분</th>
                                    <th>수금액</th>
                                    <th>입금자명</th>
                                    <th>현금영수증</th>
                                    <th>현금영수증번호</th>
                                    <th>현·영발행일</th>
                                    <th>수금여부</th>
                                    <th>비고</th>
                                </tr>
                            </thead>
                        </table>

                        <table class="layer_list_tbl width_max">
                            <tbody id="collect_list">
                                <tr class="list_selected">
                                    <td></td>
                                    <td>1</td>
                                    <td>김민아</td>
                                    <td>2024-07-10</td>
                                    <td>현금</td>
                                    <td>3,110,000</td>
                                    <td>김민아</td>
                                    <td>발행</td>
                                    <td>010-9999-9999</td>
                                    <td>2024-07-10</td>
                                    <td>입금완료</td>
                                    <td>삼성/BC</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="layer_popup_bg"></div>
<div id="layer_popup" class="x1050"></div>

<script>
let write_ajax;

$(function(){
    $(document).on('change', '#sch_service_cate, #sch_status, #sch_deposit_status', function(){
        list_act();
    });

    $(document).on('input', '#sch_str_selected_date, #sch_end_selected_date, #sch_cl_name, #sch_cl_hp', function(){
        list_act();
    });

    $(document).on('click', '#client_list > tr', function(){
        $('#client_list > tr').removeClass('list_selected');
        $(this).addClass('list_selected');
    });

    <?php if($write_permit === true) { ?>
    $(document).on('click', '#add_collect_btn', function(){
        $("#layer_popup").load(g5_bbs_url + "/client_collect_write.php");

        $('#layer_popup').css('display', 'block');
        $('#layer_popup_bg').css('display', 'block');
    });
    <?php } ?>
});

$(document).ready(function(){
    list_act();
});

function list_act() {
    let sch_service_cate = $('#sch_service_cate').val();
    let sch_status = $('#sch_status').val();
    let sch_deposit_status = $('#sch_deposit_status').val();
    let sch_str_selected_date = $('#sch_str_selected_date').val();
    let sch_end_selected_date = $('#sch_end_selected_date').val();
    let sch_cl_name = $('#sch_cl_name').val();
    let sch_cl_hp = $('#sch_cl_hp').val();

    $.ajax({
        url: g5_bbs_url + '/ajax.client_list.php',
        type: "POST",
        data: {'mode': 'collect', 'sch_service_cate': sch_service_cate, 'sch_str_selected_date': sch_str_selected_date, 'sch_end_selected_date': sch_end_selected_date, 'sch_cl_name': sch_cl_name, 'sch_cl_hp': sch_cl_hp, 'sch_status': sch_status, 'sch_deposit_status': sch_deposit_status},
        dataType: "json",
        success: function(response) {
            console.log(response);
            // 전송이 성공한 경우 받는 응답 처리
            /*
            $('#client_list').empty();
            let datas = '';
            let list_selected = '';

            if(response.length > 0) {
                for(let i=0; i<response.length; i++) {
                    list_selected = '';
                    if(i == 0) {
                        list_selected = 'list_selected';
                    }

                    datas += '<tr class="' + list_selected + '" client_idx="' + response[i].client_idx + '" area_x="' + response[i].area_x + '" area_y="' + response[i].area_y + '" client_service="' + response[i].client_service + '">';
                    datas += '<td>' + response[i].use_status + '</td>';
                    datas += '<td>' + response[i].receipt_date + '</td>';
                    datas += '<td>' + response[i].client_service + '</td>';
                    datas += '<td>' + response[i].cl_service_cate2 + '</td>';
                    datas += '<td>' + response[i].cl_service_period + '</td>';
                    datas += '<td>' + response[i].cl_name + '</td>';
                    datas += '<td>' + response[i].cl_hp + '</td>';
                    datas += '<td>' + response[i].cl_security_number + '</td>';
                    datas += '<td>' + response[i].str_date + '</td>';
                    datas += '<td>' + response[i].end_date + '</td>';
                    datas += '<td>' + response[i].cancel_date + '</td>';
                    datas += '<td>' + response[i].cctv + '</td>';
                    datas += '<td>' + response[i].pet + '</td>';
                    datas += '<td>' + response[i].prior_interview + '</td>';
                    datas += '</tr>';
                }

                $('#client_list').append(datas);

                list_member_act();
                list_work_selected_act();
            }
            */
        },
        error: function(error) {
            // 전송이 실패한 경우 받는 응답 처리
        }
    });
}
</script>
