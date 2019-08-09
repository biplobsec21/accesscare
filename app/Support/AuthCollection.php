<?php

namespace App\Support;

use Illuminate\Support\Collection;

class AuthCollection extends Collection
{
    protected $all = false;
    protected $none = false;

    public function pushAccess($items)
    {
        return $this->items = (array_merge($this->items, $this->getArrayableItems($items)));
    }

    public function gate(string $gates, $id = null)
    {
        if ($this->all)
            return 1;

        if ($this->none)
            return 0;

        $str = '<span class="debug-perm badge badge-outline-dark bg-white">';
        $str .= '<span class="debug-perm-key font-italic text-dark">' . $gates . '</span>';
        $str .= '<span class="debug-perm-deliminator">   </span>';
        if ($this->recursiveNeedleInHaystack($gates))
            $str .= '<span class="debug-perm-value text-success"><i class="far fa-lock-open"></i></span>';
        else
            $str .= '<span class="debug-perm-value text-danger"><i class="far fa-lock"></i></span>';
        $str .= '</span>';

        if($_GET['mode'] ?? false === 'debug')
            echo $str;

        return $this->recursiveNeedleInHaystack($gates);
    }

    public function recursiveNeedleInHaystack($needles)
    {
        $needles = explode('.', $needles);
        $haystack = $this->recursiveObjectToArray($this->items);
        foreach ($needles as $needle) {
            if (array_key_exists($needle, $haystack))
                $haystack = $haystack[$needle];
            else
                return 0;
        }
        return $haystack;
    }

    public function recursiveObjectToArray($obj)
    {
        return json_decode(json_encode($obj), true);
    }

    public function setAuthAll()
    {
        $this->all = true;
        $this->none = false;
    }

    public function setAuthNone()
    {
        $this->all = false;
        $this->none = true;
    }
}
