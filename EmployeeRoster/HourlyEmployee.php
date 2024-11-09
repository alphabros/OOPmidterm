<?php
class HourlyEmployee extends Employee {
    private $hoursWorked;
    private $rate;

    public function __construct($name, $address, $age, $companyName, $hoursWorked, $rate) {
        parent::__construct($name, $address, $age, $companyName); 
        $this->hoursWorked = $hoursWorked;
        $this->rate = $rate;
    }

    public function get_HW() {
        return $this->hoursWorked;
    }

    public function get_rate() {
        return $this->rate;
    }

    public function set_HW($hoursWorked) {
        $this->hoursWorked = $hoursWorked;
    }

    public function set_rate($rate) {
        $this->rate = $rate;
    }

    public function earnings() {
        return $this->hoursWorked * $this->rate;
    }

    public function __toString() {
        return parent::__toString() . ", Hours Worked: $this->hoursWorked, Rate: $this->rate";
    }
}
?>
