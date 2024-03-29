<?php
$edu_idx = $_GET['edu_idx'];

$popup_tit = '참석자 리스트';
?>

<div id="layer_popup_top">
    <h3><?php echo $popup_tit ?></h3>
    <a id="write_popup_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
</div>
<div id="layer_popup_content">

    <input type="hidden" name="edu_idx" id="edu_idx" value="<?php echo $edu_idx ?>">

    <div class="layer_popup_form">
        <div class="filter_wrap">
            <div class="filter_box xp100">
                <input type="text" class="filter_input" id="sch_value2" value="" placeholder="이름 조회">
                <a id="filter_submit2">검색</a>
            </div>
        </div>

        <div class="edul_list_box">
            <table class="edul_list_hd_tbl">
                <thead>
                    <tr>
                        <th class="x45"><input type="checkbox" class="edul_all_check"></th>
                        <th class="x60">현황</th>
                        <th class="x80">직원명</th>
                        <th class="x90">서비스</th>
                        <th class="x40">팀</th>
                        <th>주민번호</th>
                    </tr>
                </thead>
            </table>

            <table class="edul_list_tbl">
                <tbody id="edul_list"></tbody>
            </table>

            <table class="edul_list_ft_tbl">
                <thead>
                    <tr>
                        <th class="xp100">
                            전체 : <span id="edul_tot"></span>명
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div>
        <a class="submit_btn" id="edul_submit_btn">참석자 선택완료</a>
    </div>
</div>
