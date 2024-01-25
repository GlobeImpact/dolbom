<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/send/send.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">

        <div class="flex_row">
            <div class="flex_sub1">
                <h4 class="sub_tit">발송대상자 선택</h4>

                <ul class="menu_box">
                    <li class="menu_list" id="menu_list_act"><a class="menu_list_btn">제공인력</a></li>
                    <li class="menu_list"><a class="menu_list_btn">고객</a></li>
                    <li class="menu_list"><a class="menu_list_btn">기타</a></li>
                </ul>

                <div class="user_wrap">
                    <div class="user_top">
                        <div class="filter_box">
                            <select class="filter_select">
                                <option value="">전체</option>
                                <option value="활동중">활동중</option>
                                <option value="보류">보류</option>
                                <option value="퇴사">퇴사</option>
                                <option value="휴직">휴직</option>
                            </select>

                            <select class="filter_select">
                                <option value="">전체</option>
                                <option value="베이비시터">베이비시터</option>
                                <option value="청소">청소</option>
                                <option value="반찬">반찬</option>
                            </select>

                            <input type="text" class="filter_input" value="" placeholder="이름 조회">
                        </div>
                    </div>

                    <div class="user_list">
                        <table class="user_list_tbl">
                            <thead>
                                <tr>
                                    <th class="x50">번호</th>
                                    <th class="x80">활동현황</th>
                                    <th class="x70">직원명</th>
                                    <th class="x90">서비스</th>
                                    <th class="x45">팀</th>
                                    <th>행정구역</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="talign_c">1</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">2</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">3</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">4</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">5</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">6</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">7</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">8</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">9</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">10</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">11</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">12</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">13</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">14</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">15</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">16</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">17</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">18</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">19</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동</td>
                                    <td class="talign_c">베이비시터</td>
                                    <td class="talign_c">1팀</td>
                                    <td class="talign_c">부산 해운대구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">20</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동2</td>
                                    <td class="talign_c">반찬</td>
                                    <td class="talign_c">2팀</td>
                                    <td class="talign_c">부산 수영구</td>
                                </tr>
                                <tr>
                                    <td class="talign_c">21</td>
                                    <td class="talign_c">활동중</td>
                                    <td class="talign_c">홍길동3</td>
                                    <td class="talign_c">청소</td>
                                    <td class="talign_c">3팀</td>
                                    <td class="talign_c">부산 연제구</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="flex_sub2">
                <h4 class="sub_tit">발송대상자 확인</h4>

                <div class="to_wrap">
                    <h4 class="to_tit">받는사람 (총 3명)</h4>
                    <div class="to_add_box">
                        <input type="text" class="to_add_input" value="" placeholder="이름">
                        <input type="text" class="to_add_input" value="" placeholder="휴대폰번호">
                        <a class="to_add_btn">추가</a>
                    </div>
                    <div class="to_list_box">
                        <div class="to_list">
                            <p class="to_list_cate">제공인력</p>
                            <p class="to_list_name">홍길동</p>
                            <p class="to_list_hp">010-1111-1111</p>
                            <a class="to_list_del_btn">지움</a>
                        </div>
                        <div class="to_list">
                            <p class="to_list_cate">고객</p>
                            <p class="to_list_name">홍길동2</p>
                            <p class="to_list_hp">010-2222-2222</p>
                            <a class="to_list_del_btn">지움</a>
                        </div>
                        <div class="to_list">
                            <p class="to_list_cate">기타</p>
                            <p class="to_list_name">홍길동3</p>
                            <p class="to_list_hp">010-3333-3333</p>
                            <a class="to_list_del_btn">지움</a>
                        </div>
                    </div>
                    <a class="to_list_all_del_btn">전체삭제</a>
                </div>
            </div>
            <div class="flex_sub3">
                <h4 class="sub_tit">문자 내용</h4>

                <div style="position:relative; display:flex; flex-direction:column; align-items:stretch; justify-content:stretch; margin:0; padding:10px; width:100%; background:#f3f3f3; border:1px solid #cdcbca;">
                    <div style="display:flex; flex-direction:row; align-items:center; justify-content:center; margin:0; padding:6px; width:100%; border:1px solid #cdcbca; background:#fbfbfb;">
                        <p style="margin-right:8px; font-size:13px;">현재잔여건수 : 0건</p>
                        <a style="display:flex; flex-direction:row; align-items:center; justify-content:center; margin:0; padding:4px 8px; background:#6d9ac4; border:1px solid #1469b9; border-radius:4px; color:#fff;">충전하기</a>
                    </div>

                    <textarea class="" style="position:relative; margin:10px 0; padding:10px; width:100%; height:150px; background:#e5efff; border:1px solid #1469b9; resize:none; overflow-y:scroll;"></textarea>

                    <div style="display:flex; flex-direction:row; align-items:center; justify-content:center; margin:0; padding:6px; width:100%; border:1px solid #cdcbca; background:#fbfbfb;">
                        <label for="aaa" style="display:flex; flex-direction:row; align-items:center; justify-content:center; margin:0; margin-right:6px;">
                            <input type="checkbox" id="aaa" style="margin-right:4px;"> 예약발송
                        </label>
                        <input type="text" class="" value="2023-12-20" style="margin:0; padding:4px 8px; width:82px; background:#fff; border:1px solid #ddd;">
                        <select id="" style="margin:0; margin-left:6px; padding:4px 8px; border:1px solid #ddd;">
                            <option value="10:00">10:00</option>
                            <option value="11:00">10:00</option>
                            <option value="12:00">10:00</option>
                            <option value="13:00">10:00</option>
                            <option value="14:00">10:00</option>
                        </select>
                    </div>

                    <a style="position:relative; display:block; margin:0 auto; margin-top:10px; padding:15px; width:100%; text-align:center; color:#fff; font-family:'GmarketSansMedium'; font-weight:100; font-size:18px; letter-spacing:1px; background:#ed5684; border:0; border-radius:3px; cursor:pointer;">문자발송</a>
                </div>

                <h4 class="sub_tit">발송 문자 선택</h4>

                <div style="display:flex; flex-direction:column; align-items:stretch; justify-content:stretch; margin:0; padding:0; width:100%; height:268px; border:2px solid #283144;">
                    <p style="margin:0; padding:10px; width:100%; font-weight:600; font-size:14px; background:#e5efff; text-align:center; border-bottom:1px solid #283144;">문자 내용</p>
                    <div style="position:relative; margin:0; padding:0; width:100%; flex:1 1 0%; background:#fff; overflow-y:scroll;">
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                        <p style="margin:0; padding:6px 3px; border-bottom:1px solid #283144; font-size:13px; cursor:pointer;">
                            새해복 많이받으시고 가정에 평화와 행복이 가득하시기를 바랍니다.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
