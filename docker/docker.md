<!-- TOC -->

- [docker 基本概念](#docker-基本概念)
    - [docker 和 虚拟机的区别](#docker-和-虚拟机的区别)
    - [docker 和 虚拟机的区别](#docker-和-虚拟机的区别-1)
    - [镜像](#镜像)
    - [容器](#容器)
    - [仓库](#仓库)
- [docker安装](#docker安装)
    - [安装错误](#安装错误)
        - [处理](#处理)
- [镜像](#镜像-1)
    - [拉去镜像](#拉去镜像)
    - [启动并运行一个容器](#启动并运行一个容器)
    - [镜像列表](#镜像列表)
    - [删除镜像](#删除镜像)
    - [进入容器](#进入容器)
    - [Dockerfile](#dockerfile)
        - [构建文件下命令](#构建文件下命令)
            - [From](#from)
            - [RUN](#run)
            - [COPY](#copy)
            - [ADD](#add)
    - [学习地址](#学习地址)

<!-- /TOC -->



## docker 基本概念

### docker 和 虚拟机的区别

|                            docker                            |                            虚拟机                            |
| :----------------------------------------------------------: | :----------------------------------------------------------: |
| ![img](https://hijiangtao.github.io/assets/in-post/2018-04-17-Docker-in-Action-2.png) | ![img](assets/2018-04-17-Docker-in-Action-1-20181018183549564.png) |
|                                                              |                                                              |



### docker 和 虚拟机的区别

** Docker 属于 Linux 容器的一种封装，提供简单易用的容器使用接口。** 它是目前最流行的 Linux 容器解决方案。

​	Docker 将应用程序与该程序的依赖，打包在一个文件里面。运行这个文件，就会生成一个虚拟容器。程序在这个虚拟容器里运行，就好像在真实的物理机上运行一样。有了 Docker，就不用担心环境问题。

### 镜像

​	** Docker 把应用程序及其依赖，打包在 image 文件里面。** 只有通过这个文件，才能生成 Docker 容器`提供容器运行时所需的程序、库、资源、配置等文件外，还包含了一些为运行时准备的一些配置参数（如匿名卷、环境变量、用户等）。镜像不包含任何动态数据，其内容在构建之后也不会被改变。`。image 文件可以看作是容器的模板。Docker 根据 image 文件生成容器的实例。同一个 image 文件，可以生成多个同时运行的容器实例

### 容器

​	** image 文件生成的容器实例，本身也是一个文件，称为容器文件。** 也就是说，一旦容器生成，就会同时存在两个文件： image 文件和容器文件。而且关闭容器并不会删除容器文件，只是容器停止运行而已。

​	容器的实质是进程，但与直接在宿主执行的进程不同，容器进程运行于属于自己的独立的命名空间容器可以被。创建、启动、停止、删除和暂停等等，说到镜像与容器之间的关系，可以类比面向对象程序设计中的类和实例。

    每一个容器运行时，是以镜像为基础层，在其上创建一个当前容器的存储层，我们可以称这个为容器运行时读写而准备的存储层为容器存储层。容器存储层的生存周期和容器一样，容器消亡时，容器存储层也随之消亡。因此，任何保存于容器存储层的信息都会随容器删除而丢失。

### 仓库

​	镜像创建以后存储的地方

## docker安装

```
卸载老的docker
sudo yum remove docker \
              docker-client \
              docker-client-latest \
              docker-common \
              docker-latest \
              docker-latest-logrotate \
              docker-logrotate \
              docker-selinux \
              docker-engine-selinux \
              docker-engine

安装依赖
sudo yum install -y yum-utils device-mapper-persistent-data lvm2

修改源
sudo yum-config-manager \
    --add-repo \
    https://mirrors.ustc.edu.cn/docker-ce/linux/centos/docker-ce.repo
sudo yum makecache fast

安装
yum install docker-ce
```

### 安装错误

![docker安装错误](http://img.hdphp.cc/ba77dfb93f6f1a6a8c6c225b81e9c151.png)

#### 处理

```
yum remove docker-ce

删除 /var 和 /usr下对应的文件

yum update

重启再次安装

```

## 镜像

### 拉去镜像

```
docker pull [选项] [Docker Registry 地址[:端口号]/]仓库名[:标签]

Docker 镜像仓库地址：地址的格式一般是 <域名/IP>[:端口号]。默认地址是 Docker Hub。

仓库名：如之前所说，这里的仓库名是两段式名称，即 <用户名>/<软件名>。对于 Docker Hub，如果不给出用户名，则默认为 library，也就是官方镜像。

```

示例

![pll 例子](http://img.hdphp.cc/22202862fc43b40a10b18c2325ffe0ed.png)

因为镜像是分层存储的，因此下载的时候是逐层下载

### 启动并运行一个容器

```
docker run -it --rm \
   ubuntu:16.04 \
   bash

```
docker run 就是运行容器的命令，具体格式我们会在 容器 一节进行详细讲解，我们这里简要的说明一下上面用到的参数。

* ** -it ** ：这是两个参数，一个是 -i：交互式操作，一个是 -t 终端。我们这里打算进入 bash 执行一些命令并查看返回结果，因此我们需要交互式终端。

* ** --rm ** ：这个参数是说容器退出后随之将其删除。默认情况下，为了排障需求，退出的容器并不会立即删除，除非手动 docker rm。我们这里只是随便执行个命令，看看结果，不需要排障和保留结果，因此使用 --rm 可以避免浪费空间。
* ubuntu:16.04：这是指用 ubuntu:16.04 镜像为基础来启动容器。
* bash：放在镜像名后的是命令，这里我们希望有个交互式 Shell，因此用的是 bash。

### 镜像列表

```
docker image ls

列表中的镜像体积总和并非是所有镜像实际硬盘消耗。由于 Docker 镜像是多层存储结构，并且可以继承、复用，因此不同镜像可能会因为使用相同的基础镜像，从而拥有共同的层。

查看镜像和数据卷轴占用的空间
docker system df

查看虚悬镜像（因为升级没有用的镜像，名称 和 标签 为 null）
docker image ls -f dangling=true
删除所有虚悬镜像
docker image prune

查看在ubuntu 之后/之前的镜像
docker image ls -f since/before=ubuntu
```
![image list](http://img.hdphp.cc/98a85bcd8ce6d221a269977d493444bc.png)

### 删除镜像

```

docker image rm centos
docker image rm tagid

强制删除
docker image rm -f tagid


删除所有仓库名为 redis 的镜像
docker image rm $(docker image ls -q redis)


删除所有在 mongo:3.2 之前的镜像：
ocker image rm $(docker image ls -q -f before=mongo:3.2)
```

### 进入容器

```
docker run --name webserver -d -p 80:80 nginx

进入容器
docker exec -it webserver bash
```

### 制作镜像案例 Dockerfile

Dockerfile 是一个文本文件，其内包含了一条条的指令(Instruction)，每一条指令构建一层，因此每一条指令的内容，就是描述该层应当如何构建

```
mkdir mynginx
cd mynginx
touch Dockerfile
    内容
    FROM nginx
    RUN echo '<h1>Hello, Docker!</h1>' > /usr/share/nginx/html/index.html

docker build -t nginx:v3 .

最终镜像的名称 -t nginx:v

最后的点只构建的上下文，在构建过程取寻找你基础路径；一般创建空的目录，去创建 Dockerfile 文件，然后讲需要的文件复制到当前目录下面
```

#### 构建文件下命令

##### From

```
选择基础镜像
FROM nginx

选择空白镜像
FROM scratch
```

##### RUN

RUN ["可执行文件", "参数1", "参数2"]
每个命令都是新建一层，AUFS，曾经是最大不得超过 42 层，现在是不得超过 127 层。

```
将多层镜像合并成一层
RUN buildDeps='gcc libc6-dev make' \
    && apt-get update


错误案例：

RUN cd /app
RUN echo "hello" > world.txt
并不会向 /app/world.txt 写入数据

原因
第一层 RUN cd /app 的执行仅仅是当前进程的工作目录变更，一个内存上的变化而已，其结果不会造成任何文件变更。而到第二层的时候，启动的是一个全新的容器，跟第一层的容器更完全没关系，自然不可能继承前一层构建过程中的内存变化。
```

##### COPY

COPY 指令，源文件的各种元数据都会保留。比如读、写、执行权限、文件变更时间等。这个特性对于镜像定制很有用。

```
COPY package.json /usr/src/app/
COPY hom* /mydir/
COPY hom?.txt /mydir/
COPY --chown=55:mygroup files* /mydir/
```


##### ADD

copy 的升级版，但是镜像构建缓存失效，从而可能会令镜像构建变得比较缓慢。文件复制均使用 COPY 指令，仅在需要自动解压缩的场合使用 ADD

```
讲文件下载并解压到home目录下面
ADD ubuntu-xenial-core-cloudimg-amd64-root.tar.gz /home
ADD --chown=10:11 files* /mydir/
```

##### CMD ，ENTRYPOINT 容器启动命令


##### ENV

定于环境变量

```
ENV NODE_VERSION 7.2.0
RUN curl -SLO "https://nodejs.org/dist/v$NODE_VERSION/node-v$NODE_VERSION-linux-x64.tar.xz"
```

##### WORKDIR 指定工作目录


##### WORKDIR 指定工作目录

##### USER 指定当前用户

```
RUN groupadd -r redis && useradd -r -g redis redis
USER redis
RUN [ "redis-server" ]


# 建立 redis 用户，并使用 gosu 换另一个用户执行命令
RUN groupadd -r redis && useradd -r -g redis redis
# 下载 gosu
RUN wget -O /usr/local/bin/gosu "https://github.com/tianon/gosu/releases/download/1.7/gosu-amd64" \
    && chmod +x /usr/local/bin/gosu \
    && gosu nobody true
# 设置 CMD，并以另外的用户执行
CMD [ "exec", "gosu", "redis", "redis-server" ]
```

##### HEALTHCHECK 健康检查


##### ONBUILD 当前镜像不执行，当已当前镜像为基础取建立镜像的时候才去执行


## 容器

### 启动

docker run

执行的步骤

1. 检查本地是否存在指定的镜像，不存在就从公有仓库下载
2. 利用镜像创建并启动一个容器
3. 分配一个文件系统，并在只读的镜像层外面挂载一层可读写层
4. 从宿主主机配置的网桥接口中桥接一个虚拟接口到容器中去
5. 从地址池配置一个 ip 地址给容器
6. 执行用户指定的应用程序
7. 执行完毕后容器被终止

### 命令

```
显示容器列表
docker container ls

删除容器
docker container rm  nginxvim

清空不在运行的容器
docker container prune

```

### 查看映射端口配置

docker port webserver1 80


### 查看运行时的log

 docker logs -f webserver1

![port 映射](http://img.hdphp.cc/40c8232af392e9c4e5d7c3e3308a6aa5.png)




### 学习地址
[书籍](https://yeasy.gitbooks.io/docker_practice/content/image/list.html)
[命令](https://blog.csphere.cn/archives/22)
