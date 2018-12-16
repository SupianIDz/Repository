<?php

/**
 *   ___       _
 *  / _ \  ___| |_ ___  _ __  _   _
 * | | | |/ __| __/ _ \| '_ \| | | |
 * | |_| | (__| || (_) | |_) | |_| |
 *  \___/ \___|\__\___/| .__/ \__, |
 *                     |_|    |___/
 * @author  : Supian M <supianidz@gmail.com>
 * @version : v1.0
 * @license : MIT
 */

namespace App\HTTP\Controller;

use ZipArchive;
use SplFileInfo;
use RecursiveIteratorIterator as RIIterator;
use RecursiveDirectoryIterator as RDIterator;

use DB;
use Session;
use App\HTTP\Controller;
use Octopy\HTTP\Request;

class DirectoryLister extends Controller
{
    /**
     * @var object
     */
    private $config;

    /**
     * @var string
     */
    private $temporary;

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->archive   = new ZipArchive;
        $this->config    = config('directorylister');
        $this->temporary = $this->config->temporary;
    }

    /**
     * @return string
     */
    public function index()
    {
        if (!$this->request->secure() && env('APP_ENV') === 'production') {
            return redirect()->to(config('app.url'));
        }

        return view('main', [
            'title'    => config('app.name'),
            'keywords' => $this->keywords()
        ]);
    }

    /**
     * @return string
     */
    private function keywords()
    {
        $iterator = new RDIterator($this->config->root, RDIterator::SKIP_DOTS);
        $iterator = new RIIterator($iterator, RIIterator::CHILD_FIRST);
        $keywords = [];

        foreach ($iterator as $row) {
            if ($row->isFile()) {
                if ($this->exclude($row)) {
                    continue;
                }

                $keywords[] = $row->getFilename();
            }
        }

        return implode(', ', $keywords);
    }

    /**
     * @return void
     */
    public function zip()
    {
        $location = $this->config->root . Session::get('directory');
        if (empty(array_diff(scandir($location), ['.', '..']))) {
            return redirect()->to('/');
        }

        $archive  =  'Octopy-Repository.zip';

        $db = DB::table('statistics');
        $db->insert([
            'name' => $archive,
            'time' => date('H:i:s', time()),
            'date' => date('Y-m-d', time())
        ]);

        $iterator = new RIIterator(new RDIterator($location, RDIterator::SKIP_DOTS), RIIterator::LEAVES_ONLY);

        $this->archive->open($this->temporary . $archive, ZipArchive::CREATE|ZipArchive::OVERWRITE);

        foreach ($iterator as $file) {
            if ($this->exclude($file)) {
                continue;
            }

            if (!$file->isDir()) {
                $filepath = $file->getRealPath();
                $relative = substr($filepath, strlen($this->temporary) + 1);
                $this->archive->addFile($filepath, $relative);
            }
        }

        $this->archive->close();
           
        $this->response->download($this->temporary . $archive, $archive);
        unlink($this->temporary . $archive);
    }

    /**
     * @param string $location
     */
    public function octopy(Request $request)
    {
        if (isset($request->location) && $request->mode === 'readdir') {
            $location = str_replace('%20', ' ', str_replace('..', '', $request->location));
            if (is_dir($this->config->root . $location)) {
                $data = $this->scan($location);
                Session::set('directory', $location);
                return view('lister', [
                    'data'  => $data
                ]);
            }
        } elseif (isset($request->location) && $request->mode === 'download') {
            $db = DB::table('statistics');
            $db->insert([
                'name' => basename($request->location),
                'time' => date('H:i:s', time()),
                'date' => date('Y-m-d', time())
            ]);

            Session::set('location', $request->location);
        }
    }

    /**
     * @return void
     */
    public function download()
    {
        $location = $this->config->root . Session::get('location');
        $filename = preg_replace('/\_{2,}/', '_', str_replace(' ', '_', basename($location)));
        $this->response->download($location, $filename);
    }

    /**
     * @param  string $location
     * @return array
     */
    private function scan(string $location)
    {
        $iterator = new RDIterator($this->config->root . $location, RDIterator::SKIP_DOTS);

        if ($location !== '/') {
            $iterate[0][] = $this->detail(new SplFileInfo($this->config->root . $location . '/..'));
        }

        foreach ($iterator as $data) {
            if ($this->exclude($data)) {
                continue;
            }

            if ($data->isDir()) {
                $iterate[0][] = $this->detail($data);
            } else {
                $iterate[1][] = $this->detail($data);
            }
        }

        return array_merge($iterate[0] ?? [], $iterate[1] ?? []);
    }

    /**
     * @param  SplFileInfo $file
     * @return object
     */
    private function detail(SplFileInfo $file)
    {
        $name = $file->getFilename();
        $size = $this->size($file->getSize());
        $icon = $this->icon($file->getExtension());
        $type = $file->isDir() ? 'directory' : 'file';
        $time = date('Y-m-d H:i:s', $file->getMTime());
        $path = str_replace($this->config->root, '', $file);

        if ($type === 'directory') {
            $icon = 'icon-folder';
        }

        return json_decode(json_encode([
            'name' => $name,
            'size' => $size,
            'icon' => $icon,
            'type' => $type,
            'time' => $time,
            'path' => $path
        ]));
    }

    /**
     * @param  string $ext
     * @return string
     */
    private function icon(string $ext)
    {
        foreach ($this->config->icon as $class => $extension) {
            if (in_array($ext, $extension)) {
                return $class;
            }
        }

        return 'icon-code';
    }

    /**
     * @param  int $byte
     * @return string
     */
    private function size(int $byte)
    {
        if ($byte < 1024) {
            return $byte . ' B';
        } elseif ($byte < 1048576) {
            return round($byte / 1024, 2) . ' KB';
        } elseif ($byte < 1073741824) {
            return round($byte / 1048576, 2) . ' MB';
        }

        return round($byte / 1073741824, 2) . ' GB';
    }

    /**
     * @param  SplFileInfo $file
     * @return bool
     */
    private function exclude(SplFileInfo $file)
    {
        foreach ($this->config->exclude as $pattern) {
            if (preg_match($pattern, $file->getFilename())) {
                return true;
            }
        }

        return false;
    }
}
