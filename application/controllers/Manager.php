<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manager extends CI_Controller {

    private $userData;

    public function __construct()
    {
        parent::__construct();

        $this->userData = $this->session->userData();

        if(!isset($this->userData['level']) OR $this->userData['level'] == 0)
        {
            redirect(base_url());
        }
    }

    public function users()
    {
        if($this->userData['level'] < 2)
        {
            redirect(base_url());
        }
        
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('User_model', 'model');

        $viewData['items']= $this->model->result('*', [], $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/users'),
            'total_rows' => $this->model->get_count([]),
            
        ]);

        $viewData['pagination'] = $this->pagination->create_links();
        
        $this->render('manager/users',$viewData);
    }

    public function delete_user($id)
    {
        $this->load->model('User_model', 'model');

        $item = $this->model->row($id);
        
        if(is_object($item))
        {
            $this->model->delete($id);
        }
        redirect(base_url('manager/users'));

    } 

    public function edit_user($id)
    {
        $viewData = [];

        $this->load->model('User_model', 'model');
        
        $user = $this->model->row($id);

        if(!isset($user))
        {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required|min_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('level', 'Level', 'required|numeric');
        $this->form_validation->set_rules('password', 'Password', 'trim');

        if ($this->form_validation->run())
        {
            $data = [
                'first_name'   =>$this->input->post('first_name'),
                'last_name'    =>$this->input->post('last_name'),
                'address'      =>$this->input->post('address'),
                'email'        =>$this->input->post('email'),
                'level'        =>$this->input->post('level'),
            ];

            $password = $this->input->post('password');
            if($password)
            {
                $data{'password'} = md5(sha1($this->input->post('password')));
            }
            
            $this->model->update($data, $id);

            redirect(base_url('manager/users'));

        }
        $viewData['user'] = $user;

        $this->render('manager/edit_user',$viewData);
    }

    public function items()
    {
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Item_model', 'model');

        $viewData['items']= $this->model->result('*', [], $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/items'),
            'total_rows' => $this->model->get_count(),
            
        ]);

        $viewData['pagination'] = $this->pagination->create_links();
        
        $this->render('manager/items',$viewData);
    }

    public function edit_item($item_id)
    {
        $viewData = [];
        $this->load->model('Item_model', 'model');

        $item = $this->model->row($item_id);

        if(!isset($item))
        {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[34]');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric[3]|greater_than[0]');
        $this->form_validation->set_rules('qty', 'Qty', 'required|numeric');


        if ($this->form_validation->run())
        {
            $updateData = [
                'title'         =>$this->input->post('title'),
                'price'         =>$this->input->post('price'),
                'description'   =>$this->input->post('description'),
                'qty'   =>$this->input->post('qty'),
            ];
            
            $upload = $this->do_upload();
            if(isset($upload['error']))
            {
                $viewData['error'] = $upload['error'];
            }else{
                $updateData = $upload['data'];
            }

            $this->model->update($updateData, $item_id);
            $viewData['success'] = 'Item updated succesfully';

            redirect(base_url('manager/items'));

        }
        $viewData['item'] = $item;

        $this->render('manager/edit_item',$viewData);
    }
    
    public function delete_item($item_id)
    {
        $this->load->model('Item_model', 'model');

        $item = $this->model->row($item_id);
        
        if(is_object($item))
        {
            $this->model->delete($item_id);
        }
        redirect(base_url('manager/items'));

    }
    
    public function add_item()
    {
        $viewData = [];
        $this->load->model('Item_model', 'model');


        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[34]');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric[3]|greater_than[0]');
        $this->form_validation->set_rules('qty', 'Qty', 'required|numeric');


        if ($this->form_validation->run())
        {
            $upload = $this->do_upload();
            if(isset($upload['error']))
            {
                $viewData['error'] = $upload['error'];
            }else{
                $insertData = [
                    'title'         =>$this->input->post('title'),
                    'category_id'      =>$this->input->post('category_id'),
                    'price'         =>$this->input->post('price'),
                    'description'   =>$this->input->post('description'),
                    'qty'           =>$this->input->post('qty'),
                    'image'         =>$upload['data'],
                ];

                $this->model->insert($insertData);
            }
        }
        $this->render('manager/add_item',$viewData);
    }

    public function pages()
    {
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Page_model', 'model');

        $viewData['items']= $this->model->result('*', [], $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/pages'),
            'total_rows' => $this->model->get_count(),
            
        ]);

        $viewData['pagination'] = $this->pagination->create_links();
        
        $this->render('manager/pages',$viewData);
    }

    public function edit_page($item_id)
    {
        $viewData = [];
        $this->load->model('Page_model', 'model');

        $item = $this->model->row($item_id);

        if(!isset($item))
        {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('content', 'Content', 'required');

        if ($this->form_validation->run())
        {
            $updateData = [
                'title'         =>$this->input->post('title'),
                'content'         =>$this->input->post('content', true),
            ];

            $this->model->update($updateData, $item_id);
            $viewData['success'] = 'Item updated succesfully';

            redirect(base_url('manager/pages'));

        }
        $viewData['item'] = $item;

        $this->render('manager/edit_page',$viewData);
    }
    
    public function delete_page($item_id)
    {
        $this->load->model('Page_model', 'model');

        $item = $this->model->row($item_id);
        
        if(is_object($item))
        {
            $this->model->delete($item_id);
        }
        redirect(base_url('manager/pages'));

    }
    
    public function add_page()
    {
        $viewData = [];
        $this->load->model('Page_model', 'model');


        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('content', 'content', 'required');

        if ($this->form_validation->run())
        {
            $insertData = [
                'title'         =>$this->input->post('title'),
                'content'       =>$this->input->post('content', true),
            ];

            $this->model->insert($insertData);
            redirect(base_url('manager/pages'));
        }
        $this->render('manager/add_page',$viewData);
    }

    public function categories()
    {
        $viewData = [];

        $start = (int)$this->input->get('per_page');

        $viewData['categories']= $this->Category_model->result('*', [], $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/categories'),
            'total_rows' => $this->Category_model->get_count(),
            
        ]);

        $viewData['pagination'] = $this->pagination->create_links();
        
        $this->render('manager/categories',$viewData);
    }
    public function add_category()
    {
        $viewData = [];


        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[34]');

        if ($this->form_validation->run())
        {
            $insertData = [
                'title'         =>$this->input->post('title')
            ];

            $this->Category_model->insert($insertData);
            redirect(base_url('manager/categories'));
        }

        $this->render('manager/add_category',$viewData);

    }

    public function delete_category($id)
    {
        $item = $this->Category_model->row($id);
        
        if(is_object($item))
        {
            $this->Category_model->delete($id);
        }
        redirect(base_url('manager/categories'));

    } 

    public function edit_category($id)
    {
        $viewData = [];

        $item = $this->Category_model->row($id);

        if(!isset($item))
        {
            show_404();
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'required|min_length[3]|max_length[34]');

        if ($this->form_validation->run())
        {
            $data = [
                'title'         =>$this->input->post('title')
            ];

            $this->Category_model->update($data, $id);
            redirect(base_url('manager/categories'));
        }
        $viewData['item'] = $item;

        $this->render('manager/edit_category',$viewData);

    }

    public function orders()
    {
        $viewData = [];

        $start = (int)$this->input->get('per_page');
        $this->load->model('Order_model', 'model');

        $viewData['items']= $this->model->result('*', [], $start);

        $this->pagination->initialize([
            'base_url'   => base_url('manager/orders'),
            'total_rows' => $this->model->get_count(),
            
        ]);

        $viewData['pagination'] = $this->pagination->create_links();
        
        $this->render('manager/orders',$viewData);
    }

    public function delete_order($id)
    {
        $this->load->model('Order_model');

        $item = $this->Order_model->row($id);
        
        if(is_object($item))
        {
            $this->Order_model->delete($id);
        }
        redirect(base_url('manager/orders'));

    }

    public function edit_order($id)
    {
        $this->load->model('Order_model', 'model');

        $item = $this->model->row($id);
        $status = $this->input->post('status');
        if($status&&$item)
        {
            $this->model->update(['status'=>$status], $id);
        }
        redirect(base_url('manager/orders'));

    }

    public function order_detail($order_id)
    {
        $this->load->model('Order_model', 'model');
        $items = $this->model->get_items($order_id);
        $data = [
            'items' => $items,
        ];
        $this->load->view('order_detail', $data);
    }

    private function do_upload()
    {
        $config = [
            'upload_path'      => './uploads/',
            'upload_path'      => './uploads/',
            'allowed_types'    => 'gif|jpg|png',
            'max_size'         => 100,
            'max_width'        => 1024,
            'max_height'       => 768,
            'encrypt_name'     => true,

        ];

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('image'))
        {
            return  array('error' => $this->upload->display_errors($this->config->item('error_prefix'), $this->config->item('error_suffix')));
        }
        else
        {
            return array('data' => $this->upload->data('file_name'));

        }
    }

    private function render($page, $data = [])
    {
        $categories = $this->Category_model->result('*');

        $headerData = [
            'categories'    =>$categories,
            'user'          =>$this->userData,
        ];

        $this->load->view('inc/header', $headerData);
		$this->load->view($page,$data);
		$this->load->view('inc/footer');
    }
}
