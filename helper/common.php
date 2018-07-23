<?php 
    /**
     * Cookie 加密
     */
    if ( ! function_exists('encrypt')) {
        function encrypt($array = array()){
            $info = base64_encode(json_encode($array));
            $num = ceil(strlen($info)/1.5);
            $key1 = substr($info,0,$num);
            $result = strtr($info,array($key1=>strrev($key1)));
            $key2 = substr($result, -$num,$num-2);
            $result = strtr($result,array($key2=>strrev($key2)));
            return $result;
        }
    }
    
    /**
     * Cookie 解密
     */
    if ( ! function_exists('decrypt')) {
        function decrypt($str = ''){
            $num = ceil(strlen($str)/1.5);
            $key2 = substr($str, -$num,$num-2);
            $str = strtr($str,array($key2=>strrev($key2)));
            $key1 = substr($str,0,$num);
            $result = strtr($str,array($key1=>strrev($key1)));
            $info = json_decode(base64_decode($result),true);
            return $info;
        }
    }
    
    /**
     * 读取配置文件
     */
    if ( ! function_exists('C')) {
        function C($str = ''){
            $config = [];
            $filename = __DIR__.'/../config/'.$str.'.php';
            if(file_exists($filename)){
                $config = require $filename;
                if($config){
                    return $config;
                }
            }
            return $config;
        }
    }
    
    if(! function_exists('class_loop_list')){
        function class_loop_list($data, $pid = 0, $level = 0){
            $tree = [];
            foreach($data as $k => $v)
            {
                if($v['pid'] == $pid)
                {   
                    $v['level'] = $level;
                    $v['child'] = [];
                    $v['child'] = class_loop_list($data, $v['id'], $level+1);
                    $tree[] = $v;
                }
            }
            return $tree;
        }
    }
    
    /**
     *递归处理数组（将子分类与上级分类合并）
     *
     *@param string $data
     *@param string $parent
     *@param int page_number
     *@return array
     */
    if(!function_exists('class_loop')){
        function class_loop($data,$parent=0){
            
            $result = array();
            if($data)
            {
                foreach($data as $key=>$val)
                {
                    if($val['parent_id']==$parent)
                    {
                        $temp = class_loop($data,$val['id']);
                        if($temp) $val['child'] = $temp;
                        $result[] = $val;
                    }
                }
            }
            return $result;
        }
    }
?>