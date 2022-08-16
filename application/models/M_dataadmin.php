<?php
class M_dataadmin extends CI_Model {

		
    function Cek($user,$pass,$token){	
        $hsl=$this->db->query("select id_admin,nama,user,pass,pass_samaran,tgl,level,prov,kab_kot,kec,des_kel,rt_dusun,id_dasawisma from tbl_admin where user='$user' and pass='$pass' and token='$token'");
        return $hsl;				
    } 

    public function Get_dataadmin($id_admin=null){
        
        if($id_admin===null){
            $hsl=$this->db->query("select * from tbl_admin")->result_array();
            return $hsl;
        }else{
            $hsl=$this->db->query("select * from tbl_admin where id_admin ='$id_admin'")->result_array();
            return $hsl;
        }
        
    }
    
      public function Hapus_data($id_admin){
        $this->db->query("delete from tbl_admin where id_admin = '$id_admin' ");
		return $this->db->affected_rows();

      }

      public function Tambah_data($data){
        $this->db->insert('tbl_admin',$data);
        return $this->db->affected_rows();
    }

    public function Ubah_data($data, $id_admin){
        $this->db->update('tbl_admin',$data,['id_admin'=>$id_admin]);
        return $this->db->affected_rows();
    }
      
}