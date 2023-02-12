<?php

namespace App\Console\Commands;

use App\Models\ImagesNews;
use App\Models\Logs;
use App\Models\News;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class ParseSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:site';

    protected $description = 'Command description';

    private $site = 'http://static.feed.rbc.ru/rbc/logical/footer/news.rss';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $xml = $this->simple_xml($this->set_response());

        $this->download($xml);


    }


    private function set_response()
    {

        $this->info('Подключаюсь к сайту');

        $response = Http::get($this->site);


       $this->set_logs_request($response->handlerStats(),$response->body());

        if ($response->successful()) {
            $this->info('Подключился');
            $this->info("Статус: {$response->status()} ");


            return $response;

        } else {
            $this->info('Произошла ошибка');
        }

    }

    private function simple_xml($response)
    {

        $this->info('Парсинг сайта...');
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $array = json_decode($json, TRUE);

        return $array;

    }

    private function download($array)
    {
        $this->info('Загружаю в базу данных...');

        $arr = [];
        foreach ($array['channel']['item'] as $item) {

            $arr[] = $item;


        }
        foreach ($arr as $item) {

            $news =   News::create([
                'title' => $item['title'],
                'description' =>  $item['description'],
                'link' =>  $item['link'],
                'author' =>  $item['author'] ?? null,
                'date' =>  $item['pubDate'],
                'category' =>  $item['category']
            ]);
            $this->info('Загрузил в базу данных новость');

            if (array_key_exists('enclosure',$item)) {
                foreach ($item['enclosure'] as $lol) {

                    try {
                        $contents = file_get_contents($lol['url']);
                        $name = basename($lol['url']);
                        Storage::put('public/'.$name, $contents);
                        ImagesNews::create([
                            'new_id' => $news->id,
                            'image' => $name,
                            'type' => $lol['type']
                        ]);
                        $this->info('Загрузил в базу данных картинку');
                    } catch (\Exception $exception) {
                        $this->info($exception->getMessage());
                    }




                }
            }

        }


        }



    private function set_logs_request($response,$body)
    {

        Logs::create([
            'request_method' => $response['effective_method'] ?? 'GET',
            'request_url' => $response['url'],
            'response_http_code' => $response['http_code'],
            'response_body' => $body,
            'time_end' => $response['total_time_us']
        ]);
    }


}
