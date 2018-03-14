<?php

namespace App\Common\Lib;

/**
 * 邮件发送服务
 * @author Lux
 * @date 2016年4月22日 15:36:48
 * Class EmailService
 * @package Common\Service
 */
class Email
{
    private static $mailHost;       // 服务器地址
    private static $mailFrom;       // 邮件发送者
    private static $mailPassword;   // 密码
    private static $mailSMTP;       // 邮件发送协议
    private static $mailPort;       // 发送端口
    private static $mailSecure;     // 安全协议

    //单例
    private static $instance = null;

    /**
     * 初始化邮件服务参数
     * @author Lux
     * @date 2016年4月22日 17:51:54
     * EmailService constructor.
     */
    public function __construct()
    {
        self::$mailHost     = 'smtp.exmail.qq.com';
        self::$mailFrom     = config('mail.username');
        self::$mailPassword = config('mail.password');
        self::$mailSMTP     = 'smtp';
        self::$mailPort     = '465';
        self::$mailSecure   = 'ssl';
    }

    /**
     * 单例，
     * @author Chengcheng
     * @date 2016年11月5日 14:47:40
     * @return self
     */
    public static function email()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * 发送邮件
     * @author Lux
     * @date 2016年4月22日 17:51:54
     * @param string $subject 邮件主题
     * @param string|array $sendTo 收件人，单个收件人可为字符串，多个收件人则为数组
     * @param string $content 邮件内容
     * @return int 成功返回 1
     */
    public function send($subject, $sendTo, $content)
    {
        $sendTo=explode(',',$sendTo);

        $transport        = \Swift_SmtpTransport::newInstance(self::$mailHost, self::$mailPort, self::$mailSecure)
            ->setUsername(self::$mailFrom)
            ->setPassword(self::$mailPassword);
        $mailer           = \Swift_Mailer::newInstance($transport);

        $message          = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom(array(self::$mailFrom => 'Alpaca-Laravel 后台管理平台'))
            ->setTo($sendTo)
            ->setContentType("text/html")
            ->setBody($content);
        $mailer->protocal = self::$mailSMTP;
        return $mailer->send($message);
    }

    /**
     * 发送html内容邮件
     * @param string $subject 标题
     * @param string $mailTo 收件人，单个收件人可为字符串，多个收件人则为数组
     * @param string $content 邮件内容HTML模板名称
     * @return int
     */
    public function sendHtmlEmail($subject, $mailTo, $content)
    {
        return $this->send($subject, $mailTo, $content);
    }
}