<?php
abstract class Employee extends Person {
    protected $companyName;

    public function __construct($name, $address, $age, $companyName) {
        parent::__construct($name, $address, $age);
        $this->companyName = $companyName;
    }

    public function get_CN() {
        return $this->companyName;
    }

    public function set_CN($companyName) {
        $this->companyName = $companyName;
    }

    abstract public function earnings();

    public function __toString() {
        return parent::__toString() . ", Company: $this->companyName";  
    }
}
?>
