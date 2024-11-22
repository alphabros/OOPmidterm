<?php
class CommissionEmployee extends Employee {
    private $regularSalary;
    private $itemSold;
    private $commissionRate;

    public function __construct($name, $address, $age, $companyName, $regularSalary, $itemSold, $commissionRate) {
        parent::__construct($name, $address, $age, $companyName); 
        $this->regularSalary = $regularSalary;
        $this->itemSold = $itemSold;
        $this->commissionRate = $commissionRate;
    }

    public function get_RS() {
        return $this->regularSalary;
    }

    public function get_IS() {
        return $this->itemSold;
    }

    public function get_CR() {
        return $this->commissionRate;
    }

    public function set_RS($regularSalary) {
        $this->regularSalary = $regularSalary;
    }

    public function set_IS($itemSold) {
        $this->itemSold = $itemSold;
    }

    public function set_CR($commissionRate) {
        $this->commissionRate = $commissionRate;
    }

    public function __toString() {
        return parent::__toString() . ", Regular Salary: $this->regularSalary, Item Sold: $this->itemSold, Commission Rate: $this->commissionRate";
    }

    public function earnings() {
        $commission = $this->itemSold * $this->commissionRate;
        $totalEarnings = $this->regularSalary + $commission;
        return $totalEarnings;
    }
}
?>
