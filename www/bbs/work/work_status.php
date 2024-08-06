<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/work/work_status.css?ver=1">', 0);

$sch_str_selected_date = $_GET['sch_str_selected_date'];
$sch_end_selected_date = $_GET['sch_end_selected_date'];

$now_date = date('Y-m-d');
?>

<div id="layer_wrap">
    <div id="layer_box">
        <!-- Filter Layer STR -->
        <div class="filter_year_wrap">
            <div class="filter_box">
                <label>파견기간</label>
                <input type="text" class="filter_input_date date_api" id="sch_str_selected_date" value="<?php echo $sch_str_selected_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="파견기간"> ~ 
                <input type="text" class="filter_input_date date_api" id="sch_end_selected_date" value="<?php echo $sch_end_selected_date ?>" maxlength="10" oninput="autoHyphen3(this)" placeholder="파견기간">
            </div>
        </div>
        <!-- Filter Layer END -->

        <!-- Layer List Wrap STR -->
        <div class="layer_list_wrap layer_list_wrap_flex_column">
            <ul class="menu_box">
                <li class="menu_list"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work.php">파견등록</a></li>
                <li class="menu_list" id="menu_list_act"><a class="menu_list_btn" href="<?php echo G5_BBS_URL ?>/work_status.php">파견현황</a></li>
            </ul>

            <div class="work_wrap">
                <div class="work_box">
                    <div class="work_member_box">
                        <div class="layer_list_box">
                            <table class="layer_list_hd_tbl width_max">
                                <thead>
                                    <tr>
                                        <th>직원명</th>
                                        <th>팀</th>
                                        <th>연락처</th>
                                        <th>생년월일</th>
                                        <th>특이사항</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="layer_list_tbl width_max">
                                <tbody id="work_member_list"></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="work_link_box">
                        <div class="layer_list_box">
                            <table class="layer_list_hd_tbl width_max">
                                <thead>
                                    <tr>
                                        <th>근태적용</th>
                                        <th>요일</th>
                                        <th>주말/공휴일</th>
                                        <th>파견일</th>
                                        <th>도우미</th>
                                        <th>파견인원</th>
                                        <th>바우처</th>
                                        <th>유료</th>
                                        <th>근무시간</th>
                                    </tr>
                                </thead>
                            </table>
                            <table class="layer_list_tbl width_max">
                                <tbody id="work_selected_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Layer List Wrap END -->
    </div>
</div>

<script>
    let write_ajax;

    $(function(){
        $('#sch_str_selected_date, #sch_end_selected_date').change(function(){
            list_act();
        });

        $(document).on('click', '#work_member_list tr', function(){
            $('#work_member_list tr').removeClass('list_selected');
            $(this).addClass('list_selected');

            list_work_selected_act();
        });
    });

    // 고객 정보 불러오기
    function list_act() {
        let sch_str_selected_date = $('#sch_str_selected_date').val();
        let sch_end_selected_date = $('#sch_end_selected_date').val();

        $.ajax({
            url: g5_bbs_url + '/ajax.work_status_member_list.php',
            type: "POST",
            data: {'sch_str_selected_date': sch_str_selected_date, 'sch_end_selected_date': sch_end_selected_date},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#work_member_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        if(i == 0) {
                            list_selected = 'list_selected';
                        }

                        datas += '<tr class="' + list_selected + '" mb_id="' + response[i].mb_id + '">';
                        datas += '<td>' + response[i].mb_name + '</td>';
                        datas += '<td>' + response[i].team_category + '</td>';
                        datas += '<td>' + response[i].mb_hp + '</td>';
                        datas += '<td>' + response[i].birthday + '</td>';
                        datas += '<td class="talign_l">' + response[i].mb_memo2 + '</td>';
                        datas += '</tr>';
                    }

                    $('#work_member_list').append(datas);

                    list_work_selected_act();
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }

    $(document).ready(function(){
        list_act();
    });

    // 파견 정보 불러오기
    function list_work_selected_act() {
        let mb_id = $('.list_selected').attr('mb_id');
        let sch_str_selected_date = $('#sch_str_selected_date').val();
        let sch_end_selected_date = $('#sch_end_selected_date').val();

        $.ajax({
            url: g5_bbs_url + '/ajax.work_status_selected_list.php',
            type: "POST",
            data: {'mb_id': mb_id, 'sch_str_selected_date': sch_str_selected_date, 'sch_end_selected_date': sch_end_selected_date},
            dataType: "json",
            success: function(response) {
                // 전송이 성공한 경우 받는 응답 처리
                $('#work_selected_list').empty();
                let datas = '';
                let list_selected = '';

                if(response.length > 0) {
                    for(let i=0; i<response.length; i++) {
                        list_selected = '';
                        /*
                        if(i == 0) {
                            list_selected = 'list_selected';
                        }
                        */

                        datas += '<tr class="' + list_selected + '" idx="' + response[i].idx + '" work_idx="' + response[i].work_idx + '" selected_date="' + response[i].selected_date + '" selected_date_mk="' + response[i].selected_date_mk + '" str_hour="' + response[i].str_hour + '" end_hour="' + response[i].end_hour + '">';
                        datas += '<td></td>';
                        datas += '<td>' + response[i].yoil + '요일</td>';
                        datas += '<td>' + response[i].weekend + '</td>';
                        datas += '<td>' + response[i].selected_date + '</td>';
                        datas += '<td>' + response[i].mb_name + '</td>';
                        datas += '<td>' + '1명' + '</td>';
                        datas += '<td></td>';
                        datas += '<td></td>';
                        datas += '<td></td>';
                        // datas += '<td class="talign_l">' + response[i].mb_memo2 + '</td>';
                        datas += '</tr>';
                    }

                    $('#work_selected_list').append(datas);
                }
            },
            error: function(error) {
                // 전송이 실패한 경우 받는 응답 처리
            }
        });
    }
</script>
