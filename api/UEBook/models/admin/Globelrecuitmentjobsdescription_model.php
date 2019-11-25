<?php
/* Job_model
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Globelrecuitmentjobsdescription_model extends MY_Model {

    function __construct() {
        parent::__construct();
      
    }

    public $table = "globelrecuitmentjobsdescription";
    public $primary_key = "id";
  public function clasifiedjobs_select() {
        
         $query = 'select a.*,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname ,
         (select clasifiedregion_name from clasifiedregion where clasifiedregion_id=a.selectcompany) as region , (select username from users where id=a.userid) as username ,
         (select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtype) as jobtypes
         ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobsubtype) as subjobtype
          ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtechnicaltitle) as jobtechnicaltitleval
         
         from globelrecuitmentjobsdescription as a where a.status=1   ';
    $query = $this->db->query($query);
    $result = $query->result();
  
  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
   public function clasifiedjobsbyuser_select($userid) {
        
         $query = 'select a.*,(select clasifiedcompany_name from clasifiedcompany where clasifiedcompany_id=a.selectcompany) as companyname ,
         (select clasifiedregion_name from clasifiedregion where clasifiedregion_id=a.selectcompany) as region 
         
         ,
         (select count(jobid) from globelrecuiterjobapply where job_id=a.id) as totalapplied
         ,
         
         (select username from users where id=a.userid) as username ,
         
         (select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtype) as jobtypes
         ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobsubtype) as subjobtype
          ,(select clasifiedjobs_name from clasifiedjobs where clasifiedjobs_id=a.jobtechnicaltitle) as jobtechnicaltitleval
         
         from globelrecuitmentjobsdescription as a where a.status=1 and a.userid='.$userid.'   ';
    $query = $this->db->query($query);
    $result = $query->result();

  
          if ($result) {
               return $result;
            } else {
                return false;
            }
 
  } 
  
  
    public function getglobelappliedtotaljobuser($id) {
       if (!empty($id)) {
    $query = 'select a.* from users as a join globelrecuiterjobapply as b on b.user_id=a.id where b.job_id='.$id.' ';
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
