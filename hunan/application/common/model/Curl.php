<?php

namespace app\common\model;

/**
* Curl类
* curl_init() 初始化cURL会话
*
* curl_exec() 执行cUrl会话
*/
class Curl{
    protected $ch;
    function __construct(argument){
        $this->ch = curl_init();
        curl_copy_handle($ch); //复制一个cURL句柄和它的所有选项
        curl_errno(); 返回最后一次的错误代码
        curl_error($ch);　//返回当前会话最后一次错误的字符串
        curl_close($ch)
    }
    public function setopt(){

    }
    public function exec(){
        $options = array(
        /* bool类型 */
            CURLOPT_AUTOREFERER             => ,  // TRUE 时将根据 Location: 重定向时，自动设置 header 中的Referer:信息。
            CURLOPT_COOKIESESSION           => ,  // 设为 TRUE 时将开启新的一次 cookie 会话。它将强制 libcurl 忽略之前会话时存的其他 cookie。 libcurl 在默认状况下无论是否为会话，都会储存、加载所有 cookie。会话 cookie 是指没有过期时间，只存活在会话之中。
            CURLOPT_CERTINFO                => ,  // TRUE 将在安全传输时输出 SSL 证书信息到 STDERR。（在 cURL 7.19.1 中添加。 PHP 5.3.2 后有效。 需要开启 CURLOPT_VERBOSE 才有效。）
            CURLOPT_CONNECT_ONLY            => ,  // TRUE 将让库执行所有需要的代理、验证、连接过程，但不传输数据。此选项用于 HTTP、SMTP 和 POP3。（在 7.15.2 中添加。 PHP 5.5.0 起有效。）
            CURLOPT_CRLF                    => ,  // 启用时将Unix的换行符转换成回车换行符。
            CURLOPT_DNS_USE_GLOBAL_CACHE    => ,  // TRUE 会启用一个全局的DNS缓存。此选项非线程安全的，默认已开启。
            CURLOPT_FAILONERROR             => ,  // 当 HTTP 状态码大于等于 400，TRUE 将将显示错误详情。 默认情况下将返回页面，忽略 HTTP 代码。
            CURLOPT_SSL_FALSESTART          => ,  // TRUE 开启 TLS False Start （一种 TLS 握手优化方式）(cURL 7.42.0 中添加。自 PHP 7.0.7 起有效。)
            CURLOPT_FILETIME                => ,  // TRUE 时，会尝试获取远程文档中的修改时间信息。 信息可通过curl_getinfo()函数的CURLINFO_FILETIME 选项获取。
            CURLOPT_FOLLOWLOCATION          => ,  // TRUE 时将会根据服务器返回 HTTP 头中的 "Location: " 重定向。（注意：这是递归的，"Location: " 发送几次就重定向几次，除非设置了 CURLOPT_MAXREDIRS，限制最大重定向次数。）。
            CURLOPT_FORBID_REUSE            => ,  // TRUE 在完成交互以后强制明确的断开连接，不能在连接池中重用。
            CURLOPT_FRESH_CONNECT           => ,  // TRUE 强制获取一个新的连接，而不是缓存中的连接。
            CURLOPT_FTP_USE_EPRT            => ,  // TRUE 时，当 FTP 下载时，使用 EPRT (和 LPRT)命令。 设置为 FALSE 时禁用 EPRT 和 LPRT，仅仅使用PORT 命令。
            CURLOPT_FTP_USE_EPSV            => ,  // TRUE 时，在FTP传输过程中，回到 PASV 模式前，先尝试 EPSV 命令。设置为 FALSE 时禁用 EPSV。
            CURLOPT_FTP_CREATE_MISSING_DIRS => ,  // TRUE 时，当 ftp 操作不存在的目录时将创建它。
            CURLOPT_FTPAPPEND               => ,  // TRUE 为追加写入文件，而不是覆盖。
            CURLOPT_TCP_NODELAY             => ,  // TRUE 时禁用 TCP 的 Nagle 算法，就是减少网络上的小包数量。(PHP 5.2.1 有效，编译时需要 libcurl 7.11.2 及以上。)
            CURLOPT_FTPLISTONLY             => ,  // TRUE 时只列出 FTP 目录的名字。
            CURLOPT_HEADER                  => ,  // 启用时会将头文件的信息作为数据流输出。
            CURLINFO_HEADER_OUT             => ,  // TRUE 时追踪句柄的请求字符串。(从 PHP 5.1.3 开始可用。CURLINFO_ 的前缀是有意的(intentional)。)
            CURLOPT_HTTPGET                 => ,  // TRUE 时会设置 HTTP 的 method 为 GET，由于默认是 GET，所以只有 method 被修改时才需要这个选项。
            CURLOPT_HTTPPROXYTUNNEL         => ,  // TRUE 会通过指定的 HTTP 代理来传输。
            CURLOPT_NETRC                   => ,  // TRUE 时，在连接建立时，访问~/.netrc文件获取用户名和密码来连接远程站点。
            CURLOPT_NOBODY                  => ,  // TRUE 时将不输出 BODY 部分。同时 Mehtod 变成了 HEAD。修改为 FALSE 时不会变成 GET。
            CURLOPT_NOPROGRESS              => ,  // TRUE 时关闭 cURL 的传输进度。(PHP 默认自动设置此选项为 TRUE，只有为了调试才需要改变设置。)
            CURLOPT_NOSIGNAL                => ,  // TRUE 时忽略所有的 cURL 传递给 PHP 进行的信号。在 SAPI 多线程传输时此项被默认启用，所以超时选项仍能使用。
            CURLOPT_POST                    => ,  // TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。
            CURLOPT_PUT                     => ,  // TRUE 时允许 HTTP 发送文件。要被 PUT 的文件必须在 CURLOPT_INFILE和CURLOPT_INFILESIZE 中设置。
            CURLOPT_RETURNTRANSFER          => ,  // TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。
            CURLOPT_SSL_VERIFYPEER          => ,  // FALSE 禁止 cURL 验证对等证书（peer's certificate）。要验证的交换证书可以在 CURLOPT_CAINFO 选项中设置，或在 CURLOPT_CAPATH中设置证书目录。
            CURLOPT_TRANSFERTEXT            => ,  // TRUE 对 FTP 传输使用 ASCII 模式。对于LDAP，它检索纯文本信息而非 HTML。在 Windows 系统上，系统不会把 STDOUT 设置成二进制 模式。
            CURLOPT_UNRESTRICTED_AUTH       => ,  // TRUE 在使用CURLOPT_FOLLOWLOCATION重定向 header 中的多个 location 时继续发送用户名和密码信息，哪怕主机名已改变。
            CURLOPT_UPLOAD                  => ,  // TRUE 准备上传。
            CURLOPT_VERBOSE                 => ,  // TRUE 会输出所有的信息，写入到STDERR，或在CURLOPT_STDERR中指定的文件。
        /* integer */
            CURLOPT_BUFFERSIZE              => ,  // 每次读入的缓冲的尺寸。当然不保证每次都会完全填满这个尺寸。
            CURLOPT_CONNECTTIMEOUT          => ,  // 在尝试连接时等待的秒数。设置为0，则无限等待。
            CURLOPT_CONNECTTIMEOUT_MS       => ,  // 尝试连接等待的时间，以毫秒为单位。设置为0，则无限等待。 如果 libcurl 编译时使用系统标准的名称解析器（ standard system name resolver），那部分的连接仍旧使用以秒计的超时解决方案，最小超时时间还是一秒钟。
            CURLOPT_DNS_CACHE_TIMEOUT       => ,  // 设置在内存中缓存 DNS 的时间，默认为120秒（两分钟）。
            CURLOPT_FTPSSLAUTH              => ,  // FTP验证方式（启用的时候）：CURLFTPAUTH_SSL (首先尝试SSL)，CURLFTPAUTH_TLS (首先尝试TLS)或CURLFTPAUTH_DEFAULT (让cURL 自个儿决定)。
            CURLOPT_HTTP_VERSION            => ,  // CURL_HTTP_VERSION_NONE (默认值，让 cURL 自己判断使用哪个版本)，CURL_HTTP_VERSION_1_0 (强制使用 HTTP/1.0)或CURL_HTTP_VERSION_1_1 (强制使用 HTTP/1.1)。
            CURLOPT_INFILESIZE              => ,  // 希望传给远程站点的文件尺寸，字节(byte)为单位。 注意无法用这个选项阻止 libcurl 发送更多的数据，确切发送什么取决于 CURLOPT_READFUNCTION。
            CURLOPT_LOW_SPEED_LIMIT         => ,  // 传输速度，每秒字节（bytes）数，根据CURLOPT_LOW_SPEED_TIME秒数统计是否因太慢而取消传输。
            CURLOPT_LOW_SPEED_TIME          => ,  // 当传输速度小于CURLOPT_LOW_SPEED_LIMIT时(bytes/sec)，PHP会判断是否因太慢而取消传输。
            CURLOPT_MAXCONNECTS             => ,  // 允许的最大连接数量。达到限制时，会通过CURLOPT_CLOSEPOLICY决定应该关闭哪些连接。
            CURLOPT_MAXREDIRS               => ,  // 指定最多的 HTTP 重定向次数，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
            CURLOPT_PORT                    => ,  // 用来指定连接端口。
            CURLOPT_POSTREDIR               => ,  // 位掩码， 1 (301 永久重定向), 2 (302 Found) 和 4 (303 See Other) 设置 CURLOPT_FOLLOWLOCATION 时，什么情况下需要再次 HTTP POST 到重定向网址。
            CURLOPT_PROXYAUTH               => ,  // HTTP 代理连接的验证方式。使用在CURLOPT_HTTPAUTH中的位掩码。 当前仅仅支持 CURLAUTH_BASIC和CURLAUTH_NTLM。
            CURLOPT_PROXYPORT               => ,  // 代理服务器的端口。端口也可以在CURLOPT_PROXY中设置。
            CURLOPT_PROXYTYPE               => ,  // 可以是 CURLPROXY_HTTP (默认值) CURLPROXY_SOCKS4、 CURLPROXY_SOCKS5、 CURLPROXY_SOCKS4A 或 CURLPROXY_SOCKS5_HOSTNAME。
            CURLOPT_RESUME_FROM             => ,  // 在恢复传输时，传递字节为单位的偏移量（用来断点续传）。
            CURLOPT_TIMECONDITION           => ,  // 设置如何对待 CURLOPT_TIMEVALUE。 使用 CURL_TIMECOND_IFMODSINCE，仅在页面 CURLOPT_TIMEVALUE 之后修改，才返回页面。没有修改则返回 "304 Not Modified" 头，假设设置了 CURLOPT_HEADER 为 TRUE。CURL_TIMECOND_IFUNMODSINCE则起相反的效果。 默认为 CURL_TIMECOND_IFMODSINCE。
            CURLOPT_TIMEOUT                 => ,  // 允许 cURL 函数执行的最长秒数。
            CURLOPT_TIMEOUT_MS              => ,  // 设置cURL允许执行的最长毫秒数。 如果 libcurl 编译时使用系统标准的名称解析器（ standard system name resolver），那部分的连接仍旧使用以秒计的超时解决方案，最小超时时间还是一秒钟。
            CURLOPT_TIMEVALUE               => ,  // 秒数，从 1970年1月1日开始。这个时间会被 CURLOPT_TIMECONDITION使。默认使用CURL_TIMECOND_IFMODSINCE。
            CURLOPT_MAX_RECV_SPEED_LARGE    => ,  // 如果下载速度超过了此速度(以每秒字节数来统计)，即传输过程中累计的平均数，传输就会降速到这个参数的值。默认不限速。
            CURLOPT_MAX_SEND_SPEED_LARGE    => ,  // 如果上传速度超过了此速度(以每秒字节数来统计)，即传输过程中累计的平均数，传输就会降速到这个参数的值。默认不限速。
            CURLOPT_IPRESOLVE               => ,  // 允许程序选择想要解析的 IP 地址类别。只有在地址有多种 ip 类别的时候才能用，可以的值有： CURL_IPRESOLVE_WHATEVER、 CURL_IPRESOLVE_V4、 CURL_IPRESOLVE_V6，默认是 CURL_IPRESOLVE_WHATEVER。
            CURLOPT_FTP_FILEMETHOD          => ,  // 告诉 curl 使用哪种方式来获取 FTP(s) 服务器上的文件。可能的值有： CURLFTPMETHOD_MULTICWD、 CURLFTPMETHOD_NOCWD 和 CURLFTPMETHOD_SINGLECWD。
        /* string */
            CURLOPT_CAINFO                  => ,  // 一个保存着1个或多个用来让服务端验证的证书的文件名。这个参数仅仅在和CURLOPT_SSL_VERIFYPEER一起使用时才有意义。(可能需要绝对路径。)
            CURLOPT_CAPATH                  => ,  // 一个保存着多个CA证书的目录。这个选项是和CURLOPT_SSL_VERIFYPEER一起使用的。
            CURLOPT_COOKIE                  => ,  // 设定 HTTP 请求中"Cookie: "部分的内容。多个 cookie 用分号分隔，分号后带一个空格(例如， "fruit=apple; colour=red")。
            CURLOPT_COOKIEFILE              => ,  // 包含 cookie 数据的文件名，cookie 文件的格式可以是 Netscape 格式，或者只是纯 HTTP 头部风格，存入文件。如果文件名是空的，不会加载 cookie，但 cookie 的处理仍旧启用。
            CURLOPT_COOKIEJAR               => ,  // 连接结束后，比如，调用 curl_close 后，保存 cookie 信息的文件。
            CURLOPT_EGDSOCKET               => ,  // 类似CURLOPT_RANDOM_FILE，除了一个Entropy Gathering Daemon套接字。
            CURLOPT_ENCODING                => ,  // HTTP请求头中"Accept-Encoding: "的值。 这使得能够解码响应的内容。 支持的编码有"identity"，"deflate"和"gzip"。如果为空字符串""，会发送所有支持的编码类型。
            CURLOPT_FTPPORT                 => ,  // 这个值将被用来获取供FTP"PORT"指令所需要的IP地址。 "PORT" 指令告诉远程服务器连接到我们指定的IP地址。这个字符串可以是纯文本的IP地址、主机名、一个网络接口名（UNIX下）或者只是一个'-'来使用默认的 IP 地址。
            CURLOPT_INTERFACE               => ,  // 发送的网络接口（interface），可以是一个接口名、IP 地址或者是一个主机名。
            CURLOPT_KEYPASSWD               => ,  // 使用 CURLOPT_SSLKEY 或 CURLOPT_SSH_PRIVATE_KEYFILE 私钥时候的密码。
            CURLOPT_KRB4LEVEL               => ,  // KRB4 (Kerberos 4) 安全级别。下面的任何值都是有效的(从低到高的顺序)："clear"、"safe"、"confidential"、"private".。如果字符串以上这些，将使用"private"。 这个选项设置为 NULL 时将禁用 KRB4 安全认证。目前 KRB4 安全认证只能用于 FTP 传输。
            CURLOPT_POSTFIELDS              => ,  // 全部数据使用HTTP协议中的 "POST" 操作来发送。 要发送文件，在文件名前面加上@前缀并使用完整路径。 文件类型可在文件名后以 ';type=mimetype' 的格式指定。 这个参数可以是 urlencoded 后的字符串，类似'para1=val1&para2=val2&...'，也可以使用一个以字段名为键值，字段数据为值的数组。 如果value是一个数组，Content-Type头将会被设置成multipart/form-data。 从 PHP 5.2.0 开始，使用 @ 前缀传递文件时，value 必须是个数组。 从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 CURLFile 发送。 设置 CURLOPT_SAFE_UPLOAD 为 TRUE 可禁用 @ 前缀发送文件，以增加安全性。
            CURLOPT_PROXY                   => ,  // HTTP 代理通道。
            
        );
        curl_setopt_array($ch, $options)
    }
    function __destruct(){
        curl_close($this->ch);
    }
}