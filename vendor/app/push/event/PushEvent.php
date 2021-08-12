<?php
namespace app\push\event;

/**
 * 推送事件
 * 典型调用方式：
 * $push = new PushEvent();
 * $push->setUser($user_id)->setContent($string)->push();
 *
 * Class PushEvent
 * @package app\lib\event
 */
class PushEvent
{
    /**
     * @var string 目标用户id
     */
    protected $to_user = '';
    /**
     * @var string 目标群组
     */
    protected $to_group = '';
    /**
     * @var string 来源用户id
     */
    protected $from_user = '';

    /**
     * @var string 推送服务地址
     */
    protected $push_api_url = 'http://io.hljhezhan.cn:2121';

    /**
     * @var string 推送内容
     */
    protected $content = '';

    /**
     * 设置推送用户，若参数留空则推送到所有在线用户
     *
     * @param string $user
     * @return $this
     */
    public function setUser($user = '')
    {
        $this->to_user = $user ?: '';
        return $this;
    }

    /**
     * 设置来源用户
     *
     * @param string $user
     * @return $this
     */
    public function setFromUser($user = '')
    {
        $this->from_user = $user ?: '';
        return $this;
    }

    /**
     * 设置推送用户，若参数留空则推送到所有在线用户
     *
     * @param string $user
     * @return $this
     */
    public function setGroup($group = '')
    {
        $this->to_group = $group ?: '';
        return $this;
    }

    /**
     * 设置推送内容
     *
     * @param string $content
     * @return $this
     */
    public function setContent($content = '')
    {
        $this->content = $content;
        return $this;
    }

    /**
     * 推送
     */
    public function push()
    {
        $data = [
            'type' => 'publish',
            'content' => $this->content,
            'to' => $this->to_user,
            'group' => $this->to_group,
            'from' => $this->from_user,
        ];
        dump($data);
        dump( $this->push_api_url);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $this->push_api_url );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Expect:"));
        $return = curl_exec ( $ch );
        curl_close ( $ch );
        var_export($return);

        // echo json_encode(["code" => 1]);

    }
}
