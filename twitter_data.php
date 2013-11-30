<?php
/*
 *
 * Iwashita 
 * 記事に関するコメントをTwitterから検索して出力します
 *
 * TwitterAPIv1.1
 * OAuth認証にabraham/twitteroauthを使用しています。
 * https://github.com/abraham/twitteroauth
 *
 */ 

ini_set('error_reporting', E_ALL);ini_set('display_errors', '1');

class twitterSearch
{
    // TwitterAppID取得
    function getTwitterApi($apipath, $parameters = array()) {
        require_once('twitteroauth/twitteroauth.php');

        $consumer_key = '*********************';
        $consumer_secret = '**********************************';
        $access_token = '*******************************';
        $access_token_secret = '*************************';

        $connection = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
        $result = $connection->get($apipath, $parameters);
        return $result;
    }

    // Twitterテキスト置換
    function twitterTextReplace($text) {
        $text = preg_replace("/(https?:\/\/)(?!srash.info)([-_.!~*'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/", "<a href=\"\\1\\2\" target=\"_blank\" rel=\"nofollow\">\\1\\2</a>", $text);
        $text = preg_replace("/(https?:\/\/srash.info)([-_.!~*'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/", "<a href=\"\\2\">\\1\\2</a>", $text);
        $text = preg_replace("/(?<![0-9a-zA-Z'\"#@=:;])@([0-9a-zA-Z_]{1,15})/u", "@<a href=\"http://twitter.com/\\1\">\\1</a>", $text);
        $text = preg_replace("/(?<![0-9a-zA-Z'\"#@=:;])#(\w*[a-zA-Z_])/u", "<a href=\"http://search.twitter.com/search?q=%23\\1\">#\\1</a>", $text);
        return $text;
    }

    //相対時間表示
    function tweetTime($nitiji){
        $tweet_time=strtotime($nitiji);
        $now_time=time();
        $relative_time=$now_time-$tweet_time;//つぶやかれたのが何秒前か
        if($relative_time<60){//ss
            return $time = $relative_time.'秒前';
        }elseif($relative_time>=60 && $relative_time<(60*60)){//mm
            return $time = floor($relative_time/60).'分前';
        }elseif($relative_time>=(60*60) && $relative_time<(60*60*24)){//hh
            return $time = floor($relative_time/(60*60)).'時間前';
        }elseif($relative_time>=(60*60*24)){//日付
            return $time = date('m月d日',$tweet_time);
        }
    }
}

?>