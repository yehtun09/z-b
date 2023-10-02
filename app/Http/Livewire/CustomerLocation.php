<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CustomerLocation extends Component
{
    public $locationInfo = [];

    public function mount()
    {
        $this->locationInfo = [
            [
                "site_lat" => "ddd",
                "site_long" => "dddd"
            ]
        ];
    }

    public function render()
    {
        return view('livewire.customer-location');
    }

    public function addItem()
    {
        $this->locationInfo[] =  ["site_lat" => "helllo", "site_long" => "ddd"];
    }

    public function deleteItem($index)
    {
        $locationData = collect($this->locationInfo);
        if (count($locationData) > 1) {
            $this->locationInfo = $locationData->filter(function (int $value, int $key) use($index) {
                return $index !== $key;
            });
        }
    }
}
