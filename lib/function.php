<?php
/**
 * Copyright (C) Alibaba Cloud Computing
 * All rights reserved
 */

require_once realpath(dirname(__FILE__) . '/../Log_Autoload.php');

function putLogs(Aliyun_Log_Client $client, $project, $logstore, $data) {
    $topic = $data['title'];
    unset($data['title']);
    $contents =$data;
    $logItem = new Aliyun_Log_Models_LogItem();
    $logItem->setTime(time());
    $logItem->setContents($contents);
    $logitems = array($logItem);
    $request = new Aliyun_Log_Models_PutLogsRequest($project, $logstore, 
            $topic, null, $logitems);
    
    try {
        $response = $client->putLogs($request);
        var_dump($response);
    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}

function listLogstores(Aliyun_Log_Client $client, $project) {
    try{
        $request = new Aliyun_Log_Models_ListLogstoresRequest($project);
        $response = $client->listLogstores($request);
        var_dump($response);
    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}


function listTopics(Aliyun_Log_Client $client, $project, $logstore) {
    $request = new Aliyun_Log_Models_ListTopicsRequest($project, $logstore);
    
    try {
        $response = $client->listTopics($request);
        var_dump($response);
    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}

function getLogs(Aliyun_Log_Client $client, $project, $logstore,$data) {
//    $topic = 'TestTopic';
    $topic = $data['title'];
    $from = time()-3600*2;
    $to = time();
    $request = new Aliyun_Log_Models_GetLogsRequest($project, $logstore, $from, $to, $topic, '', 100, 0, False);
    
    try {
        $response = $client->getLogs($request);
//        foreach($response -> getLogs() as $log)
//        {
//            print $log -> getTime()."\t";
//            foreach($log -> getContents() as $key => $value){
//                print $key.":".$value."\t";
//            }
//            print "\n";
//        }
        foreach ($response->getLogs() as $k=> $log){
            foreach ($log->getContents() as $key => $value) {
                $tmp [$k][$key] = $value;
                $tmp [$k]['add_time'] = $log->getTime();
            }
        }
       return $tmp;

    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}

function getHistograms(Aliyun_Log_Client $client, $project, $logstore) {
    $topic = 'TestTopic';
    $from = time()-3600;
    $to = time();
    $request = new Aliyun_Log_Models_GetHistogramsRequest($project, $logstore, $from, $to, $topic, '');
    
    try {
        $response = $client->getHistograms($request);
        var_dump($response);
    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}
function listShard(Aliyun_Log_Client $client,$project,$logstore){
    $request = new Aliyun_Log_Models_ListShardsRequest($project,$logstore);
    try
    {
        $response = $client -> listShards($request);
        var_dump($response);
    } catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}
function batchGetLogs(Aliyun_Log_Client $client,$project,$logstore)
{
    $listShardRequest = new Aliyun_Log_Models_ListShardsRequest($project,$logstore);
    $listShardResponse = $client -> listShards($listShardRequest);
    foreach($listShardResponse-> getShardIds()  as $shardId)
    {
        $getCursorRequest = new Aliyun_Log_Models_GetCursorRequest($project,$logstore,$shardId,null, time() - 60);
        $response = $client -> getCursor($getCursorRequest);
        $cursor = $response-> getCursor();
        $count = 100;
        while(true)
        {
            $batchGetDataRequest = new Aliyun_Log_Models_BatchGetLogsRequest($project,$logstore,$shardId,$count,$cursor);
            var_dump($batchGetDataRequest);
            $response = $client -> batchGetLogs($batchGetDataRequest);
            if($cursor == $response -> getNextCursor())
            {
                break;
            }
            $logGroupList = $response -> getLogGroupList();
            foreach($logGroupList as $logGroup)
            {
                print ($logGroup->getCategory());

                foreach($logGroup -> getLogsArray() as $log)
                {
                    foreach($log -> getContentsArray() as $content)
                    {
                        print($content-> getKey().":".$content->getValue()."\t");
                    }
                    print("\n");
                }
            }
            $cursor = $response -> getNextCursor();
        }
    }
}
function deleteShard(Aliyun_Log_Client $client,$project,$logstore,$shardId)
{
    $request = new Aliyun_Log_Models_DeleteShardRequest($project,$logstore,$shardId);
    try
    {
        $response = $client -> deleteShard($request);
        var_dump($response);
    }catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}
function mergeShard(Aliyun_Log_Client $client,$project,$logstore,$shardId)
{
    $request = new Aliyun_Log_Models_MergeShardsRequest($project,$logstore,$shardId);
    try
    {
        $response = $client -> mergeShards($request);
        var_dump($response);
    }catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}
function splitShard(Aliyun_Log_Client $client,$project,$logstore,$shardId,$midHash)
{
    $request = new Aliyun_Log_Models_SplitShardRequest($project,$logstore,$shardId,$midHash);
    try
    {
        $response = $client -> splitShard($request);
        var_dump($response);
    }catch (Aliyun_Log_Exception $ex) {
        var_dump($ex);
    } catch (Exception $ex) {
        var_dump($ex);
    }
}

//返回json格式数据
function output_data($datas, $extend_data = array()) {
    $data = array();
    $data['code'] = 200;

    if (isset($_REQUEST['client_type']) && !empty($_REQUEST['client_type']))
    {
        $data['message'] = 'OK';
        if (!empty($extend_data))
        {
            $data['data'] = array(
                'datas' => $datas,
                'extend_data' => $extend_data,
            );
        }
        else
        {
            $data['data'] = $datas;
        }
    }
    else
    {
        if(!empty($extend_data)) {
            $data = array_merge($data, $extend_data);
        }

        $data['datas'] = $datas;
    }

    if(!empty($_REQUEST['callback'])) {
        echo $_REQUEST['callback'].'('.json_encode($data).')';die;
    } else {
        echo json_encode($data);die;
    }

}

function output_error($message, $extend_data = array(), $code = 80002) {
    $data = array();
    if (isset($_REQUEST['client_type']) && !empty($_REQUEST['client_type']))
    {
        $data = array(
            'code' => $code,
            'message' => $message,
            //'data' => $extend_data,
        );
        if (!empty($extend_data))
        {
            $data['data'] = $extend_data;
        }
    }
    else
    {
        $data = array(
            'code' => 200,
        );
        if (!empty($extend_data))
        {
            $data = array_merge($data, $extend_data);
        }
        $data['datas']['error'] = $message;
    }
    if(!empty($_REQUEST['callback'])) {
        echo $_REQUEST['callback'].'('.json_encode($data).')';die;
    } else {
        echo json_encode($data);die;
    }

}
/**
 * @example
 * test.php
 * @return void
 * 检查必须参数是否有
 */
function check_request_parameter($check_param){
    foreach($check_param as $value) {
        if (!isset($_REQUEST[$value])) output_error('缺少参数'.$value, array(), ERROR_CODE_ARG);
    }
}
//$endpoint = '<log service endpoint';
//$accessKeyId = 'your access key id';
//$accessKey = 'your access key';
//$project = 'your project';
//$logstore = 'your logstore';
//$token = "";
//
//$client = new Aliyun_Log_Client($endpoint, $accessKeyId, $accessKey,$token);
//listShard($client,$project,$logstore);
//mergeShard($client,$project,$logstore,82);
//deleteShard($client,$project,$logstore,21);
//splitShard($client,$project,$logstore,84,"0e000000000000000000000000000000");
//putLogs($client, $project, $logstore);
//listShard($client,$project,$logstore);
//batchGetLogs($client,$project,$logstore);
//listLogstores($client, $project);
//listTopics($client, $project, $logstore);
//getHistograms($client, $project, $logstore);
//getLogs($client, $project, $logstore);
