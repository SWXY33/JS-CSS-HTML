<?php

namespace common\components;

class Validator extends Model {

		public $success;
		public $valid;
		public $form;
		public $error;
		
		function Validator(){
			$this->success = 1;
			$this->valid = array();
			$this->form = array();
			$this->error = array();
		}
		
		#================检验请求参数的方法（参数可以是数组）================
		#==$va = new Validator();
		#==$va->weiXin(array(
		#	'name1' => array('funcname1', 'funcname2', array('funcname3', funcparam1, funcparam2)),
		#	'name2' => array('funcname1', 'funcname2', array('funcname3', funcparam1, funcparam2)),
		#));
		function check($args){
			// var_dump($args);exit;
			if(is_array($args)){
				foreach($args as $name => $check_funcs){
					$value = array_key_exists($name, $_REQUEST) ? $_REQUEST[$name] : NULL;
					$this->valid[$name] = trim($value);
					$this->form[$name] = $value;
					$this->error[$name] = '';
					if(is_array($check_funcs)){
						foreach($check_funcs as $check_func){
							$func_name;
							$func_param;
							if(is_array($check_func) && count($check_func) > 1){
								$func_name = array_shift($check_func);
								if(!is_string($func_name)){
									function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNCS ERROR"):die("VALIDATOR $name CHECK_FUNCS ERROR");
								}
								$func_param = $check_func;
							}elseif(is_string($check_func)){
								$func_name = $check_func;
								$func_param = array();
							}else{
								function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNCS ERROR"):die("VALIDATOR $name CHECK_FUNCS ERROR");
							}
							if(method_exists($this, $func_name)){
								if(is_array($value)){
									foreach($value as $index => $val){
										$info = call_user_func(array($this, $func_name), $val, $func_param);
										$is_succ = $info[0];
										$error_msg = isset($info[1]) ? $info[1] : FALSE;
										$modified_value = isset($info[2]) ? $info[2] : FALSE;
										if($is_succ === FALSE){
											break;
										}elseif($modified_value !== FALSE){
											$value[$index] = $modified_value;
											$this->valid[$name][$index] = $modified_value;
										}
									}
								}else{
									$info = call_user_func(array($this, $func_name), $value, $func_param);
									$is_succ = $info[0];
									$error_msg = isset($info[1]) ? $info[1] : FALSE;
									$modified_value = isset($info[2]) ? $info[2] : FALSE;
									if($is_succ === TRUE && $modified_value !== FALSE){
										$value = $modified_value;
										$this->valid[$name] = $modified_value;
									}

								}
								if($is_succ === FALSE){
									$info[1] = '"'.$name.'"值：'.$info[1];
									return $info;
									break;
								}
							}else{
								function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNC $func_name NOT_EXISTS"):die("VALIDATOR $name CHECK_FUNC $func_name NOT_EXISTS");
							}
						}
					}else{
						function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNCS ERROR"):die("VALIDATOR $name CHECK_FUNCS ERROR");
					}
				}
			}else{
				function_exists("app_die")?app_die("VALIDATOR PARAM ERROR"):die("VALIDATOR PARAM ERROR");
			}
		}
		
		#================检验变量的方法（变量可以是数组）================
		#==$va = new Validator();
		#==$variable = $va->vCheck($variable, array('funcname1', 'funcname2', array('funcname3', funcparam1, funcparam2)));
		function vCheck($variable, $check_funcs){
			// var_dump($variable,$check_funcs);exit;
			if(is_array($check_funcs)){
				foreach($check_funcs as $key => $check_func){
					$func_name;
					$func_param;
					if(is_array($check_func) && count($check_func) > 1){
						$func_name = array_shift($check_func);
						if(!is_string($func_name)){
							function_exists("app_die")?app_die("VALIDATOR CHECK_FUNCS ERROR"):die("VALIDATOR CHECK_FUNCS ERROR");
						}
						$func_param = $check_func;
					}elseif(is_string($check_func)){
						$func_name = $check_func;
						$func_param = array();
					}else{
						function_exists("app_die")?app_die("VALIDATOR CHECK_FUNCS ERROR"):die("VALIDATOR CHECK_FUNCS ERROR");
					}
					if(method_exists($this, $func_name)){
						if(is_array($variable)){
							foreach($variable as $index => $val){
								if (isset($check_funcs[$index])) {
									$info = call_user_func(array($this, $check_funcs[$index]), $val, $func_param);
									$is_succ = $info[0];
									$error_msg = isset($info[1]) ? $info[1] : FALSE;
									$modified_value = isset($info[2]) ? $info[2] : FALSE;
									if($is_succ === FALSE){
										$info[1] = '"'.$index.'"值：'.$info[1];
										return $info;
									}elseif($modified_value !== FALSE){
										$variable[$index] = $modified_value;
									}
								}
							}
						}else{
							$info = call_user_func(array($this, $func_name), $variable, $func_param);
							$is_succ = $info[0];
							$modified_value = isset($info[2]) ? $info[2] : FALSE;
							if($is_succ === TRUE && $modified_value !== FALSE){
								$variable = $modified_value;
							}
						}
						if($is_succ === FALSE){
							return FALSE;
						}
					}else{
						function_exists("app_die")?app_die("VALIDATOR CHECK_FUNC $func_name NOT_EXISTS"):die("VALIDATOR CHECK_FUNC $func_name NOT_EXISTS");
					}
				}
				return $variable;
			}else{
				function_exists("app_die")?app_die("VALIDATOR PARAM ERROR"):die("VALIDATOR PARAM ERROR");
			}
		}
		
		#=======================================各类检验参数的函数============================================
		#=========函数接收3个参数，分别是请求参数名称(string)、请求参数值(string)、检验参数(array)=========
		#=========函数返回2个值，分别是标识是否通过检验的值(TRUE/FALSE)、错误信息(string)==========
		
		#==================常用函数==================
		#=========检验是否为空=========
		#==$va->weiXin(array(
		#	'name' => array('not_blank'),
		#));
		private function notBlank($value, $func_param){
			if(!empty($value) || $value === '0'){
				return array(TRUE);
			}
			return array(FALSE, '不能为空');
		}
		#=========检验是否为正整数=========
		#==$va->weiXin(array(
		#	'name' => array('uint'),
		#));
		private function uint($value, $func_param){
			if(is_string($value) && preg_match("/^\d*$/", $value) || is_int($value) && $value >= 0 || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, '只能为正整数');
		}
		#=========检验是否为浮点数=========
		#==$va->weiXin(array(
		#	'name' => array('float'),
		#));
		private function float($value, $func_param){
			if(is_string($value) && preg_match("/^\d+(:?\.\d+)?$/", $value) || is_float($value) && $value >= 0 || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, '只能为浮点数');
		}
		#=========检验是否为特定長度的浮点数=========
		#==$va->weiXin(array(
		#	'name' => array(array('decimal',10,2)),
		#));
		private function decimal($value, $func_param){
			$int_part = $func_param[0];
			$float_part = $func_param[1];
			if(preg_match("/^\d{1,".$int_part."}(:?\.\d{1,".$float_part."})?$/", $value) || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, '只能为浮点数');
		}
		#=========检验正整数是否在某个范围内=========
		#==$va->weiXin(array(
		#	'name' => array(array('uint_range', 1, 100)),
		#));
		private function uintRange($value, $func_param){
			if(!count($func_param) > 1){
				function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNC uint_range PARAM ERROR"):die("VALIDATOR $name CHECK_FUNC uint_range PARAM ERROR");
			}
			$minValue = $func_param[0];
			$maxValue = $func_param[1];
			if(is_string($value) && preg_match("/^\d*$/", $value) && $value >= $minValue && $value <= $maxValue || is_int($value) && $value >= 0 || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, "必须为正整数并且在".$minValue."~".$maxValue."范围内");
		}
		#=========检验字符串长度是否在$minLen和$maxLen之间=========
		#==$va->weiXin(array(
		#	'name' => array(array('length', 1, 255)),
		#));
		private function length($value, $func_param){
			if(!count($func_param) > 1){
				function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNC length PARAM ERROR"):die("VALIDATOR $name CHECK_FUNC length PARAM ERROR");
			}
			$minLen = $func_param[0];
			$maxLen = $func_param[1];
			if(!(is_int($minLen) && $minLen >= 0 && is_int($maxLen) && $maxLen >= 0)){
				function_exists("app_die")?app_die("VALIDATOR $name CHECK_FUNC length PARAM ERROR"):die("VALIDATOR $name CHECK_FUNC length PARAM ERROR");
			}
			if(is_string($value) && $minLen <= strlen($value) && $maxLen >= strlen($value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, "长度必须为 $minLen~$maxLen");
		}
		#=========检验是否等于某些值=========
		#==$va->weiXin(array(
		#	'name' => array(array('eq', 'param1', 'param2')),
		#));
		private function eq($value, $func_param){
			if(@in_array($value, $func_param) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '输入不正确');
		}
		#=========检验是否不等于某些值=========
		#==$va->weiXin(array(
		#	'name' => array(array('ne', 'param1', 'param2')),
		#));
		private function ne($value, $func_param){
			if(@!in_array($value, $func_param) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '输入不正确');
		}
		
		#==================专用函数==================
		#=========检验字符串是否仅由字母、数字、下划线组成=========
		#==$va->weiXin(array(
		#	'name' => array('safe_text'),
		#));
		private function safeText($value, $func_param){
			if(is_string($value) && !preg_match("{[\\\/:*?'\"<>|&=]}su", $value) || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, "不能包含下列字符之一 \ / : * ? ' \" < > | & =");
		}
		#=========检验字符串是否不带空格=========
		#==$va->weiXin(array(
		#	'name' => array('no_space'),
		#));
		private function noSpace($value, $func_param){
			if(is_string($value) && !preg_match("/\s/", $value) || empty($value) && $value !== '0'){
				return array(TRUE);
			}
			return array(FALSE, "不允许使用空格");
		}

		#=========检验字符串是否不带引号=========
		#==$va->weiXin(array(
		#	'name' => array('no_quot'),
		#));
		private function noQuot($value, $func_param){
			if(is_string($value) && !preg_match("/['\"]/", $value) || empty($value)){
				return array(TRUE);
			}
			return array(FALSE, "不允许使用引号");
		}
		#=========检验字符串是否为一个合法IP地址=========
		#==$va->weiXin(array(
		#	'name' => array('ip_text'),
		#));
		private function ipText($value, $func_param){
			if(is_string($value) && preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, "不允许使用空格");
		}
		#=========检验手机号=========
		#==$va->weiXin(array(
		#	'name' => array('mobile'),
		#));
		private function mobile($value,$func_param){
			if(preg_match("/^1[345678]\d{9}$/", $value)){
				return array(TRUE);
		    }else{
				return array(FALSE, "手机号不正确");
		    }  
		}	

		#=========检验18位身份证号=========
		#==$va->weiXin(array(
		#	'name' => array('isCreditNo'),
		#));
    	private function isCreditNo($value,$func_param){  
	        $vCity = array(
	            '11','12','13','14','15','21','22',
	            '23','31','32','33','34','35','36',
	            '37','41','42','43','44','45','46',
	            '50','51','52','53','54','61','62',
	            '63','64','65','71','81','82','91'
	        );

	        $errorMsg = array(FALSE, "身份证号不正确");
	     
	        if (!preg_match('/^([\d]{17}[xX\d])$/', $value)){
	            return $errorMsg;
	        }
	     
	        if (!in_array(substr($value, 0, 2), $vCity)){
	            return $errorMsg;
	        }
	     
	        $vStr = preg_replace('/[xX]$/i', 'a', $value);
	        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
	     
	        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday){
	            return $errorMsg;
	        }

	        $vSum = 0;
	 
	        for ($i = 17 ; $i >= 0 ; $i--)
	        {
	            $vSubStr = substr($vStr, 17 - $i, 1);
	            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
	        }
	 
	        if($vSum % 11 != 1){
	            return $errorMsg;
	        }
	        
	        return array(TRUE);
    	}
		#=========检验字符串是否为一个合法EMAIL地址=========
		#==$va->weiXin(array(
		#	'name' => array('email'),
		#));
		private function email($value, $func_param){
			if(is_string($value) && preg_match("{^[\w\d_-]+(\.[\w\d_-]+)*@[\w\d_-]+(\.[\w\d_-]+)+$}i", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '不是合法的email地址');
		}
		#=========检验字符串是否为一个合法的url地址=========
		#==$va->weiXin(array(
		#	'name' => array('url'),
		#));
		private function url($value, $func_param){
			if(is_string($value) && preg_match("{^https?://}i", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '必须是http(s)://开始的合法域名');
		}
		#=========检验字符串是否符合日期格式=========
		#==$va->weiXin(array(
		#	'name' => array('date_text'),
		#));
		private function dateText($value, $func_param){
			if(is_string($value) && preg_match("/^\d{4}-\d{2}-\d{2}$/", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '日期格式必须为yyyy-mm-dd');
		}
		#=========检验字符串是否符合时间格式=========
		#==$va->weiXin(array(
		#	'name' => array('time_text'),
		#));
		private function timeText($value, $func_param){
			if(is_string($value) && preg_match("/^\d{2}:\d{2}:\d{2}$/", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '时间格式必须为hh:mm:ss');
		}
		#=========检验字符串是否符合日期时间格式=========
		#==$va->weiXin(array(
		#	'name' => array('datetime_text'),
		#));
		private function datetimeText($value, $func_param){
			if(is_string($value) && preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '日期时间格式必须为yyyy-MM-dd hh:mm:ss');
		}
		#=========检验字符串是否符合正则=========
		#==$va->weiXin(array(
		#	'name' => array(array('preg', "{sdf}")),
		#));
		private function preg($value, $func_param){
			$preg = array_shift($func_param);
			if(is_string($value) && preg_match($preg, $value) || empty($value) && $value !== "0"){
				return array(TRUE);
			}
			return array(FALSE, '不符合规范');
		}
		

	}
?>