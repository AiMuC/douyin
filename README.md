# 基于PHP的抖音短视频解析
抖音短视频/抖音火山版 视频无水印解析<br>

# 新版使用示例
# 介绍
新版简化了代码量,取消了抖音火山版的解析功能,如有需要可参考旧版实现方法在新本稍微修改即可!

# 示例1 下载视频
http://127.0.0.1/tiktok/api.php?type=dy&url=https://v.douyin.com/JKbBq7p/&output=download<br>
output=download时将直接返回视频内容 可直接在浏览器中进行下载<br>
如output值为空则默认返回Json<br>

由于视频真实地址无法直接使用PC端访问,返回的视频由本地服务器请求返回,如需直接返回真实地址,请自行修改.<br>


# 示例2 返回Json

http://127.0.0.1/tiktok/api.php?type=dy&url=https://v.douyin.com/JKbBq7p/<br>
此时未填入output则直接返回json内容<br>
返回结果:<br>
{"VideoSrc":"https:\/\/aweme.snssdk.com\/aweme\/v1\/play\/?video_id=v0d00f800000c0j3f4b8u75mn4nrugq0&ratio=720p&line=0","VideoTitle":"我这么会来事，今年我初几去？#花式拜年大赛","VideoImg":"https:\/\/p29.douyinpic.com\/tos-cn-p-0015\/976a209f7d354eda81190600add7787e_1613117332~tplv-dy-360p.jpeg?from=2563711402"}<br>

返回的视频连接需要在手机端请求才能直接访问PC端无法直接打开!<br>


# 旧版使用示例如下

使用示例:https://你的域名/douyin.php?url=https://v.douyin.com/JAxdnmK/<br>

返回结果:[{"code":"200","msg":"获取成功","视频地址":"http:\/\/v92-dy.ixigua.com\/4a522a377071312abed901fb500063e6\/5f688dc3\/video\/tos\/cn\/tos-cn-ve-15\/56f9c015072f4a72a5f95189709d903b\/?a=1128&br=963&bt=321&cr=0&cs=0&cv=1&dr=0&ds=6&er=&l=202009211825460101960230464C05B9E1&lr=&mime_type=video_mp4&qs=0&rc=M29qdXFnNGtzdzMzO2kzM0ApaTNmODVpM2RpNzw1O2Q1OmdwaWUyaHNkL2JfLS01LTBzczY2XmAvNTYtM18uXmA0NTQ6Yw%3D%3D&vl=&vr=","封面图":"https:\/\/p3-dy-ipv6.byteimg.com\/tos-cn-p-0015\/05c59e2038ef4f669ab44de4141cf34d_1599967566~tplv-dy-360p.jpeg?from=2563711402","标题":"他本是华人，救出了98个中国人后，便坐上了日本人的车，从此以后再也没有回来过……他叫……giao桑"}]<br>


直接跳转至下载页:https://你的域名/douyin.php?url=https://v.douyin.com/JAxdnmK/&xz=1<br>

如无需弹窗可自行修改<br>

# 仅供学习交流，严禁用于商业用途!<br>

# 看到的小伙伴帮忙点个star吧~~~

