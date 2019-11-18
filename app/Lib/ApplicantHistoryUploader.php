<?php

// From https://github.com/charliekassel/vuejs-uploader

namespace App\Lib;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;


class ApplicantHistoryUploader
{
    const UPLOAD_DIR = '/tmp/';


    var $storage_disk = 'local';

    /**
     * Uploader constructor
     */
    public function __construct()
    {
        $this->allowCors();
        $this->storage_disk = env('LBV_STORAGE_LOCATION', 'local');
    }

    /**
     * Opens up CORS access
     */
    private function allowCors()
    {

        if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        } else {
            $origin = $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
            $origin .= $_SERVER['HTTP_HOST'];
            header("Access-Control-Allow-Origin: {$origin}");
        }

        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit(0);
        }
    }

    /**
     * Saves the uploaded file
     *
     * @return [type] [description]
     */
    public function saveUploadedFile($foreign_key_name, $foreign_key_value, $display_name = 'test', $storage_path = '', $uploaded_file_name=false)
    {

        $this->handleUploadError($_FILES['file']['error']);

        $target_file_name_and_path = $this->getTargetFileNameAndPath();

        $destination_directory = env('APPLICANT_HISTORIES_DIRECTORY', 'applicant_histories');

        if (move_uploaded_file($this->getSource(), $target_file_name_and_path)) {

            if ($this->isMultipartUpload()) {

                $filename_path = self::UPLOAD_DIR . $_POST['filename'];
                $this->mergeMultiUpload($filename_path, (int)$_POST['totalParts']);

                $new_file_path = Storage::disk($this->storage_disk)->putFile($destination_directory, new File($filename_path));

            } else {

                $resized_path_name = $target_file_name_and_path;

                //$geo = $this->get_image_location($target_file_name_and_path);

                // https://superuser.com/questions/636333/what-is-the-largest-size-of-a-640x480-jpeg

                //   $this->resize_image($target_file_name_and_path, $resized_path_name, $cols=400, $rows=300, $resolution=32);

                $new_file_path = Storage::disk($this->storage_disk)->putFile($destination_directory, new File($target_file_name_and_path));

            }


            $fields_with_values['name'] = $display_name;
            $fields_with_values['uploaded_file_name'] = $uploaded_file_name ? $uploaded_file_name : $_FILES['file']['name'];
            $fields_with_values['mime'] = $_FILES['file']['type'];
            $fields_with_values['size'] = $_FILES['file']['size'];
            $fields_with_values['active'] = 1;
            $fields_with_values[$foreign_key_name] = $foreign_key_value;
            $fields_with_values['local_file_name'] = basename($new_file_path);
            $fields_with_values['url'] = $storage_path . basename($new_file_path);

//            $record = new \App\VcVendorLogo;
//            $record->fill($fields_with_values);
//            $record->save();

            return $this->response(200, [
                'message' => $this->getSuccessMessage(),
                'local_file_name' => basename($new_file_path),
                'meta' => [
                    'remainingParts' => []
                ]
            ]);
        }

        $this->response(500, ['error' => 'Unknown Error']);
    }

    /**
     * Format a success message
     *
     * @return string
     */
    private function getSuccessMessage()
    {
        if ($this->isMultipartUpload()) {
            return sprintf('file %s part %s uploaded.', $_POST['filename'], $_POST['currentPart']);
        }

        return sprintf('file %s uploaded.', $_FILES['file']['name']);
    }

    /**
     * Get upload source
     *
     * @return string
     */
    private function getSource()
    {
        return $_FILES['file']['tmp_name'];
    }

    /**
     * Get target destination
     *
     * @return string
     */
    private function getTargetFileNameAndPath()
    {
        if ($this->isMultipartUpload()) {
            return self::UPLOAD_DIR . $_POST['filename'] . '.' . $_POST['currentPart'];
        }

        return self::UPLOAD_DIR . $_FILES['file']['name'];
    }

    /**
     *
     *      NOT USED
     *
     *
     * @return mixed
     */
    private function getTargetFileName()
    {
        if ($this->isMultipartUpload()) {
            return self::$_POST['filename'];
        }

        return self::$_FILES['file']['name'];
    }


    /**
     * Is this a multipart upload?
     *
     * @return boolean
     */
    private function isMultipartUpload()
    {
        return !empty($_POST['multipart']);
    }

    /**
     * Formats an error response
     *
     * @param  int $uploadError
     */
    private function handleUploadError(int $uploadError)
    {
        if ($uploadError === 0) {
            return;
        }

        switch ($uploadError) {
            case 1:
                $error = 'UPLOAD_ERR_INI_SIZE';
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                break;
            case 2:
                $error = 'UPLOAD_ERR_FORM_SIZE';
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                break;
            case 3:
                $error = 'UPLOAD_ERR_PARTIAL';
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case 4:
                $error = 'UPLOAD_ERR_NO_FILE';
                $message = 'No file was uploaded.';
                break;
            case 6:
                $error = 'UPLOAD_ERR_NO_TMP_DIR';
                $message = 'Missing a temporary folder.';
                break;
            case 7:
                $error = 'UPLOAD_ERR_CANT_WRITE';
                $message = 'Failed to write file to disk.';
                break;
            case 8:
                $error = 'UPLOAD_ERR_EXTENSION';
                $message = 'A PHP extension stopped the file upload';
        }

        $this->response(422, [
            'error' => $error,
            'message' => $message
        ]);
    }

    /**
     * Get a list of uploaded parts
     *
     * @param  string $filename
     * @return array
     */
    private function getUploadedParts(string $filename): array
    {
        return glob($filename . '.*');
    }

    /**
     * Get a sorted list of uploaded file parts
     *
     * @param  string $filename
     * @return array
     */
    private function getSortedParts(string $filename): array
    {
        $files = $this->getUploadedParts($filename);

        $sortedFiles = [];
        array_walk($files, function ($value, $key) use (&$sortedFiles) {
            $sortedFiles[(int)pathinfo($value)['extension']] = $value;
        });
        ksort($sortedFiles);

        return $sortedFiles;
    }

    /**
     * Get a numeric array of the remaining parts to be uploaded
     *
     * @param string $filename
     * @param int $totalParts
     * @return int[]
     */
    private function getRemainingParts(string $filename, int $totalParts): array
    {
        $uploadedParts = array_keys($this->getSortedParts($filename));

        return array_values(array_diff(range(1, $totalParts), $uploadedParts));
    }

    /**
     * Combines the parts of a multipart upload into a single file.
     *
     * @param  string $filename
     * @param  int $totalParts
     */
    private function mergeMultiUpload(string $filename, int $totalParts)
    {
        if (count($this->getUploadedParts($filename)) !== $totalParts) {
            return $this->response(200, [
                'message' => $this->getSuccessMessage(),
                'meta' => [
                    'remainingParts' => $this->getRemainingParts($filename, $totalParts)
                ]
            ]);
        }

        $sortedFiles = $this->getSortedParts($filename);

        ini_set('max_execution_time', 300);

        $out = fopen($filename, 'w');
        foreach ($sortedFiles as $file) {
            $in = fopen($file, 'r');
            while ($line = fgets($in)) {
                fwrite($out, $line);
            }
            fclose($in);
        }
        fclose($out);

        foreach ($sortedFiles as $file) {
            unlink($file);
        }

        return true;
    }

    /**
     * Sets json output response
     *
     * @param  int $status
     * @param  array $data
     */
    private function response(int $status, array $data)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit(0);
    }
}
