<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/pay/pay.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">

        <ul class="menu_box">
            <li class="menu_list"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/pay_set.php">공제항목설정</a></li>
            <li class="menu_list" id="menu_list_act"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/pay.php">급여계산</a></li>
        </ul>

        <div class="sub_wrap">
            <div class="form_wrap">
                <div class="form_row">
                    <div class="form_box">
                        <h4 class="sub_tit">기본정보</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>사원명</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="홍길동">
                                    </td>
                                </tr>
                                <tr>
                                    <th>주민번호</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="900101-1234567">
                                    </td>
                                </tr>
                                <tr>
                                    <th>표준월소득액</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="1,420,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>팀</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="1팀">
                                    </td>
                                </tr>
                                <tr>
                                    <th>시급</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="9,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="sub_tit">비과세대상(급여불포함)</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>식대</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="100,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>차량지원금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="100,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>공제대상가족수</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="1,420,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>20세이하자녀</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="1팀">
                                    </td>
                                </tr>
                                <tr>
                                    <th>은행명</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="9,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>계좌번호</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="9,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>예금주</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="9,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box">
                        <h4 class="sub_tit">급여수당</h4>

                        <table class="form_tbl">
                            <thead>
                                <tr>
                                    <th class="xp50"></th>
                                    <th class="xp13">일수</th>
                                    <th>수당</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>유료평일</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처평일</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>유료(토요일)</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>바우처(토요일)</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>취학</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>미취학</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>프리미엄</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="sub_tit">공제항목</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>갑근세</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>주민세</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>회비</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="5,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>상조비</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="15,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>가입비</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="4,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>소득세</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="6,000">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box">
                        <h4 class="sub_tit">추가수당</h4>

                        <table class="form_tbl">
                            <thead>
                                <tr>
                                    <th class="xp50"></th>
                                    <th class="xp13">횟수</th>
                                    <th>수당</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>유료수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>쌍생아</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>입주</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>장애우수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>큰아이수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>마사지수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>삼태아</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="sub_tit">4대보험[자가]</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>건강보험</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>국민연금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>고용보험</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="5,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>장기요양</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="15,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>공제정산액</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="4,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>공제합계액</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="6,000">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box">
                        <h4 class="sub_tit">주휴/연차</h4>

                        <table class="form_tbl">
                            <thead>
                                <tr>
                                    <th class="xp50"></th>
                                    <th class="xp13">횟수</th>
                                    <th>수당</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>주휴</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>연차</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>휴일근로</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>고급형수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>지정비수당</th>
                                    <td colspan="2">
                                        <input type="text" id="" class="form_input xp30" value="10">
                                        <input type="text" id="" class="form_input xp66" value="119,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="sub_tit">4대보험[사업주]</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>건강보험</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>국민연금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>고용보험</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="5,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>장기요양</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="15,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>사업주부담</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="4,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>산재보험</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="6,000">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form_box">
                        <h4 class="sub_tit">실지급액</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>급여총액</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>비과세제외</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="119,600">
                                    </td>
                                </tr>
                                <tr>
                                    <th>실지급액</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="119,600">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <h4 class="sub_tit">사업주부담금</h4>

                        <table class="form_tbl">
                            <tbody>
                                <tr>
                                    <th>퇴직금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>연차적립금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="70,000">
                                    </td>
                                </tr>
                                <tr>
                                    <th>사업주총부담금</th>
                                    <td>
                                        <input type="text" id="" class="form_input xp100" value="5,000">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="list_wrap">
                <table class="list_tbl">
                    <thead>
                        <tr>
                            <th class="x160">성명</th>
                            <th class="">주민번호</th>
                            <th class="x160">팀</th>
                            <th class="x200">기본급</th>
                            <th class="x200">시급</th>
                            <th class="x200">급여총액</th>
                            <th class="x200">실지급액</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="talign_c">홍길동</td>
                            <td class="talign_c">900101-1234567</td>
                            <td class="talign_c">2팀</td>
                            <td class="talign_r">1,200,000</td>
                            <td class="talign_r">10,000</td>
                            <td class="talign_r">3,000,000</td>
                            <td class="talign_r">2,800,000</td>
                        </tr>
                        <tr>
                            <td class="talign_c">홍길동</td>
                            <td class="talign_c">900101-1234567</td>
                            <td class="talign_c">2팀</td>
                            <td class="talign_r">1,200,000</td>
                            <td class="talign_r">10,000</td>
                            <td class="talign_r">3,000,000</td>
                            <td class="talign_r">2,800,000</td>
                        </tr>
                        <tr>
                            <td class="talign_c">홍길동</td>
                            <td class="talign_c">900101-1234567</td>
                            <td class="talign_c">2팀</td>
                            <td class="talign_r">1,200,000</td>
                            <td class="talign_r">10,000</td>
                            <td class="talign_r">3,000,000</td>
                            <td class="talign_r">2,800,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="layer_popup_bg"></div>

<div id="layer_popup"></div>

<script>
    $(function(){
        $('#write_btn').click(function(){
            $("#layer_popup").load(g5_bbs_url + "/pay_write.php");

            $('#layer_popup').css('display', 'block');
            $('#layer_popup_bg').css('display', 'block');
        });

        $(document).on('click', '#popup_close_btn', function(){
            $('#layer_popup').empty();
            
            $('#layer_popup').css('display', 'none');
            $('#layer_popup_bg').css('display', 'none');
        });
    });
</script>