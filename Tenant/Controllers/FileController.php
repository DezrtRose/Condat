<?php
namespace App\Modules\Tenant\Controllers;

use Illuminate\Http\Request;

class FileController extends BaseController {

    protected $request;

    function __construct(Request $request)
    {
        parent::__construct();
        $this->request = $request;
    }

    function upload()
    {
        $folder = $this->request->input('folder');
        $folder = ($folder == '') ? 'temp' : $folder;

        $file = $this->request->input('file');
        $file = ($file == '') ? 'file' : $file;

        if ($return = tenant()->folder($folder, true)->upload($file)) {
            return $this->success($return);
        }

        return $this->fail(['error' => 'File upload failed']);
    }


    function delete()
    {
        if ($this->request->ajax()) {
            $file = $this->request->input('file');
            $folder = $this->request->input('folder');
            $folder = ($folder == '') ? 'temp' : $folder;
            tenant()->folder($folder)->delete($file);
            return $this->success(['message' => 'File deleted']);
        }
        return $this->fail(['error' => 'Something went wrong. Please try again later']);
    }

} 