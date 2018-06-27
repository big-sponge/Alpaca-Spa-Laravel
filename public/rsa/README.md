# RSA_JS_PHP
RSA_JS_PHP实现js前端加密，php后端解密用户密码

一、openssl命令窗口在bin目录下，使用命令生成的密钥文件默认也是在bin目录下。

二、RSA密钥生成命令

  1、生成RSA私钥
  openssl>genrsa -out rsa_private_key.pem 1024
    得到exponent: 10001

  2、生成modulus:
  openssl>rsa -in rsa_private_key.pem -noout -modulus  

  3、生成RSA公钥
  openssl>rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem

  4、将RSA私钥转换成PKCS8格式（==========java使用===========）
  openssl>pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM -nocrypt

  注意：“>”符号后面的才是需要输入的命令。
