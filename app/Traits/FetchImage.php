<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;


trait FetchImage {

    public function getRandomImageUrlFromGoogle($query){
        $apiKey = 'AIzaSyBAXo8R6t4ThXzgAnsViwInFPiwTUux3hs';
        $engineId = '13910592f5dab4183';

        $response = Http::get('https://www.googleapis.com/customsearch/v1',[
            'key'=>$apiKey,
            'cx'=>$engineId,
            'q'=>$query,
            'searchType'=>'image',
            'safe'=>'high',
            'num'=>1,
        ]);

        $data = $response->json();

        if(isset($data['items']) && count($data['items']) > 0){
            $randomIndex = rand(0,count($data['items']) - 1);
            return $data['items'][$randomIndex]['link'];
        }
        return null;
    }
}


?>
