<?php

/**
 * Created by PhpStorm.
 * User: mustafa
 * Date: 05-12-2017
 * Time: 10:49 AM
 */
require_once __DIR__.'/boardingCardsInterface.php';

$sortedBoardingCards = array();

class boardingCardsClass implements boardingCardsInterface
{

    /*
 * this function check if all mandatory data exists or not
 *
 * @param array $validator  contains the parameters should exist and its priority
 * @param array $BoardingCards       contains the parameters sent by request
 *
 * @return if all mandatory parameters exists proceed then proceed to  sortBoardingCard function, if one or more is missing send error response (@parameters not found)
 *
 */
    function validateBoardingCardsInformation($validator,$data)
    {
        foreach($validator as $key => $value)
        {
            if( is_array($value))
            {
                if( !isset($data[$key]) || !is_array($data[$key]) )
                {
                    sendResponse("Array not found : ".$key,true);
                }
                else { validation($value, $data[$key]); }
            }
            else if($validator[$key] == true)
            {
                if(!isset($data[$key]) || $data[$key] == "")
                {
                    sendResponse("key not found : ".$key,true);// one of the keys not found
                }
            }

        }
        return true;
    }


    public function sortBoardingCards($BoardingCards){

        global  $sortedBoardingCards;

        $first_source=$this->firstSource($BoardingCards[0]['source'],$BoardingCards);

        $this->fillSortedArray($first_source,$BoardingCards);

        $result=array('data'=>$sortedBoardingCards,"error"=>false);
        return json_encode($result);
    }


    public function firstSource($first_source,$BoardingCards){
        foreach ($BoardingCards as $BoardingCard){
            if($first_source == $BoardingCard['destination'])$first_source=$this->firstSource($BoardingCard['source'],$BoardingCards);
        }
        return $first_source;

    }

    public function fillSortedArray($first_source,$BoardingCards){
        global  $sortedBoardingCards;

        foreach ($BoardingCards as $BoardingCard){
            if($first_source == $BoardingCard['source']){
                $sortedBoardingCards[]=$BoardingCard;
                $this->fillSortedArray($BoardingCard['destination'],$BoardingCards);
            }
        }

    }

    /*
 * this function is responsible for sending back the responses
 *
 * @param string    $data   contains the response message
 * @param Boolean   $error  describe whether it's an error or not
 *
 * @return response message with response type  (error / not error)
 */
    function boardingCardsResponse($data,$error=false){

        if($error){
            $response = array('data'=>false,"error"=>$data); echo json_encode($response);
            exit();
        }
        else
            $response = array('data'=>$data,"error"=>$error);

        echo json_encode($response);


    }
}