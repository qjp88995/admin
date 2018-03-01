<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller{
    public function index(){
        phpinfo();
        $to = "759848795@qq.com";
        $subject = "HTML email";
        $message = "
        <html>
        <head>
        <title>HTML email</title>
        </head>
        <body>
        <p>This email contains HTML Tags!</p>
        <table>
        <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        </tr>
        <tr>
        <td>John</td>
        <td>Doe</td>
        </tr>
        </table>
        </body>
        </html>
        ";

        // Always set content-type when sending HTML email
        $headers = "MIME-版本： 1.0" . "rn";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "rn";

        // More headers
        $headers .= 'From: <local@admin.ceshi.com>' . "rn";
        $headers .= 'Cc: myboss@admin.ceshi.com' . "rn";

        $res = mail($to,$subject,$message,$headers);
        dump($res);
        return $this->fetch();
    }
}