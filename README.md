# TRIP_SORTER

Basic use of this project is to sort unordered boarding cards:

### classes:
 * boardingCardsClass

### function:

   
 1)validateBoardingCardsInformation [$validator,$data]: 
 	to validate boradering cards information
 
  2)sortBoardingCards[$BoardingCards]: to receive unsorted boradering cards
 
 3)firstSource($first_source,$BoardingCards) :
	to get the first location of the trip.
   
 4)fillSortedArray($first_source,$BoardingCards) : to fill the new array with sorted boradering cards
 
 5)boardingCardsResponse($data,$error=false): to return the error if exsist, then stop the program. 
 
 ### files:

   
 1)Config.php :contains the credentials
 
  2)IO.php: its the linke between the classes and the UI, get the Inputs and return the response as Output
 
 3)actions :contains array of all the functions in the IO.php file .
   
 4)boardingCardsClass  : it's the main file contain all the needed classes for the project.  
 
 5)boardingCardsResponse($data,$error=false): to return the error if exsist, then stop the program. 
 
  ### Running the tests:


- send JSON request to IO.php file with prameter name (data)
for example :
IO.php?data{
  "username": "mustafa",
  "password": "mustafa@@@@",
  "token": "7eb7a16a99783d832ce2e7d91f4c8736",
  "action": "sortBoardingCards",
  "boarding_cards": [
    {
    "name": "mustafa",
    "source": "union",
    "destination": "ajman",
    "transportation_number": "152",
    "transportation_type": "bus",
    "gate": 5,
    "seat": 7
    },
    {
    "name": "mustafa",
    "source": "ajman",
    "destination": "aain",
    "transportation_type": "bus",
    "gate": 5,
    "seat": 7
    },
  {
    "name": "mustafa",
    "source": "marina",
    "destination": "union",
    "transportation_type": "metro",
    "gate": 1
    }
]
}



