# 用docker-compose和php实现的读写分离
用Dockerfile创建一个php-fpm的镜像，主要是为了包含mysqli扩展
然后把php/mysql.php文件添加到php镜像里面，
php镜像里面，我增加了两个环境变量，存放主库和分库的链接信息
数据库的端口可以不传，默认3306

目前还有点问题，就是php容器需要等待mysql各个容器启动完成后，再执行才起作用
有待研究

如果看到Waiting for master send event.. 什么的就成功了，你现在在主库上的修改，都会同步到从库上
