<?php
namespace App\Services;

use Illuminate\Support\Collection;

class Select2
{
    protected $data = [];
    protected $textPattern = [];
    
    public function __construct($data = null, $textPattern = null)
    {
        if ($data != null) $this->data = ($data instanceof Collection) ? $data->toArray() : (array) $data;
        if ($textPattern != null) $this->textPattern = $textPattern;
    }
    
    public function data($data)
    {
        $this->data = $data->toArray();
        return $this;
    }

    public function pattern($textPattern)
    {
        $this->textPattern = $textPattern;
        return $this;
    }

    public function array()
    {
        $result = [];
        foreach ($this->data as $item)
        {
            $item = (object) json_decode(json_encode($item));

            $text = [];
            foreach($this->textPattern as $pattern)
            {
                $text[] = $item->{$pattern};
            }

            $result[] = [
                'id' => $item->id,
                'text' => implode(' - ', $text),
            ];
        }
        return $result;
    }

    public function original()
    {
        return $this->data;
    }

    public function json()
    {
        return json_encode($this->array());
    }
}