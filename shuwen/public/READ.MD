项目API说明
===========
一、图片获取API
===========
    公共参数

        宽度：number
        高度：number
        坐标：number

### 1. 裁剪
    url: http://域名/uploads/image/92/源文件名称-c_宽度_高度_x坐标_y坐标.后缀名

### 2. 缩略
    url: http://域名/uploads/image/92/源文件名称-t_宽度_高度_类型编号.后缀名

类型编号: number

    1: 等比例缩放
    2: 缩放后填充
    3: 居中裁剪
    4: 左上角裁剪
    5: 右下角裁剪
    6: 固定尺寸缩放

### 3. 翻转
    url: http://域名/uploads/image/92/源文件名称-f_类型编号.后缀名

类型编号: number

    1. X轴翻转
    2. Y轴翻转

### 4. 旋转
    url: http://域名/uploads/image/92/源文件名称-r_旋转角度.后缀名

旋转角度: number


二、docker构建
=============
### 1.安装apache
    方法一、通过 Dockerfile构建
    创建Dockerfile
    首先，创建目录apache,用于存放后面的相关东西。

    mkdir -p  ~/apache/www ~/apache/logs ~/apache/conf
    www目录将映射为apache容器配置的应用程序目录
    logs目录将映射为apache容器的日志目录
    conf目录里的配置文件将映射为apache容器的配置文件

### 2.

### 3.

### 4.