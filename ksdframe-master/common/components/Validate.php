<?php
/**
 * ============================================================================
 * 文件名称：Validate.php
 * ----------------------------------------------------------------------------
 * 功能描述：验证类模型
 * ============================================================================
 */

namespace common\components;

class Validate extends Model {

    /**
     * 处理最大最小长度
     *
     * @param int|string $max 最大长度,默认 '',无穷大
     * @param   int $min 最小长度,默认 1
     * @return string
     */
	protected static function length($max='',$min=1){
		$min=max(1,(int)$min);
		if(($max=(int)$max) && ($max>=$min)){
			return "{".$min.",".$max."}";
		}else{
			return "{".$min.",}";
		}
	}	
	
	/**
	 * 经过trim,htmlspecialchars过滤
	 *
	 * @param   string  $value    被过滤数据 
     * @param   int     $max      字符串最大长度,默认'' 无限制
     * @param   string  $default  不符合返回值,默认 ''
	 * @return  string
	 */
	public static function testInput($value,$max=0,$default='')
	{
		if(empty($value)){
		    return $default;
		}
        if(!empty(abs($max)) && (mb_strlen($value,'utf8')>abs($max))){
            return $default;
        }
		$value = trim($value);
		$value = htmlspecialchars($value,ENT_QUOTES);
		return $value;
	}	

    /**
	 * 验证手机号
	 * 
     * @param   string   $value    手机号
     * @param   string   $default  不符合返回值,默认 ''   
     * @return  string
     */
	public static function mobile($value,$default=''){
		if(preg_match("/^1[34578]\d{9}$/", $value)){
			return $value;
	    }else{
			return $default;
	    }  
	}	
	
    /**
	 * 验证邮箱
	 * 
     * @param   string   $value    邮箱 
     * @param   string   $default  不符合返回值,默认 ''  
     * @return  string
     */
	public static function email($value,$default=''){
		if(preg_match("/^[\w\-\.]{6,18}\@[\w\-\.]{2,10}\.[\w\-]{1,5}$/", $value)){
			return $value;
	    }else{
			return $default;
	    }  
	}
	
    /**
	 * 只包含字母数字
	 * 
     * @param   string   $value    验证的值      
	 * @param   int      $max      最大长度,默认 '',无穷大
	 * @param   int      $min      最小长度,默认 1
     * @param   string   $default  不符合返回值,默认 '' 
     * @return  string
     */
	public static function alphanumeric($value,$max=0,$min=1,$default=''){
        $length = self::length($max,$min);
		if(preg_match("/^[\da-zA-Z]".$length."$/", $value)){
			return $value;
	    }else{
			return $default;
	    }  
	}

    /**
     * 验证正整数
     *
     * @param   string $value 验证的值
     * @param int|string $max 最大长度,默认 '',无穷大
     * @param   int $min 最小长度,默认 1
     * @param   string $default 不符合返回值,默认 ''
     * @return string
     */
	public static function posint($value,$max=0,$min=1,$default=''){
        $length = self::length($max,$min);
		if((preg_match("/^[\d]".$length."$/", $value)) && (preg_match("/^[1-9]/", $value))){
			return $value;
	    }else{
			return $default;
	    }  
	}
    
    /**
     * 验证日期时间格式
     * 
     * @param   string   $value    验证的值  
     * @param   boolean  $choice   true 返回时间戳,false 返回原值,默认false
     * @param   string   $default  不符合返回值,默认 ''
     * @return  string
     */
    public static function dataFormat($value='',$choice=false,$default=''){

        $is_date = strtotime($value)?strtotime($value):false;
         
        if($is_date===false){
            return $default;
        }else{
            if(!empty($choice)){
                return $is_date;
            }else{
                return $value;
            }
        }
    }    
    
    /**
     * 验证18位身份证号
     * 
     * @param   string   $value    身份证号码
     * @param   string   $default  不符合返回值,默认 ''
     * @return  string
     */
    public static function isCreditNo($value,$default='')
    {  
        $vCity = array(
            '11','12','13','14','15','21','22',
            '23','31','32','33','34','35','36',
            '37','41','42','43','44','45','46',
            '50','51','52','53','54','61','62',
            '63','64','65','71','81','82','91'
        );
     
        if (!preg_match('/^([\d]{17}[xX\d])$/', $value)){
            return $default;
        }
     
        if (!in_array(substr($value, 0, 2), $vCity)){
            return $default;
        }
     
        $vStr = preg_replace('/[xX]$/i', 'a', $value);
        $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
     
        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday){
            return $default;
        }

        $vSum = 0;
 
        for ($i = 17 ; $i >= 0 ; $i--)
        {
            $vSubStr = substr($vStr, 17 - $i, 1);
            $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
        }
 
        if($vSum % 11 != 1){
            return $default;
        }
        
        return $value;
    }
    			
}