<?php

namespace FernandoWobeto\UolMotor1Rss;

use DateTime;

class Rss
{

    private $url = 'https://motor1.uol.com.br/rss/news/all/';

    private $data = [];

    public function __construct()
    {
        $this->load();
    }

    public function get()
    {
        return $this->data;
    }

    private function load()
    {
        $get = file_get_contents($this->url);

        if ($get) {
            $xml = simplexml_load_string($get);

            foreach ($xml->channel->item as $item) {
                $this->data[] = (object)[
                    'title'          => reset($item->title),
                    'date_published' => new DateTime(reset($item->pubDate)),
                    'link'           => reset($item->link),
                    'image'          => reset($item->enclosure)['url'],
                ];
            }
        }
    }

}