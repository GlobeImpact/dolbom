<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/setting/setting.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <div class="sub_wrap">
            <div class="sub_left">
                <div class="sub_left_top">
                    <div class="filter_box">
                        <select id="" class="filter_select">
                            <option value="">전체</option>
                            <option value="">활동중</option>
                            <option value="">보류</option>
                            <option value="">퇴사</option>
                            <option value="">휴직</option>
                        </select>

                        <select id="" class="filter_select">
                            <option value="">전체</option>
                            <option value="">베이비시터</option>
                            <option value="">청소</option>
                            <option value="">반찬</option>
                        </select>

                        <input type="text" id="" class="filter_input" value="" placeholder="이름 조회">
                    </div>
                    <a id="write_btn">제공인력등록</a>
                </div>

                <div class="sub_left_list">
                    <table class="list_tbl">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>활동현황</th>
                                <th>직원명</th>
                                <th>서비스</th>
                                <th>팀</th>
                                <th>행정구역</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for($i=0; $i<100; $i++) { ?>
                            <tr>
                                <td class="talign_c">1</td>
                                <td class="talign_c">활동중</td>
                                <td class="talign_c">홍길동</td>
                                <td class="talign_c">베이비시터</td>
                                <td class="talign_c">3팀</td>
                                <td class="talign_c">수영구 광안동</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sub_box">123</div>
        </div>
    </div>
</div>