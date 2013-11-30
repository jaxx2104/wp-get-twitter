<?php

class getTest {
  public function get_twitter() {
    require_once('twitter_data.php');
    
    //REST API
    $ur = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    //$ur = 'https://api.twitter.com/1.1/statuses/home_timeline.json';
    
    //SearchAPI
    //$ur = 'https://api.twitter.com/1.1/search/tweets.json';

    $pa = array(
      'count' => '1',//取得数
      //'q' => 'pic.twitter.com',//検索クエリ
      //'lang' => 'ja',//抽出言語
      //'result_type' => 'recent',
      //'include_entities' => 'true',
    );
    $object = new twitterSearch();
    $result = $object->getTwitterApi($ur, $pa);

    /**
    //debug 返ってくるjsonデータを見るとき下をコメントアウトしてください
    echo"<pre>";
    var_dump($result);
    echo"</pre>";
    exit;
     **/

    $html = '';

    foreach ($result as $status) {
      //ID
      $id = $status->id;
      //アカウント名
      $screen_name = $status->user->screen_name;
      //名前
      $name = $status->user->name;
      //本文
      $text = $object->twitterTextReplace($status->text);
      //時間
      $time = $object->tweetTime($status->created_at);

      //$text = preg_replace('/<a href="(.*?)">(.*?)<\/a>/','\\1',$text);
      $text = preg_replace('/<a href="(.*?)">(.*?)<\/a>/','\\1',$text);

      //出力フォーマット
      $title = sprintf('%sのつぶやき',$time);
      $data = sprintf('<p align="center" data-toggle="tooltip" title="" data-original-title="%s"></p>',$text);

    }
    return array($title,$data);
  }





}









?>