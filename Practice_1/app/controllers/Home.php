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
        // TODO: test get,set,flashData Session
        // Session::isInvalid();
        // Session::data('khoi','depzai');
        // pre(Session::data('khoi'));

        // Session::delete('khoi');
        // pre(Session::data());
        // pre(Session::flash_Data('khoi'));

        //TODO: Gán vào errors_Field_Home để in errors field ra bên view 
        $this->errors_Field_Home['errors_Home'] = Session::flash_Data('errors_Home'); 
        $this->errors_Field_Home['msg_errors'] = Session::flash_Data('msg_errors'); 
        $this->errors_Field_Home['old_Data_Home'] = Session::flash_Data('old_Data_Home'); 
        // pre($this->errors_Field_Home);

        $request_Obj = new Request;
        $this->data['sub_ContentPage']['dataPage'] = $this->errors_Field_Home;
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
            $userId_Test = 2;// test validate (lớn/nhở hơn)

            $request_Obj->rules([
                'fullname' => 'required|min:3|max:10',
                'age'=> 'required|callback_checkAge', // callback_funcCallBack
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
                'age.required'=>"Tuổi không được để trống",
                'age.callback_checkAge'=>"Tuổi lớn hơn 30",// ? test nên viết chay ra
                'password.required'=>"Vui lòng nhập mật khẩu",
                'password.min'=>"Mật khẩu ít nhất có 3 ký tự",
                'confirm_password.required'=> "Vui lòng xác nhận mật khẩu",
                'confirm_password.match'=>"Nhập lại mật khẩu không đúng",
            ]);
            
            // test validate
            $check_Validate = $request_Obj->validate();
            
            if(!$check_Validate){
                //TODO: Set giá trị của Session[session_1] = [....]
                Session::flash_Data('errors_Home',$request_Obj->errors());
                Session::flash_Data('msg_errors','Vui lòng nhập lại'); // thông báo chung cho toàn bộ errors field
                Session::flash_Data('old_Data_Home',$request_Obj->getFields());
                // pre($_SESSION['session_1']);
    
                // ! in ra thông báo error field (chưa dùng SESSION). Dùng cùng với block else ở dưới 
                // $this->errors_Field_Home['errors_Home'] = $request_Obj->errors();
                // $this->errors_Field_Home['old_Data_Home'] = 'Vui lòng nhập lại';
                // $this->errors_Field_Home['old_Data_Home']= $request_Obj->getFields();
            }
        }
        // else{ // TODO: header về form ban đầu nếu form đó use method GET. Khối block này dùng khi không áp dung session
        //     $url_Obj = new Respone ;
        //     $url_Obj->redirect('home/formPostUser');
        // }

        $url_Obj = new Respone ;
        $url_Obj->redirect('home/formPostUser');
    }

    /**
     * ? Dùng để test những ngoại lên errors không có trong validate dựng sẵn
     * * hiểu đơn giản là coder muốn ghi thêm validate nào khác mà validate đó ko có trong func dựng sẵn
     */
    public function checkAge($age){
        if($age >= 30) return true;
        return false;
    }
}