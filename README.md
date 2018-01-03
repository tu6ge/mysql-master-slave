主库里面运行如下指令

<code>GRANT REPLICATION SLAVE ON *.* to 'backup'@'%' identified by '123456';</code>

创建一个用户，然后查看主库状态

<code>show master status</code>

记录类似于mysql-bin.000004、312 这样的值
然后在从库运行如下指令
<code>
  change master to master_host='master',master_user='backup',master_password='123456',
master_log_file='mysql-bin.000004',master_log_pos=312,master_port=3306;
</code>
从库继续运行

<code>
  start slave;
</code>

查看从库的同步状态

<code>
  show slave status
</code>

如果看到Waiting for master send event.. 什么的就成功了，你现在在主库上的修改，都会同步到从库上
