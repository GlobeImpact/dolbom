<?php
include_once('./_common.php');

$list = Array();

$update_date = (int)date('Y') + 1;

$ch = curl_init();
$url = 'http://apis.data.go.kr/B090041/openapi/service/SpcdeInfoService/getRestDeInfo'; /*URL*/
$queryParams = '?' . urlencode('serviceKey') . 'E%2BLp%2BvUO5o6rKaUQ%2B8v%2BTSaSR8KJPUrLgX9EnWXIhK%2FtcepGe9eyLC6hZNN6jQ9WcYFVKJ%2FjNaXq9b12XaLtGg%3D%3D'; /*Service Key*/
$queryParams .= '&' . urlencode('pageNo') . '=' . urlencode('1'); /**/
$queryParams .= '&' . urlencode('numOfRows') . '=' . urlencode('1000'); /**/
$queryParams .= '&' . urlencode('solYear') . '=' . urlencode($update_date); /**/
//$queryParams .= '&' . urlencode('solMonth') . '=' . urlencode('04'); /**/

curl_setopt($ch, CURLOPT_URL, $url . $queryParams);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
$response = curl_exec($ch);

$object = simplexml_load_string($response);
$items = $object->body->items->item;

$i = 0;
foreach ($items as $item) {
    $h_name = $item->dateName;
    $h_date_char = $item->locdate;
    $is_holiday = $item->isHoliday;
    $h_year = substr($h_date_char, 0, 4);
    $h_month = substr($h_date_char, 4, 2);
    $h_day = substr($h_date_char, 6, 2);
    $h_date = $h_year.'-'.$h_month.'-'.$h_day;

    $chk_sql = " select count(*) as cnt from g5_holiday where h_date_char = '{$h_date_char}' ";
    $chk_row = sql_fetch($chk_sql);

    if($chk_row['cnt'] == 0) {
        $sql = " insert into g5_holiday set h_name = '{$h_name}', h_year = '{$h_year}', h_month = '{$h_month}', h_day = '{$h_day}', h_date = '{$h_date}', h_date_char = '{$h_date_char}', is_holiday = '{$is_holiday}' ";
        sql_query($sql);
    }
}

$list['code'] = '0000';

echo json_encode($list);

curl_close($ch);

//var_dump($items);

?>