<?php

namespace App\Services;

class MultidimensionalArrayEditor
{
    /**
     * Slackリソースを登録するために使用する配列を生成する
     *
     * @param mixed $original_array 変換前の配列
     * @param mixed $selected_key 変換前の配列の中で抽出したい値のキー
     * @param mixed $new_key 新しい配列で使うキー用の単語
     * @return array 新しい配列を返す
     */
    public function createNewArray($original_array,$selected_key,$new_key){
        $array_values = array_column($original_array,$selected_key);
        
        foreach($array_values as $key=>$array)
        {
            $key = $new_key;
            $new_array[$key] = $array;
            $result_array[] = $new_array;
        }
        
        return $result_array;
    }
}
