<?php

namespace App\Http\Middleware;

use Closure;

class ParseViewForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //$data = Request::all();
        $formData = $request->all();
        $returnData = [];
        foreach($formData as $key => $value)
        {
            $keys = explode('_', $key);
            $returnData = $this->insert($returnData, $keys, $value);
            //break;
        }
        $request['parsed'] = $returnData;
        return $next($request);
    }

    private function insert($base, $keys, $value)
    {
        //var_dump($base);
        $firstKey = $keys[0];
        if($firstKey == "") {
            array_shift($keys);
            $firstKey = $keys[0];
        }
        array_shift($keys);
        if(count($keys) > 0)
        {
            $insert = (isset($base[$firstKey])) ? $base[$firstKey] : [];
            $arr = $this->insert($insert, $keys, $value);
            $base[$firstKey] = $arr;
            //echo('<br/>');
            //echo($firstKey);
            //echo('<br/>');
            //return [$firstKey => $this->insert($keys, $value)];
            
        }else{
            //echo('<br/>');
            //echo('putting value<br/>');
            //echo($firstKey . ' -- ' . $value);
            $base[$firstKey] = $value;
            //echo('<br/>');
        }
        return $base;
    }
}
