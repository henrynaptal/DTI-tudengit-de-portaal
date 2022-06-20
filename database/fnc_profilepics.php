
<?php

    function save_image($image, $file_type, $target){
        $notice = null;
        
        if($file_type == "jpg"){
            if(imagejpeg($image, $target, 90)){
                $notice = "Foto salvestamine �nnestus!";
            } else {
                $notice = "Foto salvestamine ei �nnestunud!";
            }
        }
        
        if($file_type == "png"){
            if(imagepng($image, $target, 6)){
                $notice = "Foto salvestamine �nnestus!";
            } else {
                $notice = "Foto salvestamine ei �nnestunud!";
            }
        }
        
        if($file_type == "gif"){
            if(imagegif($image, $target)){
                $notice = "Foto salvestamine �nnestus!";
            } else {
                $notice = "Foto salvestamine ei �nnestunud!";
            }
        }
        
        return $notice;
    }