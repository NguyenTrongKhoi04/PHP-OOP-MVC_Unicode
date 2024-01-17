<?php
/**
 * * Global MiddleWare. Tất cả sẽ chạy qua class này
 */
class ParamMiddleWare extends BaseMiddleWare {
    public function handle(){
            // pre($this->db->table('airlines')->get());//TODO: test truy vấn với MiddleWare

            // var_dump(MiddleWare_LoadViewModel::model('HomeModel'));//TODO: Load model và sử dụng những func của model đó
            // MiddleWare_LoadViewModel::model('HomeModel')->checkModelMiddleWare();//TODO: test func của model
            // MiddleWare_LoadViewModel::render('product/ListSanPham',MiddleWare_LoadViewModel::model('HomeModel')->all());// TODO: Test render

            /**
             * TODO: xử lý "?..." (ví dụ: trang-chu/?a=3&b=2)
             * * Sẽ redirect về trang chính nó =>> trang-chu
             */
            if(!empty($_SERVER['QUERY_STRING'])){
                $respone = new Respone();
                $respone->redirect(Route::getFullUrl());
            }
    }
}