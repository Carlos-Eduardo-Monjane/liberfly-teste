<?php

namespace App\Traits;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait ApiResponser{

private function successResponse($data,$code){
return response()->json($data,$code);
}

private function errorResponse($error,$code){
    return response()->json(["error"=>$error],$code);
    }

protected function showAll($msg,Collection $collection,$code=200){

return $this->successResponse(['message'=>$msg,'data'=>$collection],$code);
}

protected function showone($msg,Model $model,$code=200){
    
    return $this->successResponse(['message'=>$msg,'data'=>$model],$code);
}



}//







?>