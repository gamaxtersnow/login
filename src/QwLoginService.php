<?php
namespace app\login\service\login;

use app\login\constant\Constants;
use app\login\service\login\weChat\QyWeChat;

class QwLoginService implements LoginServiceInterface
{
    protected QyWeChat $qyWeChat;
    public function setAgentName(string $agentName):LoginServiceInterface
    {
        $this->qyWeChat = invoke(QyWeChat::class,[$agentName]);
        return $this;
    }
    /**
     * 登录授权
     * @param string $state
     * @return string
     */
    public function webLoginAuth(string $state):string{

        return $this->qyWeChat->webLoginAuth($state);
    }

    /**
     * 获取企微token
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->qyWeChat->getAccessToken();
    }

    /**
     * 获取用户ID
     * @param string $code
     * @return string
     */
    public function getUserId(string $code): string
    {
        return $this->qyWeChat->getQyWeChatUserId($code);
    }

    /**
     * 用户基础信息
     * @param string $code
     * @return array
     */
    public function getUserBase(string $code): array
    {
        $userBase =  $this->qyWeChat->getQyWeChatUserBase($code);
        if (empty($userBase)){
            return [];
        }
        return [
            'userid'=>$userBase['UserId']?? '',
            'email'=>$userBase['email']??'',
            'deviceid'=>$userBase['DeviceId']??'',
            'ticket'=>$userBase['user_ticket']??''
        ];
    }
    /**
     * 获取用户基本信息
     * @param string $userTicket
     * @return array
     */
    public function getUserInfo(string $userTicket): array
    {
        return $this->qyWeChat->getQyWeChatUserInfo($userTicket);
    }

    /**
     * 获取用户详情信息
     * @param string $code
     * @return array
     */
    public function getUserDetail(string $code=''): array
    {
        $user =  $this->getUserInfo($this->getUserId($code));
        if(empty($user)){
            return [];
        }
        return [
                'userid'=>$user['userid']?? '',
                'email'=>$user['email']??'',
                'mobile'=>$user['mobile']??'',
                'biz_mail'=>$user['biz_mail']??'',
                'update_fields'=>[
                    'qywx_userid'=>$user['userid']?? '',
                    'qywx_gender'=>$user['gender']?? 0,
                    'qywx_qr_code'=>$user['qr_code']?? '',
                    'qywx_address'=>$user['address']?? '',
                    'login_type'=>Constants::QW_LOGIN_TYPE,
                    'last_login_time'=>echoDate()
                    ]
        ];
    }

    /**
     * 获取登录二维码
     * @param string $state
     * @return string
     */
    public function getLoginQrcode(string $state): string
    {
        return app('wework')->get('wx_qrcode')->getLoginQrCode($state)->toBase64();
    }

    public function code2session(string $code): array
    {
        return app('wework')->get('session')->code2session($code);
    }

    public function decryptUserEmail(string $sessionKey, string $encryptedData, string $iv): array
    {
        return app('wework')->get('session')->decryptUserEmail($sessionKey,$encryptedData,$iv);
    }

    public function getLoginQrCodes(string $state):string
    {
        return $this->qyWeChat->getLoginQrCodes($state);
    }
}