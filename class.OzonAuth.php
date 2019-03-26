<?php

class OzonAuth
{
    private $tokensData, $isTokensRequested = false;
    
    public function __construct($loginOrToken = null,$password = null)
    {
        
        // Both parametres used -> it's a pair (login,password)
        if (!is_null($loginOrToken) && !is_null($password)) {
            $this->requestByAuth($loginOrToken, $password);
            return ;
        }

        // Only one of parametres used -> it's refresh token
        if (!is_null($loginOrToken) && is_null($password)) {
            $this->requestByRefreshToken($loginOrToken);
            return ;
        }

    }
    
    
    // Request tokens by login and password
    public function requestByAuth($login, $password)
    {
        
        $resultJson = CurlHelper::request(
            'POST', 
            "https://api.ozon.ru/affiliates/partner-api/account/token", 
            ['email' => $login,'password' => $password]
        );
        
        if (!$resultJson) {
            throw new Exception('Authentication failed');
        }

        $this->tokensData = json_decode($resultJson, true);
        $this->isTokenRequested = true;        
    }
    
    // Request tokens by refresh token. 
    public function requestByRefreshToken($refreshToken)
    {

        $resultJson = CurlHelper::request(
            'PUT', 
            "https://api.ozon.ru/affiliates/partner-api/account/token", 
            ['refresh_token' => $refreshToken]
        );

        if (!$resultJson) {
            throw new Exception('Authentication failed');
        }

        $this->tokensData = json_decode($resultJson, true);
        $this->isTokenRequested = true;        

    }

    public function getAccessToken()
    {
        return $this->getTokenValue('access_token');
    }
    
    public function getRefreshToken()
    {
        return $this->getTokenValue('refresh_token');
    }
    
    private function getTokenValue($key)
    {

        if (!isset($this->tokensData[$key])) {
            throw new Exception("You must request tokens by email,passowrd or by refresh token");
        }

        if (!isset($this->tokensData[$key])) {
            throw new Exception("Wrong key $key in tokenData. Token didn't loaded");            
        }
        
        return $this->tokensData[$key];
    }
    

    private function isTokensRequested()
    {
        return ($this->isTokensRequested === true);        
    }
    
}
