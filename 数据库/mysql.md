## MYSQL

### 常用函数

####  时间格式化函数

```
UNIX_TIMESTAMP('2018-07-01 0:0')

from_unixtime(`create_time`) 
```



#### mysql的坑

```
当查询数据类型和索引数据类型不一致的时候，查询不走索引
```



## LevelDB

### 特点

*   写入速度，明显大鱼读取速度

[![特点](assets/TB1AMqNSXXXXXczXFXXXXXXXXXX-851-479.png)](http://taobaofed.org/blog/2017/07/05/leveldb-analysis/)

