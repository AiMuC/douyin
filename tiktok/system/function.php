<?php
/* File Info 
 * Author:      AiMuC 
 * CreateTime:  2021/2/12 下午2:50:15 
 * LastEditor:  AiMuC
 * ModifyTime:  2021/2/13 下午12:59:15
 * Description: 
*/

/* 
 * @Description: 获取抖音短视频无水印视频数据
 * @param: url 视频连接
 * @param: output 默认值为Json 共两种类型 Download/Json
 * @return: Video/Json
*/
function GetDyVideo($url, $output = "json")
{
    if ($output == null) $output = "json";
    $WebData = MyRequest($url, "", "GET", "", "");
    $VideoId = explode("/", $WebData['headers']['location']);
    $VideoData = MyRequest("https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids=$VideoId[5]", "", "GET", "", "");
    $VideoData = json_decode($VideoData['body'], true);
    $VideoSrc = str_replace("playwm", "play", $VideoData['item_list'][0]['video']['play_addr']['url_list'][0]); //视频去水印未跳转地址
    $VideoTitle = $VideoData['item_list'][0]['desc']; //视频标题
    $VideoImg = $VideoData['item_list'][0]['video']['origin_cover']['url_list'][0]; //视频封面
    if ($output == "download") {
        $Video = MyRequest($VideoSrc, "", "GET", "", "", "PE");
        header("Content-type: video/mp4"); //定义头部为mp4
        echo $Video['body']; //输出视频
    } else if ($output == "json") {
        $ReturnArr = array(
            'VideoSrc' => $VideoSrc,
            'VideoTitle' => $VideoTitle,
            'VideoImg' => $VideoImg,
        );
        echo json_encode($ReturnArr, JSON_UNESCAPED_UNICODE);
    }
}

/* 
 * @Description: Web请求函数
 * @param: url 必填
 * @param: header 请求头 为空时使用默认值
 * @param: type 请求类型
 * @param: data 请求数据
 * @param: DataType 数据类型 分为1,2 1为数据拼接传参 2为json传参
 * @param: HeaderType 请求头类型 默认为PC请求头 值为PE时请求头为手机
 * @return: result
*/
function MyRequest($url, $header, $type, $data, $DataType, $HeaderType = "PC")
{
    //常用header
    //$header = "user-agent:" . 1 . "\r\n" . "referer:" . 1 . "\r\n" . "AccessToken:" . 1 . "\r\n" . "cookie:" . 1 . "\r\n";
    if (empty($header)) {
        if ($HeaderType == "PC") {
            $header = "user-agent:Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.150 Safari/537.36 Edg/88.0.705.63\r\n";
        } else if ($HeaderType == "PE") {
            $header = "user-agent:Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1 Edg/88.0.4324.150\r\n";
        }
    }
    if (!empty($data)) {
        if ($DataType == 1) {
            $data = http_build_query($data); //数据拼接
        } else if ($DataType == 2) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE); //数据格式转换
        }
    }
    $options = array(
        'http' => array(
            'method' => $type,
            "header" => $header,
            'content' => $data,
            'timeout' => 15 * 60, // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $headers = get_headers($url, true); //获取请求返回的header
    $ReturnArr = array(
        'headers' => $headers,
        'body' => $result
    );
    return $ReturnArr;
}
