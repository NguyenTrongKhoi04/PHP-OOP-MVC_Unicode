<?php 
class Home extends Controller{
    private $model_Home;// obj để làm việc của page này
    private $errors_Field_Home =[];

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
        
        // * $data[ContentPage]: URL chính trỏ đến ViewHome 
        $this->data['sub_ContentPage']['dataPage'] = $this->db->table('airlines')->get();
        
        // TODO: test Last Insert ID bằng global query
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
        
        $request_Obj = new Request;//obj lấy dữ liệu form, method, errors
        if($request_Obj->isPost()){
            $userId_Test = 2;// test validate 

            $request_Obj->rules([
                'fullname' => 'required|min:3|max:10',
                // 'email'    => 'required|email|min:6|unique:email:email',
                'email'    => 'required|email|min:6|unique:email:email:id='.$userId_Test,
                                                    // ? unique:tên bảng:tên cột muốn so:điều kiện thêm
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
                'email.unique'=>"Email đã có người sử dụng",
                'password.required'=>"Vui lòng nhập mật khẩu",
                'password.min'=>"Mật khẩu ít nhất có 3 ký tự",
                'confirm_password.required'=> "Vui lòng xác nhận mật khẩu",
                'confirm_password.match'=>"Nhập lại mật khẩu không đúng",
            ]);
            
            // test validate
            $request_Obj->validate();
            
            $this->errors_Field_Home['errors_Home'] = $request_Obj->errors();
            $this->errors_Field_Home['msg_errors'] = 'Vui lòng nhập lại';
            $this->errors_Field_Home['old_Data_Home']= $request_Obj->getFields();
            
            $this->data['sub_ContentPage']['dataPage']=$this->errors_Field_Home; 
            $this->info_Render('Form','validate/add');
        }else{
            // header về form ban đầu nếu form đó use method GET
            $url_Obj = new Respone ;
            $url_Obj->redirect('home/formPostUser');
        }
    }
}