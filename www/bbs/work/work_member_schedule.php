<?php
$mb_id = $_GET['mb_id'];

$popup_tit = '관리가 일정보기';

$sql = " select * from g5_work where mb_id = '{$mb_id}' ";
$qry = sql_query($sql);
$num = sql_num_rows($qry);
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="scheduleform" name="scheduleform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="mb_id" id="mb_id" value="<?php echo $mb_id ?>">

        <div class="layer_list_box">
            <table class="layer_list_hd_tbl">
                <thead>
                    <tr>
                        <th>파견</th>
                        <th>직원명</th>
                        <th>팀</th>
                        <th>연락처</th>
                        <th>생년월일</th>
                        <th>행정구역</th>
                        <th>접수일</th>
                        <th>신청인</th>
                        <th>신청인 연락처</th>
                        <th>시작일</th>
                        <th>종료일</th>
                        <th>취소일</th>
                    </tr>
                </thead>
            </table>

            <table class="layer_list_tbl">
                <tbody>
                    <?php
                    if($num > 0) {
                        for($i=0; $row = sql_fetch_array($qry); $i++) {
                            $mb_sql = " select * from g5_member where mb_id = '{$row['mb_id']}' ";
                            $mb_row = sql_fetch($mb_sql);

                            $mb_addr_arr = explode(' ', $mb_row['mb_addr1']);

                            $cl_sql = " select * from g5_client where client_idx = '{$row['client_idx']}' ";
                            $cl_row = sql_fetch($cl_sql);
                    ?>
                    <tr>
                        <td>파견중</td>
                        <td><?php echo $mb_row['mb_name'] ?></td>
                        <td><?php echo $mb_row['team_category'] ?></td>
                        <td><?php echo $mb_row['mb_hp'] ?></td>
                        <td><?php echo wz_get_birth($mb_row['security_number']) ?></td>
                        <td><?php echo $mb_addr_arr[1] ?></td>
                        <td><?php echo $cl_row['receipt_date'] ?></td>
                        <td><?php echo $cl_row['cl_name'] ?></td>
                        <td><?php echo $cl_row['cl_hp'] ?></td>
                        <td><?php echo ($cl_row['str_date'] == '0000-00-00')?'':$cl_row['str_date']; ?></td>
                        <td><?php echo ($cl_row['end_date'] == '0000-00-00')?'':$cl_row['end_date']; ?></td>
                        <td><?php echo ($cl_row['cancel_date'] == '0000-00-00')?'':$cl_row['cancel_date']; ?></td>
                    </tr>
                    <?php
                        }
                    }else{
                    ?>
                    <tr>
                        <td>등록된 파견일정이 없습니다.</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </form>
</div>
