<?php

namespace App\Controllers;

use App\Models\LinksModel;

class Home extends BaseController
{
    protected $LinksModel;
    public function __construct()
    {
        $this->LinksModel = new LinksModel();
    }

    public function index()
    {
        return view('testing_link');
    }

    public function Generate()
    {
        $longurl = $this->request->getVar('long_url');
        $baseUrl = base_url();
        $shortUrl = $this->RandomGenerator();
        $mergeUrl = base_url() . $shortUrl;
        // save to Database
        $data = [
            'url_ori' => $longurl,
            'url_short' => $shortUrl,
        ];

        $this->LinksModel->insert($data);

        return json_encode(['long_url' => $longurl, 'mergeUrl' => $mergeUrl]);
    }

    public function Redirect()
    {
        $segmentRandom = $this->request->getPath(1);
        $links = $this->LinksModel->getUrlShort($segmentRandom);
        // redirect to original URL
        return redirect()->to($links['url_ori']);

    }
}
