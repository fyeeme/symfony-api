

this framework is mainly used for api, Through regex match parsing, it can help you minimize routing configuration.

you can also custom the regex match rule.


## install

1. setup program
```bash
    cp .env.dist .env
    cp phinx.yml.dist phinx.yml
    composer install --ignore-platform-reqs
```

2. set nginx 

```bash
    cp config/documents/nginx  /path/servers/api
```

## Feature


1. [Events and Event Listeners](https://symfony.com/doc/current/reference/events.html)
    1. kernel.request 全局拦截 options请求，处理前端跨域问题
    2. kernel.response 设置 options的跨域设置
    3. kernel.exception 全局异常处理

2. [auth](https://symfony.com/doc/current/security.html)
    1. web login auth
    2. token auth
    3. api auth
    4. oauth

3. [session](https://symfony.com/doc/current/doctrine/pdo_session_storage.html)
    1. support redis as cache client
    2. use redis as session handler

4. [service kernel](https://github.com/ageglow/base-framework)
    1. simple service framework for service、dao、 validate ...
   
## TODO LIST    
[test unit link](https://symfony.com/doc/current/best_practices/tests.html#unit-tests)
