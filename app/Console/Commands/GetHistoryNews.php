<?php
/**
 * Created by PhpStorm.
 * User: ccoo12
 * Date: 2020/4/26
 * Time: 15:41
 */

namespace App\Console\Commands;


use GuzzleHttp\Client;
use Illuminate\Console\Command;

class getHistoryNews extends Command
{
    protected $signature = 'news:get';

    public function handle()
    {
        $regex = '/href=\"([^\"]+)/';
        $imgRegex = '/src=\"([^\"]+)/';
        $aRegex = '/>(.*?)</is';
        $file = file_get_contents(public_path().'/news.html');
        preg_match_all('/<li>(.*?)<\/li>/is', $file, $str, PREG_SET_ORDER);
        $arr = [];
        for ($i=6;$i <= 533;$i++) {dd($str[$i][0]);
            preg_match($regex, $str[$i][0], $url);
            preg_match($imgRegex, $str[$i][0], $img);
            preg_match('/<h3>(.*?)<\/h3>/is', $str[$i][0], $titles);
            preg_match($aRegex, $titles[1], $title);
            preg_match('/<p>(.*?)<\/p>/is', $str[$i][0], $content);
            preg_match('/<em>(.*?)<\/em>/is', $str[$i][0], $time);
            $time = date('Y-m-d H:i:s', strtotime($time[1]));
            $ar['source'] = 2;
            $ar['news_type'] = $i >= 506 ? 1 : 2;
            $ar['title'] = $title[1];
            $ar['content'] = $content[1];
            $ar['img_url'] = $img[1];
            $ar['send_time'] = $time;
            $ar['weburl'] = $url;
            $ar['send_state'] = 1;
            $ar['system_version'] = $i >= 506 ? 'by' : 'cqzgh';
            $arr[$i] = $ar;
            unset($ar);
        }

        $result = DB::table('news')->insert($arr);
        if (!$result) {
            echo '出错';
        }
        $this->info('success');
    }
}