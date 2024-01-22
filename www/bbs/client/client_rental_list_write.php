<?php
$rent_idx = $_GET['rent_idx'];
$rent_set = $_GET['rent_set'];

if($rent_set == 1) {
    $popup_tit = '대여자 리스트';
}else{
    $popup_tit = '반납자 리스트';
}
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="write_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <input type="hidden" name="rent_idx" id="rent_idx" value="<?php echo $rent_idx ?>">
    <input type="hidden" name="rent_set" id="rent_set" value="<?php echo $rent_set ?>">

    <div class="layer_popup_form">
        <div class="filter_wrap">
            <div class="filter_box xp100">
                <input type="text" class="filter_input" id="sch_value2" value="" placeholder="이름 조회">
                <a id="filter_submit2">검색</a>
            </div>
        </div>

        <div class="select_list_box">
            <table class="select_list_hd_tbl">
                <thead>
                    <tr>
                        <th class="x45"></th>
                        <th class="x60">현황</th>
                        <th class="x80">직원명</th>
                        <th class="x90">서비스</th>
                        <th class="x40">팀</th>
                        <th>주민번호</th>
                    </tr>
                </thead>
            </table>

            <table class="select_list_tbl">
                <tbody id="select_list"></tbody>
            </table>

            <table class="select_list_ft_tbl">
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
        <a class="submit_btn" id="select_submit_btn"><?php echo ($rent_set == 1)?'대여자':'반납자'; ?> 선택완료</a>
    </div>
</div>
