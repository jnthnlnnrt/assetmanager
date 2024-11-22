<?php

use App\Models\Asset;

    function checkSerial($serial){
        if($serial === 'SIN SERIE'){
            return 1;
        } else{
            if(Asset::where('serial', strtoupper($serial))->exists()){
                return 0;
            } else {
                return 1;
            }
        }
    }

    function generateAssetTag($asset_id){
        $asset_tag = 'DPK' . zero_fill($asset_id);

        return $asset_tag;
    }

    function zero_fill($string){
        if(strlen($string) === 1){
            $string = '00000' . $string;
        } else if(strlen($string) === 2){
            $string = '0000' . $string;
        } else if(strlen($string) === 3){
            $string = '000' . $string;
        } else if(strlen($string) === 4){
            $string = '00' . $string;
        } else if(strlen($string) === 5){
            $string = '0' . $string;
        }

        return $string;
    }