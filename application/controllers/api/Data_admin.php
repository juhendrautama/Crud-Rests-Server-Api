<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Data_admin extends REST_Controller {
    
    function __construct(){
    		 parent::__construct();
            $this->methods['users_get']['limit'] = 10; // 500 requests per hour per user/key
            $this->methods['users_post']['limit'] = 100; 
            $this->methods['users_delete']['limit'] = 100;
            $this->load->model('M_dataadmin');
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