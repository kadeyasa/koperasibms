<?php

namespace App\Controllers;

use App\Models\Profilemodel;

class Profile extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->profilemodel=new Profilemodel();
        helper('form');
    }

    public function index()
    {
        if(session('userlevel')!=0){
            return view('main/profile');
        }else{
            return view('member/profile');
        }
    }

    public function koperasi()
    {
        $check = $this->profilemodel->first();
        $data['check']=$check;
        if(session('userlevel')!=0){
            return view('main/profile_koperasi',$data);
        }else{
            return view('member/profile_koperasi',$data);
        }
    }

    public function user()
    {
        if(session('userlevel')!=0){
            return view('main/profile_user');
        }else{
            return view('member/profile_user');
        }
    }

    public function saveprofile(){
        $rules = [
            //'email' => 'required|min_length[5]',
            'email'=> 'required|valid_email',
            //'password' => 'required|min_length[8]'
        ];
        $password = $this->request->getVar('password');
        $repassword = $this->request->getVar('repassword');
        $email = $this->request->getVar('email');
        $id = session('user_id');
        //$session = session();
        if($password!=''){
            if($password!=$repassword){
                $error=1;
                $message = 'Password tidak sama!';
            }else{
                $password = password_hash($password,PASSWORD_DEFAULT);
                $data = array(
                    'email'=>$email,
                    'password'=>$password
                );
                if($id){
                    if($this->usermodel->update($id,$data)){
                        $error=0;
                        $message='Data updated';
                        //$session = session(); 
                        session()->setFlashdata('success',$message);
                    }else{
                        $error=1;
                        $message = 'Data tidak tersimpan';
                    }
                }
            }
        }else{
            if($id){
                if($password==''){
                    $data = array(
                        'email'=>$email
                    );
                }
                if($this->usermodel->update($id,$data)){
                    $error=0;
                    $message='Data updated';
                    session()->setFlashdata('success',$message);
                }else{
                    $error=1;
                    $message = 'Data tidak tersimpan';
                }
            }
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        
        echo json_encode($d);
    }

    public function savekoperasi(){
        $rules = [
            'nama_koperasi' => 'required',
            'alamat'=> 'required',
            'no_telp' => 'required',
            'no_akta' => 'required'
        ];
        if($this->validate($rules)){
            $img = $this->request->getFile('userfile');
            $validationRule = [
                'userfile' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[logo]'
                        . '|is_image[logo]'
                        . '|mime_in[logo,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[logo,100]'
                        . '|max_dims[logo,1024,768]',
                ],
            ];
            if ($this->validate($validationRule)) {
                if (! $img->hasMoved()) {
                    $filepath = WRITEPATH . 'uploads/' . $img->store();
                }
                if($img->getName()){
                    $data = array(
                        'nama'=>$this->request->getVar('nama_koperasi'),
                        'alamat'=>$this->request->getVar('alamat'),
                        'no_telp'=>$this->request->getVar('no_telp'),
                        'no_akta'=>$this->request->getVar('no_akta'),
                        'iuran_pokok'=>$this->request->getVar('iuran_pokok'),
                        'iuran_wajib'=>$this->request->getVar('iuran_wajib'),
                        'logo'=>img->getName()
                    );
                }
            }else{
                $data = array(
                    'nama'=>$this->request->getVar('nama_koperasi'),
                    'alamat'=>$this->request->getVar('alamat'),
                    'no_telp'=>$this->request->getVar('no_telp'),
                    'no_akta'=>$this->request->getVar('no_akta'),
                    'iuran_pokok'=>$this->request->getVar('iuran_pokok'),
                    'iuran_wajib'=>$this->request->getVar('iuran_wajib'),
                    //'logo'=>img->getName()
                );
            }
            //echo json_encode($data);
            $check = $this->profilemodel->first();
            if(!$check){
                $save = $this->profilemodel->insert($data);
            }else{
                $save = $this->profilemodel->update($check['id'],$data);
            }
            if($save){
                session()->setFlashdata('success','Data berhasil disimpan');
                return redirect()->to('profilekoperasi'); 
            }
        }else{
            session()->setFlashdata('error',$this->validator->listErrors());
            return redirect()->to('profilekoperasi'); 
        }
    }
}