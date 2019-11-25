<?php

Class Cms extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation'));
        $this->load->model('admin/Cms_model');
        $this->load->model('admin/menu_manager_model');
        $this->cmsPageDir = $this->config->item('upload_cms_image');
    }

    function index() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }

        $list = $this->Cms_model->get_all();
        $data = array(
            'title' => 'CMS Page List',
            'list_heading' => 'CMS Pages',
            'pages' => $list,
        );

        $this->template->load('admin/base', 'admin/cms/list', $data);
    }

    function add($id = null) {
        $insertedArray = array();
        $pagesData = array();

        if (!empty($id)) {
            $pagesData = $this->Cms_model->get($id);
        }
        $data = $this->input->post();
        if (!empty($data)) {
            $insertedArray = !empty($data) ? $data : '';

            $name = !empty($insertedArray['page_title']) ? $insertedArray['page_title'] : '';
            $descriptions = !empty($insertedArray['desc']) ? $insertedArray['desc'] : '';

            $slug = url_title($name, 'dash', true);
            $insertedArray['url'] = $slug;
            $insertedArray['description'] = $descriptions;

            if (!empty($_FILES['image']['name'])) {
                $pagesImage['image'] = $_FILES['image'];
                $condition_array = array(
                    'path' => $this->cmsPageDir,
                    'extention' => 'jpeg|jpg|png',
                    'redirect_url' => 'admin/cms/add',
                );

                $iconImg = $this->Common_Model->uploadFile($pagesImage, $condition_array);
                $insertedArray['thumb_image'] = $iconImg;
            } else {
                $insertedArray['thumb_image'] = null;
            }

            try {
                if (!empty($id)) {
                    $update = $this->Cms_model->update($insertedArray, $id);
                    redirect('admin/cms', 'refresh');
                }

                $insert = $this->Cms_model->insert($insertedArray, FALSE);
                if ($insert) {
                    setMessage('Page added Successfully', 'success');
                    redirect('admin/cms', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('Page not added! Please Try again', 'error');
                redirect('admin/cms', 'refresh');
            }
        }

        $data = array(
            'title' => 'Add Page',
            'list_heading' => 'Page',
            'edit_data' => $pagesData,
        );
        $this->template->load('admin/base', 'admin/cms/add', $data);
    }

    function menu_manager() {
        if (!$this->ion_auth->logged_in()) {
            redirect('admin/auth/login', 'refresh');
        }

        $list = $this->menu_manager_model->get_all();
        $data = array(
            'title' => 'Menu Manager',
            'list_heading' => 'Menu Manager',
            'menus' => $list,
        );

        $this->template->load('admin/base', 'admin/cms/menu_list', $data);
    }

    function add_menus() {
        $insertedArray = array();
        $pagesData = array();

        if (!empty($id)) {
            $pagesData = $this->Cms_model->get($id);
        }
        $post = $this->input->post();
        if (!empty($post)) {
            try {

                $insert = $this->menu_manager_model->insert($post, FALSE);
                if ($insert) {
                    setMessage('Menu added Successfully', 'success');
                    redirect('admin/cms/menu_manager', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('Page not added! Please Try again', 'error');
                redirect('admin/cms/add_menus', 'refresh');
            }
        }

        $categoryList = $this->menu_manager_model->fetchCategoryTree();
        $cms_pages = $this->Cms_model->get_all();
//        dump($cms_pages);die;

        $data = array(
            'title' => 'Add Page',
            'list_heading' => 'Page',
            'categoryList' => $categoryList,
            'cms_pages' => $cms_pages
        );
        $this->template->load('admin/base', 'admin/cms/add_menu', $data);
    }

    function edit_menu($id = null) {
        if (!empty($id)) {
            $edit_data = $this->menu_manager_model->get($id);
        }

        $postData = $this->input->post();

        if (!empty($postData)) {
            try {
                $res = $this->menu_manager_model->update($postData, $id);
                if ($res) {
                    setMessage('Menu added Successfully', 'success');
                    redirect('admin/cms/menu_manager', 'refresh');
                }
            } catch (Exception $ex) {
                setMessage('Page not added! Please Try again', 'error');
                redirect('admin/cms/add_menus', 'refresh');
            }
        }

        $categoryList = $this->menu_manager_model->fetchCategoryTree();
        $cms_pages = $this->Cms_model->get_all();

        $data = array(
            'title' => 'Update Menu',
            'list_heading' => 'Update Menu',
            'categoryList' => $categoryList,
            'cms_pages' => $cms_pages,
            'edit_data' => $edit_data
        );
        $this->template->load('admin/base', 'admin/cms/edit_menu', $data);
    }

}
