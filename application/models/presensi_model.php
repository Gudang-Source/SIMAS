<?php

class Presensi_model extends CI_Model
{

    public function addHarian($tahun_akademik, $semester)
    {
        $data=[
            'tahun_akademik'=>$tahun_akademik,
            'semester'=>$semester,
            'tanggal'=>date('Y-m-d'),
            'hari'=>date('D'),
            'id_guru'=> $_POST['id'],
            'jam_masuk'=>date('H:i:s')
        ];

        $this->db->insert('presensi_harian',$data);
        return $this->db->affected_rows();
    }

    public function updateJamKeluar()
    {
        $this->db->set('jam_pulang', date('H:i:s'));
        $this->db->where('id_guru', $_POST['id']);
        $this->db->where('tanggal',date('Y-m-d'));
        $this->db->update('presensi_harian');
        return $this->db->affected_rows();
    }

    public function cekExistMasuk()
    {
        return $this->db->get_where('presensi_harian',['id_guru'=>$_POST['id'],'tanggal'=>date('Y-m-d')]);
    }

    public function getJamMasuk()
    {
        $query= $this->db->get_where('presensi_harian',['id_guru'=>$_POST['id'],'tanggal'=>date('Y-m-d')]);
        $ret = $query->row();
        return $ret->jam_masuk;
    }

    public function getIDPresensiHarian()
    {
        $query= $this->db->get_where('presensi_harian',['id_guru'=>$_POST['id']]);
        $ret = $query->row();
        return $ret->id_presensi_harian;
    }

    public function getRFID()
    {
        $query =$this->db->get_where('guru', ['rfid'=>$_POST['rfid']]);
        // $query =$this->db->get_where('guru', ['rfid'=>$id]);
        $ret = $query->row();
        if(isset($ret)){
            return $ret->id_guru;
        }else{
            return 'fail';
        }

    }

    public function getLibur()
    {
        return $this->db->get_where('libur',['tanggal_libur'=>date('Y-m-d')])->result_array();
    }

    public function getNama()
    {
        $query =$this->db->get_where('guru', ['id_guru'=>$_POST['id']]);
        $ret = $query->row();
        return $ret->nama_guru;
    }

}