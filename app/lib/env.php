<?php

class env {

    private static $_load_cache = null;

    public static function getVariable(string $key):?string {
        self::_loadEnv();
        if(key_exists($key, self::$_load_cache))
            return self::$_load_cache[$key];
        else
            return null;
    }

    private static function _loadEnv():void {
        if(self::$_load_cache===null) {
            $data = file_get_contents(base_path() . '/.env');
            $data_exploded = array_filter(explode("\n",$data));
            if(count($data_exploded)) {
                foreach($data_exploded as $one_row) {
                    if(strpos($one_row,'=')!==false) {
                        $one_row_exploded = explode('=', $one_row);
                        self::$_load_cache[trim($one_row_exploded[0])] = trim($one_row_exploded[1]);
                    }
                }
            }
        }
    }

}