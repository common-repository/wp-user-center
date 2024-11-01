<?php
/*
Plugin Name: WordPress 用户中心
Author: 水脉烟香
Author URI: https://wptao.com/smyx
Plugin URI: https://wptao.com/wp-user-center.html
Description: 目前功能包括前台注册、登录、个人资料、每日签到、积分(包括积分商城、抽奖等)、查看隐藏内容（积分支付或者微信公众号验证码）、收藏、赞、踩、推广、我的文章等。
Version: 1.0.1
*/

define('WP_USER_CENTER_V', '1.0.1');
define('WP_USER_CENTER_URL', plugins_url('wp-user-center'));
define("WP_USER_CENTER_PATH", WP_PLUGIN_DIR . "/wp-user-center");

add_action('admin_menu', 'wp_user_center_add_page');
function wp_user_center_add_page() {
	if (function_exists('add_menu_page')) {
		add_menu_page('用户中心', '用户中心', 'manage_options', 'wp-user-center', 'wp_user_center_do_page', 'dashicons-businessman');
	} 
	if (function_exists('add_submenu_page')) {
		add_submenu_page('wp-user-center', '基本设置', '基本设置', 'manage_options', 'wp-user-center');
		add_submenu_page('wp-user-center', '积分记录', '积分记录', 'manage_options', 'wp-user-center#', 'wp_user_points_do_page');
		add_submenu_page('wp-user-center', '积分兑换', '积分兑换 (未发货)', 'manage_options', 'wp-user-center#', 'wp_user_points_do_page');
		add_submenu_page('wp-user-center', '积分统计', '积分统计', 'manage_options', 'wp-user-center#', 'wp_user_actions_do_page');
	} 
} 

add_action('plugin_action_links_' . plugin_basename(__FILE__), 'wp_user_center_plugin_actions');
function wp_user_center_plugin_actions($links) {
    $new_links = array();
    $new_links[] = '<a href="options-general.php?page=wp-user-center">' . __('Settings') . '</a>';
    return array_merge($new_links, $links);
}

function wp_user_center_do_page() {
	echo '<div class="updated"><p><strong><a href="https://wptao.com/wp-user-center.html" target="_blank" title="WordPress用户中心">此为后台演示，不可以保存，请点击这里购买正式版</a></strong></p></div>';
	wp_register_style('wp-user-center-admin', WP_USER_CENTER_URL . '/css/admin.css', array(), WP_USER_CENTER_V);
	wp_register_script("jquery-bqq", WP_USER_CENTER_URL . "/js/jquery.ba-bbq.min.js", array("jquery"));
	wp_register_script("wp-user-center-admin", WP_USER_CENTER_URL . "/js/admin.js", array(), WP_USER_CENTER_V);
	wp_print_styles('wp-user-center-admin');
	wp_print_scripts('jquery-bqq');
	wp_print_scripts('wp-user-center-admin');
?>
<form class="plugin_options" action="" method="post" id="plugin-options-panel">
  <div class="header">
	<div class="header_left">
	  <h3><a href="https://wptao.com/wp-user-center.html" target="_blank" title="WordPress用户中心">WordPress</a></h3>
	  <h5>用户中心</h5>
	</div>
	<div class="header_right">
	  <div class="description">
		<h3>用户中心 v<?php echo WP_USER_CENTER_V;?></h3>
		<h5><a href="https://wptao.com/author/smyx" target="_blank" title="查看水脉烟香所有作品">水脉烟香出品</a></h5>
	  </div>
	</div>
  </div>
  <div class="content clearfix">
	<ul class="menu">
	  <li><a href="#tab-base" class="">基本设置<span class="general"></span></a></li>
	  <li><a href="#tab-global" class="selected">全局设置<span class="setting"></span></a></li>
	  <li><a href="#tab-setting">功能设置<span class="refresh"></span></a>
		  <ul class="submenu" style="display: none;">
			 <li><a href="#tab-setting_wechat">微信验证码</a></li>
			 <li><a href="#tab-setting_register">注册登录</a></li>
			 <li><a href="#tab-setting_rating">文章评分</a></li>
		  </ul>
	  </li>
	  	  <li><a href="#tab-points">积分计划<span class="contact_form"></span></a>
		  <ul class="submenu" style="display: none;">
			 <li><a href="#tab-points_pay">积分消费</a></li>
			 <li><a href="#tab-points_register">注册</a></li>
			 <li><a href="#tab-points_login">登录</a></li>
			 <li><a href="#tab-points_sign">签到</a></li>
			 <li><a href="#tab-points_post">写文章</a></li>
			 <li><a href="#tab-points_comment">写评论</a></li>
			 <li><a href="#tab-points_favorite">收藏</a></li>
			 <li><a href="#tab-points_rating">文章评分</a></li>
			 <li><a href="#tab-points_affiliate">推荐用户</a></li>
			 <li><a href="#tab-points_click">访客点击</a></li>
			 <li><a href="#tab-points_list">积分详细列表</a></li>
		  </ul>
	  </li>
	  	  <li><a href="#tab-about">关于我们<span class="social"></span></a></li>
	</ul>
	<div id="tab-base" class="settings" style="display: none;">
	  <h3>插件授权</h3>
	  <div class="option">
		<h4>填写插件授权码</h4><input type="text" class="inputs" name="authorize_code" size="50" value=""> 	  </div>
    </div>
	<div id="tab-global" class="settings" style="display: block;">
	  <h3>全局设置</h3>
	  <div class="option">
		<h4>前台注册登录</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[active][register]" type="hidden" value="1">
		<span class="text-tips">替换WordPress原有注册登录页面</span>
	  </div>
	  <div class="option">
		<h4>前台资料页面</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[active][profile]" type="hidden" value="1">
		<span class="text-tips">将WordPress原有的个人资料页面搬到前台</span>
	  </div>
	  <div class="option">
		<h4>积分计划</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[active][points]" type="hidden" value="1">
		<span class="text-tips">您的用户在进行一些操作时，奖励积分作为回报</span>
	  </div>
	  <div class="option">
		<h4>积分商城</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[active][jifen]" type="hidden" value="">
		<span class="text-tips">开启后，可以让用户【兑换/抽奖】您发布的商品。</span>
	  </div>
	  <div class="option">
		<h4>收藏文章</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[active][favorite]" type="hidden" value="1">
		<span class="text-tips">用户可以收藏您网站的文章，方便今后查阅。</span>
	  </div>
	  <div class="option">
		<h4>文章评分</h4>
		<select name="wpuser[active][rating]" class="option-select">
		  <option value="0">不使用</option>
		  <option value="1" selected="selected">顶和踩</option>
		  <option value="2">顶</option>
		</select>
		<span class="text-tips">用户可以对网站文章进行评分，以此表达一种态度。</span>
	  </div>
	  <div class="option">
		<h4>推广联盟</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[active][affiliate]" type="hidden" value="1">
		<span class="text-tips">已注册用户可以推荐新用户。在微信APP登录后分享给好友或者朋友圈自动加推介参数。</span>
	  </div>
	  <div class="option">
		<h4>我的文章</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[active][posts]" type="hidden" value="0">
		<span class="text-tips">用户可以在前台查看自己的文章，其他用户也可以访问。</span>
	  </div>
	  <div class="option">
		<h4>在【首页】显示赞、踩、收藏按钮</h4>
		<select name="wpuser[theme][home]" class="option-select">
		  <option value="0" selected="selected">不显示</option>
		  <option value="1">小图标</option>
		  <option value="2">大图标</option>
		</select>
	  </div>
	  <div class="option">
		<h4>在【文章页】显示赞、踩、收藏按钮</h4>
		<select name="wpuser[theme][single]" class="option-select">
		  <option value="0">不显示</option>
		  <option value="1">小图标</option>
		  <option value="2" selected="selected">大图标</option>
		</select>
	  </div>
	  <div class="option">
		<h4>★ 调用插件的【弹出登录窗口】</h4>
		<span class="text-tips">您可以修改主题，在要点击的地方添加class值为<code>uc-login-button</code>【<a target="_blank" href="https://wptao.com/wp-user-center.html#uc-login-button">看教程</a>】<br><br>如果您安装了<a target="_blank" href="https://wptao.com/wp-connect.html">WordPress连接微博</a>，会在弹出的登录框自动加上社交帐号登录。</span>
	  </div>
	  <div class="option">
		<h4>★ 自定义赞、踩、收藏 [<a target="_blank" href="https://wptao.com/wp-user-center.html#custom-actions">看教程</a>]</h4>
	  </div>
    </div>
	<div id="tab-setting" class="settings" style="display: none;">
	<div id="tab-setting_wechat" class="subsettings" style="display: none;">
	  <h3>微信验证码</h3>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">隐藏文章中的任意内容，关注您的<a target="_blank" href="https://mp.weixin.qq.com/">微信公众号</a>后，通过发送特定关键字获取验证码才可以查看隐藏内容。需要安装<a target="_blank" href="https://wptao.com/wechat.html">WordPress连接微信</a>插件，此功能可以跟<a href="#tab-points_pay">积分消费</a>一起使用。</span>
	  </div>
	  <div class="option">
		<h4>微信验证码</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[wechat][open]" type="hidden" value="">
	  </div>
	  <div class="option">
		<h4>名称</h4>
		<input name="wpuser[wechat][name]" class="inputs" type="text" size="60" value="">
		<span class="text-tips">微信公众平台→公众号设置→名称，与下面的微信号二选一，优先显示名称。</span>
	  </div>
	  <div class="option">
		<h4>微信号</h4>
		<input name="wpuser[wechat][account]" class="inputs" type="text" size="60" value="">
		<span class="text-tips">微信公众平台→公众号设置→微信号，与上面的名称二选一，优先显示名称。</span>
	  </div>
	  <div class="option">
		<h4>微信二维码</h4>
		<input name="wpuser[wechat][qrcode]" class="inputs" type="text" size="60" value="" id="upid-wechat-account"><input type="button" class="button upload_button" upid="wechat-account" value="上传">
		<span class="text-tips">建议：150x150px</span>
	  </div>
	  <div class="option">
		<h4>全局关键字（慎用）</h4>
		<input name="wpuser[wechat][keyword]" class="inputs" type="text" size="60" value="">
		<span class="text-tips">设置后，如果文章【关键字】没有自定义，即选择【默认】时，将全局使用该关键字来获取验证码。</span>
	  </div>
	  <div class="option">
		<h4>全局关键字的验证码</h4>
		<input name="wpuser[wechat][code]" class="inputs" type="text" size="60" value="">
		<span class="text-tips">只有配置了全局关键字才有效，如果此处不填写，将使用随机验证码。</span>
	  </div>
	  <div class="option">
		<h4>随机验证码有效期</h4>
		<input name="wpuser[wechat][expired]" class="inputs small" type="text" size="60" value="60" onmouseup="value=value.replace(/[^\d]/g,'')" onkeyup="value=value.replace(/[^\d]/g,'')"> 分钟
		<span class="text-tips">请写30~1440区间的纯数字。到期后会生成新的验证码。</span>
	  </div>
	  <div class="option">
		<h4>突出隐藏的内容</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[wechat][succeed]" type="hidden" value="">
		<span class="text-tips">验证成功后，在内容外层加红色虚线，以便突出隐藏的内容。</span>
	  </div>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">除了这边用到微信公众号外，还有<a href="#tab-points_sign">微信签到</a>。需要安装<a target="_blank" href="https://wptao.com/wechat.html">WordPress连接微信</a>插件。</span>
	  </div>
	</div>
	<div id="tab-setting_register" class="subsettings" style="display: none;">
	  <h3>注册登录</h3>
	  <div class="option">
		<h4>登录后跳转到首页</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[register][login_redirect]" type="hidden" value="1">
		<span class="text-tips">在登录页面，默认是进入后台(仪表盘)，开启后会进入首页。只有在<code>redirect_to</code>没有值时生效。</span>
	  </div>
	  <div class="option">
		<h4>登录类型</h4>
		<select name="wpuser[login_type]" class="option-select">
		  <option value="">只使用用户名</option>
		  <option value="email">只使用邮箱</option>
		  <option value="both" selected="selected">使用用户名或者邮箱（推荐）</option>
		</select>
	  </div>
	  <div class="option">
		<h4>处理WordPress原有的登录页面</h4>
		<select name="wpuser[register][wplogin]" class="option-select">
		  <option value="0">跳到新的登录页面</option>
		  <option value="1">返回404页面</option>
		  <option value="2" selected="selected">依旧可以登录</option>
		</select>
		<span class="text-tips">当用户打开WordPress原有的登录页面时的处理方式。</span>
	  </div>
	  <div class="option">
		<h4>支持中文用户名</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[register][chinese_username]" type="hidden" value="">
		<span class="text-tips">默认情况下，WordPress只允许字母、数字、下划线等组合的用户名。</span>
	  </div>
	  <div class="option">
		<h4>新用户注册时禁止通知管理员</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[register][disable_send_admin]" type="hidden" value="">
		<span class="text-tips">默认情况下，新用户注册时会发送一封邮件通知管理员，如果不需要通知请开启。</span>
	  </div>
	  	  <div class="option">
		<h4>任何人都可以注册</h4>
		<div class="on-off"><span></span></div>
		<input name="wpoption[users_can_register]" type="hidden" value="0">
		<span class="text-tips">如果您正在使用<a target="_blank" href="https://wptao.com/wp-connect.html">WordPress连接微博</a>，不开启也能注册。</span>
	  </div>
	  <div class="option">
		<h4>新用户默认角色</h4>
		<select name="wpoption[default_role]" class="option-select">
		  
	<option selected="selected" value="subscriber">订阅者</option>
	<option value="contributor">投稿者</option>
	<option value="author">作者</option>
	<option value="editor">编辑</option>
	<option value="administrator">管理员</option>		</select>
	  </div>
	  	</div>
	<div id="tab-setting_rating" class="subsettings" style="display: none;">
	  <h3>文章评分</h3>
	  <div class="option">
		<h4>允许匿名评分</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[rating][anonymous]" type="hidden" value="">
		<span class="text-tips">开启后，未登录也可以评分。</span>
	  </div>
	  <div class="option">
		<h4>【赞】对外显示的文字</h4>
		<input name="wpuser[rating][like]" class="inputs" type="text" size="60" value="赞">
		<span class="text-tips">可能部分模版不直接显示文字</span>
	  </div>
	  <div class="option">
		<h4>【踩】对外显示的文字</h4>
		<input name="wpuser[rating][dislike]" class="inputs" type="text" size="60" value="踩">
		<span class="text-tips">可能部分模版不直接显示文字</span>
	  </div>
	</div>
	</div>
	<div id="tab-points" class="settings" style="display: none;">
	<div id="tab-points_pay" class="subsettings" style="display: none;">
	  <h3>积分消费</h3>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">目前支持的消费方式包括：积分商城（兑换、抽奖）、文章内容收费（隐藏内容可见）。</span>
	  </div>
	  <div class="option">
		<h4>1元人民币相当于</h4>
		<select name="wpuser[points][rmb]" class="option-select">
		  <option value="100">100积分（推荐）</option>
		  <option value="1000">1000积分</option>
		  <option value="500">500积分</option>
		  <option value="200">200积分</option>
		  <option value="10">10积分</option>
		</select>
		<span class="text-tips">仅作为参考，方便您配置各项积分，不作为真实兑换。</span>
	  </div>
	  <div class="option">
		<h4>隐藏内容可见</h4>
		<span class="text-tips">用户通过消耗积分查看隐藏的内容，文章作者可以获得积分。此功能可以跟<a href="#tab-setting_wechat">微信公众号</a>一起使用。</span>
	  </div>
	  <div class="option">
		<h4>扣除手续费（比例）</h4>
		<select name="wpuser[points][pay][fee]" class="option-select">
		  <option value="0">不扣除</option>
		  <option value="10">10%</option>
		  <option value="20">20%</option>
		  <option value="30">30%</option>
		  <option value="40">40%</option>
		  <option value="50">50%</option>
		</select>
		<span class="text-tips">用户支付积分后，文章作者可以获得用户支付的积分，网站是否扣除手续费？</span>
	  </div>
	</div>
	<div id="tab-points_register" class="subsettings" style="display: none;">
	  <h3>注册</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][register][active]" type="hidden" value="1">
		<span class="text-tips">开启后，新注册用户才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>奖励积分</h4>
		<input name="wpuser[points][register][user]" class="inputs" type="text" size="60" value="20" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>绑定手机号-额外奖励积分</h4>
		<input name="wpuser[points][register][phone]" class="inputs" type="text" size="60" value="50" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。绑定手机号需要安装<a target="_blank" href="https://wptao.com/wptao-sms.html">WordPress短信服务</a>插件</span>
	  </div>
	</div>
	<div id="tab-points_login" class="subsettings" style="display: none;">
	  <h3>登录</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][login][active]" type="hidden" value="1">
		<span class="text-tips">开启后，登录才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>奖励积分</h4>
		<input name="wpuser[points][login][user]" class="inputs" type="text" size="60" value="1" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>限制</h4>
		<select name="wpuser[points][login][limit]" class="option-select">
		  <option value="1" selected="selected">每天一次（0时开始算起）</option>
		  <option value="24">每24小时一次</option>
		</select>
	  </div>
	</div>
	<div id="tab-points_sign" class="subsettings" style="display: none;">
	  <h3>签到</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][sign][active]" type="hidden" value="1">
		<span class="text-tips">开启后，当日签到的用户才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>奖励基础积分</h4>
		<input name="wpuser[points][sign][user]" class="inputs" type="text" size="60" value="5" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>微信签到额外奖励积分</h4>
		<input name="wpuser[points][sign][weixin]" class="inputs" type="text" size="60" value="2" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。签到时会自动加上基础积分。需要安装<a target="_blank" href="https://wptao.com/wechat.html">WordPress连接微信</a>插件</span>
	  </div>
	  <div class="option">
		<h4>连续签到5天后每天额外奖励积分</h4>
		<input name="wpuser[points][sign][5day]" class="inputs" type="text" size="60" value="2" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。签到时会自动加上基础积分，只要有一天漏签就会重新计算。</span>
	  </div>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">每日一次，0时后开始算起。</span>
	  </div>
	</div>
	<div id="tab-points_post" class="subsettings" style="display: none;">
	  <h3>写文章</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][post][active]" type="hidden" value="1">
		<span class="text-tips">开启后，发布新文章才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>奖励积分</h4>
		<input name="wpuser[points][post][author]" class="inputs" type="text" size="60" value="5" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>每天限制单个用户允许奖励的文章数</h4>
		<input name="wpuser[points][post][limit]" class="inputs" type="text" size="60" value="10" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制</span>
	  </div>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">如果文章发布后超过一个月被删除的，依然保持前一次状态的分值，否则文章删除后积分会被归为0</span>
	  </div>
	</div>
	<div id="tab-points_comment" class="subsettings" style="display: none;">
	  <h3>写评论</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][comment][active]" type="hidden" value="1">
		<span class="text-tips">开启后，发布新评论才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>评论获准-评论者奖励积分</h4>
		<input name="wpuser[points][comment][user][approved]" class="inputs" type="text" size="60" value="1" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>评论获准-文章作者奖励积分</h4>
		<input name="wpuser[points][comment][author][approved]" class="inputs" type="text" size="60" value="0" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>评论待审-评论者奖励积分</h4>
		<input name="wpuser[points][comment][user][unapproved]" class="inputs" type="text" size="60" value="0" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>垃圾评论-评论者奖励积分</h4>
		<input name="wpuser[points][comment][user][spam]" class="inputs" type="text" size="60" value="-5" onkeyup="value=value.replace(/[^\-\d]/g,'')">
		<span class="text-tips">本处允许<code>负值</code>。正值不加符号，负值时数字前使用减号(<code>-</code>)</span>
	  </div>
	  <div class="option">
		<h4>回收站-评论者奖励积分</h4>
		<input name="wpuser[points][comment][user][trash]" class="inputs" type="text" size="60" value="-1" onkeyup="value=value.replace(/[^\-\d]/g,'')">
		<span class="text-tips">本处允许<code>负值</code>。正值不加符号，负值时数字前使用减号(<code>-</code>)</span>
	  </div>
	  <div class="option">
		<h4>说明</h4>
		<span class="text-tips">当评论状态改变时，积分将做出相应修改。删除评论不再扣分，依然保持前一次评论状态的分值。</span>
	  </div>
	  <div class="option">
		<h4>每篇文章限制单个用户允许奖励的评论条数</h4>
		<input name="wpuser[points][comment][limits][per_post]" class="inputs" type="text" size="60" value="10" onkeyup="value=value.replace(/[^\d]/g,'')"> 
		<span class="text-tips">填<code>0</code>表示不限制</span>
	  </div>
	  <div class="option">
		<h4>每天限制单个用户允许奖励的评论条数</h4>
		<input name="wpuser[points][comment][limits][per_day]" class="inputs" type="text" size="60" value="10" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制</span>
	  </div>
	  <div class="option">
		<h4>当文章作者自己评论时也有积分</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[points][comment][limits][self_comment]" type="hidden" value="">
	  </div>
	  <div class="option">
		<h4>当评论者回复自己的评论时也有积分</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[points][comment][limits][self_reply]" type="hidden" value="">
	  </div>
	</div>
	<div id="tab-points_favorite" class="subsettings" style="display: none;">
	  <h3>收藏文章</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][favorite][active]" type="hidden" value="1">
		<span class="text-tips">开启后，收藏文章才有积分奖励，如果网站文章很多，不建议开启，避免用户靠收藏文章赚取积分。（关闭时，用户依然可以收藏文章）</span>
	  </div>
	  <div class="option">
		<h4>收藏者 奖励积分</h4>
		<input name="wpuser[points][favorite][user]" class="inputs" type="text" size="60" value="1" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。如果用户取消收藏，积分将被收回（即为0）</span>
	  </div>
	  <div class="option">
		<h4>文章作者 奖励积分</h4>
		<input name="wpuser[points][favorite][author]" class="inputs" type="text" size="60" value="0" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。如果用户取消收藏，积分将被收回（即为0）</span>
	  </div>
	  <div class="option">
		<h4>每天限制单个用户允许奖励的文章数</h4>
		<input name="wpuser[points][favorite][limit]" class="inputs" type="text" size="60" value="2" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制</span>
	  </div>
	</div>
	<div id="tab-points_rating" class="subsettings" style="display: none;">
	  <h3>文章评分</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][rating][active]" type="hidden" value="1">
		<span class="text-tips">开启后，对文章进行评分才有积分奖励，如果网站文章很多，不建议开启，避免用户靠评分赚取积分。（关闭时，用户依然可以对文章进行评分）</span>
	  </div>
	  <div class="option">
		<h4>评分者 奖励积分</h4>
		<input name="wpuser[points][rating][user]" class="inputs" type="text" size="60" value="1" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>【顶】时，文章作者 奖励积分</h4>
		<input name="wpuser[points][rating][author][like]" class="inputs" type="text" size="60" value="0" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。</span>
	  </div>
	  <div class="option">
		<h4>【踩】时，文章作者 奖励积分</h4>
		<input name="wpuser[points][rating][author][dislike]" class="inputs" type="text" size="60" value="0" onkeyup="value=value.replace(/[^\-\d]/g,'')">
		<span class="text-tips">本处允许<code>负值</code>。正值不加符号，负值时数字前使用减号(<code>-</code>)</span>
	  </div>
	  <div class="option">
		<h4>每天限制单个用户允许奖励的文章数</h4>
		<input name="wpuser[points][rating][limit]" class="inputs" type="text" size="60" value="2" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制</span>
	  </div>
	</div>
	<div id="tab-points_affiliate" class="subsettings" style="display: none;">
	  <h3>推荐新用户</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][affiliate][active]" type="hidden" value="1">
		<span class="text-tips">开启后，推荐新用户注册才有积分奖励。</span>
	  </div>
	  <div class="option">
		<h4>推荐者 奖励积分</h4>
		<input name="wpuser[points][affiliate][user]" class="inputs" type="text" size="60" value="5" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。如果新用户被管理员删除，推荐者奖励的积分将被收回。</span>
	  </div>
	  <div class="option">
		<h4>新用户 奖励积分</h4>
		<input name="wpuser[points][affiliate][new_user]" class="inputs" type="text" size="60" value="2" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。如果用户被管理员删除，该用户的所有记录将被删除。</span>
	  </div>
	  <div class="option">
		<h4>每天限制单个用户允许奖励的新用户数</h4>
		<input name="wpuser[points][affiliate][limit]" class="inputs" type="text" size="60" value="10" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制（不建议填0，避免出现僵尸帐号。）</span>
	  </div>
	</div>
	<div id="tab-points_click" class="subsettings" style="display: none;">
	  <h3>访客点击</h3>
	  <div class="option">
		<h4>积分</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[points][click][active]" type="hidden" value="0">
		<span class="text-tips">开启后，访客点击推广链接时有积分。</span>
	  </div>
	  <div class="option">
		<h4>仅未登录用户点击有积分</h4>
		<div class="on-off"><span style="margin-left: 49px;"></span></div>
		<input name="wpuser[points][click][nologin]" type="hidden" value="1">
		<span class="text-tips">开启后，仅未登录用户点击他人的推广链接时对方有积分。</span>
	  </div>
	  <div class="option">
		<h4>前台不显示访客点击的数据</h4>
		<div class="on-off"><span></span></div>
		<input name="wpuser[points][click][hide]" type="hidden" value="">
		<span class="text-tips">开启后，用户在前台看不到访客点击的数据，但是积分总数会包含这一部分数据。</span>
	  </div>
	  <div class="option">
		<h4>奖励积分</h4>
		<input name="wpuser[points][click][user]" class="inputs" type="text" size="60" value="1" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">本处只允许正值。每天同一个IP只记一次。</span>
	  </div>
	  <div class="option">
		<h4>每天次数上限</h4>
		<input name="wpuser[points][click][limit]" class="inputs" type="text" size="60" value="10" onkeyup="value=value.replace(/[^\d]/g,'')">
		<span class="text-tips">填<code>0</code>表示不限制（不建议填0，避免出现刷链接。）</span>
	  </div>
	  <div class="option">
		<h4>仅点击以下链接有积分</h4>
		<textarea name="wpuser[points][click][links]" cols="80" rows="4"></textarea>
		<span class="text-tips">URL一行一个（不设置表示所有推广链接都支持。不支持固定连接是朴素的链接，URL不要加无用的参数，不要加推介参数，如果是首页URL最后面必须加/）</span>
	  </div>
	</div>
	<div id="tab-points_list" class="subsettings" style="display: none;">
	  <h3>积分详细列表（请保存设置后查看）</h3>
	  <div class="option">
		<table class="uc-table-base" id="wp-uc-table"><thead><tr><th>操作</th><th>积分</th><th>限制</th></tr></thead><tbody><tr><td>绑定手机号</td><td>50 【<a target="_blank" href="http://www.wptao.com/profile">去绑定</a>】</td><td></td></tr><tr><td>文章作者</td><td>写文章: 5（每天前10次有积分）<br>积分收入（隐藏内容可见）: 不限积分，扣除手续费: 1%</td><td></td></tr><tr><td>注册</td><td>20</td><td></td></tr><tr><td>登录</td><td>1</td><td>每天前1次有积分</td></tr><tr><td>每日签到</td><td>基础积分: 5<br>微信签到额外奖励积分: 2（给本站公众号发关键字：签到）<br>连续签到5天后每天额外奖励积分: 2</td><td></td></tr><tr><td>写评论</td><td>已发布: 1<br>垃圾评论: -5<br>回收站: -1<br></td><td>每天前10次有积分</td></tr><tr><td>收藏</td><td>1</td><td>每天前2次有积分</td></tr><tr><td>文章评分</td><td>1</td><td>每天前2次有积分</td></tr><tr><td>推荐新用户</td><td>5</td><td>每天前10次有积分</td></tr></tbody></table>	  </div>
	</div>
	</div>
	<div id="tab-about" class="settings" style="display: none;">
	  <h3>关于我们</h3>
		<div class="option">
		<p><a href="https://wptao.com/wp-user-center.html#Changelog" target="_blank">查看插件更新日志</a></p>
		<p>产品推荐</p>
		<ol><li><a target="_blank" href="https://wptao.com/product-lists.html">产品套餐（付费一次拥有以下所有插件，超级划算）</a></li><li><a target="_blank" href="https://wptao.com/wp-connect.html">WordPress连接微博专业版（一键登录网站，同步到微博、博客，社会化评论）</a></li><li><a target="_blank" href="https://wptao.com/wechat.html">WordPress连接微信(微信机器人)</a></li><li><a target="_blank" href="https://wptao.com/blog-optimize.html">WordPress优化与增强插件：博客优化</a></li><li><a target="_blank" href="https://wptao.com/wptao-sms.html">WordPress短信服务（支持手机号注册/登录，短信通知等）</a></li><li><a target="_blank" href="https://wptao.com/wp-taomall.html">WordPress淘宝客主题：wp-taomall (自动获取商品信息和推广链接)</a></li><li><a target="_blank" href="https://wptao.com/wptao.html">WordPress淘宝客插件 (一键获取及自动填充商品信息和推广链接)</a></li><li><a target="_blank" href="https://wptao.com/wp-user-center.html">WordPress用户中心</a></li><li><a target="_blank" href="https://wptao.com/weixin-cloned.html">WordPress微信分身（避免微信封杀网站域名）</a></li><li><a target="_blank" href="https://wptao.com/weixin-helper.html">WordPress微信群发助手</a></li></ol>		</div>
    </div>
  </div>
  <div class="footer">
	<div class="footer_left">
	  <ul class="social-list">
		<li><a target="_blank" href="https://img.wptao.com/3/small/62579065gy1fqx11pit2mj20by0bygme.jpg" class="social-list-wechat" title="微信号:wptaocom"></a></li>
		<li><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=3249892&amp;site=qq&amp;menu=yes" class="social-list-qq" title="QQ:3249892"></a></li>
		<li><a target="_blank" href="http://weibo.com/smyx" class="social-list-weibo" title="新浪微博"></a></li>
		<li><a target="_blank" href="https://twitter.com/smyx" class="social-list-twitter" title="Twitter"></a></li>
	  </ul>
	</div>
	<div class="footer_right">
	  <input type="submit" name="wpuser_options" class="button-submit" value="保存设置">
	</div>
  </div>
</form>
<?php
}