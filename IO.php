<?php

require_once('actions.php');
require_once('config.php');
require_once __DIR__ . "/classes/boardingCardsClass.php";

/* decode the json request*/
$data=json_decode($_REQUEST['data'],true);
/* create object from our boarding Cards Class */
$boardingCardsClass = new boardingCardsClass();

/* check for authorization */
if(($data['username'] != UserName)||($data['token'] != Token)||($data['password'] != Password)){
    sendResponse("Sorry You don't have permission !",$error=true);
}
else {
    startProcess($data['action']);
}

/* start sorting process*/
function startProcess($requestedAction)
{
    global $actions;
    if(!$actions[$requestedAction]){
        sendResponse("Invalid action !",$error=true);
    }
    else $actions[$requestedAction]();
}

function sort_boarding_cards(){
    global $data;
    global $boardingCardsClass;

    /* check if all all the boarding cards information is valid as required
    true = if mandatory
    false = if not
    */
     $validateBoardingCardsInformation   =
         $boardingCardsClass->validateBoardingCardsInformation
         (
         array(array('name' => true,'source' => true,'destination' => true,'transportation_type' => true,'transportation_number' => false,'gate' => false,'seat' => false)),
         $data['boarding_cards']
         );

     if($validateBoardingCardsInformation){
         /*
          * send the boarding cards random to get the sorting result
          * */
         $response=$boardingCardsClass->sortBoardingCards($data['boarding_cards']);


         /* print the result */
         echo"<h2 align='center'>Your journey details</h2>";
         echo "<div align='center'>";
         foreach (json_decode($response,true)['data'] as $key => $trip){
             echo ++$key."- Take ".$trip['transportation_type'];
             echo($trip['transportation_number'] != null?$trip['transportation_number']:"");
             echo" from ".$trip['source']." to ".$trip['destination']." .";
             echo($trip['gate'] != null?"Gate ".$trip['gate'].", ":"");
             echo($trip['seat'] != null?"Sit in seat".$trip['seat']:"No seat assignment");
             echo"<br>";

         }
         echo"</div>";


     }

}


/*
* this function check if all mandatory data exists or not
*
* @param array $validator  contains the parameters should exist and its priority
* @param array $data       contains the parameters sent by request
*
* @return if all mandatory parameters exists proceed , if one or more is missing send error response (@parameters not found)
*
*/
function validation($validator,$data)
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
    return ;
}
/*
 * this function is responsible for sending back the responses
 *
 * @param string    $data   contains the response message
 * @param Boolean   $error  describe whether it's an error or not
 *
 * @return response message with response type  (error / not error)
 */
/*
* this function is responsible for sending back the responses
*
* @param string    $data   contains the response message
* @param Boolean   $error  describe whether it's an error or not
*
* @return response message with response type  (error / not error)
*/
function sendResponse($data,$error=false){

    if($error){
        $response = array('data'=>false,"error"=>$data); echo json_encode($response);
        exit();
    }
    else
        $response = array('data'=>$data,"error"=>$error);

    echo json_encode($response);


}

