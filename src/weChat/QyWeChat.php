<?php

namespace app\login\service\login\weChat;

use think\facade\Log;

class QyWeChat
{
    private string $_corpId = '';
    private string $_agentId = '';
    private string $_redirectUrl = '';
    private string $_agentName = '';
    private string $_appPrefix = 'wework_';
    private string $_appName = '';

    public function __construct(string $agentName)
    {
        $this->_agentName = $agentName;
        $this->_appName = $this->_appPrefix.$this->_agentName;

        $weworkConfig = config('wework');
        $agents = $weworkConfig['agents'];
        $agent = $agents[$this->_agentName];
        unset($weworkConfig['agents']);
        $agentConfig = $weworkConfig + $agent;
        $this->_corpId = $agentConfig['corp_id'];
        $this->_agentId = $agentConfig['agent_id'];
        $this->_redirectUrl = $agentConfig['redirect_url'];
    }
    /**
     * 获取企业微信的token
     * @return string
     */
    public function getAccessToken(): string
    {
        try {
            $token = app($this->_appName)->get('token');
            $tokenString = $token->get();
            if (empty($tokenString)) {
                $token->get(true);
            }
            return $token->get();
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return '';
        }
    }

    /**
     * 授权登录
     * @param string $state
     * @return string
     */
    public function webLoginAuth(string $state): string
    {
       return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_corpId}&redirect_uri=".urlencode($this->_redirectUrl)."&response_type=code&scope=snsapi_privateinfo&state={$state}&agentid={$this->_agentId}#wechat_redirect";
    }

    /**
     * 获取用户id和ticket
     * @param string $code
     * @return string
     */
    public function getQyWeChatUserId(string $code): string
    {
        try {
            $user = app($this->_appName)->get('user');
            return $user->getInfo($code)['user_ticket'] ?? '';
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return '';
        }
    }
    public function getQyWeChatUserBase(string $code): array
    {
        try {
            $user = app($this->_appName)->get('user');
            return $user->getInfo($code) ?? [];
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return [];
        }
    }
    /**
     * 获取用户详情
     * @param string $userTicket
     * @return array
     */
    public function getQyWeChatUserInfo(string $userTicket):array
    {
        try {
            $user = app($this->_appName)->get('user');
            return $user->getDetail($userTicket);
        }catch (\Exception $e){
            Log::error($e->getMessage());
            return [];
        }
    }

    /**
     * 获取二维码
     * @param string $state
     * @return string
     */
    public function getLoginQrCodes(string $state): string
    {
        return app($this->_appName)->get('wx_qrcode')->getLoginQrCode($state)->toBase64();
    }
}