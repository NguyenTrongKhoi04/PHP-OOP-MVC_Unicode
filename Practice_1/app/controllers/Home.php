<?php 
class Home extends Controller{
    private $model_Home;// obj để làm việc của page này

    function __construct()
    {
        $this->model_Home =  $this->model('HomeModel');// include file model chứa data vào     
    }
    
    // * param 1/2/3

    function index(){
        // test Global Query Builder
        $data = [
            'airline_name' => 'hello'
        ] ;
        
        $this->data['sub_ContentPage']['dataPage'] = $this->db->table('airlines')->get();
        
        // TODO: test Last Insert ID
        // $lastId_Test = $this->model_Home->lastInsertIdUser($data);
        // echo $lastId_Test;

        // TODO: Lấy dự liệu bằng func dựng sẵn =>> $this->data['sub_ContentPage']['dataPage'] = $this->model_Home->get();

        $this->info_Render('Trang Home','home/index','style','script');
        
    }

    function formPostUser(){
        $request_Obj = new Request;
        $this->info_Render('Form','validate/add');
    }

    function postUser(){
        /**
         * * Test request & respone
         */
        // $request_Obj = new Request;
        // pre($request_Obj->getFields()); 

        // $url_Obj = new Respone ;
        // $url_Obj->redirect('home/index');

        $request_Obj = new Request;
        echo 'pre trang home';pre($request_Obj->getFields());
        $request_Obj->rules([
            'fullname' => 'required|min:3|max:10',
            'email'    => 'required|email|min:6',
            'password' => 'required|min:3',
            'confirm_password' => 'required|match:password'
        ]);
        $request_Obj->message([
            'fullname.required'=>"Vui lòng nhập tên",
            'fullname.min'=>"Tối thiểu 3 ký tự",
            'fullname.max'=>"Tối đa 10 ký tự",
            'email.required'=>"Vui lòng nhập email",
            'email.email'=>"Nhập đúng định dạng email",
            'email.min'=>"Nhập ít nhất 6 ký tự",
            'password.required'=>"Vui lòng nhập mật khẩu",
            'password.min'=>"Mật khẩu ít nhất có 3 ký tự",
            'confirm_password.required'=> "Vui lòng xác nhận mật khẩu",
            'confirm_password.match'=>"Nhập lại mật khẩu không đúng",
        ]);
        
        // test validate
        $request_Obj->validate();
        pre($request_Obj->__errors);
        $this->info_Render('Form','validate/add');
    }
}