<?php namespace App\Filters;
use App\Models\Statusmodel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 
class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // jika user belum login
        if(! session()->get('logged_in')){
            // maka redirct ke halaman login
            return redirect()->to('/'); 
        }
        //check status 
        $model = New Statusmodel();
        $status = $model->where('status',0)->first();
        //echo json_encode($status);
        if($status && session()->get('userlevel')==2){
            return redirect()->to('/'); 
        }
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}