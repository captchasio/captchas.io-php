# PHP Module for CAPTCHAs.IO API
The easiest way to quickly integrate [CAPTCHAs.IO] captcha solving service into your code to automate solving of any types of captcha.

- [Installation](#installation)
  - [Composer](#composer)
  - [Manual](#manual)
- [Configuration](#configuration)
- [Solve captcha](#solve-captcha)
  - [Normal Captcha](#normal-captcha)
  - [ReCaptcha v2](#recaptcha-v2)
  - [ReCaptcha v3](#recaptcha-v3)
  - [hCaptcha](#hcaptcha)
- [Other methods](#other-methods)
  - [balance](#balance)
- [Error handling](#error-handling)


## Installation
This package can be installed via composer or manually

### Composer
```
composer require CAPTCHAs.IO/CAPTCHAs.IO
```

### Manual
Copy `src` directory to your project and then `require` autoloader (`src/autoloader.php`) where needed:
```php
require 'path/to/autoloader.php';
```

## Configuration
`CaptchasIO` instance can be created like this:
```php
$solver = new \CaptchasIO\CaptchasIO('YOUR_API_KEY');
```
Also there are few options that can be configured:
```php
$solver = new \CaptchasIO\CaptchasIO([
    'apiKey'           => 'YOUR_API_KEY',
    'softId'           => 123,
    'callback'         => 'https://your.site/result-receiver',
    'defaultTimeout'   => 120,
    'recaptchaTimeout' => 600,
    'pollingInterval'  => 10,
]);
```

### CaptchasIO instance options

|Option|Default value|Description|
|---|---|---|
|softId|-|your software ID obtained after publishing in [CAPTCHAs.IO sofware catalog]|
|callback|-|URL of your web-sever that receives the captcha recognition result. The URl should be first registered in [pingback settings] of your account|
|defaultTimeout|120|Polling timeout in seconds for all captcha types except ReCaptcha. Defines how long the module tries to get the answer from `res.php` API endpoint|
|recaptchaTimeout|600|Polling timeout for ReCaptcha in seconds. Defines how long the module tries to get the answer from `res.php` API endpoint|
|pollingInterval|10|Interval in seconds between requests to `res.php` API endpoint, setting values less than 5 seconds is not recommended|

>  **IMPORTANT:** once `callback` is defined for `CaptchasIO` instance, all methods return only the captcha ID and DO NOT poll the API to get the result. The result will be sent to the callback URL.
To get the answer manually use [getResult method](#send--getresult)

## Solve captcha
When you submit any image-based captcha use can provide additional options to help CAPTCHAs.IO workers to solve it properly.

### Captcha options
|Option|Default Value|Description|
|---|---|---|
|numeric|0|Defines if captcha contains numeric or other symbols [see more info in the API docs][post options]|
|minLength|0|minimal answer lenght|
|maxLength|0|maximum answer length|
|phrase|0|defines if the answer contains multiple words or not|
|caseSensitive|0|defines if the answer is case sensitive|
|calc|0|defines captcha requires calculation|
|lang|-|defines the captcha language, see the [list of supported languages] |
|hintImg|-|an image with hint shown to workers with the captcha|
|hintText|-|hint or task text shown to workers with the captcha|

Below you can find basic examples for every captcha type. Check out [examples directory] to find more examples with all available options.

### Normal Captcha
To bypass a normal captcha (distorted text on image) use the following method. This method also can be used to recognize any text on the image.
```php
$result = $solver->normal('path/to/captcha.jpg');
```
### ReCaptcha v2
Use this method to solve ReCaptcha V2 and obtain a token to bypass the protection.
```php
$result = $solver->recaptcha([
    'sitekey' => '6Le-wvkSVVABCPBMRTvw0Q4Muexq1bi0DJwx_mJ-',
    'url'     => 'https://mysite.com/page/with/recaptcha',
]);
```
### ReCaptcha v3
This method provides ReCaptcha V3 solver and returns a token.
```php
$result = $solver->recaptcha([
    'sitekey' => '6Le-wvkSVVABCPBMRTvw0Q4Muexq1bi0DJwx_mJ-',
    'url'     => 'https://mysite.com/page/with/recaptcha',
    'version' => 'v3',
]);
```
### hCaptcha
Use this method to solve hCaptcha challenge. Returns a token to bypass captcha.
```php
$result = $solver->hcaptcha([
    'sitekey'   => '10000000-ffff-ffff-ffff-000000000001',
    'url'       => 'https://www.site.com/page/',
]);
```

## Other methods

### send / getResult
These methods can be used for manual captcha submission and answer polling.
```php
$id = $solver->send(['file' => 'path/to/captcha.jpg', ...]);

sleep(20);

$code = $solver->getResult($id);
```
### balance
Use this method to get your account's balance
```php
$balance = $solver->balance();
```
[CAPTCHAs.IO]: https://captchas.io
[CAPTCHAs.IO sofware catalog]: https://captchas.io/software
[examples directory]: /examples
