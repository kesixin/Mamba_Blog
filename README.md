### 欢迎使用，如果本项目对您有帮助，请帮忙点击Star一下！！！
#### 简介
* 一个基于Laravel开发，支持markdown语法开源的简易博客。

#### 依赖开源程序
* LAMP
* Laravel
* AdminLTE
* Bootstrap
* Editor.md
* andersao/l5-repository
* etrepat/baum

### 获取源码

源码地址：[Github](https://github.com/kesixin/new_blog)

* 使用gitclone获取源码

```
git clone https://github.com/kesixin/new_blog.git
```

### 运行环境要求
* PHP : 5.6+
* MYSQL : 5.6+
* Composer

### 进入项目目录

```
cd new_blog
```

### 安装项目依赖

```
composer install
```

### 生成.env

```
cp .env.example .env
php artisan key:generate
```

### 修改.env文件配置

```
APP_DEBUG=true #开启调试
DB_HOST= #数据库地址
DB_PORT=3306 #数据库端口
DB_DATABASE= #数据库名称
DB_USERNAME= #数据库用户
DB_PASSWORD= #数据库密码
```

### 数据迁移和数据填充

```
php artisan migrate
php artisan db:seed --class=UserTableSeeder
```

### 调优
* 部署到线上可选，本地测试无需执行

```
php artisan optimize  //优化类加载
php artisan config:cache  //配置缓存
php artisan route:cache  //路由缓存
```

### 后台登录

* 后台地址: 域名/backend
* email：462369233@qq.com
* password : kesixin.xin
