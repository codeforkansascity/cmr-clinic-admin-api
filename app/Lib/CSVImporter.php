<?php


namespace App\Lib;


use Illuminate\Support\Facades\DB;

class CsvImporter
{
    protected $filename;
    protected $delimiter = ',';
    protected $header = null;

    public function __construct($filename, $header = null, $delimiter = ',')
    {
        $this->filename = $filename;
        $this->header = $header;
        $this->delimiter = $delimiter;
    }

    public function toDatabase($table, $callback = null)
    {
        $data = $this->toArray();

        if ($callback && is_callable($callback)) {
            $data = array_map($callback, $data);
        }

        $chunks = array_chunk($data, 500);
        foreach ($chunks as $chunk) {
            DB::table($table)->insert($chunk);
        }

        return true;
    }

    public function toArray()
    {

        if (!file_exists($this->filename) || !is_readable($this->filename))
            return false;

        $data = [];
        if (($handle = fopen($this->filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== false) {
                if (!$this->header) {
                    $this->header = $row;
                } else {
                    $data[] = array_combine($this->header, $row);
                }

            }
            fclose($handle);
        }


        return $data;
    }

}
