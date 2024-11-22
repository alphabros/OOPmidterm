<?php
class PieceWorker extends Employee {
    private $numberItems;
    private $wagePerItem;

    public function __construct($name, $address, $age, $companyName, $numberItems, $wagePerItem) {
        parent::__construct($name, $address, $age, $companyName);  
        $this->numberItems = $numberItems;
        $this->wagePerItem = $wagePerItem;
    }

    public function get_NI() {
        return $this->numberItems;
    }

    public function get_WPI() {
        return $this->wagePerItem;
    }

    public function set_NI($numberItems) {
        $this->numberItems = $numberItems;
    }

    public function set_WPI($wagePerItem) {
        $this->wagePerItem = $wagePerItem;
    }

    public function earnings() {
        return $this->numberItems * $this->wagePerItem;
    }

    public function __toString() {
        return parent::__toString() . ", Number of Items: $this->numberItems, Wage per Item: $this->wagePerItem";
    }
}
?>
