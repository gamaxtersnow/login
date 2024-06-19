<?php
namespace app\login\service\login;

class WxLoginService implements LoginServiceInterface
{
    public function __construct()
    {
        return '';
    }

    public function webLoginAuth(string $state): string
    {
        return '';
    }

    public function getAccessToken(): string
    {
        return '';
    }

    public function getUserDetail(string $code=''): array
    {
        return [];
    }

    public function getUserId(string $code): string
    {
        return '';
    }

    public function getUserBase(string $code): array
    {
        return [];
    }

    public function getUserInfo(string $userTicket): array
    {
        return [];
    }

    public function getLoginQrcode(string $state): string
    {
        return '';
    }

    public function code2session(string $code): array
    {
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
