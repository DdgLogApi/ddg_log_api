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
	if(empty($_REQUEST['key'])){
		output_data('key is null');
	}
	$member_info  = file_get_contents('http://shop.aigegou.com/qa/mobile/index.php?act=member_index&op=ddg_index&key='.$_REQUEST['key']);
	$member_id = json_decode($member_info,1)['datas']['member_info']['member_id'];
	$data = array(
		'member_id'      => $member_id?$member_id:mt_rand(100000,999999),
		'title'          => $_REQUEST['title'],
		'curpage'        => $_REQUEST['curpage'],
		'context'        => $_REQUEST['context'],
		'url'            => $_REQUEST['url'],
		'remark'         => $_REQUEST['remark'],
		'start_time'     => $_REQUEST['start_time'],
		'end_time'       => $_REQUEST['end_time'],
		'add_time'       => $_REQUEST['add_time'],
		'topic'          => 'interface_log',
	);

	switch($type){
		case 1;
			$function  = 'putLogs';
			unset($data['curpage'],$data['start_time'],$data['end_time']);
			break;
		case 2;
			$function  = 'getLogs';
			break;
		case 3;
			$function  = 'putLogs';
			unset($data['curpage'],$data['start_time'],$data['end_time']);
			break;
		default;
			$type;
			break;
	}
	if($type==3){
		for($i=1;$i<=2183;$i++){
			$url='http://shop.aigegou.com/agg/mobile/index.php?act=bug_log&op=get_wx_bug_log&curpage='.$i;
			$html = file_get_contents($url);
			$all_datas = json_decode($html,1)['datas']['log_list'];

			foreach($all_datas as $value){
				$value['context'] = htmlspecialchars_decode($value['context']);
				$value['topic'] = 'test_log';
				$list  = $function($client, $project, $logstore,$value);
				echo $i;
			}
		}
		output_data(1);
	}

//print_r(get_config('shop_site_url'));die;
//	print_r(strstr($_REQUEST['start_time'],'-'));die;
//	$check_param = array('type','title');
//	check_request_parameter($check_param);

	if($_REQUEST['key']!=$accessKeyId || $type==''){
		output_error('No permissions');
	}

	$qurey = '';
	if($_REQUEST['m']){
 		$query = $_REQUEST['m'];
	}
	if($_REQUEST['t']){
		$query = $_REQUEST['t'];
	}
	if($_REQUEST['c']){
		$query = $_REQUEST['c'];
	}
	if($_REQUEST['u']){
		$query = $_REQUEST['u'];
	}
	if($_REQUEST['r']){
		$query = $_REQUEST['r'];
	}

	$list  = $function($client, $project, $logstore,$data,"{$query}");
//	$condition = explode('=',$query);
//	foreach($res as $key=>$value){
//		$kk = strpos("'{$value[$condition [0]]}'",$condition[1]);
//
//		if(!empty($kk) ){
//   			$list[$key] =$value;
//		}
//
//	}
	output_data(array(
		'log_list'   => $list,
		'total_num'  => count($list),
	));

