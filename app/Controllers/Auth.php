<?php

namespace App\Controllers;
use App\Models\Usermodel;
class Auth extends BaseController
{
    public function __construct(){
        //$this->load->model(array('usermodel'));
        $this->usermodel=new Usermodel();
    }

    public function signup(){
        echo view('auth/sign-up');
    }

    public function signupsave(){
        $rules = [
            'username' => 'required|min_length[5]',
            'email'=> 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];
        if($this->validate($rules)){
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $email = $this->request->getVar('email');
            if($username && $password && $email){
                $checkusername = $this->usermodel->where('username',$username)->first();
                $checkemail = $this->usermodel->where('email',$email)->first();
                if($checkusername){
                    $error=1;
                    $message='Username telah terdaftar';
                }else if($checkemail){
                    $error=1;
                    $message='Email telah terdaftar';
                }else{
                    $password = password_hash($password,PASSWORD_DEFAULT);
                    $save = $this->usermodel->insert(array(
                            'username'=>$username,
                            'password'=>$password,
                            'email'=>$email,
                            'userlevel'=>0,
                            'status'=>0
                        )
                    );
                    if($save){
                        $session = session(); 
                        $session->setFlashdata('success','Pendaftaran berhasil, silahkan login');
                        $error=0;
                        $message='Pendaftaran berhasil';
                    }else{
                        $error=1;
                        $message='Gagal melakukan pendaftaran';
                    }
                }
            }else{
                $error=1;
                $message='Invalid data';
            }
        }else{
            $error=1;
            $message = strip_tags($this->validator->listErrors());
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        
        echo json_encode($d);
    }

    public function login()
    {
        $rules = [
            'username' => 'required|min_length[5]',
            'password' => 'required|min_length[8]'
        ];
        if($this->validate($rules)){
            //get data 
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            if($username){
                $conditions = array(
                    'username'=>$username,
                    'status'=>1
                );
                $data_user = $this->usermodel->where($conditions)->first();
                if($data_user){
                    $pass = $data_user['password'];
                    $verify_pass = password_verify($password, $pass);
                    if($verify_pass){
                        $session = session();
                        if($data_user['userlevel']==1){
                            $level='Admin';
                        }elseif($data_user['userlevel']==2){
                            $level='Karyawan';
                        }else{
                            $level='Anggota';
                        }
                        $ses_data = array(
                            'user_id'=>$data_user['id'],
                            'username'=>$data_user['username'],
                            'user_email'=>$data_user['email'],
                            'userlevel'=>$data_user['userlevel'],
                            'level'=>$level,
                            'logged_in'=>TRUE
                        );
                        $session->set($ses_data);
                        $error=0;
                        $message='Login Success';
                    }else{
                        $error=1;
                        $message='Invalid username or password';
                    }
                }else{
                    $error=1;
                    $message='Invalid username or password';
                }
            }else{
                $error=1;
                $message='Invalid username or password';
            }
        }
        else{
            $error=1;
            $message = strip_tags($this->validator->listErrors());
        }
        $d = array(
            'error'=>$error,
            'message'=>$message
        );
        
        echo json_encode($d);
    }

    function logout(){
        $session=session();
        $session->destroy();
        return redirect()->to('/'); 
    }
}


