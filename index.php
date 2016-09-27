<?php
/**
 * Copyright (C) Alibaba Cloud Computing
 * All rights reserved
 */

 require_once realpath(dirname(__FILE__) . '/Log_Autoload.php');
 require_once  realpath(dirname(__FILE__) . '/lib/function.php');
 require_once realpath(dirname(__FILE__) . '/global.php');
 require_once realpath(dirname(__FILE__) . '/config.ini.php');

	/*
	 * type 1:插入阿里云日志后台;2:查询日志
	 */
	$endpoint = 'cn-qingdao.log.aliyuncs.com'; // 选择与上面步骤创建Project所属区域匹配的Endpoint
	$accessKeyId = '6KKVWcpCxAjAHaOL';        // 使用你的阿里云访问秘钥AccessKeyId
	$accessKey = 'Bc4guQZAjvxx0MGz5kYFWWSUXVeVL1';             // 使用你的阿里云访问秘钥AccessKeySecret
	$project = 'testing-logservice';                  // 上面步骤创建的项目名称
	$logstore = 'test-log';                // 上面步骤创建的日志库名称
	$client = new Aliyun_Log_Client($endpoint, $accessKeyId, $accessKey);
	$type = $_REQUEST['type'];
	$data = array(
		'member_id'      => $_REQUEST['member_id'],
		'title'          => $_REQUEST['title'],
		'curpage'        => $_REQUEST['curpage'],
		'context'        => $_REQUEST['context'],
		'url'            => $_REQUEST['url'],
		'remark'         => $_REQUEST['remark'],
		'start_time'     => $_REQUEST['start_time'],
		'end_time'       => $_REQUEST['end_time'],
		'topic'          => 'interface_log',
	);
	switch($type){
		case 1;
			$function  = 'putLogs';
			break;
		case 2;
			$function  = 'getLogs';
			break;
		case 3;
			$function  = 'putLogs';
			break;
		default;
			$type;
			break;
	}
	if($type==3){
		for($i=1;$i<=2135;$i++){
			$url='http://shop.aigegou.com/agg/mobile/index.php?act=bug_log&op=get_wx_bug_log&page='.$i;
			$html = file_get_contents($url);
			$all_datas = json_decode($html,1)['datas']['log_list'];

			foreach($all_datas as $value){
				$value['context'] = htmlspecialchars_decode($value['context']);
				$value['topic'] = 'interface_log';
				$list  = $function($client, $project, $logstore,$value);
			}
		}
		output_data([]);
	}


//print_r($type);die;
print_r(get_config('shop_site_url'));die;
//	print_r(strstr($_REQUEST['start_time'],'-'));die;
//	$check_param = array('type','title');
//	check_request_parameter($check_param);

	if($_REQUEST['key']!=$accessKeyId || $type==''){
		output_error('No permissions');
	}


	$list  = $function($client, $project, $logstore,$data);

	output_data(array(
		'log_list'   => $list,
		'total_num'  => count($list),
	));

