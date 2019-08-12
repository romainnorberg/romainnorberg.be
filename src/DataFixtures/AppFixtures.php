<?php

/*
 * This file is part of romainnorberg.be source code.
 * (c) Romain Norberg <romainnorberg@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\BlogPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $author = new Author();
        $author
            ->setName('Romain Norberg')
            ->setTitle('Developer')
            ->setUsername('romainnorberg')
            ->setCompany('Me')
            ->setShortBio('')
            ->setPhone('070000000')
            ->setFacebook('romainnorberg')
            ->setTwitter('romainnorberg')
            ->setGithub('romainnorberg');

        $manager->persist($author);

        $blogPost = new BlogPost();
        $blogPost
            ->setTitle('Work with OVH API using Postman')
            ->setSlug('work-with-ovh-api-using-postman')
            ->setDescription('It\'s necessary to generate a unique signature to communicate with the OVH API. We\'ll see how to use Pre-request scripts to generate it and test /SMS service (GET).')
            ->setBody('



We are using /SMS API services in this example

### Prerequisites, assuming that you have:

- An OVH account
- Valid access to the OVH API _(doc: [First Steps with the API](https://docs.ovh.com/gb/en/customer/first-steps-with-ovh-api/))_
- Credentials needed to access services _(Doc: [Creating API Keys for your script for SMS services](https://api.ovh.com/createToken/index.cgi?GET=/sms&GET=/sms/%2a&PUT=/sms/%2a&DELETE=/sms/%2a&POST=/sms/%2a))_ 
- An SMS account configured in your OVH manager
- Postman is not unknown to you _(define env. variable, ...)_

# Introduction

## OVH API

![ovh-api](https://api.ovh.com/images/ovh-under-construction.png)

OVH API is a Web service allowing OVH customers to buy, manage, upgrade and configure OVH products without using the graphical customer interface (OVH manager).

## Postman Pre-request scripts

Pre-request scripts are snippets of code associated with a collection request that are executed before the request is sent. This is perfect for use-cases like including the timestamp in the request headers or sending a random alphanumeric string in the URL parameters.

_Doc: [Postman Pre-request scripts](https://www.getpostman.com/docs/v6/postman/scripts/pre_request_scripts)_

# Let\'s go

## Process

### 1) Import curl

Copy/paste content of [request.curl](https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-request-curl) into prompt window _(File > Import > "Paste Raw text")_ and confirm

```json
curl -X GET \
  https://api.ovh.com/1.0/sms \
-H \'Content-Type: application/json; charset=utf-8\' \
-H \'X-Ovh-Application: xxxxxx\' \
-H \'X-Ovh-Consumer: {{lf_ovh_api_app_consumer_key}}\' \
-H \'X-Ovh-Signature: {{lf_ovh_api_app_consumer_signature}}\' \
-H \'X-Ovh-Timestamp: {{lf_ovh_api_app_timestamp}}\' \
-H \'cache-control: no-cache\'
```

![import curl request](https://thepracticaldev.s3.amazonaws.com/i/dlkneheob182kwalioaa.png)

### 2) Define variables

- In Headers tab, fill `X-Ovh-Application` with your application key _(e.g. AmJgcE99XcibYrV1)_.

  ![Postman headers tab](https://thepracticaldev.s3.amazonaws.com/i/t82pp1x2ooq1yyaolqt8.png)

- Define env. variable
  - `lf_ovh_api_app_consumer_key` with your consumer key
  - `lf_ovh_api_app_secret` with your app secret

![Postman Manage Environments](https://thepracticaldev.s3.amazonaws.com/i/n600ryjw1zruxnkak3en.png)

_(doc: [Postman Variables](https://www.getpostman.com/docs/v6/postman/environments_and_globals/variables))_

### 3) Try to run

  If you send the request as it is, the OVH API will return an error because the signature and the timestamp are not filled.

Response after press "Send" button:

  ```json
  {
    "errorCode": "QUERY_TIME_OUT",
    "httpCode": "400 Bad Request",
    "message": "Query out of time"
  }
  ```

### 4) Pre-request Script

Copy/paste content of [pre-request-script](https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-pre-request-script) into "Pre-request Script" tab textarea.

![pre-request script tab](https://thepracticaldev.s3.amazonaws.com/i/xvyl6sf6qboq6gy9xpfy.png)

```javascript
pm.sendRequest({
    url: "https://api.ovh.com/1.0/auth/time",
    method: "GET",
    headers: {
        \'Content-Type\': \'application/json; charset=utf-8\'
    },
    body: {}
 },
 function (err, res) {
     
    pm.expect(err).to.not.be.ok;
    pm.expect(res).to.have.property(\'code\', 200);
    pm.expect(res).to.have.property(\'status\', \'OK\');
    
    var serverTimestamp = res.text();
    postman.setGlobalVariable("lf_ovh_api_app_server_timestamp", serverTimestamp);
    
    var time_delta = serverTimestamp - Math.round(new Date().getTime()/1000);
    var now = Math.round(new Date().getTime()/1000) + time_delta;
    var body = \'\';
    
    postman.setGlobalVariable("lf_ovh_api_app_timestamp", now);
    
    var toSign = environment.lf_ovh_api_app_secret + \'+\' + environment.lf_ovh_api_app_consumer_key + \'+\' + pm.request.method + \'+\' + pm.request.url.toString() + \'+\' + body + \'+\' + now;
    
    var signature = \'$1$\' + CryptoJS.SHA1(toSign);
    
    postman.setGlobalVariable("lf_ovh_api_app_consumer_signature", signature);
 }
);
```

### 5) Try to run

Normally you should then have the following response from OVH API 🎉🎉

```json
  [
    "sms-rnXXXXX-1"
  ]
```

😠the API returns you an error? check your credentials, check "Possibles issues" section below.

## Possibles issues

### Empty response []

No problem, the service works but you have to configure an SMS account in your OVH manager.

### Invalid signature (400 Bad Request)

Check if your consumer_key and app_secret are valid.

### This call has not been granted (403 Forbidden)

Make sure that you have generated the key with the permissions that are good for the service

_Doc: [Creating API Keys for your script for SMS services](https://api.ovh.com/createToken/index.cgi?GET=/sms&GET=/sms/%2a&PUT=/sms/%2a&DELETE=/sms/%2a&POST=/sms/%2a)_

### Another issue ?

Do not hesitate to leave a comment with the error encountered.

## Evolution

⚠️ the "Pre-request" script only supports the GET method for the moment. You are free to upgrade the script to support POST, PUT & DELETE methods.

## Alternative

Use and test the OVH API directly from the browser with your OVH account: https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/

![ovh-api-login](https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/connection_api_log.jpg)

![ovh-api-service](https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/api.jpg)

## Script sources

Check [https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa](https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa)

')
            ->setHeaderImage('https://source.unsplash.com/1200x600/?postbox')
            ->setTags(['ovh', 'api', 'postman', 'pre-request'])
            ->setCreatedAt(new \DateTime('2018-11-01'))
            ->setAuthor($author);

        $manager->persist($blogPost);
        $manager->flush();
    }
}
