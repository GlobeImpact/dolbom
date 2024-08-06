<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/theme/basic/css/default.css?ver=2">', 0);

$idx = $_GET['idx'];

$popup_tit = $set_row['set_tit'].' 민원접수내역';

$sql = " select * from g5_client_complaints where idx = '{$idx}' ";
$view = sql_fetch($sql);

if($view['comp_date'] == '0000-00-00') $view['comp_date'] = '';
if($view['take_date'] == '0000-00-00') $view['take_date'] = '';

// 등록/수정 권한
$write_permit = true;
if(!$is_admin) {
    $management_sql = " select count(*) as cnt from g5_management where me_code = '{$_SESSION['this_mn_cd_full']}' and mb_id = '{$member['mb_id']}' and mode = 'write' ";
    $management_row = sql_fetch($management_sql);
    if($management_row['cnt'] == 0) {
        $write_permit = false;
    }
}

$edit_btn = '';
if($write_permit === true) $edit_btn = '<a class="edit_btn" idx="'.$idx.'">수정</a>';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?><?php echo $edit_btn ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="idx" id="idx" value="<?php echo $idx ?>">
        <input type="hidden" name="now_year" id="now_year" value="<?php echo $now_year ?>">
        <input type="hidden" name="comp_date" id="comp_date" value="<?php echo $view['comp_date'] ?>">

        <div class="layer_popup_form">
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th class="x110">상담구분</th>
                            <td class="x390"><?php echo $view['comp_category'] ?></td>
                            <th class="x110">조치구분</th>
                            <td colspan="3"><?php echo $view['take_category'] ?></td>
                        </tr>
                        <tr>
                            <th>고객선택</th>
                            <td>
                                <?php
                                $client_sql = " select * from g5_client where client_idx = '{$view['comp_client_idx']}' ";
                                $client_row = sql_fetch($client_sql);

                                $client_service = '';
                                if($client_row['client_service'] != '') $client_service = ' ['.$client_row['client_service'].']';
                                $client_hp = '';
                                if($client_row['client_service'] != '') $client_service = ' '.$client_row['cl_hp'];
                                ?>
                                <?php echo $view['comp_client_name'] ?><?php echo $client_service ?><?php echo $client_hp ?>
                            </td>
                            <th>조치일자</th>
                            <td class="x120"><?php echo $view['take_date'] ?></td>
                            <th class="x110">관리사선택</th>
                            <td>
                                <?php
                                $member_sql = " select * from g5_member where mb_id = '{$view['take_mb_id']}' ";
                                $member_row = sql_fetch($member_sql);

                                $member_service = '';
                                if($view['take_mb_id'] != '') {
                                    $member_service .= ' ['.substr($member_row['security_number'], 0, 6).']';
                                }
                                ?>
                                <?php echo $view['take_mb_name'] ?><?php echo $member_service ?>
                            </td>
                        </tr>
                        <tr>
                            <th>상담내용</th>
                            <td><div class="view_content"><?php echo nl2br($view['comp_content']) ?></div></td>
                            <th>조치내용</th>
                            <td colspan="3"><div class="view_content"><?php echo nl2br($view['take_content']) ?></div></td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="5"><div class="view_content"><?php echo nl2br($view['take_etc']) ?></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
