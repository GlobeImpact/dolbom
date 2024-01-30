<?php
$w = $_GET['w'];
$branch_id = $_GET['branch_id'];

$popup_tit = $set_row['set_tit'].' 지점등록';
if($w == 'u') $popup_tit = $set_row['set_tit'].' 지점수정';

if($w == 'u' && $branch_id != '') {
    $sql = " select * from g5_branch where branch_id = '{$branch_id}' ";
    $write = sql_fetch($sql);
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="fregisterform" name="fregisterform" action="" onsubmit="return fregisterform_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="w" id="w" value="<?php echo $w ?>">
        <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $branch_id ?>">

        <div class="layer_popup_form">
            <div class="form_tbl_wrap">
                <table class="form_tbl">
                    <tbody>
                        <tr>
                            <th class="x130">지점명</th>
                            <td>
                                <input type="text" name="branch_name" id="branch_name" class="form_input x150" value="<?php echo $write['branch_name'] ?>">
                            </td>
                        </tr>
                        <?php
                        $mn_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 2 and me_use = 1 order by me_order asc, me_code asc ";
                        $mn_qry = sql_query($mn_sql);
                        $mn_num = sql_num_rows($mn_qry);
                        if($mn_num > 0) {
                            for($mn=0; $mn_row = sql_fetch_array($mn_qry); $mn++) {
                                $addr_sql = " select * from g5_branch_addr where branch_id = '{$branch_id}' and menu_code = '{$mn_row['me_code']}' ";
                                $addr_row = sql_fetch($addr_sql);
                        ?>
                        <tr>
                            <th><?php echo $mn_row['me_name'] ?> 주소</th>
                            <td>
                                <input type="hidden" name="menu_code[]" id="menu_code<?php echo $mn ?>" value="<?php echo $mn_row['me_code'] ?>">
                                <input type="text" name="branch_addr[]" id="branch_addr<?php echo $mn ?>" class="form_input xp100 branch_addr" value="<?php echo $addr_row['branch_addr'] ?>" me_name="<?php echo $mn_row['me_name'] ?>">
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
    </form>
    <a class="submit_btn" id="submit_btn">저장하기</a>
</div>
