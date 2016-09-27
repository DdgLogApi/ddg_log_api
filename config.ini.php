<?php
// defined('emall') or exit('Access Invalid!');

$config = array();
$config['shop_site_url'] 		= 'http://localhost/server-php/shop';
$config['cms_site_url'] 		= 'http://localhost/server-php/cms';
$config['microshop_site_url'] 		= 'http:/localhost/server-php/microshop';
$config['circle_site_url'] 		= 'http://localhost/server-php/circle';
$config['admin_site_url'] 		= 'http://localhost/server-php/manage';
$config['mobile_site_url'] 		= 'http://localhost/server-php/mobile';
$config['wap_site_url'] 		= 'http://localhost/server-php/wapdev';
$config['chat_site_url'] 		= 'http://localhost/server-php/chat';
$config['node_site_url'] 		= 'http://120.27.45.213:8090';
$config['upload_site_url']		= 'http://img2.aigegou.com';
$config['upload_site_url_old']		= 'http://localhost/server-php/data/upload';
$config['resource_site_url']	= 'http://localhost/server-php/data/resource';
$config['error_log_path'] = '/alidata/log/php/log_error'; //错误信息日志
$config['version'] 		= '201411158256';
$config['setup_date'] 	= '2015-07-20 16:20:17';
$config['gip'] 			= 0;
$config['dbdriver'] 	= 'mysqli';
$config['tablepre']		= 'agg_';

$config['db']['1']['dbhost']       = 'rdsbmn6svctt68r9asa1public.mysql.rds.aliyuncs.com';
$config['db']['1']['dbport']       = '3306';
$config['db']['1']['dbuser']       = 'hktxsql';
$config['db']['1']['dbpwd']        = 'hktxsql';
$config['db']['1']['dbname']       = 'aigegou_online';


//$config['db']['1']['dbhost']       = 'rdsol0p554u6d9r6p119.mysql.rds.aliyuncs.com';
//$config['db']['1']['dbport']       = '3306';
//$config['db']['1']['dbuser']       = 'readonly';
//$config['db']['1']['dbpwd']        = '123456';
//$config['db']['1']['dbname']       = 'phpagg';

/*$config['db']['1']['dbhost']       = 'localhost';
$config['db']['1']['dbport']       = '3306';
$config['db']['1']['dbuser']       = 'root';
$config['db']['1']['dbpwd']        = 'root';
$config['db']['1']['dbname']       = 'aigegou_online';*/

$config['db']['1']['dbcharset']    = 'UTF-8';
$config['db']['slave']                  = $config['db']['master'];
$config['session_expire'] 	= 3600;
$config['lang_type'] 		= 'zh_cn';
$config['cookie_pre'] 		= '29E6_';
$config['thumb']['cut_type'] = 'gd';
$config['thumb']['impath'] = '';
$config['cache']['type'] 			= 'file';
$config['redis']['prefix']      	= 'a_';
$config['redis']['master']['port']     	= 6379;
$config['redis']['master']['host']     	= '127.0.0.1';
//$config['redis']['master']['auth']     	= 'phpredis2015';
//$config['redis']['master']['pconnect'] 	= 0;
//$config['redis']['slave']      	    = array();
//$config['fullindexer']['open']      = false;
//$config['fullindexer']['appname']   = 'shopnc';
$config['debug'] 			= false;
$config['default_store_id'] = '1';
$config['url_model'] = false;
$config['subdomain_suffix'] = '';
//$config['session_type'] = 'redis';
//$config['session_save_path'] = 'tcp://120.27.45.213?auth=phpredis2015';
$config['node_chat'] = true;
//流量记录表数量，为1~10之间的数字，默认为3，数字设置完成后请不要轻易修改，否则可能造成流量统计功能数据错误
$config['flowstat_tablenum'] = 10;
/* $config['sms']['gwUrl'] = 'http://sdkhttp.eucp.b2m.cn/sdk/SDKService';
$config['sms']['serialNumber'] = '';
$config['sms']['password'] = '';
$config['sms']['sessionKey'] = ''; */
$config['sms']['accountsid'] = '6fd0ddd750bcd05c409c2989ddbe5e93';
$config['sms']['token'] = '93b64deadb12b9b15c2058460cf999d7';
$config['sms']['appId'] = '3fd50af1ef90431392eadbbb7a8cb5c6';
$config['qny']['accessKey'] = '8_o9V8S_pThZMXZbPT5MMbzosdSogRRAIDrGUKP7';
$config['qny']['secretKey'] = '7ofQXZIU3aISwmdSlW4i6b8pNzxPub0VJbCLH41U';
$config['qny']['bucket'] = 'aggo2onctest';
$config['qny']['watermark_url'] = 'http://7xl2n7.com2.z0.glb.qiniucdn.com/watermark.png';
//极光推送配置
$config['JPush']['appKey']='495ba12d57e820ba926b6e29';
$config['JPush']['masterSecret']='a980c8e57ce1e48827c1937b';
$config['JPush']['isPruduction']=false; //测试环境填false,真实环境true
$config['JPush']['registration_id'] = array('161a3797c805bb8b87a','0907561039f', '08142b4e59a', '030c0cab4e3', '051c803cba2', '091a8320063', '0a194ac481f', '0002c9b7746', '09059db0dec', '080a797eaf2', '0107e93b285', '0108fc0ad3d', '07162fe117b',  '010f19aa512', '030fdc9b39c', '060452bcdb3');//测试环境下可发送的设备id
$config['thrift']['host']='120.27.45.213';
$config['thrift']['port']='7631';
$config['queue']['open'] = false;
$config['queue']['host'] = '127.0.0.1';
$config['queue']['port'] = 6379;
$config['cache_open'] = false;
$config['delivery_site_url']    = 'http://server-php.com/delivery';

$config['JPush']['ptbStoreAppKey']='4f2bd1ea7c3d912bb51fcffd';
$config['JPush']['ptbStoreMasterSecret']='3b6ab06368af6d4e40c24d03';

$config['JPush']['ptbStoreAppKeyOne']='05b07882b698c70f13100c2d';
$config['JPush']['ptbStoreMasterSecretOne']='f7352d44ab8f5113b0375856';
//叮大哥活动相关参数
$config['ddg']['act_special_banner_id'] = 37;
//mongodb config
$config['mongodb']['1']['auth']       = 'true';
$config['mongodb']['1']['host']       = '120.27.45.213';
$config['mongodb']['1']['port']       = '27017';
$config['mongodb']['1']['username']        = 'ddg_user';
$config['mongodb']['1']['password']       = 'kNMAwa6kKd';
$config['mongodb']['1']['db']       = 'ddg_online';
return $config;
