## 概述

### docker 是什么

docker 是一个开源平台，支持开发人员`构建、部署、运行、更新和管理`容器

这些容器是标准化的可执行组件，结合了应用源代码以及在任何环境中运行该代码所需的操作系统（os）库和依赖项

### docker 能做什么

#### 虚拟机技术

通过`软件`模拟的具有完整`硬件`系统功能的、运行在一个`完全隔离`的环境中的完整计算机系统

#### 虚拟机缺点

1. 资源占用多
2. 冗余步骤多
3. 启动慢

#### docker 和虚拟机区别

1. 传统的虚拟机，可以虚拟出一条硬件，运行一个完整的操作系统，在这个操作系统上安装和运行所需的软件
2. 容器内的应用可以直接运行在`宿主主机的内核`中，容器没有自己的内核，也不用虚拟硬件（`轻便`）
3. 每个容器是相互隔离的，每个容器内都有自己的文件系统，之间互不影响

#### 容器化技术

模拟的不是一个完整的操作系统

1. 应用于更快速的交付和部署

   1. 传统：通过大量的帮助文档，安装程序
   2. docker：打包镜像发布测试，一键运行

2. 更便捷的升级和扩缩容

   通过使用 docker，部署应用如同搭积木一样

3. 更简单的系统运维

   通过使用 docker，开发和测试环境是高度一致的

4. 更高效的计算资源利用

   docker 是内核级别的虚拟化，可以在一个物理机上运行很多的容器，让服务器的性能可以压榨到极致

#### 容器工作原理

容器是通过`linux内核`中内置的`过程隔离和虚拟化`功能来实现的

#### 容器架构

![容器架构](https://i-blog.csdnimg.cn/blog_migrate/248f02d5aed04fd53897eb532f639f76.png)

### 基本概念

1. 镜像（Image）

   相当于是一个 root 文件系统，比如官方镜像`ubuntu16.04`就包含了完整的一套`ubuntu16.04`最小系统的 root 文件系统

   通过这个镜像可以创建多个容器（最终服务运行或者项目运行就是在容器中）

2. 容器（container）

   docker 利用容器技术，独立运行一个或者一组应用，通过镜像来创建

   目前可以把这个容器理解为就是一个建议的 linux 系统

3. 仓库（repository）

   仓库就是存放镜像的地方，分为公有仓库和私有仓库

## 安装

### windows

1. 下载
   <https://docs.docker.com/desktop/install/windows-install/#install-docker-desktop-on-windows>

2. 启动`Microsoft Hyper-V`和其他配置

   > 控制面板 => 程序 => 启动或关闭 windows 功能

   勾选如下几个配置

   1. Hyper-V
   2. Windows 虚拟机监控程序平台
   3. 适用于 Linux 的 windows 子系统
   4. 虚拟机平台

   > 如果没有 Hyper-V 怎么办
   >
   > https://www.abackup.com/enterprise-backup/win11-cannot-find-hyper-v-6540.html

3. 执行下载的安装包

   1. 安装完成之后会提示需要重新注销登录 windows 账户
   2. 然后选配置的时候，直接选择第一个`Use recommended settings (requires administrator password)`通用配置即可

4. 启动之后可能会提示`Docker Desktop - WSL update failed`

   打开`cmd`执行`wsl --update`更新`wsl`的版本，然后重新启动`docker desktop`

5. 汉化

   <https://github.com/asxez/DockerDesktop-CN>

6. 命令行测试

   > docker -v

### mac 安装 docker

1. 如果没有安装 homebrew 要先安装

   > /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"

2. > brew install --cask --appdir=/Applications docker

3. 然后在应用程序中就可以看到 docker 应用了

4. 查看是否安装成功

   > docker --version

### mac 卸载 docker

```
## 1）进入docker的安装目录
cd /usr/local/bin/

## 2）删除与docker相关的文件夹
sudo rm -rf docker*
sudo rm -rf com.docker.*
sudo rm -rf hub-tool*
sudo rm -rf kube*
sudo rm -rf vpnkit*
```

### linux 安装 docker

> https://blog.csdn.net/weixin_43977692/article/details/127492590

### docker 删除镜像、容器

> https://blog.csdn.net/u014282578/article/details/127866389

## 起步 demo

### hello wrold

> docker pull hello-world

```shell
Using default tag: latest
latest: Pulling from library/hello-world
c1ec31eb5944: Pull complete
Digest: sha256:1408fec50309afee38f3535383f5b09419e6dc0925bc69891e79d84cc4cdcec6
Status: Downloaded newer image for hello-world:latest
docker.io/library/hello-world:latest

What's next:
    View a summary of image vulnerabilities and recommendations → docker scout quickview hello-world
```

查看是否拉取成功

> docker images

```shell
REPOSITORY    TAG       IMAGE ID       CREATED         SIZE
hello-world   latest    d2c94e258dcb   15 months ago   13.3kB
```

## 配置阿里云镜像加速

1. 登录官网：镜像加速器

   <https://cr.console.aliyun.com/cn-hangzhou/instances/mirrors>

2. 找到`windows`选项，按照教程即可（其他系统同理）

3. 注意，如果是中文的话，配置地址是`设置 => docker引擎（从上往下数第三个）`，然后把`"registry-mirrors": ["https://ucfqyvm9.mirror.aliyuncs.com"]`加入到对象中即可，`而不是替换`

## 常用命令

```shell
# 查看镜像
docker images

# 删除镜像
docker rmi xx.image

# 清理本地docker镜像
# 强制清理不再被使用的镜像
# 1. 没有被任何容器所使用的镜像
# 2. 所有标签都是none的镜像
docker image prune -f

# 启动容器
# -it 允许与容器的标准输入进行交互，并分配一个伪终端
# --rm 容器退出后自动删除
# --entrypoint /bin/bash 设置容器入口点为 /bin/bash，这样当容器启动时会直接进入交互式的bash shell
docker run -it mysql /bin/bash
docker run -it --rm -entrypoint /bin/bash 镜像名
```
