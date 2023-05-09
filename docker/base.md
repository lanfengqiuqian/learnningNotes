### mac安装docker

1. 如果没有安装homebrew要先安装

    > /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"

2. > brew install --cask --appdir=/Applications docker

3. 然后在应用程序中就可以看到docker应用了

4. 查看是否安装成功

    > docker --version


### mac卸载docker

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


### linux安装docker

> https://blog.csdn.net/weixin_43977692/article/details/127492590

### docker删除镜像、容器

> https://blog.csdn.net/u014282578/article/details/127866389