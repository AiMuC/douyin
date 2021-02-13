<?php

/*
//目前支持抖音，火山解析 默认不加参数为抖音解析
//参数表 $type=huoshan,
//状态码 403 空参数,404 解析出错,200 返回正常
//By:AiMuC QQ:1446929313
*/

$inurl=$_GET[url];//接收的url链接

$code=$_GET[code];//输出方式 空默认输出json数组

$xz=$_GET[xz];//下载参数为1跳转至播放页

$type=$_GET[type];//链接类型

$arr = array();

if($inurl==""){
	
	//空参数状态码403

	$tmp = array('code' => "403",'msg' => "参数错误",'视频地址' => $videosrc, '封面图'=> $videoimg,'标题'=> $videotitle);
	
	array_push($arr, $tmp);
	
	echo json_encode($arr,JSON_UNESCAPED_UNICODE);
	
}else{

	if($type==huoshan){//抖音火山版解析
		
		$videoid=get_videosrc("$inurl");//获取传入url跳转后地址

		$preg="/id=.*&tag/";//获取视频ID

		preg_match_all($preg,"$videoid",$ok);

		//var_dump($ok[0][0]);

		$videoid=$ok[0][0];

		$videoid=str_replace(array("id=","&tag"),"","$videoid");
		
		$srccode=get_url("https://share.huoshan.com/api/item/info?item_id=$videoid");//获取视频信息

		$srccode=json_decode($srccode, true);

		$videoimg=$srccode[data][item_info][cover];//视频封面

		$videosrc=$srccode[data][item_info][url];//视频地址未跳转

		$videosrc=str_replace("app_id=0","app_id=1","$videosrc");

		$videosrc=get_videosrc("$videosrc");//视频真实地址
		
		//未获取到视频地址报错
		
		if($videosrc==null){

				$tmp = array('code' => "404",'msg' => "无法获取到视频地址,请检查视频地址是否输入错误或未加入参数");
				
				array_push($arr, $tmp);
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);

				exit();

		}
		
		$tmp = array('code' => "200",'msg' => "获取成功",'视频地址' => $videosrc, '封面图'=> $videoimg);//封装进数组

		array_push($arr, $tmp);

		if($code==arr){
				
				print_r($arr);
			
			}elseif($xz==1){
				
				echo "<script language='javascript' type='text/javascript'>alert('点击确定后跳转到播放页');window.location.href='$videosrc';</script>";	

			}else{
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);
				
			}
		
	}else{//抖音短视频解析

		$url=get_videosrc("$inurl");//获取跳转后的url

		$newcode=get_url("$url");//获取跳转后url源代码

		$preg="/video\/.*\//";//匹配视频id

		preg_match_all($preg,"$url",$ok);

		//var_dump($ok[0][0]);

		$videoid=$ok[0][0];

		$videoid=str_replace(array("video/","/"),"","$videoid");

		$srccode=get_url("https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids=$videoid");//获取视频信息

		$srccode=json_decode($srccode, true);

		$videotitle=$srccode[item_list][0][desc];//视频标题
		
		$videosrc=$srccode[item_list][0][video][play_addr][url_list][0];//视频带水印地址

		$videosrc=str_replace("playwm","play","$videosrc");//视频去水印未跳转地址

		$videosrc=get_videosrc("$videosrc");//视频真实地址
		
		$videoimg=$srccode[item_list][0][video][origin_cover][url_list][0];

			//未获取到视频地址报错

			if($videosrc==null){

				$tmp = array('code' => "404",'msg' => "无法获取到视频地址,请检查视频地址是否输入错误或未加入参数");
				
				array_push($arr, $tmp);
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);

				exit();

			}
			
			//未获取到封面图报错
			if($videoimg==null){

				$tmp = array('code' => "404",'msg' => "无法获取到封面图");
				
				array_push($arr, $tmp);
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);

				exit();

			}

			//未获取到视频标题报错

			if($videotitle==null){

				$tmp = array('code' => "404",'msg' => "无法获取到视频标题");
				
				array_push($arr, $tmp);
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);

				exit();

			}

		$tmp = array('code' => "200",'msg' => "获取成功",'视频地址' => $videosrc, '封面图'=> $videoimg,'标题'=> $videotitle);//封装进数组

		array_push($arr, $tmp);
		
			if($code==arr){
				
				print_r($arr);
			
			}elseif($xz==1){
				
				echo "<script language='javascript' type='text/javascript'>alert('点击确定后跳转到播放页');window.location.href='$videosrc';</script>";	

			}else{
				
				echo json_encode($arr,JSON_UNESCAPED_UNICODE);

			}
	}
}

function get_videosrc($url){

	$printvideo="";//是否直接输出视频

	$ch = curl_init($url); //初始化

	curl_setopt($ch, CURLOPT_HEADER, 0); // 不返回header部分

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 返回字符串，而非直接输出

	curl_setopt($ch, CURLOPT_USERAGENT, "Dalvik/1.6.0 (Linux; U; Android 4.1.2; DROID RAZR HD Build/9.8.1Q-62_VQW_MR-2)");//模拟手机进行访问

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); //是否抓取跳转后的页面

	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 返回最后的地址

	curl_exec($ch);//执行

		if($printvideo!=null){

		curl_close($ch);//关闭curl进程

		$srcvideo=curl_exec($ch);//定义视频地址

		header("Content-type: video/mp4"); //定义头部为mp4

		echo $srcvideo;//输出视频

		}else{

		$info = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);//真实地址

		curl_close($ch);//关闭curl进程

		return $info;//输出无水印地址

		}

}

function get_url($url){
	
    $ifpost = '';//是否post请求
	
    $datafields ='';
	
    $cookiefile = '';//cookie文件
	
    $cookie = '';//cookie变量
	
    $v = false;//构造随机ip
	
    $ip_long = array(
	
        array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
		
    );
	
    $rand_key = mt_rand(0, 9);
	
    $ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
	
    //模拟http请求header头
	
    $header = array("Connection: Keep-Alive","Accept: text/html, application/xhtml+xml, */*", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'CLIENT-IP:'.$ip,'X-FORWARDED-FOR:'.$ip);
    
	$ch = curl_init();
	
    curl_setopt($ch, CURLOPT_URL, $url);
	
    curl_setopt($ch, CURLOPT_HEADER, $v);
	
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.douyin.com/');//模拟来路
	
    $ifpost && curl_setopt($ch, CURLOPT_POST, $ifpost);
	
    $ifpost && curl_setopt($ch, CURLOPT_POSTFIELDS, $datafields);
	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
    $cookie && curl_setopt($ch, CURLOPT_COOKIE, $cookie);//发送cookie变量
	
    $cookiefile && curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);//发送cookie文件
	
    $cookiefile && curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);//写入cookie到文件
	
    curl_setopt($ch,CURLOPT_TIMEOUT,60); //允许执行的最长秒数
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	
    $ok = curl_exec($ch);
	
    //$ok = json_decode($ok, true);
	
    curl_close($ch);
	
    unset($ch);
	
    //return var_dump($ok);
	
    return $ok;
}


?>
