<?php

/**
 * ? Call_user_func ví dụ
 */
class ExampleController {
    public function someAction($paramArray) {
        // $paramArray là một mảng
        echo "Parameter 1: " . $paramArray[0] . ", Parameter 2: " . $paramArray[1];
    }
}

$controllerInstance = new ExampleController();
$paramArray = ['value1', 'value2'];

// Gọi phương thức someAction với tham số là một mảng
call_user_func_array([$controllerInstance, 'someAction'], [$paramArray]);
// hoặc
$controllerInstance->someAction(...[$paramArray]);


$b = new ExampleController;