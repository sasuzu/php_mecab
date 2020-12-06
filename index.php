<?php
   require_once "./MeCab.php";

   use \Sasuzu\MeCab\Models\MeCab;

   $mecab = new MeCab();
   $result = $mecab->parse("桜が咲いたら約束の場所で");

   print_r($result);