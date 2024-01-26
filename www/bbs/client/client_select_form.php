<?php
$idx = $_GET['idx'];
$tit = $_GET['tit'];
$popup_tit = $tit.' 리스트';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="select_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <input type="hidden" name="client_select_idx" id="client_select_idx" value="<?php echo $idx ?>">

    <div class="layer_popup_form">
        <div class="client_select_filter_wrap">
            <div class="client_select_filter_box">
                <input type="text" class="client_select_filter_input" id="sch_value2" value="" placeholder="이름 조회">
                <a class="client_select_filter_submit" id="filter_submit2">검색</a>
            </div>
        </div>

        <div class="client_select_list_box">
            <table class="client_select_list_hd_tbl">
                <thead>
                    <tr>
                        <th class="client_select_list_check"><input type="checkbox" class="select_all_check"></th>
                        <th class="client_select_list_name">고객명</th>
                        <th class="client_select_list_service_category">서비스</th>
                        <th class="client_select_list_hp">연락처</th>
                        <th>현황</th>
                    </tr>
                </thead>
            </table>

            <table class="client_select_list_tbl">
                <tbody id="select_list"></tbody>
            </table>

            <table class="client_select_list_ft_tbl">
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
