<?php 
class Person {
    private $name;
    private $address;
    private $age;

    public function __construct($name, $address, $age) {
        $this->name = $name;
        $this->address = $address;
        $this->age = $age;
    }

    public function get_name() {
        return $this->name;
    }

    public function set_name($name) {
        $this->name = $name;
    }

    public function get_address() {
        return $this->address;
    }

    public function set_address($address) {
        $this->address = $address;
    }

    public function get_age() {
        return $this->age;
    }

    public function set_age($age) {
        $this->age = $age;
    }

    public function __toString() {
        return "Name: $this->name, Address: $this->address, Age: $this->age";
    }
}
?>
