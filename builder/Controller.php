<?php

namespace Builder;

use Builder\View\View;
use Illuminate\Support\Facades\DB;

class Controller
{
    public $ignoreField = ['is_del','update_time','audit_time','create_time','delete_time','creator','updater','ip','level'];

    public function index()
    {
        $view         = View::tbl('index', ['name' => 'test']);
        $view->layout = false;
        echo $view->html();
        die();
    }

    public function builder()
    {
        $table = request()->input('table_name');
        $table = str_replace(' ', '', $table);

        $className = ucwords(str_replace(array('.', '-', '_'), ' ', $table));
        $className = str_replace(' ', '', $className);

        $result = DB::select("SHOW FULL COLUMNS FROM " . "tb_" . $table);

        $fields = [];
        foreach ($result as $r) {

            if(in_array($r->Field,$this->ignoreField)){
                continue;
            }

            $field            = [];
            $field['db_type'] = $r->Type;
            $field['field']   = $r->Field;
            $field['comment'] = $r->Comment;
            $field['in_type'] = 'string';
            $field['in_name'] = $r->Comment;

            $comment =str_replace('，',',',$r->Comment);
            if(strstr($comment, '枚举-')){
                $field['in_type'] = 'enum';
                $enums = explode(',',$comment);
                $field_enum= [];
                foreach($enums as $index=>$en){
                    if($index == 0){
                        $field['in_name'] = explode('-',$en)[1];
                        continue;
                    }
                    $key = explode('=',$en);
                    $enum= [];
                    $enum['value'] = $key[0];
                    $enum['label'] = (isset($key[1])?$key[1]:$key[0]);
                    $enum['key'] = $r->Field."_".(isset($key[2])?$key[2]:(isset($key[1])?$key[1]:$key[0]));
                    $enum['common'] = '//'.$enums[0].":".(isset($key[1])?$key[1]:$key[0]);
                    $enum['const'] =  'const '.strtoupper($enum['key']).' = '.$key[0].';    '.$enum['common'];
                    array_push($field_enum,$enum);
                }
                $field['in_enum'] = $field_enum;
            }
            array_push($fields,$field);
        }

        //创建 - model
        $view         = View::tbl('model', ['fields' => $fields, 'className' => $className, 'tableName' => "tb_" . $table]);
        $view->layout = false;
        $html         = $view->html();
        $fileName     = base_path() . "\\builder\\output\\" . $className . '_M';
        echo $fileName;
        var_dump($html);
        file_put_contents($fileName, $html, LOCK_EX);
        //创建 - List-html
        $view         = View::tbl('list_html', ['fields' => $fields, 'className' => $className, 'tableName' => "tb_" . $table]);
        $view->layout = false;
        $html         = $view->html();
        $fileName     = base_path() . "\\builder\\output\\" . $className . '_LIST_html';
        echo $fileName;
        var_dump($html);
        file_put_contents($fileName, $html, LOCK_EX);
        //创建 - Edit-html
        $view         = View::tbl('edit_html', ['fields' => $fields, 'className' => $className, 'tableName' => "tb_" . $table]);
        $view->layout = false;
        $html         = $view->html();
        $fileName     = base_path() . "\\builder\\output\\" . $className . '_EDIT_html';
        echo $fileName;
        var_dump($html);
        file_put_contents($fileName, $html, LOCK_EX);

        //创建 - Function
        $view         = View::tbl('function', ['fields' => $fields, 'className' => $className, 'tableName' => "tb_" . $table]);
        $view->layout = false;
        $html         = $view->html();
        $fileName     = base_path() . "\\builder\\output\\" . $className . '_F';
        echo $fileName;
        var_dump($html);
        file_put_contents($fileName, $html, LOCK_EX);

        die();
    }
}
