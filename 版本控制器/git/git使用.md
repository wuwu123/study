### 基础命令



#### submodule

```
git submodule add

git submodule init

//更新
git submodule update --init

同步配置文件
git submodule sync
```





```json
{
    "name": "包的名字",
    "version":"发行的版本号",
    "type": "包的类型，支持如下library,project,metapackage,composer-plugin，默认为library",
    "keywords": [
        
    ],
    "description": "",
    "license": "Apache-2.0",//包的许可协议
    "require": {
        '必须依赖的包'
    },
    "require-dev": {
    },
    "autoload": {//自动加载
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/Core/Functions.php"
        ]
    },
    "minimum-stability": "dev",
    "prefer-stable": true,
    "extra": {
    },
    "scripts": {
        "cs-fix": "php-cs-fixer fix $1"
    },
    "repositories": {//代码来源
        "submodules": {
            "type": "path",
            "url": "submodules/*"
        },
        "packagist": {
            "type": "composer",
            "url": "https://packagist.laravel-china.org"
        }
    }
}

```





###### 参考地址

[git 官方文档](https://blog.tomyail.com/using-git-submodule-lock-project/)

[学习地址](https://blog.tomyail.com/using-git-submodule-lock-project/)