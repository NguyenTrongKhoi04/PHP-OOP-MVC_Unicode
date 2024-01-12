<?php
class Request{
    private $__rules= [],$__mess= [],$__errors = [];
    public $db;

    public function __construct(){
        $this->db = new Database;
    }
    /**
     * TODO: kiểm tra phương thức (GET / POST)
     */
    public function getMethod(){
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(){
        if($this->getMethod()==='get'){
            return true;
        }
        return false;
    }

    public function isPost(){
        if($this->getMethod()==='post'){
            return true;
        }
        return false;
    }

    /**
     * return data[những field nhận được từ form]
     */
    public function getFields(){
        $dataField = [];
          if($this->isGet()){
            if(!empty($_GET)){
                foreach($_GET as $key=>$value){
                    if(is_array($value)){
                        $dataField[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataField[$key]=filter_input(INPUT_GET,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    // ! FILTER_REQUIRE_ARRAY để xử lý trường hợp biến là mảng =>> ?act=3&id[]=1
                }
            }
          }

          if($this->isPost()){
            if(!empty($_POST)){
                
                foreach($_POST as $key=>$value){
                    
                    if(is_array($value)){
                        $dataField[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                    }else{
                        $dataField[$key]=filter_input(INPUT_POST,$key,FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                    // ! FILTER_REQUIRE_ARRAY để xử lý trường hợp biến là mảng =>> ?act=3&id[]=1
                }
            }
          }
        return $dataField;
    } 

    function rules($rules=[]){
        $this->__rules = $rules;
    }

    function message($mess=[]){
        $this->__mess = $mess;
    }

    function validate(){
        $this->__rules = array_filter($this->__rules);
        $dataField = $this->getFields();
        $check_Validate = true;

        if(!empty($this->__rules)){
            foreach($this->__rules as $arrFieldName => $arrRule){
                // pre($arrFieldName);
                $arrFieldNameRule = explode('|',$arrRule);

                foreach($arrFieldNameRule as $fieldName){
                    // pre($arrFieldNameRule);
                    $fieldName_Check = '';
                    $fieldValue = '';

                    $fieldNameRule = explode(':',$fieldName);
                    // pre($fieldNameRule);

                    $fieldName_Check = reset($fieldNameRule);
                    if(count($fieldNameRule)>1){
                        $fieldValue = end($fieldNameRule);
                        $check_Validate;
                    }

                    if($fieldName_Check == 'required'){
                        if(empty(trim($dataField[$arrFieldName]))){
                            $this->setErrors($arrFieldName,$fieldName_Check);
                            $check_Validate= false;
                        }
                    }

                    if($fieldName_Check == 'min'){
                        if(strlen(trim($dataField[$arrFieldName]))<3){
                            $this->setErrors($arrFieldName,$fieldName_Check);
                            $check_Validate= false;
                        }
                    }

                    if($fieldName_Check == 'max'){
                        if(strlen(trim($dataField[$arrFieldName])) > $fieldValue){
                            $this->setErrors($arrFieldName,$fieldName_Check);
                            $check_Validate= false;
                        }
                    }
                    
                    if($fieldName_Check == 'email'){
                        if(!filter_var($dataField[$arrFieldName],FILTER_VALIDATE_EMAIL)){
                            $this->setErrors($arrFieldName,$fieldName_Check);
                            $check_Validate= false;
                        }
                    }

                    if($fieldName_Check == 'match'){
                        /**
                         * ! Giá trị ở đây chính là 'password'
                         * TODO: arr_Post[confirm_password] != arr_Post[password]
                         * */   
                        if(trim($dataField[$arrFieldName]) != trim($dataField[$fieldValue])){
                            $this->setErrors($arrFieldName,$fieldName_Check);
                            $check_Validate= false;
                        }
                    }

                    if($fieldName_Check == 'unique'){
                        $fieldTableCheck_Unique='';
                        $fieldNameCheck_Unique='';

                        /**
                         * lấy bảng để check
                         */
                        if(!empty($fieldNameRule[1])){
                            $fieldTableCheck_Unique = $fieldNameRule[1] ;
                        }

                        /**
                         * Lấy cột để check
                         */
                        if(!empty($fieldNameRule[2])){
                            $fieldNameCheck_Unique = $fieldNameRule[2] ;
                        }

                        /**
                         * áp dụng khi có 3 điều kiện
                         *  =>> required|email|min:6|unique:email:email
                         *                           ? unique:tên bảng:tên cột muốn so
                         */
                        if(count($fieldNameRule)==3){   
                            $check_Unique = $this->db->query("SELECT $arrFieldName FROM $fieldTableCheck_Unique WHERE $fieldNameCheck_Unique = '$dataField[$arrFieldName]'")->fetchAll(PDO::FETCH_ASSOC);

                            // có dữ liệu => bị trùng
                            if(!empty($check_Unique)){
                                $this->setErrors($arrFieldName,$fieldName_Check);
                                $check_Validate = false;
                            }
                        }

                        if(count($fieldNameRule)==4){
                            $condition = $fieldNameRule[3];   
                            $condition = str_replace('=','<>',$condition);
                            // pre($condition);
                            
                            $check_Unique = $this->db->query("SELECT $arrFieldName FROM $fieldTableCheck_Unique WHERE $fieldNameCheck_Unique = '$dataField[$arrFieldName]' AND $condition")->fetchAll(PDO::FETCH_ASSOC);

                            if(!empty($check_Unique)){
                                $this->setErrors($arrFieldName,$fieldName_Check);
                                $check_Validate = false;
                            }
                        }
                    }
                }
            }
        }
        return $check_Validate;
    }

    function errors($errorsFieldName=''){
        if(!empty($this->__errors)){
            if(empty($errorsFieldName)){
                $dataErrors = [];// arr chứa 1 lỗi lần lượt của 1 field
                foreach($this->__errors as $error_OneField => $value){
                    // ! $error_OneField là arr, $value là item của mảng đó
                    $dataErrors[$error_OneField] = reset($value);
                }
                return $dataErrors;

                // * trả về lỗi đầu tiên có trong mảng __errors của field đớ 
            }
            return reset($this->__errors[$errorsFieldName]);
        }
        
        return false;
    }

    function setErrors($arrFieldName,$fieldName_Check){
        // TODO: cho lỗi vào field tương ứng trong mảng __errors 
        $this->__errors[$arrFieldName][$fieldName_Check] = $this->__mess[$arrFieldName.'.'.$fieldName_Check] ;
    }
}