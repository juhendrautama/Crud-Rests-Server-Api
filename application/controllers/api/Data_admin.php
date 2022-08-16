<?php
use Firebase\jwt\JWT;
use Firebase\jwt\Key;
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . 'libraries/JWT.php';
require APPPATH . 'libraries/Key.php';
class Data_admin extends REST_Controller {

    function __construct(){
    		 parent::__construct();
            $this->load->model('M_dataadmin');

    }
	
    public function tes_get(){
        $hendra=md5("hendra");
        $key = 'a';
        $payload = [
            'user' => 'juhendra utama ali',
            'email' => 'juhendrautama@gmail.com',
            'alamat' => 'jambi'
        ];
        
        $jwt = JWT::encode($payload, $key, 'HS512');
        // $decoded = JWT::decode($jwt, new Key($key, 'HS512'));
        return $jwt;
        
    }

    public function tes2_get(){
       print_r($this->tes_get());
        
    }


    public function login_post(){
       
        $user = $this->post('user');
        $pass = md5($_POST['pass']);
        $token = $this->tes_get();
        $hsl=$this->M_dataadmin->cek($user,$pass,$token);
        if($hsl->num_rows() > 0){
            $this->response([
                'status' => true,
                'Pesan'=>'Login Berhasil'
             ],REST_Controller::HTTP_OK); 
        }else{
            $this->response([
                'status' => false,
                  'Pesan' =>'Login Gagal',
              ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }
		
    public function index_get(){
        $id_admin = $this->get('id_admin');
        
        if($id_admin=== null){
            $data_admin = $this->M_dataadmin->Get_dataadmin();
        }else {
             $data_admin = $this->M_dataadmin->Get_dataadmin($id_admin);
        }
        
        
        if($data_admin){
              $this->response([
                    'status' => true,
                    'data' => $data_admin
                ], REST_Controller::HTTP_OK); 
        }else{
              $this->response([
                  'status' => false,
                    'Pesan' =>'Data Tidak Ada',
                ], REST_Controller::HTTP_NOT_FOUND); 
        }
    } 
    
    public function index_delete(){
        $id_admin = $this->delete('id_admin');
        if($id_admin===null){
             $this->response([
                  'status' => false,
                    'Pesan' =>'MASUKAN id_admin !',
                ],REST_Controller::HTTP_BAD_REQUEST); 
        }else{ 
            
            if($this->M_dataadmin->Hapus_data($id_admin) > 0){     
                 $this->response([
                    'status' => true,
                    'data'=>$id_admin,
                    'Pesan'=>'terhapus'
                 ],REST_Controller::HTTP_OK); 
            }else{
                 $this->response([
                  'status' => false,
                    'Pesan' =>'id tidak ada !',
                ], REST_Controller::HTTP_BAD_REQUEST); 
            }
            
        }
        
    }

    public function index_post(){
        $data=[
            'nama'=>$this->post('nama'),
            'user'=>$this->post('user'),
            'pass'=>md5($_POST['pass']),
            'pass_samaran'=>$this->post('pass')
        ];

        if($this->M_dataadmin->Tambah_data($data) > 0){
            $this->response([
                'status' => true,
                'Pesan'=>'DATA DI SIMPAN'
             ],REST_Controller::HTTP_CREATED); 
        }else{
            $this->response([
                'status' => false,
                  'Pesan' =>'Gagal simpan data',
              ], REST_Controller::HTTP_BAD_REQUEST); 
        }
    }

    
    public function index_put(){
        $id_admin = $this->put('id_admin');
        $data=[
            'nama'=>$this->put('nama'),
            'user'=>$this->put('user'),
            'pass'=>md5($this->put('pass')),
            'pass_samaran'=>$this->put('pass')
        ];

        if($this->M_dataadmin->Ubah_data($data, $id_admin) > 0){
            $this->response([
                'status' => true,
                'Pesan'=>'DATA DI UBAH'
             ],REST_Controller::HTTP_OK); 
        }else{
            $this->response([
                'status' => false,
                  'Pesan' =>'Gagal Ubah Data',
              ], REST_Controller::HTTP_BAD_REQUEST); 
        }

    }

}