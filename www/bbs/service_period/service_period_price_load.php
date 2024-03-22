<?php
$w = $_GET['w'];
$mb_id = $_GET['mb_id'];

$popup_tit = '금액 불러오기';

$write['branch_id'] = $_SESSION['this_branch_id'];
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">
    <form id="copyform" name="copyform" action="" onsubmit="return false" method="post" enctype="multipart/form-data" autocomplete="off">
        <input type="hidden" name="paste_branch_id" value="<?php echo $_SESSION['this_branch_id'] ?>">
        <input type="hidden" name="paste_year" id="paste_year" value="">

        <div class="layer_popup_form">
            <div class="load_tit">불러올 지점 선택</div>
            <div class="load_form_wrap">
                <div class="mtop12">
                    <table class="form_tbl">
                        <tbody>
                            <tr>
                                <th class="x115">지점</th>
                                <td>
                                    <select name="copy_branch_id" id="copy_branch_id" class="form_select">
                                        <option value="" branch_name="">지점 선택</option>
                                        <?php
                                        $branch_sql = " select * from g5_branch where branch_hide = '' order by branch_name asc, branch_id desc ";
                                        $branch_qry = sql_query($branch_sql);
                                        $branch_num = sql_num_rows($branch_qry);
                                        if($branch_num > 0) {
                                            for($i=0; $branch_row = sql_fetch_array($branch_qry); $i++) {
                                                if($branch_row['branch_id'] == $_SESSION['this_branch_id']) continue;
                                        ?>
                                            <option value="<?php echo $branch_row['branch_id'] ?>" branch_name="<?php echo $branch_row['branch_name'] ?>"><?php echo $branch_row['branch_name'] ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>

                                    <select name="copy_year" id="copy_year" class="form_select">
                                        <option value="">년도 선택</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>서비스</th>
                                <td>
                                    <div class="flex_row">
                                        <?php
                                        $k = 0;
                                        $copy_mn_sql = " select * from g5_menu where length(me_code) = 2 and me_use = 1 order by me_code desc ";
                                        $copy_mn_qry = sql_query($copy_mn_sql);
                                        $copy_mn_num = sql_num_rows($copy_mn_qry);
                                        if($copy_mn_num > 0) {
                                            for($i=0; $copy_mn_row = sql_fetch_array($copy_mn_qry); $i++) {
                                                if(count(${'set_mn'.$copy_mn_row['me_code'].'_service_category_arr'}) > 0) {
                                                    for($j=0; $j<count(${'set_mn'.$copy_mn_row['me_code'].'_service_category_arr'}); $j++) {
                                        ?>
                                        <label class="input_label" for="service_category_arr<?php echo $k ?>">
                                            <input type="checkbox" name="service_category_arr[]" id="service_category_arr<?php echo $k ?>" value="<?php echo ${'set_mn'.$copy_mn_row['me_code'].'_service_category_arr'}[$j] ?>">
                                            <?php echo ${'set_mn'.$copy_mn_row['me_code'].'_service_category_arr'}[$j] ?>
                                        </label>
                                        <?php
                                                        $k++;
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="load_help">※ 금액을 불러오면 현재 설정된 금액이 삭제되고 불러온 금액으로 변경 설정됩니다.</p>
                </div>
            </div>
            <div class="load_tit mtop12">불러오기 결과</div>
            <div class="load_form_wrap mtop12">
                <div class="copy_wrap">
                    <div id="copy_branch"></div>
                    <img src="<?php echo G5_IMG_URL ?>/copy_arrow.png">
                    <div>
                        <?php
                        $branch_sql = " select * from g5_branch where branch_id = '{$_SESSION['this_branch_id']}' ";
                        $branch_row = sql_fetch($branch_sql);
                        echo $branch_row['branch_name'];
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <a class="submit_btn" id="copy_submit_btn">저장하기</a>
</div>
