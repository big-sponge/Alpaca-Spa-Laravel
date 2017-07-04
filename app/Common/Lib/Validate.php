<?php
namespace App\Common\Lib;
class Validate
{
    /**
     * 判断是否是微信浏览器
     *
     * @return number
     */
    public static function isWxBrowser()
    {
        return preg_match('/MicroMessenger\/([^\s]+)/i', $_SERVER ['HTTP_USER_AGENT']);
    }

    /**
     * 判断是否是购车通webview
     *
     * @return number
     */
    public static function isGctBrowser()
    {
        return preg_match('/qqcar\/([^\s]+)/i', $_SERVER ['HTTP_USER_AGENT']);
    }

    /**
     * 校验是否qq域名
     *
     * @param string $url
     * @return boolean
     */
    public static function isQQcomDomain($url)
    {
        if (empty ($url)) {
            return false;
        }
        $urlInfo = parse_url($url);
        $host    = $urlInfo ['host'];
        return substr($host, -7, 7) == '.qq.com';
    }

    /**
     * 判断地址是否在同域名下
     */
    public static function inSameDomain($domain1, $domain2, $grade = 3)
    {
        $domain1Arr = explode('.', $domain1);
        $domain2Arr = explode('.', $domain2);

        if (array_slice($domain1Arr, -$grade) === array_slice($domain2Arr, -$grade)) {
            return true;
        }

        return false;
    }

    /**
     * 验证是否是内网IP
     *
     * @param unknown $ip
     * @return boolean
     */
    public static function isIntranetIP($ip)
    {
        if ($ip == "127.0.0.1") {
            return true;
        }

        $i = explode('.', $ip);

        if ($i [0] == 10) {
            return true;
        }

        if ($i [0] == 172 && $i [1] > 15 && $i [1] < 32) {
            return true;
        }

        if ($i [0] == 172 && $i [1] == 168) {
            return true;
        }

        return false;
    }

    // 验证字符串长度
    public static function strLen($str, $min = 0, $max = 0)
    {
        if ($min && mb_strlen($str, 'UTF8') < $min) {
            return false;
        }

        if ($max && mb_strlen($str, 'UTF8') > $max) {
            return false;
        }

        return true;
    }

    /**
     * 验证是否是正整数
     */
    public static function isPosInt($value, $min = null, $max = null)
    {
        $result = preg_match("/^[1-9][0-9]*$/", $value);

        if ($result) {
            if (!is_null($min) && $min > $value) {
                return false;
            }

            if (!is_null($max) && $max < $value) {
                return false;
            }

            return true;
        }

        return false;
    }

    /**
     * 判断是否是页面数
     *
     * @param unknown $value
     */
    public static function isPageNumber($value)
    {
        return static::isPosInt($value, 1, 10000);
    }

    /**
     * 验证数字和 26 个英文字母组成的字符串
     */
    public static function isLetterOrNum($value)
    {
        return preg_match('/^[A-Za-z0-9]*$/', $value);
    }

    /**
     * 验证数字和 26 个英文字母组成的字符串,以及下划线
     */
    public static function isLetterOrNumAndUnderline($value)
    {
        return preg_match('/^[A-Za-z0-9_]*$/', $value);
    }

    /**
     * 验证是否是QQ号
     *
     * @param $value string
     *            验证QQ号
     */
    public static function isQQ($value)
    {
        return preg_match("/^[1-9][0-9]{4,9}$/", $value);
    }

    /**
     * email地址合法性检测
     */
    public static function isEmail($value)
    {
        return preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $value);
    }

    /**
     * URL地址合法性检测
     */
    public static function isUrl($value)
    {
        return preg_match("/^http:\/\/[\w]+\.[\w]+[\S]*/", $value);
    }

    /**
     * 是否是QQ域名
     */
    public static function isQQUrl($value)
    {
        $urlParams = parse_url($value);
        return strtolower(substr($urlParams ['host'], -7)) === '.qq.com';
        // return preg_match("/^http:\/\/[^\s]*qq.com[\/=\?%\-&_~`@[\]\’:+!]*([^<>\”])*$/", $value);
    }

    /**
     * 是否是一个合法域名
     */
    public static function isDomainName($str)
    {
        return preg_match("/^[a-z0-9]([a-z0-9-]+\.){1,4}[a-z]{2,5}$/i", $str);
    }

    /**
     * 检测IP地址是否合法
     */
    public static function isIpAddr($ip)
    {
        return preg_match("/^[\d]{1,3}(?:\.[\d]{1,3}){3}$/", $ip);
    }

    /**
     * 邮编合法性检测
     *
     * @return boolean true表示合法，false表示非法
     */
    public static function isPostalCode($postal_code)
    {
        return (is_numeric($postal_code) && (strlen($postal_code) == 6));
    }

    /**
     * 电话(传真)号码合法性检测
     *
     * @return boolean true表示合法，false表示非法
     */
    public static function isPhone($value)
    {
        return preg_match("/^\d{2,4}[\-]?\d{6,9}$/", $value);
    }

    /**
     * 手机号码合法性检查
     *
     * @return boolean true表示合法，false表示非法
     */
    public static function isMobile($mobile)
    {
        return preg_match("/^1[34578]\d{9}$/", $mobile) ? true : false;
    }

    /**
     * 身份证号码合法性检测
     */
    public static function isIdCard($value)
    {
        return preg_match("/^(\d{15}|\d{17}[\dx])$/i", $value);
    }

    /**
     * 是否是日期字符串
     *
     * @param string $date_string
     * @return boolean 20151101 2015-11-01 2015-1101 201511-01
     */
    static public function isDate($date_string)
    {
        if (preg_match('/^(\d{4})-?(\d{2})-?(\d{2})/', $date_string, $match)) {
            list ($all_string, $year, $month, $day) = $match;
            return checkdate($month, $day, $year);
        } else {
            return false;
        }
    }

    /**
     * 是否是日期时间
     *
     * @param string $str
     * @return boolean
     */
    public static function isDatetime($str)
    {
        return preg_match('/^[0-9]{4}(\-|\/)[0-9]{1,2}(\\1)[0-9]{1,2}(|\s+[0-9]{1,2}(|:[0-9]{1,2}(|:[0-9]{1,2})))$/', $str);
    }

    /**
     * 是否是数字
     *
     * @param int|string $digital_string
     * @return boolean
     */
    static public function isDigital($digital_string)
    {
        if (preg_match('/^-?\d+$/i', $digital_string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是否是字符
     *
     * @param string $string
     * @return boolean
     */
    static public function isWordChar($string)
    {
        if (preg_match('/^\S+$/i', $string)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 16位颜色码
     */
    public static function isColor($value)
    {
        return preg_match('/^#[0-9a-fA-F]{6}$/', $value);
    }

    /**
     * 验证是否是json字符串
     *
     * @param unknown $str
     * @return boolean
     */
    public static function isJson($str)
    {
        $json = json_decode($str);

        if (is_null($json) || false === $json) {
            return false;
        }

        return true;
    }

    /**
     * 严格的身份证号码合法性检测(按照身份证生成算法进行检查)
     */
    public static function chkIdCard($value)
    {
        if (strlen($value) != 18) {
            return false;
        }
        $wi    = array(
            7,
            9,
            10,
            5,
            8,
            4,
            2,
            1,
            6,
            3,
            7,
            9,
            10,
            5,
            8,
            4,
            2
        );
        $ai    = array(
            '1',
            '0',
            'X',
            '9',
            '8',
            '7',
            '6',
            '5',
            '4',
            '3',
            '2'
        );
        $value = strtoupper($value);
        $sigma = '';
        for ($i = 0; $i < 17; $i++) {
            $sigma += (( int )$value{$i}) * $wi [$i];
        }
        $parity_bit = $ai [($sigma % 11)];
        if ($parity_bit != substr($value, -1)) {
            return false;
        }
        return true;
    }

}
