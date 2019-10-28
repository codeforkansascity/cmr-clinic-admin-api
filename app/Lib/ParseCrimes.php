<?php


namespace App\Lib;



class ParseCrimes
{
    protected $filename;
    protected $crimes = [];


    /**
     * @param $filename
     * @return array|bool
     * @throws \Exception
     */
    public function __invoke($filename)
    {
        if(!$filename || !file_exists($filename)) throw new \Exception("File $filename doesn't exist");
        $this->filename = $filename;

        /// unzip and parse xml files
        ///
        $content = '';
        $zip = zip_open($this->filename);
        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

            /// ignore if empty or not document.xml
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

            if (zip_entry_name($zip_entry) != "word/document.xml") continue;

            $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

            zip_entry_close($zip_entry);
        }
        zip_close($zip);

        $content = str_replace('<w:t xml:space="preserve">', ' ', $content);
        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\n", $content);
        $content = strip_tags($content);

        $content = explode("\n", $content);
        $content = array_filter($content, function ($row) {
            /// try to determine if a line contains a description and citation number without extra trailing data
            /// descriptions with multiple lines will be cut off
            ///  but there is no good way to determine if they are multiline
            $row = trim($row);
            $row = preg_replace('/\s{2,}/', ' ', $row);
            $isStatute = (preg_match('/[\dA-z\.]+\s+\d{3}\.?\d{0,3}/', $row) && !preg_match('/\d{3}\.\d{3}[.]+ [\w\d]*/', $row) );
            return $isStatute;
        });


        return $this->crimes = array_map(function($row) {
            /// attempt to match citation number
            preg_match('/(\d{3}\.*\d{0,3})/', $row, $matches);
            $number = $matches[0];
            $name = trim(str_replace($number, '', $row));
            return [
                'number' => $number,
                'name' => $name
            ];
        }, $content);
    }

}
