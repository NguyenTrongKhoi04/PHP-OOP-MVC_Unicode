<?php
/**
 * ? Xử lý rồi mới trả về hoặc respone,...
 * * Mô hình hoạt động: URL -> router -> MiddleWare($keyRoute) -> action/return
 * * Sau khi lấy được $key của routes thì sẽ xử lý ở đây (trả về value, header,...)
 * TODO: ở đây có thể xử lý Login, kiểm tra dữ liệu có trong DB hay không
 */
class AuthorMiddleWare extends BaseMiddleWare{
    public function handle(){
        // var_dump($this->db);die;// kiểm tra kết nối với db
        // pre($this->db->table('airlines')->get());//TODO: test truy vấn với MiddleWare. Gọi ở bên ParamMiddleWare cũng đc

        var_dump(MiddleWare_LoadViewModel::model('HomeModel'));//TODO: Load model và sử dụng những func của model đó
        MiddleWare_LoadViewModel::model('HomeModel')->checkModelMiddleWare();//TODO: test func của model
        MiddleWare_LoadViewModel::render('product/ListSanPham',MiddleWare_LoadViewModel::model('HomeModel')->all());// TODO: Test render

        // ! ví dụ về xử lý $keyRoute với MiddleWare
        if(Session::data('admin_login')==null){
            $respone = new Respone();
            // $respone->redirect('san-pham/the-gioi-1.html');
        }
    }
}