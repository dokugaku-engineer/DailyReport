<?php

namespace App\Services;

class MultidimensionalArrayEditor
{
    public function createNewArray($your_array,$selected_key,$new_key){
        $array_values = array_column($your_array,$selected_key);
        
        foreach($array_values as $key=>$array)
        {
            $key = $new_key;
            $new_array[$key] = $array;
            $result_array[] = $new_array;
        }
        
        return $result_array;
    }
}
