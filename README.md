# leaf-loger



## leaf-loger是一个遵循PSR-3规范的，相对轻量级的日志组件。

### 特点：

1. 使用composer包，便于集成到基于composer的项目中。
2. 遵循psr-3标准规范。所以，使用leaf-loger替换现有系统的日志组件是非常简单的。
3. 支持多个handler。写入日志的时候，可以指定不仅仅一个日志处理器。比如你需要将error级别的记录日志到文件的同时，还要触发短信报警。



## 引入leaf-loger

### 引入有2种方式：

1、基于composer的项目的引入方式：

``` 
composer require leaf/leaf-loger
```

2、非composer项目引入方式：

``` 
\Leaf\Loger\Autoloader::register();
```



## leaf-loger的基本使用

leaf-loger的核心理念是：有一个log manager。你可以向log manager中注册多个日志处理器，比如：handlerFile，用于记录文件日志。你还可以再注册进去一个 handlerMail，用于当记录error级别的日志的时候，发送报警邮件等。当然，你还可以自己定制化handler，注册到log manager中。leaf-loger默认仅仅提供了文件处理器。

首先：实例化一个日志控制器。

``` 
$loger = new \Leaf\Loger\Loger。
```

然后，实例化一个日志处理器，这里以文件处理器为例：

``` 
$handlerFile = new \Leaf\Loger\Handler\HandlerFile();
```

当然，既然是存储文件，你可能需要指定文件的存储路径，存储路径只有文件处理器需要。（倘若你自己写了日志处理器是短信日志处理器，那么设置路径的方法就没有必须要了）

``` 
$handlerFile->setLogFile($path);
```

接下来，我们将日志处理器注册到日志控制器中。这样的目的是，当触发日志控制器的记录操作的时候，系统会通过文件处理器完成记录操作。

``` 
$loger->addHandler('file',$fileHandler);
```

最后，我们可以这样记录日志。

``` 
$loger->info("this is a test string");
```

**集成方式**

> 上面的例子，是基本的使用方式。在你的项目中，你很可能不会每次都实例化日志记录器才能记录日志。而是
> 
> 1、通过注册树模式，将日志记录器注册到全局树上。
> 
> 2、或者是注册到项目的容器中。
> 
> 3、注册到项目application的静态方法中，以Yii2为例：Yii::info()。

leaf-loger提供了一个logDriver，你可以参考其实现，将leaf-loger融入到你的项目中：

``` 
leaf-loger/src/Example/LogDriver.php
```



## 日志记录级别说明：

你可以选择的记录日志级别有8个。

**EMERGENCY**

> 系统不可用。

``` 
$loger->emergency('emergency message string');
```

**ALERT**

> **必须**立刻采取行动
> 
> 例如：在整个网站都垮掉了、数据库不可用了或者其他的情况下，**应该**发送一条警报短信把你叫醒。

``` 
$loger->alert("alert message string");
```

**CRITICAL**

> 紧急情况
> 
> 例如：程序组件不可用或者出现非预期的异常。

``` 
$loger->critical('critical message string');
```

**ERROR**

> 运行时出现的错误，不需要立刻采取行动，但必须记录下来以备检测。

``` 
$loger->error('error message string');
```

**WARNING**

> 出现非错误性的异常
> 
> 例如：使用了被弃用的API、错误地使用了API或者非预想的不必要错误。

``` 
$loger->warning('warning message string');
```

**NOTICE**

> 一般性重要的事件

``` 
$loger->notice('notice messsage string');
```

**INFO**

> 一般事件
> 
> 例如：用户登录和SQL记录。

``` 
$loger->info("sql...");
```

**DEBUG**

> 调试详情
> 
> 例如：某个断点的内存占用、执行时间等等。

``` 
$loger->debug('debug message string');
```



## 计划内容：

- 自由设置文件处理器实时触发IO写log，或者php请求生命周期结束的时候才写log。
- 文件处理器的日志分割。
- 日志记录的级别限定。比如限定为warning写log，那么info、notice级别的记录不生效。