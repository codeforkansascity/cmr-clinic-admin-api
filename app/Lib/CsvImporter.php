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

        if (empty($data)) {
            return true;
        }

        if ($callback && is_callable($callback)) {
            $data = array_map($callback, $data);
        }

        $chunks = array_chunk($data, 1);
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
                    // Handel condition where row has fewer columns than the header
                    $header_count = count($this->header);
                    $row_count = count($row);

                    if ($header_count > $row_count) {
                        for ($i = $row_count; $i < $header_count; $i++ ) {
                            $row[] = '';
                        }
                    } elseif ($header_count < $row_count) {
                        $tmp = $row;
                        $row = [];

                        foreach ($tmp AS $i => $value) {
                            if ($i >= $header_count) {
                                break;
                            }
                           $row[] = $value;
                        }
                    }

                    $data[] = array_combine($this->header, $row);
                }

            }
            fclose($handle);
        }


        return $data;
    }

}
