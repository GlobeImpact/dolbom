<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/work/work.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <div class="sub_wrap">
            <div class="sub_box">
                <div id="filter_wrap">
                    <div class="filter_box">
                        <label>접수기간</label>
                        <input type="text" id="filter_str_receipt_date" class="form_input x80 date_api" value="" oninput="autoHyphen3(this)" maxlength="10"><span>~</span>
                        <input type="text" id="filter_end_receipt_date" class="form_input x80 date_api" value="" oninput="autoHyphen3(this)" maxlength="10">
                    </div>
                    <div class="filter_box">
                        <label>신청인</label>
                        <input type="text" id="" class="form_input x100" value="">
                    </div>
                    <div class="filter_box">
                        <label>연락처</label>
                        <input type="text" id="" class="form_input x100" value="" oninput="autoHyphen(this)" maxlength="13">
                    </div>
                    <div class="filter_box">
                        <label>접수상태</label>
                        <select id="" class="form_select">
                            <option value="">전체</option>
                            <option value="">접수</option>
                            <option value="">종료</option>
                            <option value="">취소</option>
                        </select>
                    </div>
                </div>

                <div class="work_wrap">
                    <ul class="work_menu_box">
                        <li class="work_menu_list" id="menu_list_act">
                            <a class="work_menu_list_btn" href="<?php echo G5_BBS_URL ?>/work.php?this_code=<?php echo $_SESSION['this_code'] ?>">파견등록</a>
                        </li>
                        <li class="work_menu_list">
                            <a class="work_menu_list_btn" href="<?php echo G5_BBS_URL ?>/work_status.php?this_code=<?php echo $_SESSION['this_code'] ?>">파견현황</a>
                        </li>
                    </ul>
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
