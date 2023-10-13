<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


trait CacheHelper {

        protected $query;

        // collection type normal means the output will be get() result but if you choose paginate it will return paginated results

        //conditions array should be [key] => field name , [value] => first index equal the value , second index equal the operator

        public function cacheQuery(string $table,int $minutes = 60,mixed $with = null,array $arrayOfConditions = [],string $collectionType = 'normal'){
            $this->getModel($table);

            $cacheName = $collectionType === 'count' ? $table."_count" : $table."_cached";

            if(Cache::has($cacheName)){
                return Cache::get($cacheName);
            }

            $this->with($with);
            $this->setConditions($arrayOfConditions);

            switch($collectionType)  {
                case "normal":
                    $this->query = $this->query->get();
                    break;

                case "paginated":
                    $this->query = $this->query->paginate();
                    break;
                case 'count':
                    $this->query = $this->query->count();
                    break;
            }


            Cache::put($cacheName,$this->query,now()->addMinutes($minutes));
            return $this->query;
        }

        // the function take table name then get the model from it and add query starter to $query property
        public function getModel(string $table){
            try{
                if(substr($table,-3) == 'ies'){
                    $table = str_replace('ies','ys',$table);
                }
                $modelName = ucfirst(substr($table,0,-1));
                $model = "App\Models\\{$modelName}";
            } catch (Exception $e){
                Log::error('model not found'.$e->getMessage());
            }
            return $this->query = $model::query();
        }

        // the function take the relations that you want to get with your main query
        public function with(mixed $with){
            if($with == null){
                return null;
            }
            try{
                if(!is_array($with)){
                    return $this->query = $this->query->with($with);
                }
                $withCount = count($with);
                if($withCount > 0){
                return $this->query = $this->query->with($with);
                }
            } catch (Exception $e){
                Log::error('relation not exists'.$e->getMessage());
            }
        }

        // the function take array of conditions and loop throw them and asign the values to this trait $query property
        public function setConditions(array $conditions){
            $conditionsCount = count($conditions);
            if(!$conditionsCount > 0){
                return null;
            }

            foreach ($conditions as $key => $value){
                if(is_array($value)){
                    $operator = $value[1] ?? '=';
                    $this->query = $this->query->where($key,$operator,$value[0]);
                }else{
                    $this->query = $this->query->where($key,$value);
                }
            }
        }
}
