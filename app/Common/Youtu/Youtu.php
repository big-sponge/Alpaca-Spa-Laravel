<?php

namespace App\Common\Youtu;

class YouTu
{
    // 30 days
    const EXPIRED_SECONDS = 2592000;
    const HTTP_BAD_REQUEST = 400;
    const HTTP_SERVER_ERROR = 500;

    /**
     * return the status message
     */
    public static function statusText($status)
    {
        switch ($status)
        {
        case 0:
          $statusText = 'CONNECT_FAIL';
          break;
        case 200:
          $statusText = 'HTTP OK';
          break;
        case 400:
          $statusText = 'BAD_REQUEST';
          break;
        case 401:
          $statusText = 'UNAUTHORIZED';
          break;
        case 403:
          $statusText = 'FORBIDDEN';
          break;
        case 404:
          $statusText = 'NOTFOUND';
          break;
        case 411:
          $statusText = 'REQ_NOLENGTH';
          break;
        case 423:
          $statusText = 'SERVER_NOTFOUND';
          break;
        case 424:
          $statusText = 'METHOD_NOTFOUND';
          break;
        case 425:
          $statusText = 'REQUEST_OVERFLOW';
          break;
        case 500:
          $statusText = 'INTERNAL_SERVER_ERROR';
          break;
        case 503:
          $statusText = 'SERVICE_UNAVAILABLE';
          break;
        case 504:
          $statusText = 'GATEWAY_TIME_OUT';
          break;
        default:
            $statusText =$status;
            break;
        }
        return $statusText;
    }

    /**
     * return the status message
     */
    public static function getStatusText() {
        $info=Http::info();
        $status=$info['http_code'];
        return self::statusText($status);
    }

    /**
     * @brief detectface
     * @param image_path 待检测的路径
     * @param isbigface 是否大脸模式 ０表示检测所有人脸， 1表示只检测照片最大人脸　适合单人照模式
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function detectface($image_path, $isbigface) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/detectface';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
            'mode' => $isbigface
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

     /**
     * @brief detectfaceurl
     * @param url 图片url
     * @param isbigface 是否大脸模式 ０表示检测所有人脸， 1表示只检测照片最大人脸　适合单人照模式
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function detectfaceurl($url, $isbigface) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/detectface';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
            'mode' => $isbigface
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @brief faceshape
     * @param image_path 待检测的路径
     * @param isbigface 是否大脸模式
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function faceshape($image_path, $isbigface) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceshape';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
            'mode' => $isbigface
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

      /**
     * @brief faceshapeurl
     * @param url 图片url
     * @param isbigface 是否大脸模式 ０表示检测所有人脸， 1表示只检测照片最大人脸　适合单人照模式
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function faceshapeurl($url, $isbigface) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceshape';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
            'mode' => $isbigface
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

   /**
     * @brief facecompare
     * @param image_path_a 待比对的A图片数据
     * @param image_path_b 待比对的B图片数据
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function facecompare($image_path_a, $image_path_b) {

        $real_image_path_a = realpath($image_path_a);
        $real_image_path_b = realpath($image_path_b);
        if (!file_exists($real_image_path_a))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path_a.' not exists', 'data' => array());
        }

        if (!file_exists($real_image_path_b))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path_b.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/facecompare';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data_a = file_get_contents($real_image_path_a);
        $image_data_b = file_get_contents($real_image_path_b);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'imageA' =>  base64_encode($image_data_a),
            'imageB' =>  base64_encode($image_data_b)
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

	/**
	 * @brief facecompareurl
	 * @param urlA 待比对的A图片url
	 * @param urlB 待比对的B图片url
	 * @return 返回的结果，JSON字符串，字段参见API文档
	 */
    public static function facecompareurl($urlA, $urlB) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/facecompare';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'urlA' => $urlA,
            'urlB' => $urlB
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }



    /**
     * @brief faceverify
     * @param person_id 待验证的人脸id
     * @param image_path 待验证的图片路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function faceverify($image_path,$person_id) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceverify';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' =>  base64_encode($image_data),
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

        /**
     * @brief faceverifyurl
     * @param person_id 待验证的人脸id
     * @param url 待验证的图片url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function faceverifyurl($url,$person_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceverify';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' =>  $url,
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }


    /**
     * @brief faceidentify
     * @param group_id 识别的组id
     * @param image_path 待识别的图片路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */

    public static function faceidentify($image_path,$group_id) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceidentify';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' =>  base64_encode($image_data),
            'group_id' =>$group_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

        /**
     * @brief faceidentifyurl
     * @param group_id 识别的组id
     * @param url 待识别的图片的url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */

    public static function faceidentifyurl($url,$group_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/faceidentify';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' =>  $url,
            'group_id' =>$group_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

	/**
	 * @brief newperson
	 * @param person_id 新建的个体id，用户指定，需要保证app_id下的唯一性
	 * @param person_name 个体名字
	 * @param group_ids 新建的个体存放的组id，可以指定多个组id，用户指定（组默认创建）
	 * @param image_path 包含个体人脸的图片数据
	 * @param person_tag 备注信息，用户自解释字段
	* @return 返回的结果，JSON字符串，字段参见API文档
	 */

    public static function newperson($image_path, $person_id, array $group_ids, $person_name='', $person_tag='') {
        $real_image_path = realpath($image_path);
        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/newperson';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' =>  base64_encode($image_data),
            'person_id' =>$person_id,
            'group_ids' =>$group_ids,
            'person_name' =>$person_name,
            'tag' => $person_tag
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    /**
     * @brief newpersonurl
     * @param person_id 新建的个体id，用户指定，需要保证app_id下的唯一性
     * @param person_name 个体名字
     * @param group_ids 新建的个体存放的组id，可以指定多个组id，用户指定（组默认创建）
     * @param url 包含个体人脸的图片url
     * @param person_tag 备注信息，用户自解释字段
    * @return 返回的结果，JSON字符串，字段参见API文档
     */

    public static function newpersonurl($url, $person_id, array $group_ids, $person_name='', $person_tag='') {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/newperson';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' =>  $url,
            'person_id' =>$person_id,
            'group_ids' =>$group_ids,
            'person_name' =>$person_name,
            'tag' => $person_tag
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

	/**
	 * @brief delperson
	 * @param person_id 待删除的个体id
	 * @return 返回的结果，JSON字符串，字段参见API文档
	 */

    public static function delperson($person_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/delperson';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }


    /**
     * @brief addface
     * @param person_id 新增人脸的个体身份id
     * @param image_path_arr 待增加的包含人脸的图片数据，可加入多张（包体大小<2m）
     * @param facetag 人脸备注信息，用户自解释字段
	 * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function addface($person_id,array $image_path_arr, $facetag='') {
        $image_data_arr=array();
        foreach($image_path_arr as $one_path){
            if (!file_exists($one_path))
            {
                return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$one_path.' not exists', 'data' => array());
            }
            $image_data=file_get_contents($one_path);
            array_push($image_data_arr,base64_encode($image_data));
        }
        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/addface';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'images' =>  $image_data_arr,
            'person_id' =>$person_id,
            'tag' => $facetag
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

     /**
     * @brief addfaceurl
     * @param person_id 新增人脸的个体身份id
     * @param url_arr 待增加的包含人脸的图片url，可加入多张（包体大小<2m）
     * @param facetag 人脸备注信息，用户自解释字段
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function addfaceurl($person_id,array $url_arr, $facetag='') {
        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/addface';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'urls' =>  $url_arr,
            'person_id' =>$person_id,
            'tag' => $facetag
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }


	/**
	 * @brief delface
	 * @param person_id 待删除人脸的个体身份id
	 * @param face_id_arr 待删除的人脸id
	 * @return 返回的结果，JSON字符串，字段参见API文档
	 */
    public static function delface($person_id,array $face_id_arr) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/delface';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'face_ids' => $face_id_arr,
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }


       /**
     * @brief setinfo
     * @param person_id 待设置的个体身份id
     * @param person_name 新设置的个体名字
     * @param person_tag 新设置的人备注信息
	* @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function setinfo($person_name,$person_id, $person_tag) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/setinfo';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'person_name' =>  $person_name,
            'person_id' =>$person_id,
            'tag' => $person_tag
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }


    /**
     * @brief getinfo
     * @param person_id 待查询的个体身份id
	* @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function getinfo($person_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/getinfo';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    /**
     * @brief getgroupids
     * @param rsp 返回的组列表查询结果，JSON字符串，字段参见API文档
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function getgroupids() {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/getgroupids';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    /**
     * @brief getpersonids
     * @param group_id 待查询的组id
     * @param rsp 返回的个体列表查询结果，JSON字符串，字段参见API文档
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function getpersonids($group_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/getpersonids';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'group_id' =>$group_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

        /**
         * @brief getfaceids
         * @param person_id 待查询的个体id
         * @param rsp 返回的人脸列表查询结果，JSON字符串，字段参见API文档
         * @return 返回的结果，JSON字符串，字段参见API文档
         */
    public static function getfaceids($person_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/getfaceids';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'person_id' =>$person_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    /**
     * @brief getfaceinfo
     * @param face_id 待查询的人脸id
     * @param rsp 返回的人脸信息查询结果，JSON字符串，字段参见API文档
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function getfaceinfo($face_id) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/api/getfaceinfo';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'face_id' =>$face_id,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
            ),
        );
        $rsp  = Http::send($req);
         $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

     /**
     * @param $image_path 待检测的路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function fuzzydetect($image_path) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/fuzzydetect';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function fuzzydetecturl($url) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/fuzzydetect';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $image_path 待检测的路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function fooddetect($image_path) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/fooddetect';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function fooddetecturl($url) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/fooddetect';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $image_path 待检测的路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function imagetag($image_path) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/imagetag';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function imagetagurl($url) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/imagetag';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

     /**
     * @param $image_path 待检测的路径
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function imageporn($image_path) {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/imageporn';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function imagepornurl($url) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/imageapi/imageporn';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * 通用OCR
     * @param string  $image 图片
     * @return array|string 返回的结果，JSON字符串，字段参见API文档
     */
    public static function generalocr($image) {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/ocrapi/generalocr';

        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $image,
        );
        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }


    /**
     * @param $url 图片url
     * @param $card_type 身份证照片类型，0 表示身份证正面， 1表示身份证反面
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function idcardocr($image_path, $card_type = 0, $seq = '') {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/ocrapi/idcardocr';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
            'seq' => $seq,
            'card_type' => $card_type,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @param $card_type 身份证照片类型，0 表示身份证正面， 1表示身份证反面
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function idcardocrurl($url,  $card_type, $seq = '') {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/ocrapi/idcardocr';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
            'seq' => $seq,
            'card_type' => $card_type,
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }


    /**
     * @param $image_path 待检测的路径
     * @param $retimage 是否返回名片图像
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function namecardocr($image_path, $retimage = 1, $seq = '') {

        $real_image_path = realpath($image_path);

        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/ocrapi/namecardocr';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $image_data = file_get_contents($real_image_path);
        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'image' => base64_encode($image_data),
             'seq' => $seq,
            'retimage'=> (bool)$retimage
        );

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    /**
     * @param $url 图片url
     * @param $retimage 是否返回名片图像
     * @return 返回的结果，JSON字符串，字段参见API文档
     */
    public static function namecardocrurl($url, $retimage = 1, $seq = '')
    {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/ocrapi/namecardocr';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'url' => $url,
            'seq' => $seq,
            'retimage'=> (bool)$retimage
        );


        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }

        return $ret;
    }

    public static function livegetfour($seq = '')
    {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/openliveapi/livegetfour';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'seq' => $seq
        );


        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    public static function livedetectfour($validate_data,$video_path,$card_path,$compare_card=false,$seq = '')
    {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/openliveapi/livedetectfour';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $real_video_path = realpath($video_path);
        if (!file_exists($real_video_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$video_path.' not exists', 'data' => array());
        }

        $video_data = file_get_contents($real_video_path);

        if($compare_card)
        {
          $real_card_path = realpath($card_path);
          if (!file_exists($real_card_path))
          {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$card_path.' not exists', 'data' => array());
          }

          $card_data = file_get_contents($real_card_path);
          $post_data = array(
            'app_id' =>  Conf::$APPID,
            'validate_data' =>  $validate_data,
            'compare_flag' => true,
            'video' =>  base64_encode($video_data),
            'card' =>  base64_encode($card_data),
            'seq' => $seq
            );
        }
        else
        {
            $post_data = array(
            'app_id' =>  Conf::$APPID,
            'validate_data' =>  $validate_data,
            'compare_flag' => false,
            'video' =>  base64_encode($video_data),
            'seq' => $seq
            );
        }

        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    public static function idcardlivedetectfour($idcard_number,$idcard_name,$validate_data,$video_path,$seq = '')
    {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/openliveapi/idcardlivedetectfour';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $real_video_path = realpath($video_path);
        if (!file_exists($real_video_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$video_path.' not exists', 'data' => array());
        }

        $video_data = file_get_contents($real_video_path);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'idcard_number' =>  $idcard_number,
            'idcard_name' =>  $idcard_name,
            'validate_data' =>  $validate_data,
            'video' =>  base64_encode($video_data),
            'seq' => $seq
        );


        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

    public static function idcardfacecompare($idcard_number,$idcard_name,$image_path,$seq = '')
    {

        $expired = time() + self::EXPIRED_SECONDS;
        $postUrl = Conf::$END_POINT . 'youtu/openliveapi/idcardfacecompare';
        $sign = Auth::appSign($expired, Conf::$USER_ID);

        $real_image_path = realpath($image_path);
        if (!file_exists($real_image_path))
        {
            return array('httpcode' => 0, 'code' => self::HTTP_BAD_REQUEST, 'message' => 'file '.$image_path.' not exists', 'data' => array());
        }

        $image_data = file_get_contents($real_image_path);

        $post_data = array(
            'app_id' =>  Conf::$APPID,
            'idcard_number' =>  $idcard_number,
            'idcard_name' =>  $idcard_name,
            'image' =>  base64_encode($image_data),
            'seq' => $seq
        );


        $req = array(
            'url' => $postUrl,
            'method' => 'post',
            'timeout' => 10,
            'data' => json_encode($post_data),
            'header' => array(
                'Authorization:'.$sign,
                'Content-Type:text/json',
                'Expect: ',
            ),
        );
        $rsp  = Http::send($req);

        $ret  = json_decode($rsp, true);

        if(!$ret){
            return self::getStatusText();
        }
        return $ret;
    }

}
