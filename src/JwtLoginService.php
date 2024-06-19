<?php
namespace app\login\service\login;

class JwtLoginService implements LoginServiceInterface
{
    private $_jwtAuth;
    private string $_agentName;
    private string $_appKey = "";
    private string $_appKeyId = '';
    private string $_expireTime = '';
    private string $_authUrl = '';

    public function __construct($jwtAuth,string $agentName='')
    {
        $agentName = $agentName?:config('jwt.default');
        $this->_agentName = $agentName;
        $agent = config('jwt.agents')[$this->_agentName]??[];
        $this->_appKey = $agent['key']??$this->_appKey;
        $this->_appKeyId = $agent['key_id']??$this->_appKeyId;
        $this->_authUrl = $agent['auth_url']??$this->_authUrl;
        $this->_expireTime = $agent['expire_time']??$this->_expireTime;
        $this->_jwtAuth = $jwtAuth;
    }

    public function webLoginAuth(string $state): string {
        return $this->_authUrl;
    }
    public function getAccessToken(): string
    {
        try {
            $userInfo['id'] = 1870;
            $userInfo['name'] = '姜洪宇';
            $userInfo['status'] = 1;
            $userInfo['part_id'] = [47,48];
            $token = $this->_jwtAuth->createToken($userInfo['id'], $this->_agentName, $this->_expireTime, $userInfo);
            return $token['token'];
        } catch (\Exception | \Error $e) {
            return '';
        }
    }

    public function getUserId(string $code): string
    {
        return $code;
    }

    public function getUserInfo(string $userTicket): array
    {
        return [];
    }

    public function getUserBase(string $code): array
    {
        return [];
    }
    public function getUserDetail(string $code=''): array
    {
        return [];
    }

    public function getLoginQrcode(string $state): string
    {
        return '';
    }

    public function code2session(string $code): array
    {
        // TODO: Implement getSession() method.
        return [];
    }

    public function decryptUserEmail(string $sessionKey, string $encryptedData, string $iv): array
    {
        // TODO: Implement decryptUserEmail() method.
        return [];
    }
    public function getLoginQrCodes(string $state):string
    {
        return '';
    }

    public function setAgentName(string $agentName): LoginServiceInterface
    {
        // TODO: Implement setAgentName() method.
        return $this;
    }
}
