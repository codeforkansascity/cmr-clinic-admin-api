<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PersonHistory implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        print_r('ssss');
        print_r($collection->toArray());
    }
}
