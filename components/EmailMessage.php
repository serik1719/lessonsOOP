<?php
    function EmailMessage($to, $subject, $message, $NameSite, $EmailSite){		//	Отправка сообщения на почту
        $subject = "=?utf-8?B?".base64_encode($subject)."?=";
        $message = wordwrap($message, 300, "\r\n");

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/plain; charset=utf-8\r\n";
        $headers .= "From: ".$NameSite." <".$EmailSite.">\r\n";

        if(mail($to, $subject, $message, $headers)){
            return true;
        }
        
        return false;
    }