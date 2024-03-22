<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/work/work.css?ver=1">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <!-- Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="filter_box">
                <label>접수기간</label>
                <input type="text" class="filter_input_date date_api" id="sch_str_receipt_date" value="" maxlength="10" oninput="autoHyphen3(this)"> ~ 
                <input type="text" class="filter_input_date date_api" id="sch_end_receipt_date" value="" maxlength="10" oninput="autoHyphen3(this)">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_name" value="" placeholder="신청인">
                <input type="text" class="filter_input filter_input_tel" id="sch_cl_hp" value="" oninput="autoHyphen(this)" maxlength="13" placeholder="연락처">
                <select class="filter_select" id="sch_status">
                    <option value="">접수상태선택</option>
                    <option value="접수">접수</option>
                    <option value="종료">종료</option>
                    <option value="취소">취소</option>
                </select>
            </div>
        </div>
        <!-- Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <li class="menu_list" id="menu_list_act"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work.php">파견등록</a></li>
                <li class="menu_list"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work_status.php">파견현황</a></li>
            </ul>
            <div class="layer_list_box">
                <table class="layer_list_hd_tbl">
                    <thead>
                        <tr>
                            <th>123</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- Layer List Wrap END -->







        <div class="sub_wrap">
            <div class="sub_box">
                <div class="work_wrap">
                    <div class="client_list_box">
                        <table class="client_list_hd_tbl">
                            <thead>
                                <tr>
                                    <th class="x56">접수</th>
                                    <th class="x90">접수일</th>
                                    <th class="x80">서비스구분</th>
                                    <th class="x150">서비스명</th>
                                    <th class="x130">서비스유형</th>
                                    <th class="x100">신청인</th>
                                    <th class="x110">연락처</th>
                                    <th class="x90">주민번호</th>
                                    <th class="x60">예정일</th>
                                    <th class="x60">출생일</th>
                                    <th class="x60">시작일</th>
                                    <th class="x60">종료일</th>
                                    <th class="x70">파견일수</th>
                                    <th class="x70">출산순위</th>
                                    <th class="x120">본인부담금</th>
                                </tr>
                            </thead>
                        </table>

                        <table class="client_list_tbl">
                            <tbody>
                                <?php for($i=0; $i<15; $i++) { ?>
                                <tr>
                                    <td class="x56">접수</td>
                                    <td class="x90">2024/02/02</td>
                                    <td class="x80">바우처</td>
                                    <td class="x150 talign_l">단태아 둘째(기본형)</td>
                                    <td class="x130 talign_l">둘째(기본형)</td>
                                    <td class="x100">황다혜</td>
                                    <td class="x110">010-1111-2222</td>
                                    <td class="x90">891116-2</td>
                                    <td class="x60">10/23</td>
                                    <td class="x60">10/24</td>
                                    <td class="x60">10/25</td>
                                    <td class="x60">10/26</td>
                                    <td class="x70">5</td>
                                    <td class="x70">둘째</td>
                                    <td class="x120 talign_r">1,038,000</td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="work_box">
                        <div class="work_member_box">
                            <div class="work_member_top">
                                <div></div>
                                <div>
                                    <a class="set_btn">관리사 일정보기</a>
                                </div>
                            </div>
                            <div class="work_member_list">
                                <table class="work_member_list_hd_tbl">
                                    <thead>
                                        <tr>
                                            <th class="x60">파견</th>
                                            <th class="x100">성명</th>
                                            <th class="x50">팀</th>
                                            <th class="x110">연락처</th>
                                            <th class="x130">행정구역</th>
                                            <th class="x400 talign_l">특이사항</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="work_member_list_tbl">
                                    <tbody>
                                        <tr>
                                            <td class="x60"></td>
                                            <td class="x100">고민성</td>
                                            <td class="x50">1팀</td>
                                            <td class="x110">010-5555-5333</td>
                                            <td class="x130">부산시 수영구</td>
                                            <td class="x400 talign_l">다온근무 및 동래여성 인력센터 근무</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="work_link_box">
                            <div class="work_link_top">
                                <div>
                                    <a class="set_btn">기간연장</a>
                                    <a class="set_btn">일정추가</a>
                                </div>
                                <div>
                                    <a class="set_btn">파견관리사</a>
                                    <a class="set_btn">관리사교체</a>
                                </div>
                            </div>
                            <div class="work_link_list">
                                <table class="work_link_list_hd_tbl">
                                    <thead>
                                        <tr>
                                            <th>근태적용</th>
                                            <th>요일</th>
                                            <th>토요일/평일</th>
                                            <th>파견일</th>
                                            <th>도우미</th>
                                            <th>파견인원</th>
                                            <th>바우처</th>
                                            <th>유료</th>
                                            <th>근무시간</th>
                                            <th>아기</th>
                                            <th>장애우</th>
                                            <th>입주</th>
                                            <th>취학</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="work_link_list_tbl">
                                    <tbody>
                                        <tr>
                                            <td class="x60"></td>
                                            <td class="x100">고민성</td>
                                            <td class="x50">1팀</td>
                                            <td class="x110">010-5555-5333</td>
                                            <td class="x130">부산시 수영구</td>
                                            <td class="x400 talign_l">다온근무 및 동래여성 인력센터 근무</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>                                                                                                            
    </div>
</div>
