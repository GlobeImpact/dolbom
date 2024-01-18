<?php
add_stylesheet('<link rel="stylesheet" href="'.G5_BBS_URL.'/sitemap/sitemap.css">', 0);
?>

<div id="layer_wrap">
    <div id="layer_box">
        <h3>전체 메뉴</h3>

        <?php
        $stm_mn1_where = "";
        if(!$is_admin) $stm_mn1_where .= " and me_code = '{$member['mb_menu']}'";

        $stm_mn1_sql = " select * from g5_menu where length(`me_code`) = 2 and me_use = 1 {$stm_mn1_where} order by me_order asc, me_code asc ";
        $stm_mn1_qry = sql_query($stm_mn1_sql);
        $stm_mn1_num = sql_num_rows($stm_mn1_qry);
        if($stm_mn1_num > 0) {
            for($i=0; $stm_mn1_row = sql_fetch_array($stm_mn1_qry); $i++) {
        ?>
        <h4 class="sub_tit"><?php echo $stm_mn1_row['me_name'] ?></h4>
        <div class="sitemap_wrap">
        <?php
                $stm_mn2_sql = " select * from g5_menu where length(`me_code`) = 4 and me_use = 1 and me_code like '{$stm_mn1_row['me_code']}%' order by me_order asc, me_code asc ";
                $stm_mn2_qry = sql_query($stm_mn2_sql);
                $stm_mn2_num = sql_num_rows($stm_mn2_qry);
                if($stm_mn2_num > 0) {
                    for($j=0; $stm_mn2_row = sql_fetch_array($stm_mn2_qry); $j++) {
        ?>
            <a class="sitemap_box" href="<?php echo $stm_mn2_row['me_link'] ?>?this_code=<?php echo $stm_mn1_row['me_code'] ?>" target="_<?php echo $stm_mn2_row['me_target'] ?>">
                <img src="<?php echo G5_IMG_URL ?>/sitemap_<?php echo $j ?>.png">
                <p><?php echo $stm_mn2_row['me_name'] ?></p>
            </a>
        <?php
                    }
                }
        ?>
        </div>
        <?php
            }
        }
        ?>
        <?/*
        <div class="sitemap_wrap">
            <?php
            $stm_mn_sql = " select * from g5_menu where length(`me_code`) = 2 and me_use = 1 order by me_order asc, me_code asc ";
            echo $stm_mn_sql;
            $stm_mn_qry = sql_query($stm_mn_sql);
            $stm_mn_num = sql_num_rows($stm_mn_qry);
            if($stm_mn_num > 0) {
                for($i=0; $stm_mn_row = sql_fetch_array($stm_mn_qry); $i++) {
            ?>
            <div class="sitemap_box">
                <a href=""><img src="<?php echo G5_IMG_URL ?>/sitemap_0.png"></a>
            </div>
            <?php
                }
            }
            ?>
            <div class="sitemap_box">2</div>
            <div class="sitemap_box">3</div>
            <div class="sitemap_box">4</div>
            <div class="sitemap_box">5</div>
        </div>
        */?>
    </div>
</div>
