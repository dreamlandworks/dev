<?php

use Modules\User\Models\SmsTemplateModel;

/**
 * Function to send SMS
 * 
 * Should Contain all variables to replace, name and mobile number in the array
 * @param mixed $data 
 * 
 * @return [type]
 */
function sendSms($data)
{

    $sms_model = new SmsTemplateModel();

    $res = $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);

    return $res;
}


/**
 *  Function to generate Image File from Base64
 * 
 *  Just pass the Image String to the function
 * 
 *  @param mixed $img
 * 
 *  @return [String] File Name
 */
function generateImage($img)
{

    $folderPath = "./images/";
    $image_base64 = base64_decode($img);
    $name = date('Ymd') . uniqid() . '.png';
    $file = $folderPath . $name;
    file_put_contents($file, $image_base64);
    return "images/" . $name;
}

/**
 *  Function to generate Image File from Base64
 * 
 *  Just pass the Image String to the function
 * 
 *  @param mixed $img
 * 
 *  @return [String] File Name
 */
function generateDynamicImage($folder,$img,$type="png")
{

    $folderPath = "./".$folder.'/';
    $image_base64 = base64_decode($img);
    $name = date('Ymd') . uniqid() . '.'.$type;
    $file = $folderPath . $name;
    file_put_contents($file, $image_base64);
    return $folder."/".$name;
}


