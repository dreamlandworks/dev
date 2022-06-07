<?php

use Modules\User\Models\SmsTemplateModel;
require 'vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Modules\Provider\Models\CommonModel;


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

function getMimeType($type){
    
    $common = new CommonModel();
    $data = $common->get_details_dynamically('mime_type','type',$type);

    return $data[0]['mime'];

}

function generateS3Object($folder,$file,$type){

// Hard-coded credentials
$s3Client = new S3Client([
    'version'     => 'latest',
    'region'      => 'ap-south-1',
    'credentials' => [
        'key'    => 'AKIA2HDFYTR76Z4DNNE4',
        'secret' => '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',
    ],
]);


//S3 Path to the File
$folderPath = $folder.'/';
$file_base64 = base64_decode($file);
$name = date('Ymd') . uniqid() . '.'.$type;
$file = $folderPath . $name;
$mime_type = getMimeType($type);
$temp = tempnam('/tmp','temp');

// print_r($mime_type);
// exit;

//fwrite("./images/".$name,$file_base64);
file_put_contents($temp, $file_base64);

$s3Path = 'https://elasticbeanstalk-ap-south-1-702440578175.s3.ap-south-1.amazonaws.com/'.$file;


// Send a PutObject request and get the result object.
$result = $s3Client->putObject([
    'Bucket' => 'elasticbeanstalk-ap-south-1-702440578175',
    'Key' => $file,
    'Body' => fopen($temp,'r'),
    'ACL' => 'public-read',
    'ContentType' => $mime_type
]);


// Print the path of the object uploaded.
return $s3Path;


}



function generateS3Video($name, $file){


    // Hard-coded credentials
    $s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => 'ap-south-1',
        'credentials' => [
            'key'    => 'AKIA2HDFYTR76Z4DNNE4',
            'secret' => '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',
        ],
    ]);
    
    
    //S3 Path to the File
    $folderPath = 'videos/';
    // $file_base64 = base64_decode($file);
    // $name = date('Ymd') . uniqid() . '.'.$type;
        
    // $mime_type = $file->getMimeType();

    // print_r($mime_type);
    // exit;
    
    $file_name = $folderPath . $name;
    $type = $file->getMimeType();
    
    $s3Path = 'https://elasticbeanstalk-ap-south-1-702440578175.s3.ap-south-1.amazonaws.com/'.$file;
    
    
    try {
        // Upload data.
        $result = $s3Client->putObject([
            'Bucket' => 'elasticbeanstalk-ap-south-1-702440578175',
            'Key'    => $file_name,
            'Body'   => fopen($file,'r'),
            'ACL'    => 'public-read',
            'ContentType' => $type
        ]);
    
        // Print the URL to the object.
        return $result['ObjectURL'] . PHP_EOL;
    } catch (S3Exception $e) {
        return $e->getMessage() . PHP_EOL;
    }


    }

    function deleteS3Object($file_name){

        $file = str_replace("https://elasticbeanstalk-ap-south-1-702440578175.s3.ap-south-1.amazonaws.com/","",$file_name);


        // Hard-coded credentials
        $s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => 'ap-south-1',
        'credentials' => [
            'key'    => 'AKIA2HDFYTR76Z4DNNE4',
            'secret' => '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',
        ],
        ]);

        try {
        $result = $s3Client->deleteObject(array(
            'Bucket' => 'elasticbeanstalk-ap-south-1-702440578175',
            'Key'    => $file
            )); 
            return 1;
        } catch (S3Exception $e) {
            return $e->getMessage() . PHP_EOL;
        }
        

    }



