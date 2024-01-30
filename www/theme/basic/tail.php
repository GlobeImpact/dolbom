<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>

    </div>
    <div id="aside">
        <ul class="left_menu_box">
            <?/*<li><a href="<?php echo G5_BBS_URL ?>/setting.php">시스템 설정</a></li>*/?>
            <li><a href="<?php echo G5_BBS_URL ?>/sitemap.php" <?php echo ($mn_cd == 'sitemap')?'id="left_menu_sitemap_active"':''; ?>>전체 메뉴</a></li>

            <?php if($is_admin) { ?>
            <li><a href="<?php echo G5_BBS_URL ?>/branch_set.php" <?php echo ($mn_cd == 'branch')?'id="left_menu_sitemap_active"':''; ?>>지점 설정</a></li>
            <?php } ?>

            <li>
                <?php
                $lmn_where = "";
                if(!$is_admin) $lmn_where .= " and me_code = '{$member['mb_menu']}'";
                $lmn_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 2 and me_use = 1 {$lmn_where} order by me_order asc, me_code asc ";
                $lmn_qry = sql_query($lmn_sql);
                $lmn_num = sql_num_rows($lmn_qry);
                if($lmn_num > 0) {
                    for($i=0; $lmn_row = sql_fetch_array($lmn_qry); $i++) {
                ?>
                    <h4><?php echo $lmn_row['me_name'] ?></h4>
                    <?php
                    $mn_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 4 and me_use = 1 and me_code like '{$lmn_row['me_code']}%' ";
                    $mn_qry = sql_query($mn_sql);
                    $mn_num = sql_num_rows($mn_qry);
                    if($mn_num > 0) {
                        echo '<ul class="mn_box">';
                        for($j=0; $mn_row = sql_fetch_array($mn_qry); $j++) {
                    ?>
                        <li>
                            <a class="mn_nav" <?/*href="<?php echo $mn_row['me_link'] ?>?this_code=<?php echo $lmn_row['me_code'] ?>" target="_<?php echo $mn_row['me_target'] ?>"*/?> <?php echo ($mn_row['me_code'] == $_SESSION['this_code'].''.$mn_cd)?'id="left_menu_active"':''; ?>><?php echo $mn_row['me_name'] ?></a>

                            <div class="mn_sub_box">
                                <div>
                                    <div class="mn_sub_top">
                                        <a class="mn_sub_close_btn"><img src="<?php echo G5_IMG_URL ?>/popup_close_btn.png"></a>
                                    </div>
                                    <div class="mn_sub_nav_box">
                                        <?php
                                        $mn_sub_sql = " select * from g5_menu where (1=1) and length(`me_code`) = 6 and me_use = 1 and me_code like '{$mn_row['me_code']}%' ";
                                        $mn_sub_qry = sql_query($mn_sub_sql);
                                        $mn_sub_num = sql_num_rows($mn_sub_qry);
                                        if($mn_num > 0) {
                                            echo '<ul class="mn_sub_ul">';
                                            for($k=0; $mn_sub_row = sql_fetch_array($mn_sub_qry); $k++) {
                                        ?>
                                        <li><a href="<?php echo $mn_sub_row['me_link'] ?>?this_code=<?php echo $lmn_row['me_code'] ?>" target="_<?php echo $mn_sub_row['me_target'] ?>"><?php echo $mn_sub_row['me_name'] ?></a></li>
                                        <?php
                                            }
                                            echo '</ul>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                        }
                        echo '</ul>';
                    }
                    ?>
                <?php
                    }
                }
                ?>
            </li>
        </ul>
    </div>
    <script>
    $(function(){
        $('.mn_nav').click(function(){
            $('.mn_nav').removeClass('left_menu_sub_active');
            $(this).addClass('left_menu_sub_active');
        });

        $('html').click(function(e){
            if($(e.target).parents('#aside').length < 1){
                $('.mn_nav').removeClass('left_menu_sub_active');
            }
        });

        $('.mn_sub_close_btn').click(function(){
            $('.mn_nav').removeClass('left_menu_sub_active');
        });
    });
    </script>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">
    <div id="ft_copy">© bsdolbom ALL RIGHTS RESERVED.</div>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");