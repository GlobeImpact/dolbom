<?php
global $lo_location;
global $lo_url;

include_once('./_common.php');

if($error) {
    $g5['title'] = "오류안내 페이지";
} else {
    $g5['title'] = "결과안내 페이지";
}

// 필수 입력입니다.
// 양쪽 공백 없애기
// 필수 (선택 혹은 입력)입니다.
// 전화번호 형식이 올바르지 않습니다. 하이픈(-)을 포함하여 입력하세요.
// 이메일주소 형식이 아닙니다.
// 한글이 아닙니다. (자음, 모음만 있는 한글은 처리하지 않습니다.)
// 한글이 아닙니다.
// 한글, 영문, 숫자가 아닙니다.
// 한글, 영문이 아닙니다.
// 숫자가 아닙니다.
// 영문이 아닙니다.
// 영문 또는 숫자가 아닙니다.
// 영문, 숫자, _ 가 아닙니다.
// 최소 글자 이상 입력하세요.
// 이미지 파일이 아닙니다..gif .jpg .png 파일만 가능합니다.
// 파일만 가능합니다.
// 공백이 없어야 합니다.

$msg = isset($msg) ? strip_tags($msg) : '';
$msg2 = str_replace("\\n", "<br>", $msg);

$url = isset($url) ? clean_xss_tags($url, 1) : '';
if (!$url) $url = isset($_SERVER['HTTP_REFERER']) ? clean_xss_tags($_SERVER['HTTP_REFERER'], 1) : '';

$url = preg_replace("/[\<\>\'\"\\\'\\\"\(\)]/", "", $url);
$url = preg_replace('/\r\n|\r|\n|[^\x20-\x7e]/','', $url);

// url 체크
check_url_host($url, $msg);
?>

<script>
alert("<?php echo $msg; ?>");
<?php if ($url) { ?>
document.location.replace("<?php echo str_replace('&amp;', '&', $url); ?>");
<?php } else { ?>
history.back();
<?php } ?>
</script>
