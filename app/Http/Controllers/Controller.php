<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Exception;
use http\Env\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $devs = [
        'dev_5' =>  [ 'level' => 5, 'time' =>0 , 'tasks' => [] ],
        'dev_4' =>  [ 'level' => 4, 'time' =>0 , 'tasks' => [] ],
        'dev_3' =>  [ 'level' => 3, 'time' =>0 , 'tasks' => [] ],
        'dev_2' =>  [ 'level' => 2, 'time' =>0 , 'tasks' => [] ],
        'dev_1' =>  [ 'level' => 1, 'time' =>0 , 'tasks' => [] ],
    ];
    private static $_apis = Array(
        "api_1" => Array( "url" => "http://www.mocky.io/v2/5d47f24c330000623fa3ebfa",
                          "task_id_path" =>  Array(
                              Array( "type" => "string", "val" => "id"  )
                          ),
                          "duration_path" =>  Array(
                              Array( "type" => "string", "val" => "sure"  )
                          ),
                          "level_path" =>  Array(
                              Array( "type" => "string", "val" => "zorluk"  )
                          ),
                          "name" => "api1",
                          "fields" => Array( "level", "duration", "task_id" )
            ),

        "api_2" => Array( "url" => "http://www.mocky.io/v2/5d47f235330000623fa3ebf7",
                          "task_id_path" => Array(
                              Array( "type" => "own", "val" => 0 )
                          ),
                          "duration_path" => Array(
                              Array( "type" => "key", "val" => 0 ),
                              Array( "type" => "string", "val" => "estimated_duration"  )
                          ),
                          "level_path" => Array(
                              Array( "type" => "key", "val" => 0 ),
                              Array( "type" => "string", "val" => "level"  )
                          ),
                          "name" => "api2",
                          "fields" => Array( "level", "duration", "task_id" )
            ),
    );

    /**
     * Controller constructor.
     */
    public function __construct()
    { }


    /**
     *get data from api and then saving to database.
     */
    public function getApiData()
    {
        $result = Array();
        foreach (self::$_apis as $api) {
            $result[$api["name"]] = Array();
            $response = file_get_contents($api["url"]);
            $data = json_decode($response, TRUE);
            if (json_last_error() !== JSON_ERROR_NONE) {
                continue;
            }

            foreach ($data as $key => $value) {
                $tmp = Array("task_id" => "", "level" => "", "duration" => "");

                foreach ($api["fields"] as $field) {
                    $fieldVal = $value;

                    foreach ($api[$field . "_path"] as $path) {
                        if ($path["type"] == "string") {
                            $fieldVal = $fieldVal[$path["val"]];
                        } else if ($path["type"] == "int") {
                            $fieldVal = $fieldVal[$path["val"]];
                        } else if ($path["type"] == "key") {
                            $arrKeys = array_keys($value);
                            $fieldVal = $fieldVal[$arrKeys[$path["val"]]];
                        } else if ($path["type"] == "own") {
                            $arrKeys = array_keys($value);
                            $fieldVal = $arrKeys[$path["val"]];
                        }
                    }
                    $tmp[$field] = $fieldVal;
                }

                $result[$api["name"]][] = $tmp;
            }
        }

        return $this->saveData($result);
    }

    /**
     * @param $data
     */
    public function saveData($data)
    {
        foreach ($data as $items) {
            foreach ($items as $item) {
                $task = new Task;
                $task->fill( $item );
                $task->save();
            }
        }
    }

    /**
     * @return array
     * returns weekly task schedule
     */
    public function createPlanning()
    {
        $tasks = Task::all();
        $devs = $this->devs;
        $weeks = [];

        while ( count($tasks) > 0 ){
            foreach ($tasks as $task){
                $time = (array_column($devs, 'time'));
                array_multisort($time, SORT_ASC, $devs);
                foreach ($devs as $ind => $dev){
                    if (($devs[$ind]["time"]+ ($task->level * $task->duration) / $devs[$ind]["level"]) < 45)
                    {
                        $devs[$ind]["time"] += ($task->level * $task->duration) / $devs[$ind]["level"];
                        array_push($devs[$ind]["tasks"], $task->task_id);
                        unset($tasks[$task->id-1]);
                        break;
                    }
                }
            }
            ksort($devs);
            array_push($weeks, $devs);
            $devs = $this->devs;
        }

        return view('tasks', compact( 'weeks'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function taskList()
    {
        $tasks = Task::all();
        return view('main', compact( 'tasks'));
    }

}
