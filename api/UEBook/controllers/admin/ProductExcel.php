<?php
Class ProductExcel extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/ProductExcel_model');
       $this->load->model('frontend/prodcut_track_url_model');
       $this->load->model('frontend/product_share_model');
       $this->load->model('frontend/affiliate_user_model');
        $this->tmpFileDir = $this->config->item('upload_temp_dir');
    }
    
    function index(){
        die('direct script not allowed');
    }

    function import() {
//        var_dump(extension_loaded ('zip'));die;
        $data = array('message' => '');
        if ($this->form_validation->run($this) != FALSE) {
            setMessage('Please select excel file to import', 'error');
            redirect('admin/product');
        } else {
            $arr_data = array();
            // config upload
            $config['upload_path'] = $this->tmpFileDir;
            $config['allowed_types'] = 'xlsx|csv|xls|xls';
            $config['max_size'] = '10000';
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('file')) {
                setMessage($this->upload->display_errors(), 'danger');
                redirect('admin/product/admin_curation_product');
            } else {
                $upload_data = $this->upload->data();

                $productFile = $upload_data['full_path'];
                chmod($productFile, 0777);
                $this->load->library('excel');
                //read file from path
                $objPHPExcel = PHPExcel_IOFactory::load($productFile);
                try {
                    $fileType = PHPExcel_IOFactory::identify($productFile);
                    $objReader = PHPExcel_IOFactory::createReader($fileType);
                    $objPHPExcel = $objReader->load($productFile);
                    $sheets = [];
                    foreach ($objPHPExcel->getAllSheets() as $sheet) {
                        $sheets[$sheet->getTitle()] = $sheet->toArray();
                    }
                } catch (Exception $e) {
                    log_message('Productfile : ', $e->getMessage());
                }
                $productRecordArray = array();
                $header = array();
                $srh = array("  ", " ", "_(", ")", "(");
                $repl = array("_", "_", "_", "", "_");
                $objWorksheet = $objPHPExcel->getActiveSheet();
                // format  each row  with column as key of array 
                foreach ($objWorksheet->getRowIterator() as $row) {
                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                    //    even if a cell value is not set.
                    // By default, only cells that have a value 
                    //    set will be iterated.
                    foreach ($cellIterator as $cell) {
                        $rowNumber = $cell->getRow();
                        $cell_value = $cell->getValue();
                        $column = $cell->getColumn();
                        if ($rowNumber == 1) {
                            $header[$rowNumber][$column] = str_replace($srh, $repl, strtolower(trim($cell_value)));
                        } else if ($rowNumber > 1) {
                            $productRecordArray[$rowNumber][$header[1][$column]] = $cell_value;
                        }
                    }
                }
                if (count($productRecordArray) > 0) {
//                    dump($productRecordArray);die;
                    $catId = NULL;
                    $subCatId = NULL;
                    foreach ($productRecordArray as $productData) {
                        $hotelInfoArray = array(); // array to  insert product  information
                        if (isset($productData['product-title']) && $productData['product-title'] != "") {
                            
                            if(isset($productData['category'])){
                                 $category_id = $this->getCategoryId($productData['category']);
                                    if(!empty($category_id)){
                                        $catId = $category_id;
                                    }
                            }
                            
                            if(isset($productData['sub-category'])){
                                 $subcategory = $this->getSubcategoryId($productData['category'],$productData['sub-category']);
                                    if(!empty($subcategory)){
                                        $subCatId = $subcategory;
                                    }
                            }
                            
                             if(isset($productData['store-name'])){
                                 $store_id = $this->getStoreId($productData['store-name']);
                                    if(!empty($store_id)){
                                        $storeId = $store_id;
                                    }
                            }
                            
                            if(isset($productData['product-title'])){
                                 $name = $productData['product-title'];
                                 $slug = url_title($name, 'dash', true);
                            }
                            
                            $productDataInsert[] = array(
                                'title' => $productData['product-title'],
                                'url' => $slug,
                                'category_id' => $catId,
                                'sub_category_id' => $subCatId,
                                'price' => $productData['price'],
                                'discription' => $productData['product-description'],
                                'product_url' => $productData['product-url'],
                                'medium_image' => $productData['product_image_url'],
                                'source' => 'admin',
                                'youtube_link' => $productData['youtube-link'],
                                'blog_link' => $productData['blog-link'],
                                'reviews' => $productData['reviews'],
                                'editor_review' => $productData['editors-review'],
                                'rating_count' => $productData['rating-count'],
                                'star_rating' => $productData['star-rating'],
                                'store' => $storeId,
                                'created_at' => date('Y-m-d H:i:s'),
                            );
                            
//                            $productId = $this->ProductExcel_model->importProducts($productDataInsert);
                        }
                    }
                    $this->db->insert_batch('product', $productDataInsert);
//                     dump($productDataInsert);die;
                }
            }
        }

        if (file_exists($productFile)) {
            try {
                unlink($productFile);
            } catch (Exception $e) {
                log_message('pricing file delete: ', $e->getMessage());
            }
        }
        setMessage('Product Imported Successfully','success');
        redirect('admin/product/admin_curation_product');
    }

    public function export($by = null) {
        $this->load->library('excel');
        $rowCount = 1;
        $column = 'A';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Product Export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Product List');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);



        $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);
        //   $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setSize(16);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Title');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Price');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'URL');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Currency Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Image');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Publisher');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Source');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Blog Link');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Youtube Link');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Description');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Reviews');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Editor Reviews');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Rating Count');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'Star Ratings');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Store Name');

        $filter_array = array();
        if(!empty($by) && ($by == 'admin_curation')){
            $filter_array = array('source' => 'admin');
        }
        $data = $this->ProductExcel_model->fields('title,price,product_url,currecny_code,medium_image,store,publisher,source,blog_link,youtube_link,discription,reviews,editor_review,rating_count,star_rating')->where($filter_array)->as_array()->get_all();
//        dump($data);die;
        if(!empty($data)){
            $counter = 1;
            $finalArray = array();
            foreach ($data as $value) {
                $storeName =  $this->ProductExcel_model->getStoreName($value['store']);
                $value['store_name'] = $storeName;
                unset($value['store']);
                $finalArray[] = $value;
                $counter++;
            }
        }
        $objPHPExcel->getActiveSheet()->fromArray($finalArray, null, 'A2');
        $this->excel->getActiveSheet()->fromArray($data);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="products(' . date('Y-m-d') . ').xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit();
    }
    
    function export_product_links(){
        $this->load->library('excel');
        $rowCount = 1;
        $column = 'A';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Products Tracking Links")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Products Tracking Links');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);


        $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Title');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'URL');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'TRACK DATE');

       
        $data = $this->prodcut_track_url_model->fields('product_title,url,created_at')->as_array()->get_all();
        $objPHPExcel->getActiveSheet()->fromArray($data, null, 'A2');
        $this->excel->getActiveSheet()->fromArray($data);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="LinkData(' . date('Y-m-d') . ').xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit();
    }
    
    function export_share_data(){
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        $this->load->library('excel');
        $rowCount = 1;
        $column = 'A';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Products Tracking Links")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Products Tracking Links');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);


        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product Link');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'IP Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Affiliate ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Share From');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Tracking ID');
        
        
        
        $postData = $this->input->post();
        if(!empty($postData)){
            $from_date = !empty($postData['from_date']) ? date('Y-m-d', strtotime($postData['from_date'])) : '';
            $to_date = !empty($postData['to_date']) ? date('Y-m-d', strtotime($postData['to_date'])) : '';
            if (!empty($from_date) && !empty($to_date)) {
                $filter_array = array('created_at >=' => $from_date, 'created_at <=' => $to_date);
                $list = $this->product_share_model->fields('user_type,product_link,ip_address,aff_sub2,ref_id,share_from,track_id')->where($filter_array)->as_array()->get_all();
                
                $objPHPExcel->getActiveSheet()->fromArray($list, null, 'A2');
                $this->excel->getActiveSheet()->fromArray($list);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="ShareData(' . date('Y-m-d') . ').xlsx"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit();
            } 
        }
    }
    
    function export_affiliate_product(){
         if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }
        
        $this->load->library('excel');
        $rowCount = 1;
        $column = 'A';
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setTitle("Products Tracking Links")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle('Products Tracking Links');

        $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);


        $objPHPExcel->getActiveSheet()->getStyle("A1:F1")->getFont()->setBold(true);

        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'User Type');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Product URL');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'IP Address');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Affiliate ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Associate Tag ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Store Name');
        
        
        
        $postData = $this->input->post();
        if(!empty($postData)){
            $from_date = !empty($postData['from_date']) ? date('Y-m-d', strtotime($postData['from_date'])) : '';
            $to_date = !empty($postData['to_date']) ? date('Y-m-d', strtotime($postData['to_date'])) : '';
            if (!empty($from_date) && !empty($to_date)) {
                $filter_array = array('created_at >=' => $from_date, 'created_at <=' => $to_date);
//                dump($filter_array);die;
                $list = $this->affiliate_user_model->fields('user_type,product_url,ip_address,aff_sub2,associate_tag_id,storename')->where($filter_array)->as_array()->get_all();
//                echo $this->db->last_query();die;
//                dump($list);die;
                $objPHPExcel->getActiveSheet()->fromArray($list, null, 'A2');
                $this->excel->getActiveSheet()->fromArray($list);
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="AffiliateData(' . date('Y-m-d') . ').xlsx"');
                header('Cache-Control: max-age=0');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit();
            } 
        }
    }
    
    function getCategoryId($category = '') {
        $name = removeExtraspace($category);
        /* check if already in database if not then add */
        if ($afid = $this->ProductExcel_model->getCategoryId($name)) {
            $fId = $afid;
        } else {
            /* add data in database  */
            $slug = url_title($category, 'dash', true);
            $categoryData = array('category' => $category, 'url' => $slug);
            $fId = $this->ProductExcel_model->addCategory($categoryData);
        }
        return $fId;
    }
    
    
      function getSubcategoryId($parent_category, $category = '') {
        $name = removeExtraspace($category);
        /* check if already in database if not then add */
        if ($afid = $this->ProductExcel_model->getSubCategoryId($name)) {
            $fId = $afid;
        } else {
            /* add data in database  */
            $slug = url_title($category, 'dash', true);
            $parent_id = $this->getCategoryId($parent_category);
            $categoryData = array('category' => $category, 'url' => $slug,'parent_id' => $parent_id);
            $fId = $this->ProductExcel_model->addCategory($categoryData);
        }
        return $fId;
    }
    
    function getStoreId($store = '') {
        $name = removeExtraspace($store);
        if ($afid = $this->ProductExcel_model->getStoreId($name)) {
            $fId = $afid;
        } else {
            $storeData = array('store_name' => $name);
            $fId = $this->ProductExcel_model->addStore($storeData);
        }
        return $fId;
    }

}
