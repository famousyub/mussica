<?php

use PSpell\Config;

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    private $userData;

    public function __construct()
    {
        parent::__construct();
        $this->userData = $this->session->userData();
    }

    public function index($category_id = 0)
    {
        $this->load->model('Item_model', 'model');
        $viewData = [];
        $search = $this->input->get('search');
        $start = (int) $this->input->get('per_page');
        $where = [];
    
        if ($search) {
            $where['title LIKE'] = '%' . $search . '%';
        }
    
        if ($category_id) {
            $where['category_id'] = (int) $category_id;
        }
    
        $where['qty >'] = 0;
    
        $viewData['items'] = $this->model->result('id, title, price, image, qty', $where, $start);
    
        $this->pagination->initialize([
            'base_url' => base_url() . ($category_id ? 'category/' . $category_id : '') . ($search ? '?search=' . $search : ''),
            'total_rows' => $this->model->get_count($where),
        ]);
    
        $viewData['pagination'] = $this->pagination->create_links();
    
        $this->render('home', $viewData);
    }
    

    public function add_cart($item_id)
    {
        if(!isset($this->userData['logged']))
        {
            redirect(base_url('login'));

        }else{
            
            $this->load->model('Item_model');
            $item = $this->Item_model->row($item_id);

            if(!is_object($item))
            {
                show_404();
            }
            $this->userData['cart'] [] = $item_id;
            $this->session->set_userdata('cart',$this->userData['cart'] );
            redirect(base_url('cart'));
        }
    }

    public function cart()
    {
        if(!isset($this->userData['logged']))
        {
            redirect(base_url('login'));
        }

        $delete = $this->input->get('del');
        if($delete)
        {
            unset($this->userData['cart'][$delete-1]);
            $this->session->set_userdata('cart',$this->userData['cart'] );

            redirect(base_url('cart'));
        }

        $this->load->model('Item_model');
        $data = ['total' => 0];
        foreach($this->userData['cart'] as $key=>$item_id)
        {
            $item = $this->Item_model->row($item_id);

            $data['items'][$key] = $item;
            $data['total'] += $item->price;
        }
        $this->render('cart', $data);
    }

    public function checkout()
    {
        if(!isset($this->userData['cart']) || !is_array($this->userData['cart']))
        {
            redirect(base_url('checkout'));
        }

        $this->load->model('Item_model');
        $this->load->model('Order_model');
        $this->load->model('OrderItem_model');
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation
            ->set_rules('first_name', 'First Name', 'required')
            ->set_rules('last_name', 'Last Name', 'required')
            ->set_rules('address', 'Address', 'required')
            ->set_rules('paymentmethod', 'Payment method', 'required');


        $data = ['total' => 0];

        foreach($this->userData['cart'] as $key=>$item_id)
        {
            $item = $this->Item_model->row($item_id);
            $data['items'][$key] = $item;
            $data['total'] += $item->price;
            
        }

        if($this->form_validation->run()){
            $orderData = [
                'first_name'    => $this->input->post('first_name'),
                'last_name'     => $this->input->post('last_name'),
                'address'       => $this->input->post('address'),
                'paymentmethod' => $this->input->post('paymentmethod'),
                'user_id'       => $this->userData['user_id'],
                'price'       => $data['total'],
            ];

            
            $order_id = $this->Order_model->insert($orderData);

            if($order_id){
                foreach($data['items'] as $item)
                {
                    $this->OrderItem_model->insert([
                        'order_id'  =>$order_id,
                        'item_id'   =>$item->id,
                        'title'     =>$item->title,
                        'price'     =>$item->price,
                    ]);

                    $data = ['qty'       => $item->qty-1];

                    $this->Item_model->update($data, $item->id);

                }
                $this->userData['cart'] = [];
                $this->session->set_userdata('cart', $this->userData['cart'] );

                echo('order success');
                redirect(base_url('orders'));
            }else{
                echo('system error');
            }
        }

        $data['user'] = $this->userData;
        $this->render('checkout', $data);
    }

    public function orders()
    {
        if(!isset($this->userData['logged']))
        {
            redirect(base_url('login'));
        }
        $this->load->model('Order_model', 'model');
        $start = (int)$this->input->get('per_page');
        $limit = $this->config->item('per_page');
        $where = ['user_id' => $this->userData['user_id']];

        $this->pagination->initialize([
            'base_url'   => base_url('orders'),
            'total_rows' => $this->model->get_count($where),
            
        ]);

        $data=[
            'items' => $this->model->result('*', $where),

            'pagination' => $this->pagination->create_links(),
        ];

        $this->render('orders', $data);
    }

    public function logout()
    {
        $this->session->unset_userdata([

            'logged', 'user_id', 'first_name', 'last_name','address', 'email'    
        ]);

        redirect(base_url('home'));
    }

    public function login()
    {
        if(isset($this->userData['logged']))
        {
            redirect(base_url());
        }
        
        $viewData = [];

        $this->load->model('User_model', 'model');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run())
        {
            $user =[
                'email'     =>$this->input->post('email'),
                'password'  =>md5(sha1($this->input->post('password'))),
            ];
            
            $userData = $this->model->row($user, 'id,first_name,last_name,address,email,level');
            if(is_object($userData))
            {
                $newdata = [
                    'logged'        => true, 
                    'user_id'       =>$userData->id,
                    'first_name'    =>$userData->first_name,
                    'last_name'     =>$userData->last_name,
                    'address'       =>$userData->address,
                    'email'         =>$userData->email,
                    'level'         =>$userData->level,
                ];

                $newdata['cart'] = isset($this->userData['cart']) ? $this->userData['cart'] : [] ;

                $this->session->set_userdata($newdata);
                redirect(base_url());
            }else{
                $viewData['error'] = 'login or password incorrect. ';
            }
        }
        $this->render('login',$viewData);
    }

    public function register()
    {
        if(isset($this->userData['logged']))
        {
            redirect(base_url());
        }

        $viewData = [];

        $this->load->model('User_model', 'model');

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First Name', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|min_length[2]|max_length[50]');
        $this->form_validation->set_rules('address', 'Address', 'required|min_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('passconf', 'Password Confirm', 'required|matches[password]');

        if ($this->form_validation->run())
        {
            $data = [
                'first_name'   =>$this->input->post('first_name'),
                'last_name'    =>$this->input->post('last_name'),
                'address'      =>$this->input->post('address'),
                'email'        =>$this->input->post('email'),
                'password'     =>md5(sha1($this->input->post('password'))),
            ];
            $insert = $this->model->insert($data);
            if($insert)
            {
                $newdata = [
                    'logged'        => true,
                    'level'         => 0, 
                    'user_id'       => $insert,
                    'first_name'    => $data['first_name'],
                    'last_name'     => $data['last_name'],
                    'address'       => $data['address'],
                    'email'         => $data['email'],                    
                ];

                $newdata['cart'] = isset($this->userData['cart']) ? $this->userData['cart'] : [] ;

                $this->session->set_userdata($newdata);
                $viewData['success'] = true;
            }
        }
        $this->render('register',$viewData);
    }

    public function page($page_id)
    {
        $this->load->model('Page_model', 'model');
        $page = $this->model->row($page_id);
        if(!$page)
        {
            show_404();
        }
        $this->render('page', $page);
    }

    public function product($items_id)
    {
        $this->load->model('Item_model', 'model');
        $product = $this->model->row($items_id);
        if(!$product)
        {
            show_404();
        }
        
        $this->render('product', $product);


    }

    public function profile($id)
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
        $this->form_validation->set_rules('password', 'Password', 'trim');

        if ($this->form_validation->run())
        {
            $data = [
                'first_name'   =>$this->input->post('first_name'),
                'last_name'    =>$this->input->post('last_name'),
                'address'      =>$this->input->post('address'),
                'email'        =>$this->input->post('email'),
                'password'     =>$this->input->post('password'),
            ];

            $password = $this->input->post('password');
            if($password)
            {
                $data['password'] = md5(sha1($this->input->post('password')));
            }
            
            $this->model->update($data, $id);

            $data['cart'] = isset($this->userData['cart']) ? $this->userData['cart'] : [] ;

                $this->session->set_userdata($data);
                $viewData['success'] = true;

            redirect(base_url('profile/').$id);

        }
        $viewData['user'] = $user;

        $this->render('profile',$viewData);


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
