<?php


namespace App\DTO;


class WechatSetingDTO extends DTO
{
    /**
     * @var string | null
     * @description app_id
     */
    private $app_id;


    /**
     * @var string | null
     * @description secret
     */
    private $secret;



    /**
     * @var string | null
     * @description token
     */
    private $token;


    /**
     * @var string | null
     * @description aes_key
     */
    private $aes_key;

    /**
     * @return string|null
     */
    public function getAppId(): ?string
    {
        return $this->app_id;
    }

    /**
     * @param string|null $app_id
     */
    public function setAppId(?string $app_id)
    {
        $this->app_id = $app_id;
    }

    /**
     * @return string|null
     */
    public function getSecret(): ?string
    {
        return $this->secret;
    }

    /**
     * @param string|null $secret
     */
    public function setSecret(?string $secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string|null
     */
    public function getAesKey(): ?string
    {
        return $this->aes_key;
    }

    /**
     * @param string|null $aes_key
     */
    public function setAesKey(?string $aes_key)
    {
        $this->aes_key = $aes_key;
    }




}