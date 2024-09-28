<?php

namespace App\Controllers;
use App\Models\Taghianmodel;

class Tagihan extends BaseController
{
    public function bulanan(){
        $model = NEW Tagihanmodel();

        $pager = service('pager');

        $page    = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 50;
        $total   = $model->getcount()->total;

        // Call makeLinks() to make pagination links.
        $pager_links = $pager->makeLinks($page, $perPage, $total);
    }
}