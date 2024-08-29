<?php
class Car {
    private $carID;
    private $carModel;
    private $carMake;
    private $carType;
    private $registrationYear;
    private $description;
    private $pricePerDay;
    // private $capacity;
    private $capacityOfSuitcases;
    private $capacityOfPeople;

    private $colors;
    private $fuelType;
    private $averageConsumption;
    private $horsepower;
    private $length;
    private $width;
    private $plateNumber;
    private $mileage;//
    private $features;//
    // private $available;//
    private $conditions;
    private $carPhotoURL=array ();
    private $gearType;
    private $status;

    private  $startDate ;
    private $endDate ;

    private $pick_up_location_ID;
    private $return_location_ID;

    public function __construct($obj) {
        $this->carID = $obj['carID'];
        $this->carModel = $obj['carModel'];
        $this->carMake = $obj['carMake'];
        $this->carType = $obj['carType'];
        $this->registrationYear = $obj['registrationYear'];
        $this->description = $obj['description'];
        $this->pricePerDay = $obj['pricePerDay'];
        // $this->capacity = $obj['capacity'];
        $this->colors = $obj['colors'];
        $this->fuelType = $obj['fuelType'];
        $this->averageConsumption = $obj['averageConsumption'];
        $this->horsepower = $obj['horsepower'];
        $this->length = $obj['length'];
        $this->width = $obj['width'];
        $this->plateNumber = $obj['plateNumber'];
        $this->conditions = $obj['conditions'];
        $this->setCarPhotoURL( $obj['carPhotoURL']);
        // $this->carPhotoURL = $obj['carPhotoURL'];
        // private $mileage;//
        // private $features;//
        // private $available;//
        $this->mileage = $obj['mileage'];
        $this->features = $obj['features'];
        // $this->available = $obj['status'];
        // private $capacityOfSuitcases;
        // private $capacityOfPeople;
        $this->capacityOfSuitcases = $obj['capacityOfSuitcases'];
        $this->capacityOfPeople = $obj['capacityOfPeople'];
        // gearType
        $this->gearType = $obj['gearType'];
        // status
        $this->status = $obj['status'];

    }


    public function setStatus($status) {
        $this->status = $status;
    }
    public function getStatus() {
        return $this->status;
    }
//private $pick_up_location_ID;
// private $return_location_ID;
    


    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    // Getter and Setter for $endDate
    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }
    public function getGearType() {
        return $this->gearType;
    }

    public function setGearType($gearType) {
        $this->gearType = $gearType;
    }
    public function getCapacityOfSuitcases() {
        return $this->capacityOfSuitcases;
    }

    public function setCapacityOfSuitcases($capacityOfSuitcases) {
        $this->capacityOfSuitcases = $capacityOfSuitcases;
    }

    // Getter and Setter for capacityOfPeople
    public function getCapacityOfPeople() {
        return $this->capacityOfPeople;
    }

    public function setCapacityOfPeople($capacityOfPeople) {
        $this->capacityOfPeople = $capacityOfPeople;
    } 
    public function isAvailable() {
        return $this->status ;
       
    }
    // Getters and setters
    public function getCarID() {
        return $this->carID;
    }

    public function setCarID($carID) {
        $this->carID = $carID;
    }

    public function getCarModel() {
        return $this->carModel;
    }

    public function setCarModel($carModel) {
        $this->carModel = $carModel;
    }

    public function getCarMake() {
        return $this->carMake;
    }

    public function setCarMake($carMake) {
        $this->carMake = $carMake;
    }

    public function getCarType() {
        return $this->carType;
    }

    public function setCarType($carType) {
        $this->carType = $carType;
    }

    public function getRegistrationYear() {
        return $this->registrationYear;
    }

    public function setRegistrationYear($registrationYear) {
        $this->registrationYear = $registrationYear;
    }

  
    public function getDescription() {
        $description_statements = explode('.', $this->description);          
        $strDescription = '';

        foreach ($description_statements as $statement) {
            $statement = trim($statement);
            if (!empty($statement)) {
                if (substr($statement, -1) !== '.') {
                    $statement .= '.';
                }
                $strDescription .= "<li>" . htmlspecialchars($statement) . "</li>";
            }
        }
        $strDescription = "<ul>" . $strDescription . "</ul>";
        return $strDescription;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPricePerDay() {
        return $this->pricePerDay;
    }

    public function setPricePerDay($pricePerDay) {
        $this->pricePerDay = $pricePerDay;
    }

    // public function getCapacity() {
    //     return $this->capacity;
    // }

    // public function setCapacity($capacity) {
    //     $this->capacity = $capacity;
    // }

   
    public function getColors() {
        return $this->colors;
    }

    public function setColors($colors) {
        $this->colors = $colors;
    }

    public function getFuelType() {
        return $this->fuelType;
    }

    public function setFuelType($fuelType) {
        $this->fuelType = $fuelType;
    }

    public function getAverageConsumption() {
        return $this->averageConsumption;
    }

    public function setAverageConsumption($averageConsumption) {
        $this->averageConsumption = $averageConsumption;
    }

    public function getHorsepower() {
        return $this->horsepower;
    }

    public function setHorsepower($horsepower) {
        $this->horsepower = $horsepower;
    }

    public function getLength() {
        return $this->length;
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getWidth() {
        return $this->width;
    }

   
    public function setWidth($width) {
        $this->width = $width;
    }

    public function getPlateNumber() {
        return $this->plateNumber;
    }

    public function setPlateNumber($plateNumber) {
        $this->plateNumber = $plateNumber;
    }

    public function getConditions() {
        return $this->conditions;
    }

    public function setConditions($conditions) {
        $this->conditions = $conditions;
    }

    public function getFirstCarPhotoURL() {
        return isset($this->carPhotoURL[0]) ? $this->carPhotoURL[0] : null;
    }

    public function getCarPhotoURL() {
        return $this->carPhotoURL;
    }
    // public function setCarPhotoURL($carPhotoURL) {
    //     $this->carPhotoURL = $carPhotoURL;
    // }
    public function setCarPhotoURL($photoURLString) {
        $photoURLs = explode(',', $photoURLString);
        foreach ($photoURLs as $url) {
            $this->carPhotoURL[] = trim($url);
        }
    }
    public function setCarPhotoURLArray($photoURLString) {
        $carPhotoURL = $photoURLString;
    }

    // getRegistrationYear
    // getDescription
    // getPricePerDay
    // getColors
    // getFuelType
    // getAverageConsumption
    // getHorsepower
    // getLength
    // getWidth
    // getPlateNumber
    // getConditions
    // getAvailable
    // getMileage
    // getFeatures
    public function getAvailable() {
        return $this->status;
    }

    // Setter for $available
    public function setAvailable($status) {
        $this->status = $status;
    }

    // Other getters and setters for $mileage and $features can be similarly defined
    public function getMileage() {
        return $this->mileage;
    }

    public function setMileage($mileage) {
        $this->mileage = $mileage;
    }

    public function getFeatures() {
        return $this->features;
    }

    public function setFeatures($features) {
        $this->features = $features;
    }
    public function displayInTableSearch() {
        $output = "<tr class=\"fuel-{$this->fuelType}\">";
        $output .= "<td><input type=\"checkbox\" name=\"carCheckbox[]\" value=\"{$this->carID}\"></td>";
        $output .= "<td>" . $this->pricePerDay . "</td>";
        $output .= "<td>" .$this->carType . "</td>";
        $output .= "<td>" .$this->fuelType. "</td>";

        $output .= "<td><img src=\"./images/{$this->getFirstCarPhotoURL()}\" alt=\"Car Image\" style=\"max-width: 100px;\"><br>
        <p>{$this->getFirstCarPhotoURL()}</p></td>";
        // $output .= "<td><a href='car_details.php?id={$this->carID}'?startdate= endDate class='rent-button'>Rent</a></td>";

        // public  $startDate ;
        // public $endDate ;
  
        $output .= "<td><a href='car_details.php?id={$this->carID}&startDate={$this->startDate}&endDate={$this->endDate}' class='rent-button'>Rent</a></td>";


        $output .= "</tr>";
        return $output;
    }

    public function getNumberOfDaysBetweenDates($startDate, $endDate) {
        $startDateTime = new DateTime($startDate);
        $endDateTime = new DateTime($endDate);
        $interval = $startDateTime->diff($endDateTime);
        return $interval->days;
    }
    public function displayInTableSearchForManager() {
        return "<tr>
                    <td>{$this->carID}</td>
                    <td>{$this->carType}</td>
                    <td>{$this->carModel}</td>
                    <td>{$this->description}</td>
                    

                     <td><img src=\"./images/{$this->getFirstCarPhotoURL()}\" alt=\"Car Image\" style=\"max-width: 100px;\"><br>
                     <p>{$this->getFirstCarPhotoURL()}</p></td>




                    <td>{$this->fuelType}</td>
                    <td>{$this->status}</td>
                </tr>";
    }
   
}
?>