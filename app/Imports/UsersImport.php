<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    var $count=0;
    public function model(array $row)
    {

        if (!isset($row[0])) {
            return null;
        }

        print_r($row);
        $this->count++;
        print "|$this->count|\n";
        if ($this->count > 200) return;



//        return new User([
//            //
//        ]);
    }
}
