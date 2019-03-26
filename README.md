# ozon-catalog
Access to ozon cantalog by API
https://partner.ozon.ru/tools/xml

## Auth
You need to do first auth by email,password. Then you can use refresh point.
In both case API provide new access and token key
 


Tokens live time
access key: 30day
refresh key: 90day

First access by login,password
```
$auth = new OzonAuth('email@email.com', 'password');

$accessToken = $auth->getAccessToken();
$refreshToken = $auth->getRefreshToken();

echo "\nAccess token: $accessToken";
echo "\nRefresh token: $refreshToken";
```

Next you need to refresh in each 30 day with stored $refreshToken
```
$auth = new OzonAuth($refreshToken);

$accessToken = $auth->getAccessToken();
$refreshToken = $auth->getRefreshToken();

echo "\nAccess token: $accessToken"; 
echo "\nRefresh token: $refreshToken";
```


