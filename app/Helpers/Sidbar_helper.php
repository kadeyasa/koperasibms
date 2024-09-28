<?php
if(!function_exists('getModuleParents')){
    function getModuleParents(){
        $model = new \App\Models\Modulemodel();
        $results = $model->where('parent',0)->orderby('id','ASC')->findAll();
        return $results;
    } 
}

if(!function_exists('getModuleChilds')){
    function getModuleChilds($id){
        $model = new \App\Models\Modulemodel();
        $results = $model->where('parent',$id)->orderby('id','ASC')->findAll();
        return $results;
    }
}
if(!function_exists('getUserModule')){
    function getUserModule($user_id){
        $model = new \App\Models\Usermodulemodel();
        $results = $model->where('user_id',$user_id)->where('deleted_at',null)->first();
        return $results;
    }
}
?>