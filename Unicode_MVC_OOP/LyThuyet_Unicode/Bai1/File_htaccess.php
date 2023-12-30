<?php
/**
 * ? Tại sao phải dùng htaccess
 *      Nếu để đúng đường dẫn theo sơ đồ folder =>> hacker biết và tấn công dễ dàng
 *      chính vì vậy ta phải ẩn URL đó đi 
 * 
 * * Dùng để ẩn đi URL
 * * RewriteCond = RewriteCondition (điều kiện rewrite)
 * * %{REQUEST_FILENAME}: Biến môi trường trong Apache, đại diện cho đường dẫn tới tệp tin được yêu cầu.
 * 
 * * !-d =>> điều kiện kiểm tra xem đây không phải là thư mục (directory) 
 * * !-f =>> điều kiện kiểm tra xem đây không phải là file 
 * 
 * ? RewriteRule ^(.+)$ index.php/$1 [L,QSA] là như thế nào
 *          TODO: index.php là file mặc định chạy vào => trong phần tổng kết sẽ hiểu rõ hơn    
 *          TODO: $1 là phân tử ĐẦU TIÊN của CHUỖI BIỂU THỨC CHÍNH QUY - ^(.+)$ -> với bất kỳ ký tự nào
 *                      Ví dụ: "/khoi" =>> URL mói = index.php/khoi
 *                             "/hocsinh/lop" =>> index.php/hocsinh/lop
 *          TODO: L là last, tức là kết thúc quy trình rerwite cho yêu cầu hiện tại, không xem xét các quy tắc RewriteRule tiếp theo trong danh sách  
 *          TODO: QSA là "Query String Append" - nối tiếp chuỗi truy vấn => giúp cho b không bị mất đi chuỗi YÊU CẦU
 *                      ! nếu không có QSA
 *                              b có URL sau: /hocsinh?id=1&lop=3 
 *                              =>> URL mói sau khi được rewrite xong: index.php/hocsinh =>> mất đi chuỗi đằng sau
 *                                      TODO: lúc này " ?id=1&lop=3 " được gọi là chuỗi truy vấn 
 * 
 * 
 * * TỔNG KÉT: 
 *      TODO STEP_1: Khi 2 điều kiện RewriteCond đúng (directory, file không tồn tại)
 *      TODO STEP_2: Lúc này sẽ thực hiện RewriteRule với mặc định là chuỗi "index.php" đứng đầu trong URL truy cập
 *      ! chúng ta truyền tham số sau index (trang, file, tham số) => ví dụ: index.php/hocsinh/home/1                      
 */