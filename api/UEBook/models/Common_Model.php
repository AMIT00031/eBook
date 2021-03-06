<?php

class Common_Model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }
		public function check_admin_login_status() {        $_id = $this->session->userdata('admin_id');        if (!empty($_id)) {            return true;        } else {            return false;        }    }	

    function getUserDetail($id) {
        if (!empty($id)) {
            $this->db->select('username,email,location,phone,created_at,updated_at,device_id,user_type');
            $this->db->from('users');
            $this->db->where('id', $id);
            $query = $this->db->get();
            $result = $query->row();
            if ($result) {
               return $result;
            } else {
                return false;
            }
        }else{
			return false;
		}
    }
	
	
	function get_country($id='') {
           
            $this->db->select('id,code,continent_code,currency_code,continent_code,phone,name,capital,asciiname');
            $this->db->from('oilcountries');
			
            if($id) $this->db->where('id', $id);
			$this->db->where('active', 1);
            $query = $this->db->get();
			//echo $this->db->last_query();
            $result = $query->result();
            if (!empty($result)) {
               return $result;
            } else {
                return false;
            }
        
    }
	
	function get_currencies($code="",$id='') {
        
            $this->db->select('id,code,font_arial,name,html_entity');
            $this->db->from('oilcurrencies');
            if($id)$this->db->where('id', $id);
			if($code)$this->db->where('code', $code);
            $query 	= $this->db->get();
            $result = $query->row();
            if (!empty($result)) {
               return $result;
            } else {
                return false;
            }
        
    }
	
	function get_city($c_code='',$city_id='') {
           
            $this->db->select('id,country_code,name,latitude,longitude,asciiname');
            $this->db->from('oilcities');
            if($c_code)$this->db->where('country_code', $c_code);
			if($city_id)$this->db->where('id', $city_id);
            $query = $this->db->get();
            $result = $query->result();
			//echo $this->db->last_query(); die;
            if (!empty($result)) {
               return $result;
            } else {
                return false;
            }     
    }
	
	function get_category($cat_id='') {
           //classified categores: type="classified"
            $this->db->select('id,name,type,icon_class,slug');
            $this->db->from('oilcategories');
            if($cat_id)$this->db->where('id', $cat_id);
            $query = $this->db->get();
            $result = $query->result();
			//echo $this->db->last_query(); die;
            if (!empty($result)) {
               return $result;
            } else {
                return false;
            }      
    }
    function uploadFile($file = array(), $conditionArray = array()) {
        $fileName = '';
        $uploadFile = '';
        if (!empty($file) && !empty($conditionArray)) {
            $ab = key($file);
            if ($this->form_validation->run($this) != FALSE) {
                setMessage('Please select a file to upload', 'warning');
                redirect($conditionArray['redirect_url'], 'referesh');
            } else {
                $setting['upload_path'] = $conditionArray['path'];
                if (array_key_exists('extention', $conditionArray)) {
                    $setting['allowed_types'] = $conditionArray['extention'];
                }
                if (array_key_exists('max_width', $conditionArray)) {
                    $setting['max_width'] = $conditionArray['max_width'];
                }
                if (array_key_exists('max_height', $conditionArray)) {
                    $setting['max_height'] = $conditionArray['max_height'];
                }
                if (array_key_exists('size', $conditionArray)) {
                    $setting['max_size'] = $conditionArray['size'];
                }

                if (array_key_exists('min_width', $conditionArray)) {
                    $setting['min_width'] = $conditionArray['min_width'];
                }
                if (array_key_exists('min_height', $conditionArray)) {
                    $setting['min_height'] = $conditionArray['min_height'];
                }

                $this->load->library('upload', $setting);
                $this->upload->initialize($setting);
                if (!$this->upload->do_upload($ab)) {
                    setMessage($this->upload->display_errors(), 'warning');
                    redirect($conditionArray['redirect_url'], 'referesh');
                } else {
                    $upload_data = $this->upload->data();
                    $fileName = $upload_data['file_name'];
                    $image_path = $upload_data['full_path'];
                    try {
                        chmod($image_path, 0777);
                    } catch (Exception $e) {
                        log_message('file permession: ', $e->getMessage());
                    }
                }

                return $fileName;
            }
        }
        return false;
    }

    function deleteCustomeAttribute($tableName = null, $coloum = null, $id = null, $extraCondition = array()) {
        if (!empty($tableName) && !empty($coloum)) {
            $this->db->where($coloum, $id);
            $res = $this->db->delete($tableName);
            if ($res) {
                return true;
            }
            return false;
        }else{			return false;		}
    }

    function push_notification($user_mobile_info, $payload_info, $trip_id, $sender_id, $to_id, $notification_type, $title) {
       
        $user_device_key = $user_mobile_info['user_mobile_token'];
        $api_key = 'AAAAO_GwUeQ:APA91bGOmp4b8eiKZtytk6n-Jhd7aOkQ_xiGUwl57ZZuH99DzCdw9fMKvmLnwRG0AElnS5Og36jNKjuORKpof0_xGtVSPwaBJ5XYD68qTCSqXMS1eoNJL5XXNeAGjKjCu1WgO23QQRzN';
        $registrationIds = $user_device_key;
        #prep the bundle
         //dump($api_key);die;
        $msg = array
            (
            'body' => json_decode($payload_info)->aps->message,
            'title' => $title,
            'icon' => 'myicon', /* Default Icon */
            'sound' => 'mySound'/* Default sound */
        );
       
        $fields = array
            (
            'to' => $registrationIds,
            'notification' => $msg
        );
 

        $headers = array
            (
            'Authorization: key=' . $api_key,
            'Content-Type: application/json'
        );
      
        #Send Reponse To FireBase Server	
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        $response = json_decode($result);
        
        if ($response->success == 1) {
            $insert_log = "INSERT INTO notification_log set message ='" . json_decode($payload_info)->aps->message . "',
                            device_token     ='" . $user_device_key . "',
                            status          ='1',
                            trip_id    ='" . $trip_id . "',
                            type    ='" . $notification_type . "',
                            title    ='" . $title . "',
                            request_from    ='" . $sender_id . "',
                            sending_date    ='" . date('Y-m-d H:i:s') . "',
                            to_id    ='" . $to_id . "'";

            $result = $this->db->query($insert_log);
            return 1;
            curl_close($ch);
        } else {
            return false;
            curl_close($ch);
        }
    }

    function create_payload_json($message, $title) {
        $badge = "0";
        $sound = 'default';
        $payload = array();
        $payload['aps'] = array('message' => $message, 'title' => $title, 'badge' => intval($badge), 'sound' => $sound);
        return json_encode($payload);
    }

}
