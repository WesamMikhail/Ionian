<?php
namespace Ionian\Utils;

class Email {
    /**
     *
     * @param string $to
     * @param string $subject
     * @param string $message
     * @param string $headers
     * @param string $mailserver
     * @return boolean True on success, False otherwise!
     */
    public static function send($to, $subject, $message, $headers = null, $mailserver = null) {
        if (!is_null($mailserver))
            ini_set("SMTP", $mailserver);

        return (!is_null($headers)) ? mail($to, $subject, $message, $headers) : mail($to, $subject, $message);
    }

    /**
     * @param $from (Domain)
     * @param $to   (Email)
     * @param $subject
     * @param $message
     * @return boolean True or False
     */
    public static function sendStandardEmail($from, $to, $subject, $message){
        $headers = "From: no-reply@{$from} \r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=ISO-8859-1\r\n";

        $message = '<html>
                        <head></head>
                        <body style="background: #f4f3f1; margin: 0px; padding: 0px;">
                            <table style="margin: 20px auto; width: 880px; background: #fff; border: 1px #dfdfdf solid; padding: 10px;">
                                <tr>
                                    <td>
                                        <a target="_blank" href="//' . $from . '" style="width: 131px; height: 44px; margin: 6px 0px 6px 0px; float: left;">
                                            <img src ="//' . $from . '/images/logo.png"/>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h1 style="color: #ff7346; font-weight: normal; margin: 5px 10px; font-size: 15pt; font-family: arial;">' . $subject . '</h1>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div style="margin: 5px 10px; font-family: arial; color: #3d3d3d;">' . $message . '</div>
                                    </td>
                                </tr>
                            </table>
                       </body>
                    </html>';


        return Email::send($to, $subject, $message, $headers);
    }
}