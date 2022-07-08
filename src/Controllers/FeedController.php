<?php

namespace AporteWeb\Dashboard\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class FeedController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    public function getInstagramPublicFeed($account) {
        $url = 'https://www.instagram.com/'.$account.'/?__a=1';
        $csrftoken = 'sacar del navegador';
        $sessionid = 'sacar del navegador';
        $cookies = 'ig_cb=1; csrftoken='.$csrftoken.'; sessionid='.$sessionid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $result = $result['graphql']['user']['edge_owner_to_timeline_media']['edges'];
        $result = array_slice($result, 0, 10);
        $result = array_reverse($result);
        $images = [];
        foreach ($result as $key => $value) {
            $images[] = [
                'account' => $account,
                'image' => $value['node']['display_url'],
                'caption' => $value['node']['edge_media_to_caption']['edges'][0]['node']['text'],
                'date' => $value['node']['taken_at_timestamp'],
                'likes' => $value['node']['edge_liked_by']['count'],
                'comments' => $value['node']['edge_media_to_comment']['count'],
                'link' => $value['node']['shortcode'],
                'link_full' => 'https://www.instagram.com/p/'.$value['node']['shortcode'].'/',
            ];
        }
        return $images;
    }
    public function getInstagramFeedByAccount(Type $var = null){
        return $this->getInstagramPublicFeed('igtgraphics');
    }

}