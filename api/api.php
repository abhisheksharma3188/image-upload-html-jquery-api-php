<?php
header('Content-Type:application/json');
header('Access-Control-Allow-Origin:*');

$jwt=getallheaders()['Authorization'];

$text_input=$_POST['text_input'];

//////////////////////////////////// code to check if all input fields are empty below ////////////////
if(str_replace(' ','',$text_input)=='' &&
   str_replace(' ','',$_FILES['file_input']['name'])==''){
    $response_array=['response'=>'failure','message'=>'All fields cannot be empty.'];
    $response_json=json_encode($response_array);
    echo $response_json;
    die;
}
//////////////////////////////////// code to check if all input fields are empty above ////////////////

////////////// code to check image file type below //////////////////////////////////////
if(str_replace(' ','',$_FILES['file_input']['name'])!=''){
    $image_original_name=$_FILES['file_input']['name'];
    $image_original_name_exploded=explode(".",$image_original_name);
    $image_file_type=end($image_original_name_exploded); //end gives last element of array
    if($image_file_type!='jpg' && $image_file_type!='jpeg' &&
       $image_file_type!='JPG' && $image_file_type!='JPEG' &&
       $image_file_type!='PNG' && $image_file_type!='png'){
        $response_array=['response'=>'failure','message'=>'Only JPG and PNG format are allowed.'];
        $response_json=json_encode($response_array);
        echo $response_json;
        die;
    }
}    
//////////// code to check image file type above ///////////////////////////////////////

//////////////////////// Code to get new filename for image below ////////////////
if(str_replace(' ','',$_FILES['file_input']['name'])!=''){
    $image_new_file_name= rand(100000,999999);
}
//////////////////////// Code to get new filename for image above ////////////////

//////////// code to set new name of image below ///////////////////////////////
if(str_replace(' ','',$_FILES['file_input']['name'])!=''){
    $image_new_name=$image_new_file_name.'.'.$image_file_type;
}
else{
    $image_new_name='';    
}
//////////// code to set new name of image above ///////////////////////////////

//////////// code to upload image below //////////////////////////////////////////
if(str_replace(' ','',$_FILES['file_input']['name'])!=''){
    $temporary_image_name=$_FILES['file_input']['tmp_name'];
    $dir='../image_uploads';
    if(!move_uploaded_file($temporary_image_name,$dir."/".$image_new_name)){
        $response_array=['response'=>'failure','message'=>'Image upload failure.'];
        $response_json=json_encode($response_array);
        echo $response_json;
        die;
    }
    else{
    $response_array=['response'=>'success','message'=>'Image uploaded successfully.','text_input'=>$text_input,'jwt'=>$jwt,'image_new_name'=>$image_new_name];
    $response_json=json_encode($response_array);
    echo $response_json;
    die;
}
}

////////////// code to upload image above//////////////////////////////////////
?>
