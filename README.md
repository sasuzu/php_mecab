# MeCab / PHP Library
形態素解析エンジン[MeCab](https://taku910.github.io/mecab/)をphpライブラリなしで実行できる形式にしたもの

MeCab-PHP連携のものは存在するが、ユーザー辞書に新しい項目を追加しても対応できるものがなかったので

自分用に取得結果を訂正した

## 利用方法
composerの場合は実行環境にMeCabをインストールして下さい

```
vi composer.json
composer install
```
composer.json

```
{
    "repositories": {
         "sasuzu/php_mecab": {
             "type": "vcs",
             "url": "https://github.com/sasuzu/php_mecab"
         }
     },
     "require": {
          "sasuzu/php_mecab": "vX.X.X"
      }
}
```
## 環境
```
Linux
PHP 7.4.*
```
## サンプル
```
<?php
   require_once "./vendor/autoload.php";

   use \Sasuzu\MeCab\Models\MeCab;

   $mecab = new MeCab();
   $result = $mecab->parse("桜が咲いたら約束の場所で");

   print_r($result);
```

## 取得結果形式

```
[
  {
    "surface":"桜",
    "feature":[
      "名詞",
      "一般",
      "*",
      "*",
      "*",
      "*",
      "桜",
      "サクラ",
      "サクラ"
    ]
  },
  {
     ...
]
```
