<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_URL.'/theme/basic/css/default.css?ver=2">', 0);

$idx = $_GET['idx'];

$popup_tit = $set_row['set_tit'].' 민원접수내역';

$sql = " select * from g5_client_complaints where idx = '{$idx}' ";
$view = sql_fetch($sql);

if($view['comp_date'] == '0000-00-00') $view['comp_date'] = '';
if($view['take_date'] == '0000-00-00') $view['take_date'] = '';

$edit_btn = '<a class="edit_btn" idx="'.$idx.'">수정</a>';
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
                            <th class="x120">상담구분<span class="required_txt">*</span></th>
                            <td class="x390"><?php echo $view['comp_category'] ?></td>
                            <th class="x120">조치구분</th>
                            <td><?php echo $view['take_category'] ?></td>
                        </tr>
                        <tr>
                            <th>고객선택<span class="required_txt">*</span></th>
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
                            <td><?php echo $view['take_date'] ?></td>
                        </tr>
                        <tr>
                            <th>상담내용</th>
                            <td><div class="view_content"><?php echo nl2br($view['comp_content']) ?></div></td>
                            <th>조치내용</th>
                            <td><div class="view_content"><?php echo nl2br($view['take_content']) ?></div></td>
                        </tr>
                        <tr>
                            <th>비고</th>
                            <td colspan="3"><div class="view_content"><?php echo nl2br($view['take_etc']) ?></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>
