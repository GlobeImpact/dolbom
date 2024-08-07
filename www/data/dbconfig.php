<?php
if (!defined('_GNUBOARD_')) exit;
define('G5_MYSQL_HOST', 'localhost');
define('G5_MYSQL_USER', 'gibssample');
define('G5_MYSQL_PASSWORD', 'globeweb12@');
define('G5_MYSQL_DB', 'gibssample');
define('G5_MYSQL_SET_MODE', true);

define('G5_TABLE_PREFIX', 'g5_');

define('G5_TOKEN_ENCRYPTION_KEY', '0de26ece90bda2d451fd32201f3078d8'); // 토큰 암호화에 사용할 키

$g5['write_prefix'] = G5_TABLE_PREFIX.'write_'; // 게시판 테이블명 접두사

$g5['auth_table'] = G5_TABLE_PREFIX.'auth'; // 관리권한 설정 테이블
$g5['config_table'] = G5_TABLE_PREFIX.'config'; // 기본환경 설정 테이블
$g5['group_table'] = G5_TABLE_PREFIX.'group'; // 게시판 그룹 테이블
$g5['group_member_table'] = G5_TABLE_PREFIX.'group_member'; // 게시판 그룹+회원 테이블
$g5['board_table'] = G5_TABLE_PREFIX.'board'; // 게시판 설정 테이블
$g5['board_file_table'] = G5_TABLE_PREFIX.'board_file'; // 게시판 첨부파일 테이블
$g5['board_good_table'] = G5_TABLE_PREFIX.'board_good'; // 게시물 추천,비추천 테이블
$g5['board_new_table'] = G5_TABLE_PREFIX.'board_new'; // 게시판 새글 테이블
$g5['login_table'] = G5_TABLE_PREFIX.'login'; // 로그인 테이블 (접속자수)
$g5['mail_table'] = G5_TABLE_PREFIX.'mail'; // 회원메일 테이블
$g5['member_table'] = G5_TABLE_PREFIX.'member'; // 회원 테이블
$g5['memo_table'] = G5_TABLE_PREFIX.'memo'; // 메모 테이블
$g5['poll_table'] = G5_TABLE_PREFIX.'poll'; // 투표 테이블
$g5['poll_etc_table'] = G5_TABLE_PREFIX.'poll_etc'; // 투표 기타의견 테이블
$g5['point_table'] = G5_TABLE_PREFIX.'point'; // 포인트 테이블
$g5['popular_table'] = G5_TABLE_PREFIX.'popular'; // 인기검색어 테이블
$g5['scrap_table'] = G5_TABLE_PREFIX.'scrap'; // 게시글 스크랩 테이블
$g5['visit_table'] = G5_TABLE_PREFIX.'visit'; // 방문자 테이블
$g5['visit_sum_table'] = G5_TABLE_PREFIX.'visit_sum'; // 방문자 합계 테이블
$g5['uniqid_table'] = G5_TABLE_PREFIX.'uniqid'; // 유니크한 값을 만드는 테이블
$g5['autosave_table'] = G5_TABLE_PREFIX.'autosave'; // 게시글 작성시 일정시간마다 글을 임시 저장하는 테이블
$g5['cert_history_table'] = G5_TABLE_PREFIX.'cert_history'; // 인증내역 테이블
$g5['qa_config_table'] = G5_TABLE_PREFIX.'qa_config'; // 1:1문의 설정테이블
$g5['qa_content_table'] = G5_TABLE_PREFIX.'qa_content'; // 1:1문의 테이블
$g5['content_table'] = G5_TABLE_PREFIX.'content'; // 내용(컨텐츠)정보 테이블
$g5['faq_table'] = G5_TABLE_PREFIX.'faq'; // 자주하시는 질문 테이블
$g5['faq_master_table'] = G5_TABLE_PREFIX.'faq_master'; // 자주하시는 질문 마스터 테이블
$g5['new_win_table'] = G5_TABLE_PREFIX.'new_win'; // 새창 테이블
$g5['menu_table'] = G5_TABLE_PREFIX.'menu'; // 메뉴관리 테이블
$g5['social_profile_table'] = G5_TABLE_PREFIX.'member_social_profiles'; // 소셜 로그인 테이블
$g5['member_cert_history_table'] = G5_TABLE_PREFIX.'member_cert_history'; // 본인인증 변경내역 테이블

define('G5_USE_SHOP', true);

define('G5_SHOP_TABLE_PREFIX', 'g5_shop_');

$g5['g5_shop_default_table'] = G5_SHOP_TABLE_PREFIX.'default'; // 쇼핑몰설정 테이블
$g5['g5_shop_banner_table'] = G5_SHOP_TABLE_PREFIX.'banner'; // 배너 테이블
$g5['g5_shop_cart_table'] = G5_SHOP_TABLE_PREFIX.'cart'; // 장바구니 테이블
$g5['g5_shop_category_table'] = G5_SHOP_TABLE_PREFIX.'category'; // 상품분류 테이블
$g5['g5_shop_event_table'] = G5_SHOP_TABLE_PREFIX.'event'; // 이벤트 테이블
$g5['g5_shop_event_item_table'] = G5_SHOP_TABLE_PREFIX.'event_item'; // 상품, 이벤트 연결 테이블
$g5['g5_shop_item_table'] = G5_SHOP_TABLE_PREFIX.'item'; // 상품 테이블
$g5['g5_shop_item_option_table'] = G5_SHOP_TABLE_PREFIX.'item_option'; // 상품옵션 테이블
$g5['g5_shop_item_use_table'] = G5_SHOP_TABLE_PREFIX.'item_use'; // 상품 사용후기 테이블
$g5['g5_shop_item_qa_table'] = G5_SHOP_TABLE_PREFIX.'item_qa'; // 상품 질문답변 테이블
$g5['g5_shop_item_relation_table'] = G5_SHOP_TABLE_PREFIX.'item_relation'; // 관련 상품 테이블
$g5['g5_shop_order_table'] = G5_SHOP_TABLE_PREFIX.'order'; // 주문서 테이블
$g5['g5_shop_order_delete_table'] = G5_SHOP_TABLE_PREFIX.'order_delete'; // 주문서 삭제 테이블
$g5['g5_shop_wish_table'] = G5_SHOP_TABLE_PREFIX.'wish'; // 보관함(위시리스트) 테이블
$g5['g5_shop_coupon_table'] = G5_SHOP_TABLE_PREFIX.'coupon'; // 쿠폰정보 테이블
$g5['g5_shop_coupon_zone_table'] = G5_SHOP_TABLE_PREFIX.'coupon_zone'; // 쿠폰존 테이블
$g5['g5_shop_coupon_log_table'] = G5_SHOP_TABLE_PREFIX.'coupon_log'; // 쿠폰사용정보 테이블
$g5['g5_shop_sendcost_table'] = G5_SHOP_TABLE_PREFIX.'sendcost'; // 추가배송비 테이블
$g5['g5_shop_personalpay_table'] = G5_SHOP_TABLE_PREFIX.'personalpay'; // 개인결제 정보 테이블
$g5['g5_shop_order_address_table'] = G5_SHOP_TABLE_PREFIX.'order_address'; // 배송지이력 정보 테이블
$g5['g5_shop_item_stocksms_table'] = G5_SHOP_TABLE_PREFIX.'item_stocksms'; // 재입고SMS 알림 정보 테이블
$g5['g5_shop_post_log_table'] = G5_SHOP_TABLE_PREFIX.'order_post_log'; // 주문요청 로그 테이블
$g5['g5_shop_order_data_table'] = G5_SHOP_TABLE_PREFIX.'order_data'; // 모바일 결제정보 임시저장 테이블
$g5['g5_shop_inicis_log_table'] = G5_SHOP_TABLE_PREFIX.'inicis_log'; // 이니시스 모바일 계좌이체 로그 테이블





/* 환경설정 STR */

    // 공통 환경설정
    $set_bank_name_arr = Array('경남', '광주', '국민', '기업', '농협', '농축협(지역)', '대구', '부산', '산업', '새마을금고', '수협', '신한', '신협', '외환', '우리', '우체국', '전북', '제주', '하나', '한국씨티', '카카오뱅크', '토스뱅크', '케이뱅크');   // 은행명
    $set_pet_use_arr = Array('애완견', '애완묘');                                   // 반려동물
    $set_vulnerable_arr = Array('한부모', '저소득', '장애인', '기타');                       // 취약계층
    $set_edu_method_arr = Array('집체', '온라인');  
    $set_comp_category_arr = Array('민원(제공인력변경)', '민원(서비스 중지)', '민원(기타)', '서비스 취소', '배상처리', '고충상담', '퇴사자상담', '취업상담', '관계자 미팅', '홍보', '기타');    // 민원관리 -> 상담구분
    $set_take_category_arr = Array('제공인력변경', '서비스 중지', '상담완료', '기타');   // 민원관리 -> 조치구분
    $set_client_service_cate_arr = Array('바우처', '유료', '프리랜서', '기타');    // 고객관리 -> 이용종류
    $set_mn_activity_status_arr = Array('활동중', '보류', '퇴사', '휴직');             // 매니저 활동현황
    $set_management_mode_arr = Array('view' => '보기', 'write' => '등록/수정', 'delete' => '삭제'); // 매니저 담당 허용 종류

    /* 가사서비스 환경설정 STR */

        // 제공인력 환경설정
        $set_mn10_activity_status_arr = Array('활동중', '보류', '퇴사', '휴직');             // 활동현황
        $set_mn10_contract_type_arr = Array('급여', '프리렌서');                            // 계약형태
        $set_mn10_service_category_arr = Array('베이비시터', '청소', '반찬');                // 서비스구분
        $set_mn10_service_category_img_arr = Array('baby', 'clean', 'cook');               // 서비스구분 이미지 아이콘
        $set_mn10_team_category_arr = Array('1팀', '2팀', '3팀', '4팀');                    // 팀구분

    /* 가사서비스 환경설정 END */

    /* ----------------------------------------------------------------------------------------------------------------------------------------- */

    /* 아가마지 환경설정 STR */

        // 제공인력 환경설정
        $set_mn20_activity_status_arr = Array('활동중', '보류', '퇴사', '휴직');              // 활동현황
        $set_mn20_contract_type_arr = Array('급여', '프리렌서');                             // 계약형태
        $set_mn20_service_category_arr = Array('아가마지');                                  // 서비스구분
        $set_mn20_service_category_img_arr = Array('baby');                                 // 서비스구분 이미지 아이콘
        $set_mn20_team_category_arr = Array('1팀', '2팀', '3팀', '4팀');                     // 팀구분

    /* 아가마지 환경설정 END */

/* 환경설정 END */
?>