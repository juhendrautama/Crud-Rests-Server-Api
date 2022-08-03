<?php
class M_dataadmin extends CI_Model {

		
    public function Get_dataadmin($id_admin=null){
        
        if($id_admin===null){
           return $this->db->get('tbl_admin')->result_array(); 
        }else{
            return $this->db->get_where('tbl_admin',['id_admin'=>$id_admin])->result_array();
        }
        
    }
    
      public function Hapus_data($id_admin){
          $this->db->delete('tbl_admin',['id_admin'=>$id_admin]);
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