<?php

class Books_model extends MY_Model {

    function __construct() {
        parent::__construct();
		define('UPLOADPATH',$_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/');
    }

    public $table = "tbl_books";
    public $primary_key = "id";
	
	//getbooksDetailByid, getbookMarkByBookid, getReviewbyBookid, getallQustionbyBook, gteAnsweredbyuser,isIsbnExists, updateBook, getbookByid, publishNewBook,addAssignment
	
	
	 public function getbooksDetailByid($bookId) {
		
		if($bookId){
			$mysql = "SELECT tbl_books.* , user_login_table.id AS userId,user_login_table.url as profile_pic, user_login_table.user_name FROM tbl_books LEFT JOIN user_login_table ON tbl_books.user_id = user_login_table.id WHERE tbl_books.id ='".$bookId."' ORDER BY tbl_books.id DESC";
		
			$query = $this->db->query($mysql);
	    
            if ($query->num_rows() > 0) { 
               
                $row = $query->row();
				
				$row->book_title = strip_tags($row->book_title);
				$row->book_description = strip_tags($row->book_description);
				if($row->thubm_image)
				$row->thubm_image = !empty($row->thubm_image)? UPLOADPATH.'books/'.$row->thubm_image: '';
				$row->book_image = !empty($row->book_image) ? UPLOADPATH.'books/gallery/'.$row->book_image: '';
				$row->video_url = !empty($row->video_url) ? UPLOADPATH.'books/video/'.$row->video_url : '';
				$row->audio_url = !empty($row->audio_url) ? UPLOADPATH.'books/audio/'.$row->audio_url : '';
				$row->pdf_url = !empty($row->pdf_url) ? UPLOADPATH.'books/document/'.$row->pdf_url : '';
				$row->profile_pic = !empty($row->profile_pic) ? UPLOADPATH.strip_tags($row->profile_pic) : '';
			 
				if($row->mostView >= 0){
					$MostVl = $row->mostView+1;
					$mysqlUpdate = "update tbl_books set mostView ='".$MostVl."' WHERE id='".$bookId."'";
					$run= $this->db->query($mysqlUpdate ); 
					//$run = mysql_query($mysqlUpdate );
				}
				return $row;
               
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
	 
        //$run = mysql_query($mysql);
       // $row = mysql_fetch_object($run);
			
    }
	
	public function getReviewbyBookid($booksId){
		
		if($booksId){
			$mysql = "SELECT tbl_review.id AS ReviewId,tbl_review.comment,tbl_review.rating ,tbl_review.created_at ,user_login_table.user_name,user_login_table.url FROM tbl_review LEFT JOIN user_login_table ON tbl_review.user_id = user_login_table.id WHERE tbl_review.books_id ='".$booksId."' ORDER BY tbl_review.id DESC";
		   // /echo $mysql;exit();
		
			$query = $this->db->query($mysql);
	    
            if ($query->num_rows() > 0) { 
               
                $row = $query->result();
				foreach($row as $key=>$res){ 
					 $row[$key]->url = ($res->url)?UPLOADPATH.strip_tags($res->url):''; 
				} 
				return $row;

			}else{
				return NULL;
			}

		}else{
			return NULL;
		}
	}
	
	public function getbookMarkByBookid($bookId,$userid) {        
        $mysql = "SELECT id AS bookmarkId, status AS bookmarkStatus FROM tbl_bookmark WHERE books_id ='".$bookId."' AND user_id ='".$userid."'";
        
		$query = $this->db->query($mysql);
	    
		if ($query->num_rows() > 0) { 
		   
			$row = $query->row();
			$row->bookmarkId = $row->bookmarkId;
			$row->bookmarkStatus = $row->bookmarkStatus;
			return $row;
			
			/* $run = mysql_query($mysql);
			$num_rows = mysql_num_rows($run);
			if ($num_rows > 0) {
				$markdata = mysql_fetch_object($run);
				$markdata->bookmarkId = $markdata->bookmarkId;
				$markdata->bookmarkStatus = $markdata->bookmarkStatus;
				return $markdata;
			} */
			
		}else{
			return NULL;
		}
	}

	public function getallQustionbyBook($bookId) { 
	
        $mysql = "SELECT id,book_id,question FROM tbl_faq WHERE book_id ='".$bookId."'";
        //echo $mysql;exit();
		$query = $this->db->query($mysql);
	    
		if ($query->num_rows() > 0) { 
		   
			$row = $query->result();
			foreach($row as $key=>$res){ 
				$row[$key]->id 	 = $res->id;
				$row[$key]->book_id = $res->book_id;
				$row[$key]->question= ($res->question=="[]")?'':$res->question;
			} 
			return $row;

		}else{
			return NULL;
		}
			
        /* if ($num_rows > 0) {
			$i=0;
			while($qdata = mysql_fetch_object($run)){

				$questionData[$i]['id'] 	 = $qdata->id;
				$questionData[$i]['book_id'] = $qdata->book_id;
				$questionData[$i]['question']= ($qdata->question=="[]")?'':$qdata->question;

				$i++;
			}	
			return $questionData;
		} */
	}
	
	public function gteAnsweredbyuser($user_id,$bookId){
		
        $mysql = "SELECT tbl_answer.question_id, tbl_answer.books_id , tbl_answer.answer,tbl_faq.question FROM tbl_answer RIGHT JOIN tbl_faq ON tbl_answer.question_id = tbl_faq.id WHERE tbl_answer.answered_by='".$user_id."' AND tbl_answer.books_id='".$bookId."' ORDER BY tbl_answer.question_id ASC";
        //echo $mysql;exit();
		$query = $this->db->query($mysql);

		if ($query->num_rows() > 0) { 
			$row = $query->result();
			return $row;

		}else{
			return NULL;;
		}
			
			
		/*   $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $rows[] = $res;
            }
            return $rows;
        } else {
            return NULL;
        } */  
		
	}
	
	public function addAnswer($answer){
		
        $answerData = json_decode($answer);
        foreach($answerData as $key => $value){
            $qid[] = $value->assignment_id;
            $ansby[] = $value->answered_by;
        }
        $qid = implode(",", $qid);
        $ansby = implode(",", $ansby);

        $mysql = "SELECT * FROM tbl_answer WHERE question_id IN ($qid) AND answered_by IN ($ansby)";
		$query = $this->db->query($mysql);
		if ($query->num_rows() > 0) { 
			$rows = $query->result();
			foreach($rows as $key=>$res){ 
				$rows[$key]->id 	 = $res->id;
			}  
		}
			  
		/* $assignmentData = mysql_query($mysql);
		while($ansdata = mysql_fetch_object($assignmentData)){
			$rows[] = $ansdata->id;
		} */
		 
        if(empty($rows)){
			foreach($answerData as $key => $value){
				$mysql = "INSERT INTO tbl_answer set answer ='".$value->answer."', answered_by='".$value->answered_by."', question_id='".$value->assignment_id."', books_id='".$value->books_id."'";
				$result = $this->db->query($mysql);
                //$result = mysql_query($mysql);
             }
             return true;
        }else{
            $updateData = array_combine($rows, $answerData);
            foreach($updateData as $key => $value){
                $mysql = "update tbl_answer set answer ='".$value->answer."' WHERE id=".$key;
                $result = $this->db->query($mysql);
					//$result = mysql_query($mysql);
            }
           return true;
        }    
	}
	
	public function UpdateAssignment($assignment_id,$answer,$answered_by){
        
		if(!empty($assignment_id)){
			
            $updated_at = date("Y-m-d H:i:s");
            $mysql = "update tbl_faq set answer ='".$answer."', answered_by='".$answered_by."', updated_at ='".$updated_at."' WHERE id='".$assignment_id."'";
            //$result = mysql_query($mysql);
			$result = $this->db->query($mysql);
            if($result == true){
				$mysql = "SELECT id, book_id, question, answer FROM tbl_faq WHERE id='".$assignment_id."' AND answered_by='".$answered_by."'";
                $query = $this->db->query($mysql);
				if ($query->num_rows() > 0) { 
					$rows = $query->row();
				}
				/* $assignmentData = mysql_query($mysql);
                $num_rows = mysql_num_rows($assignmentData);
                if ($num_rows > 0){
                    $rows =mysql_fetch_object($assignmentData);
                } */
			}
            return $rows;
      }else{
        return false;
      }
	}

	public function getBookbyCategoryId($cat_id){
        
		date_default_timezone_set('America/Los_Angeles');
        $rows = array();
        //$mysql = "SELECT id ,book_title, thubm_image, author_name,mostView FROM tbl_books WHERE category_id='".$cat_id."' AND status='1'";
		
        $mysql = "SELECT tbl_books.id ,tbl_books.book_title, tbl_books.thubm_image, tbl_books.author_name,tbl_books.book_description,tbl_review.rating FROM tbl_books LEFT JOIN tbl_review on tbl_books.id = tbl_review.books_id WHERE tbl_books.category_id='".$cat_id."' AND tbl_books.status='1' group by tbl_books.id ORDER BY tbl_books.id DESC"; 
        //echo $mysql;die;
		
		$query = $this->db->query($mysql);
		if ($query->num_rows() > 0) { 
			$rows = $query->result();
			foreach($rows as $key=>$res){ 
				$rows[$key]->book_title 	 = strip_tags($res->book_title);
				$rows[$key]->thubm_image =  ($res->thubm_image)?UPLOADPATH.'books/'.strip_tags($res->thubm_image):'';
				
			} 
            return $rows; 			
		}else {
            return NULL;
        }
		
        /* $result = mysql_query($mysql);
        $num_rows = mysql_num_rows($result);
        if ($num_rows > 0) {
            while($res = mysql_fetch_object($result)){
                $res->book_title = strip_tags($res->book_title);
                $res->thubm_image = $_SERVER['HTTP_HOST'].'/ebooks/api/v1/upload/books/'.strip_tags($res->thubm_image);
                
                $rows[] = $res;
            }
            return $rows;
        } */ 
    }
	
	public function isIsbnExists($isbn_number) {
	
		if($this->ValidIsbn($isbn_number)){
			$mysql = "SELECT id from tbl_books WHERE isbn_number='".$isbn_number."'";
			$query = $this->db->query($mysql);
			if ($query->num_rows() > 0) { 
				//$rows = $query->row();
				return false;
			}else{
				return true;
			}
		}else{
			return false;
		}
	}
	
	public function updateBook($data){
		
        date_default_timezone_set('America/Los_Angeles');
        $book_id          = $data['book_id'];
        $category_id      = $data['category_id'];
        $book_title       = $data['book_title'];
        $book_description = $data['book_description'];
        $author_name      = $data['author_name'];
        $thubm_image      = $data['thubm_image'];
        $pdf_url          = $data['pdf_url'];
        $audio_url        = $data['audio_url'];
        $book_image       = $data['book_image'];
        $video_url        = $data['video_url'];
        $questiondata     = $data['questiondata'];
        $isbn_number      = $data['isbn_number'];
        $date             = date('Y-m-d');
        $status           = $data['status'];
        $book_slug = strtolower($data['book_title']);
		$mysql = "update tbl_books set category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
                                       status           = '".$status."',
                                       updated_at       = '".$date."' where id='".$book_id."'";

									   
		$result = $this->db->query($mysql);
        //$result = mysql_query($mysql);
        if ($result){
            return $book_id ;
        } else {
            return false;
        }
    }

	public function getbookByid($id) {
        $mysql = "SELECT * FROM tbl_books WHERE  id='".$id."'";
		$query = $this->db->query($mysql);
		if ($query->num_rows() > 0) { 
			$rows = $query->row();
			return $rows;
		}else{
			return false;
		}
        //$run = mysql_query($mysql);
		//$row = mysql_fetch_object($run);
    }
	
	public function publishNewBook($data){
        date_default_timezone_set('America/Los_Angeles');
        $book_update_id   = $data['book_id'];
        $user_id          = $data['user_id'];
        $category_id      = $data['category_id'];
        $book_title       = $data['book_title'];
        $book_description = $data['book_description'];
        $author_name      = $data['author_name'];
        $thubm_image      = $data['thubm_image'];
        $pdf_url          = $data['pdf_url'];
        $audio_url        = $data['audio_url'];
        $book_image       = $data['book_image'];
        $video_url        = $data['video_url'];
        $questiondata     = $data['questiondata'];
        $isbn_number      = $data['isbn_number'];
		$is_paid     	  = $data['is_paid'];
		$admin_commission = $data['admin_commission']; 
		$price      	  = $data['price'];
        $date             = date('Y-m-d');
        $status           = $data['status'];
        $book_slug = $replaced = str_replace(' ', '-', strtolower($data['book_title'])); 
   
       if(is_numeric($book_update_id) && $book_update_id!=''){
		   
		   $mysql = "update tbl_books set user_id     = '".$user_id."',
                                       category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
									   is_paid      	= '".$is_paid."',
									   price      		= '".$price."',
									   admin_commission = '".$admin_commission."',
                                       status           = '".$status."',
                                       created_at       = '".$date."' where id='".$book_update_id."' ";   
		  
	   }else{
		   
         $mysql = "INSERT INTO tbl_books set user_id     = '".$user_id."',
                                       category_id      = '".$category_id."',
                                       book_title       ='".$book_title."',
                                       book_slug        =  '".$book_slug."',
                                       thubm_image      = '".$thubm_image."',
                                       pdf_url          = '".$pdf_url."',
                                       audio_url        = '".$audio_url."',
                                       book_image       = '".$book_image."',
                                       video_url        = '".$video_url."',
                                       question_data    = '".$questiondata."',
                                       isbn_number      = '".$isbn_number."',
                                       book_description = '".$book_description."',
                                       author_name      = '".$author_name."',
									   is_paid      	= '".$is_paid."',
									   price      		= '".$price."',
									   admin_commission = '".$admin_commission."',
                                       status           = '".$status."',
                                       created_at       = '".$date."'";  
	    }									   
		$result 	= $this->db->query($mysql);
		$books_id 	= $this->db->insert_id();
        //$result = mysql_query($mysql);
       // $books_id = mysql_insert_id();
		
		if($books_id) $books_id = $books_id;  else  $books_id = $book_update_id;
        
		if ($result){
			 
			 return $books_id;
			 
        } else {
            return false;
        }
    }

    public function addAssignment($bookId,$user_id,$question){
	
		if(!empty($question)){ 
			$bookData = json_decode($question);
			
			if(count($bookData)>1){
				foreach($bookData as $key => $value){
					 $mysql = "INSERT INTO tbl_faq set book_id = '".$bookId."',
													question  = '".$value."',
													questioned_by ='".$user_id."'"; 
					 //$result = mysql_query($mysql);
					 $result = $this->db->query($mysql);
					 
				}
			}else{ 
				  $mysql = "INSERT INTO tbl_faq set book_id = '".$bookId."',
												question  = '".$question."',
												questioned_by ='".$user_id."'"; 
				 //$result = mysql_query($mysql);
				  $result = $this->db->query($mysql);
				
				 
			}

			if ($result == 1){ 
				return true;
			} else {
				return false;
			}
		}
		else{ 
			return false;
		}
	}
   
    public function allCategoryList() {
        //UPLOADPATH
		$mysql = "SELECT * FROM tbl_category"; 
		$query = $this->db->query($mysql);
		if ($query->num_rows() > 0) { 
			$rows = $query->result();
			foreach($rows as $key=>$res){ 
				$mysql_cate = "SELECT count(*) as cate_count FROM tbl_books where status=1 and category_id='".$res->id."'"; 
				$result_cate = $this->db->query($mysql_cate);
				
				if($result_cate->num_rows()>0){
					$res_cate  = $result_cate->row();
					$rows[$key]->book_count = $res_cate->cate_count;
				}else $rows[$key]->book_count=0;
			}
            return $rows; 			
		}else {
            return 1;
        }
		
		
       /*  $result = mysql_query($mysql);
		$num_rows = mysql_num_rows($result);
        
        $rows = array();
        if ($num_rows > 0){
            while ($res = mysql_fetch_object($result)) {
				$mysql_cate = "SELECT count(*) as cate_count FROM tbl_books where status=1 and category_id='".$res->id."'"; 
				$result_cate = mysql_query($mysql_cate);
				$num_rows_cate = mysql_num_rows($result_cate); 
				if($num_rows_cate>0){
					$res_cate = mysql_fetch_object($result_cate);
					$res->book_count = $res_cate->cate_count;
				}else $res->book_count=0;
                $rows[] = $res;
            }
            return $rows;
        } else {
            return 1;
        } */
    }
   
	public function deleteBookbyId($books_id) {
		$mysql = "Update tbl_books set status ='0' WHERE id= '".$books_id."'";
		$result = $this->db->query($mysql);
		
		if ($result){ 
				return $t = $this->db->affected_rows();
		} else {
				return false;
		}
		
	}
   
   
   
   
   //below raw function not used
	
	public function getUserInfo($tbl_name, $where=array()) {
		
		if($tbl_name!='' && !empty($where)){
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->where($where);
			$query = $this->db->get();
			$rows  = array();
			
			if ($query->num_rows() > 0) {
				
				$result = $query->row();
				//$rowss  = (array) $result;
				//return $rowss;   
				return $result; 
			} else {
				return false;
			}
		}else{
			return false;
		}
    }
	
	function checkUserExist($tbl,$where='') { 
        if($tbl!='' && !empty($where)){
			$this->db->select('*');
			$this->db->from($tbl);
			$this->db->where($where);
			$query = $this->db->get();
			$rows  = array();
			if ($query->num_rows() > 0) { 
				return $query->num_rows(); 
			} else {
				return false;
			}
		}else{
			return false;
		}
    }
	
    function checkAccountExist($email) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email',$email);
		//$this->db->limit(1);
        $query = $this->db->get();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
			$result = $query->row();
            return $result;
        } else {
            return false;
        }
    }
   
	public function getDetailsOther($tbl,$fields='', $whrcond='',$user_id='') {
        
		$fields  = ($fields)?$fields:"*"; 
		
		if($tbl!=''){
			//$query = "select $fields from $tbl where 1"; 
			//( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )
			$querysel = "select $fields from $tbl as ult left join tbl_frnds ON ( tbl_frnds.user_id = ult.id OR tbl_frnds.frnd_id = ult.id )  WHERE 1 and ( tbl_frnds.user_id = $user_id OR tbl_frnds.frnd_id = $user_id ) and tbl_frnds.status=1 and ult.id != $user_id  group by ult.id"; 
			
			$query = $this->db->query($querysel);
	    
            if ($query->num_rows() > 0) { 
               
                $res = $query->result();
                //$rows[] = $res;	
                return $res;
				
			}else{
				return NULL;
			}
		}else{
			return NULL;
		}
    }
	
	
   
    function checkAccountExistById($id) { 
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$id);
		//$this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();
		//echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
	
    function isValidCode($code = '', $id = null) {

        if (!empty($code)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $this->db->where('activation_code', $code);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
	
    function isUserAlreadyActivated($id) {
        if (!empty($id)) {
            $this->db->select('*');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
                $active = $result->active;
                if ($active == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

	function getRecord($tblname,$id,$selectF='',$whrCond='') { 
	    $selectF = ($selectF)?$selectF:'*'; 
		$this->db->select($selectF);
		$this->db->from($tblname);
		if($id)$this->db->where('id',$id);
		if($whrCond)$this->db->where($whrCond);
		//$this->db->where('status',1);
		//$this->db->limit(1);
		$query = $this->db->get();
		if($query->num_rows() > 0):
			return $query->row();
		else:
			return false;
		endif;
	 }
    
    function getAllNotifications($user_id) {
        $data = array();
        $finalArray = array();
        $message = "";
        if (!empty($user_id)) {
            $this->db->select('n.notification_object_id,nb.entity_type,nb.entity_id,type.entity_type,type.entity_table,u.username,u.id as user_id,u.email');
            $this->db->from('notification n');
            $this->db->join('notification_object nb', 'nb.id=n.notification_object_id');
            $this->db->join('users u', 'n.notifier_id=u.id');
            $this->db->join('notification_entity_type type', 'type.id=nb.entity_type');
            $this->db->where('n.notifier_id', $user_id);
            $query = $this->db->get();
            $data = $query->result();
            if ($query->num_rows() > 0) {
                foreach ($data as $v) {
                    $entity = $v->entity_table;
                    $entity_id = $v->entity_id;
                    switch ($entity) {
                        case 'trips':
                            $query = $this->db->query("select id,title from trips where id = $entity_id");
                            $tripData = $query->row();
                            if (!empty($tripData)) {
                                $message = "You have received a new trip invitation named " . $tripData->title . "";
                            }
                            break;

                        default:
                            break;
                    }

                    $finalArray[] = array(
                        'notification_object_id' => !empty($v->notification_object_id) ? $v->notification_object_id : '',
                        'username' => !empty($v->username) ? $v->username : '',
                        'user_id' => !empty($v->user_id) ? $v->user_id : '',
                        'email' => !empty($v->email) ? $v->email : '',
                        'entity_type' => !empty($v->entity_type) ? $v->entity_type : '',
                        'trip_id' => !empty($tripData->id) ? $tripData->id : '',
                        'message' => $message,
                    );
                }
                return $finalArray;
            } else {
                return $finalArray;
            }
        }
    }
	function getuserdetails_select($id) {
    
        $this->db->select('*');
        $this->db->from('users');
        
        $this->db->where('id', $id);
        $query = $this->db->get();
        $result = $query->row();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
    
    
    function getusercontactusdetails_select($id) {
        $this->db->select('*');
        $this->db->from('users');
         $this->db->where('id != ', $id);
        $query = $this->db->get();
        $result = $query->result();

        if ($query->num_rows() > 0) {
            return $result;
        } else {
            return false;
        }
    }
     
	public function edituser_update($data) {
		$datan = array(
		'username' =>  $data['username'],
		'email' =>  $data['email'],
		'phone' =>  $data['phone'],
		'user_type' =>  $data['user_type'],
		'profilephoto' =>  $data['profilephoto'],
		'resume' =>  $data['resume'],
		);


		$this->db->where('id', $data['user_id']);

		$this->db->update('users', $datan);
		echo $this->db->last_query();
	}

}
