<?php

namespace App\Http\Controllers\admin;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\DomCrawler\Crawler;

class CrawlController extends Controller
{
    protected $WebList = [
                'gibcom'    =>  "http://www.gbicom.cn/search/0/2/all/1/desc/1/0/",
    ];
    //

    public function index(Request $request){


        //        $this->Spider();
//        exit;
//        var_dump($request->route('url'));//获去route中定义的变量

        $seachKey ="淀上水乡";
        echo $url = $this->WebList[$request->route('url')].$seachKey;

//        $curlobj = curl_init();
//        curl_setopt($curlobj,CURLOPT_URL,$url);
//        curl_setopt($curlobj,CURLOPT_RETURNTRANSFER,true);
//        date_default_timezone_set('PRC');
//        curl_setopt($curlobj,CURLOPT_SSL_VERIFYPEER,0);
//        $output = curl_exec($curlobj);
//        curl_close($curlobj);
//        echo $output;
//        exit;

//        $response = file_get_contents($url);
//        //进行XPath页面数据抽取
//        $data    = []; //结构化数据存本数组
//        $crawler = new Crawler();
//        $crawler->addHtmlContent($response);
//        dd($response);
//
//        $data['name'] = $crawler->filterXPath('//*[@class="brand-info"]')->text();
//
//        dd($data);


        //抓取网页
        $client = new Client(['base_uri'=>$url]);

        $res = $client->request('GET');
        echo $res->getStatusCode();

        echo $res->getHeaderLine('content-type');

         $html = $res->getBody()->getContents();
echo "<hr />";
        $crawler = new Crawler($html);
//        $crawler->addHtmlContent($html);
//         $crawler = $crawler->filter('body > p');

//        $a= $crawler->filterXPath('//search-list-trademarks/img')->html();; //头像
//        echo $crawler->filterXPath('//dt[@class="list-img"]')->text();
//        echo $crawler->filterXPath('//dt')->filter('class')->html();
        echo $crawler->filterXPath('//dt[@class="list-img"]')->text();
        dd($crawler->filterXPath('//dt[@class="list-img"]')->text());
//        $crawler->filterXPath(‘//p[@class="样式"]‘)->filter(‘a‘)->attr(‘href‘);
    }

    function Spider()
    {
        //需要爬取的页面
        $url = 'https://movie.douban.com/subject/25812712/?from=showing';

        $response = file_get_contents($url);
        //进行XPath页面数据抽取
        $data    = []; //结构化数据存本数组
        $crawler = new Crawler();
        $crawler->addHtmlContent($response);

        try {
            //电影名称
            //网页结构中用css选择器用id的比较容易写xpath表达式
            $data['name'] = $crawler->filterXPath('//*[@id="content"]/h1/span[1]')->text();
            //电影海报
            $data['cover'] = $crawler->filterXPath('//*[@id="mainpic"]/a/img/@src')->text();
            //导演
            $data['director'] = $crawler->filterXPath('//*[@id="info"]/span[1]/span[2]')->text();
            //多个导演处理成数组
            $data['director'] = explode('/', $data['director']);
            //过滤前后空格
            $data['director'] = array_map('trim', $data['director']);

            //编剧
            $data['cover'] = $crawler->filterXPath('//*[@id="info"]/span[2]/span[2]/a')->text();
            //主演
            $data['mactor'] = $crawler->filterXPath('//*[@id="info"]/span[contains(@class,"actor")]/span[contains(@class,"attrs")]')->text();
            //多个主演处理成数组
            $data['mactor'] = explode('/', $data['mactor']);
            //过滤前后空格
            $data['mactor'] = array_map('trim', $data['mactor']);

            //上映日期
            $data['rdate'] = $crawler->filterXPath('//*[@id="info"]')->text();
            //使用正则进行抽取
            preg_match_all("/(\d{4})-(\d{2})-(\d{2})\(.*?\)/", $data['rdate'], $rdate); //2017-07-07(中国大陆) / 2017-06-14(安锡动画电影节) / 2017-06-30(美国)
            $data['rdate'] = $rdate[0];
            //简介
            //演示使用class选择器的方式
            $data['introduction'] = trim($crawler->filterXPath('//div[contains(@class,"indent")]/span')->text());

            //演员
            //本xpath表达式会得到多个对象结果,用each方法进行遍历
            //each是传入的参数是一个闭包,在闭包中使用外部的变量使用use方法,并使用变量指针
            $crawler->filterXPath('//ul[contains(@class,"celebrities-list from-subject")]/li')->each(function (Crawler $node, $i) use (&$data) {
                $actor['name']   = $node->filterXPath('//div[contains(@class,"info")]/span[contains(@class,"name")]/a')->text(); //名字
                $actor['role']   = $node->filterXPath('//div[contains(@class,"info")]/span[contains(@class,"role")]')->text(); //角色
                $actor['avatar'] = $node->filterXPath('//a/div[contains(@class,"avatar")]/@style')->text(); //头像
                //background-image: url(https://img3.doubanio.com/img/celebrity/medium/5253.jpg) 正则抽取头像图片
                preg_match_all("/((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+\.(jpg|jpeg|gif|png)/", $actor['avatar'], $avatar);
                $actor['avatar'] = $avatar[0][0];
                //print_r($actor);
                $data['actor'][] = $actor;
            });

        } catch (\Exception $e) {

        }

        dd($data);

    }
}
