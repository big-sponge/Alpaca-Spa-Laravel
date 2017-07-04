<?php
namespace Builder\View;

/**
 * View - 视图模板
 * @author Chengcheng
 * @date 2017-2-27 15:50:00
 */
class View
{

    //单例
    private static $instance = null;

    //数据
    private $data;

    //模板
    private $template;

    //布局模板
    public $layout = null;

    /**
     * 创建视图
     * @author Chengcheng
     * @param string $template 视图模板名字
     * @param array  $data 视图数据
     * @date 2016年11月5日 14:47:40
     * @return static
     */
    public static function tbl($template, $data = null)
    {
        //实例化新的对象
        $newTpl = new static;

        //设置视图
        $newTpl->template = __DIR__ . '/Template/' . $template . ".php";

        //数据
        $newTpl->data = $data;

        //layout
        $newTpl->layout = static::layoutTpl();

        //返回
        return $newTpl;
    }

    /**
     * 创建layout视图
     * @author Chengcheng
     * @param string $template 视图模板名字
     * @param array  $data 视图数据
     * @date 2016年11月5日 14:47:40
     * @return static
     */
    public static function layoutTpl($template = 'layout', $data = null)
    {
        //实例化新的对象
        $newTpl = new static;

        //设置视图
        $newTpl->template = __DIR__ . '/Template/' . $template . ".php";

        //数据
        $newTpl->data = $data;

        //返回
        return $newTpl;
    }

    /**
     * 创建视图
     * @author Chengcheng
     * @param null $data
     * @return null|string
     * @throws \Exception
     */
    public function html($data = null)
    {

        //加载自己的模板
        if (!empty($this->data)) {
            foreach ($this->data as $key => $value) {
                $this->$key = $value;
            }
        }
        //参数中的数据
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }

        //读取模板中的信息
        $html = null;
        try {
            ob_start();
            require $this->template;
            $html = ob_get_clean();
        } catch (\Exception $ex) {
            ob_end_clean();
            throw $ex;
        }

        //加载layout的模板
        if ($this->layout) {
            $html = $this->layout->html(['content' => $html]);
        }

        //返回信息
        return $html;
    }

}
