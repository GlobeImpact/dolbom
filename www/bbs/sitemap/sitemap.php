<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/sitemap/sitemap.css?ver=3">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <h3>전체 메뉴</h3>

        <?php
        $stm_mn1_where = "";
        if($member['mb_level'] < 5) {
            $stm_mn1_where .= " and me_code = '{$member['mb_menu']}'";
        }

        if($member['mb_level'] == 5) {
            $stm_mn1_where .= " and b.mode = 'view'";
            $stm_mn1_sql = " select distinct(a.me_code), a.* from g5_menu as a left join g5_management as b on b.me_code1 = a.me_code where b.mb_id = '{$member['mb_id']}' {$stm_mn1_where} order by a.me_order asc, a.me_code asc ";
        }else{
            $stm_mn1_sql = " select * from g5_menu where length(`me_code`) = 2 and me_use = 1 {$stm_mn1_where} order by me_order asc, me_code asc ";
        }
        $stm_mn1_qry = sql_query($stm_mn1_sql);
        $stm_mn1_num = sql_num_rows($stm_mn1_qry);
        if($stm_mn1_num > 0) {
            for($i=0; $stm_mn1_row = sql_fetch_array($stm_mn1_qry); $i++) {
        ?>
        <h4 class="sub_tit"><?php echo $stm_mn1_row['me_name'] ?></h4>
        <div class="sitemap_wrap">
        <?php
                if($member['mb_level'] == 5) {
                    $stm_mn2_sql = " select distinct(a.me_code), a.* from g5_menu as a left join g5_management as b on b.me_code2 = a.me_code where b.me_code1 = '{$stm_mn1_row['me_code']}' and b.mb_id = '{$member['mb_id']}' and b.mode = 'view' order by a.me_order asc, a.me_code asc ";
                }else{
                    $stm_mn2_sql = " select * from g5_menu where length(`me_code`) = 4 and me_use = 1 and me_code like '{$stm_mn1_row['me_code']}%' order by me_order asc, me_code asc ";
                }
                $stm_mn2_qry = sql_query($stm_mn2_sql);
                $stm_mn2_num = sql_num_rows($stm_mn2_qry);
                if($stm_mn2_num > 0) {
                    for($j=0; $stm_mn2_row = sql_fetch_array($stm_mn2_qry); $j++) {
        ?>
            <div class="sitemap_box">
                <a class="sitemap_list" href="<?php echo $stm_mn2_row['me_link'] ?>?this_code=<?php echo $stm_mn1_row['me_code'] ?>" target="_<?php echo $stm_mn2_row['me_target'] ?>">
                    <img src="<?php echo G5_IMG_URL ?>/sitemap_<?php echo $j ?>.png">
                    <p><?php echo $stm_mn2_row['me_name'] ?></p>
                </a>

                <?php
                if($member['mb_level'] == 5) {
                    $stm_mn3_sql = " select * from g5_menu as a left join g5_management as b on b.me_code3 = a.me_code where b.me_code2 = '{$stm_mn2_row['me_code']}' and b.mb_id = '{$member['mb_id']}' and b.mode = 'view' order by a.me_order asc, a.me_code asc ";
                }else{
                    $stm_mn3_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 6 and me_use = 1 and me_code like '{$stm_mn2_row['me_code']}%' ";
                }
                $stm_mn3_qry = sql_query($stm_mn3_sql);
                $stm_mn3_num = sql_num_rows($stm_mn3_qry);
                if($stm_mn3_num > 0) {
                    echo '<ul class="sitemap_sub_box">';
                    for($k=0; $stm_mn3_row = sql_fetch_array($stm_mn3_qry); $k++) {
                ?>
                        <li class="sitemap_sub_list">
                            <a href="<?php echo $stm_mn3_row['me_link'] ?>?this_code=<?php echo $stm_mn1_row['me_code'] ?>" target="_<?php echo $stm_mn3_row['me_target'] ?>"><?php echo $stm_mn3_row['me_name'] ?></a>
                        </li>
                <?php
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        <?php
                    }
                }
        ?>
        </div>
        <?php
            }
        }
        ?>
    </div>
</div>
