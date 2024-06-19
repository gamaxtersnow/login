<?php
namespace app\login\service\login;

interface LoginServiceInterface{
    public function webLoginAuth(string $state):string; //登录授权
    public function getAccessToken():string;//获取token
    public function getUserId(string $code):string;//获取用户Ticket
    public function getUserBase(string $code):array;//获取用户id
    public function getUserInfo(string $userTicket):array;//获取用户基本信息
    public function getUserDetail(string $code=''): array;//获取用户详情信息
    public function getLoginQrcode(string $state):string;//获取登录二维码
    public function code2session(string $code):array;//获取session信息
    public function decryptUserEmail(string $sessionKey,string $encryptedData, string $iv):array;//解密用户邮箱
    public function getLoginQrCodes(string $state):string;//获取某个应用的二维码
    public function setAgentName(string $agentName):LoginServiceInterface;
}
