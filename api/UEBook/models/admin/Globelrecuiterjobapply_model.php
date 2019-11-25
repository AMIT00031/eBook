<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Globelrecuiterjobapply_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->has_one['category'] = array('foreign_model' => 'job_category_model', 'foreign_table' => 'job_category', 'foreign_key' => 'id', 'local_key' => 'category_id');
    }

    public $table = "globelrecuiterjobapply";
    public $primary_key = "id";
   public function validateglobeljobapply_insert($data) {
            $this->db->select('*');
            $this->db->from('jobapply');
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
    public function globelvalidatejobapply_insert($data) {
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
  public function globelclasifiedjobs_select($user_id,$approvedstatus) {
        
         $query = 'select a.*,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname ,(select count(jobid) from globelrecuiterjobapply where job_id=a.id and user_id='.$user_id.') as appliedstatus,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname,(select email from users where id=a.userid) as useremail,(select username from users where id=a.userid) as username,
         (select clasifiedregion_name from clasifiedregion where clasifiedregion_id=a.selectcompany) as region ,
         (select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtype) as jobtypes
         ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobsubtype) as subjobtype
          ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtechnicaltitle) as jobtechnicaltitleval
         
         from globelrecuitmentjobsdescription as a where a.status=1   ';
            $query = $this->db->query($query);
            $result = $query->result();
            $resarray=array();
            foreach ($result as $res)
            {
            
              //if($res->appliedstatus==$approvedstatus){
                $resarray[] =$res;
              //}
            }
            if ($resarray) {
               return $resarray;
            } else {
                return false;
            }
 
  } 
  public function globelclasifiedjobs_select_filter($user_id,$approvedstatus,$filter) {
        
         $query = 'select a.*,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname ,(select count(jobid) from globelrecuiterjobapply where job_id=a.id and user_id='.$user_id.') as appliedstatus,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname,(select email from users where id=a.userid) as useremail,(select username from users where id=a.userid) as username,
         (select clasifiedregion_name from clasifiedregion where clasifiedregion_id=a.selectcompany) as region ,
         (select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtype) as jobtypes
         ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobsubtype) as subjobtype
          ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtechnicaltitle) as jobtechnicaltitleval
         
         from globelrecuitmentjobsdescription as a where a.status=1   ';
            foreach ($filter as $key => $value) {
               $query .= " AND a.".$key." = '".$value."'";
            }
            $query = $this->db->query($query);
            $result = $query->result();
            $resarray=array();
            foreach ($result as $res)
            {
            
              //if($res->appliedstatus==$approvedstatus){
                $resarray[] =$res;
              //}
            }
            if ($resarray) {
               return $resarray;
            } else {
                return false;
            }
 
  } 
  
  
   function globelgetuser($id) {
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
    
}
