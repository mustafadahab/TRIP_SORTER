<?php


interface boardingCardsInterface{

    public function validateBoardingCardsInformation($validator,$BoardingCards);

    public function sortBoardingCards($BoardingCards);

    public function firstSource($first_source,$BoardingCards);

    public function fillSortedArray($first_source,$BoardingCards);

    function boardingCardsResponse($data,$error);


}
