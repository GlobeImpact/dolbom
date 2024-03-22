<?php
$idx = $_GET['idx'];
$tit = $_GET['tit'];
$mode = $_GET['mode'];
$popup_tit = $tit.' 리스트';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="select_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <input type="hidden" name="member_select_idx" id="member_select_idx" value="<?php echo $idx ?>">
    <input type="hidden" name="select_mode" id="select_mode" value="<?php echo $mode ?>">

    <div class="layer_popup_form">
        <div class="member_select_filter_wrap">
            <div class="member_select_filter_box">
                <input type="text" class="member_select_filter_input" id="sch_value2" value="" placeholder="이름 조회">
                <a class="member_select_filter_submit" id="filter_submit2">검색</a>
            </div>
        </div>

        <div class="member_select_list_box">
            <table class="member_select_list_hd_tbl">
                <thead>
                    <tr>
                        <th class="member_select_list_check"><input type="checkbox" class="select_all_check"></th>
                        <th class="member_select_list_gender">현황</th>
                        <th class="member_select_list_name">직원명</th>
                        <th class="member_select_list_gender">성별</th>
                        <th class="member_select_list_birthday">생년월일</th>
                        <th>입사일자</th>
                    </tr>
                </thead>
            </table>

            <table class="member_select_list_tbl">
                <tbody id="select_list"></tbody>
            </table>

            <table class="member_select_list_ft_tbl">
                <thead>
                    <tr>
                        <th class="xp100">
                            전체 : <span id="select_tot"></span>명
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div>
        <a class="submit_btn" id="select_submit_btn">선택완료</a>
    </div>
</div>
