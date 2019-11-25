<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Job_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->has_one['category'] = array('foreign_model' => 'job_category_model', 'foreign_table' => 'job_category', 'foreign_key' => 'id', 'local_key' => 'category_id');
    }

    public $table = "jobs";
    public $primary_key = "id";
 function getUserDetail($id,$jid,$reguser_id) {
    if (!empty($id)) {
        $query = 'select a.*,(select count(*) from jobapply where user_id = '.$reguser_id.' and job_id = '.$jid.'  ) as countitems 
        ,(select fav_id from jobfav where user_id = '.$reguser_id.' and job_id = '.$jid.' ) as favitems
        from users as a where a.id='.$id.' ';
        $query = $this->db->query($query);
        $result = $query->result();
      
        /*
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();*/
            if ($result) {
               return $result[0]->username."_".$result[0]->countitems."_".$result[0]->favitems."_".$result[0]->email;
            } else {
                return false;
            }
        }
    }
    
    function getUsertotDetail($id,$jid,$reguser_id) {
        if (!empty($id)) {
    $query = 'select a.*,(select count(*) from jobapply where  job_id = '.$jid.'  ) as countitems 
    ,(select count(*) from jobfav where   job_id = '.$jid.' and fav_id="1" ) as favitems
    from users as a where a.id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
  
    /*
            $this->db->select('username');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();*/
            if ($result) {
               return $result[0]->username."_".$result[0]->countitems."_".$result[0]->favitems."_".$result[0]->email;
            } else {
                return false;
            }
        }
    }
    
    
    public function validatejobapply_insert($data) {
            $this->db->select('*');
            $this->db->from('globelrecuiterjobapply');
            $this->db->where('user_id', $data['user_id']);
              $this->db->where('job_id', $data['job_id']);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
               return "true";
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
  public function jobapply_insert($data) {
      
    $this->db->insert('globelrecuiterjobapply', $data);  
      
  }
     public function validatefav($data) {
        
            $this->db->select('*');
            $this->db->from('jobfav');
            $this->db->where('user_id', $data['user_id']);
              $this->db->where('job_id', $data['job_id']);
            $query = $this->db->get();
            $result = $query->row();
          if ($result) {
               return "true";
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
  
   public function favapply_insert($data) {
      
    $this->db->insert('jobfav', $data);  
      
  }
   public function favapply_update($data) {
      /*$this->db->set('fav_id',$data['fav_id'])
       ->where('user_id',$data['user_id'])
         ->where('job_id',$data['job_id'])
        ->update('jobfav');*/
       

  $this->db->where('user_id',$data['user_id']);  
        $this->db->where('job_id',$data['job_id']); 
    $query = $this->db->delete('jobfav');


    $this->db->insert('jobfav', $data);  
      
  }
      public function jobrole_select() {
        
            $this->db->select('*');
            $this->db->from('job_role');
             $query = $this->db->get();
            $result =  $query->result();
          if ($result) {
               return $result;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  } 
  public function jobnotification_select($id) {
        
     //  echo $id; exit; 
        $sql = "SELECT b.user_id,(SELECT username FROM users where id=b.user_id) as username,a.* FROM jobs as a join jobapply as b on a.id=b.job_id where a.user_id=$id";
$query = $this->db->query($sql);
 $query = $query->result();

          if ($query) {
               return $query;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
  
  function getuser($id) {
        if (!empty($id)) {
    $query = 'select a.* from users as a where a.id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
            if ($result) {
               return $result[0]->username.'-'.$result[0]->resume;
            } else {
                return false;
            }
        }
    }
    
      public function jobrequestn_select($id) {
        
     //  echo $id; exit; 
        $sql = "SELECT b.jobid as appjid,b.user_id as appuid,b.jobapplied,b.user_id,(SELECT username FROM users where id=b.user_id) as appuname
        ,(SELECT email FROM users where id=b.user_id) as appemail
        ,a.* FROM jobs as a join jobapply as b on a.id=b.job_id where b.jobapplied='0' and  a.user_id=$id";
$query = $this->db->query($sql);
 $query = $query->result();

          if ($query) {
               return $query;
            } else {
                return false;
            }
  //  $this->db->insert('jobapply', $data);  
      
  }
   public function acceptforjob_update($data) {
       $datan = array( 
    'Updated_on'      => $data['Updated_on'] , 
    'updated_uid' => $data['user_id'], 
     'jobapplied' =>1, 
    'message'       => $data['message']
);

$this->db->where('jobid', $data['appjid']);

$this->db->update('jobapply', $datan);

 $from_email = "no-reply@oilbizz.com"; 
         $to_email = $data['email']; 
  $mess="<table width='100%' border='0'>
  <tr><td>Dear,</td></tr>
   <tr><td>Your Job Acceptance is Approved By User </td></tr>
    <tr><td>&nbsp;</td></tr>  <tr><td>&nbsp;</td></tr>  <tr><td>&nbsp;</td></tr>
     <tr><td>Thanks </td></tr>
       <tr><td>oilBizz Team   </td></tr>
  </table>
  "; 
         //Load email library 
         $this->load->library('email'); 
   $this->email->set_mailtype("html");
         $this->email->from($from_email, 'OilBizz'); 
         $this->email->to($to_email);
         $this->email->subject('OilBizz Job Acceptance '); 
         $this->email->message($mess); 
     $this->email->send();


/*
      $this->db->set('fav_id',$data['fav_id'])
       ->where('jobid',$data['appjid'])
              ->update('jobapply');*/
   
      
  }
   public function rejectforjob_update($data) {
       $datan = array( 
    'Updated_on'      => $data['Updated_on'] , 
    'updated_uid' => $data['user_id'], 
     'jobapplied' =>1, 
    'message'       => $data['message']
);

$this->db->where('jobid', $data['appjid']);

$this->db->update('jobapply', $datan);

 $from_email = "no-reply@oilbizz.com"; 
         $to_email = $data['email']; 
  $mess="<table width='100%' border='0'>
  <tr><td>Dear,</td></tr>
   <tr><td>Your Job Acceptance is Rejected By User </td></tr>
    <tr><td>&nbsp;</td></tr>  <tr><td>&nbsp;</td></tr>  <tr><td>&nbsp;</td></tr>
     <tr><td>Thanks </td></tr>
       <tr><td>oilBizz Team   </td></tr>
  </table>
  "; 
         //Load email library 
         $this->load->library('email'); 
   $this->email->set_mailtype("html");
         $this->email->from($from_email, 'OilBizz'); 
         $this->email->to($to_email);
         $this->email->subject('OilBizz Job Rejection '); 
         $this->email->message($mess); 
     $this->email->send();


/*
      $this->db->set('fav_id',$data['fav_id'])
       ->where('jobid',$data['appjid'])
              ->update('jobapply');*/
   
      
  }

   public function getappliedjobuser($id) {
       if (!empty($id)) {
    $query = 'select a.* from jobs as a join jobapply as b on b.job_id=a.id where b.user_id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        }  
  }
     public function getappliedtotaljobuser($id) {
       if (!empty($id)) {
    $query = 'select a.* from users as a join jobapply as b on b.user_id=a.id where b.job_id='.$id.' ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        }  
  }
  
    public function getappliedtotalfavuser($id) {
       if (!empty($id)) {
    $query = 'select a.* from users as a join jobfav as b on b.user_id=a.id where b.job_id='.$id.' and fav_id="1" ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
            if ($result) {
               return $result;
            } else {
                return false;
            }
        }  
  }
}
