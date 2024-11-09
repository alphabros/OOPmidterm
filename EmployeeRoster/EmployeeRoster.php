<?php

class EmployeeRoster {
    private $roster = [];

    public function __construct() {
        // No need to initialize with a fixed size
        $this->roster = [];
    }

    public function add(Employee $employee) {
        // Check if the employee already exists by name
        foreach ($this->roster as $existingEmployee) {
            if ($existingEmployee !== null && $existingEmployee->get_name() === $employee->get_name()) {
                echo "Employee already exists.\n";
                return false;
            }
        }

        // Add the employee to the roster
        $this->roster[] = $employee;
        echo "Employee added to the roster.\n";

        return true;
    }

    public function remove($empNumber) {
        $index = $empNumber - 1; // Convert to zero-based index
        if (isset($this->roster[$index]) && $this->roster[$index] !== null) {
            $this->roster[$index] = null;  // Remove employee by setting to null
            echo "Employee #$empNumber removed successfully.\n";
            return true;
        }
        echo "Invalid employee number or employee not found.\n";
        return false;
    }

    public function getRoster() {
        return $this->roster;
    }

    public function count() {
        return count(array_filter($this->roster, function ($employee) {
            return $employee !== null;
        }));
    }

    public function display() {
        echo "-- All Employees --\n";
        $this->displayEmployees($this->roster);
    }

    public function displayEmployees($employeeArray) {
        // Header
        echo str_repeat("-", 130) . "\n";
        echo "| #   | Name         | Address                 | Age | Type              | Company Name | R-Salary | I-Sold | C-Rate | Earnings   |\n";
        echo str_repeat("-", 130) . "\n";

        $hasEmployees = false;

        foreach ($employeeArray as $index => $employee) {
            if ($employee instanceof Employee) {
                $hasEmployees = true;
                $displayNumber = $index + 1; // Employee number starts at 1
                $regularSalary = method_exists($employee, 'get_RS') ? $employee->get_RS() : '-';
                $itemsSold = method_exists($employee, 'get_IS') ? $employee->get_IS() : '-';
                $commissionRate = method_exists($employee, 'get_CR') ? $employee->get_CR() : '-';
                $hourlyRate = method_exists($employee, 'get_rate') ? $employee->get_rate() : '-';
                $wagePerItem = method_exists($employee, 'get_WPI') ? $employee->get_WPI() : '-';
                $earnings = $employee->earnings();

                // Format and print each row (adjust width to include company name)
                printf(
                    "| %-3s | %-12s | %-23s | %-3s | %-16s | %-12s | %-7s | %-7s | %-7s | %-8s |\n", 
                    $displayNumber, 
                    $employee->get_name(), 
                    $employee->get_address(), 
                    $employee->get_age(), 
                    get_class($employee), 
                    $employee->get_CN(),  // Display the company name
                    $regularSalary,
                    $itemsSold,
                    $commissionRate,
                    $earnings
                );
            }
        }

        if (!$hasEmployees) {
            echo "| No employees found in the roster.                                                                                                   |\n";
        }

        // Footer
        echo str_repeat("-", 130) . "\n";
    }

    public function displayCE() {
        echo "-- Commission Employees --\n";
        $this->displayCommissionEmployees($this->roster);
    }

    private function displayCommissionEmployees($employeeArray) {
        // Header
        echo str_repeat("-", 130) . "\n";
        echo "| #   | Name             | Address                       | Age | Type              | Company Name   | Regular Salary | Items Sold | Commission Rate | Earnings   |\n";
        echo str_repeat("-", 130) . "\n";

        $hasEmployees = false;

        foreach ($employeeArray as $index => $employee) {
            if ($employee instanceof CommissionEmployee) {
                $hasEmployees = true;
                $displayNumber = $index + 1; // Employee number starts at 1
                $regularSalary = method_exists($employee, 'get_RS') ? $employee->get_RS() : '-';
                $itemsSold = method_exists($employee, 'get_IS') ? $employee->get_IS() : '-';
                $commissionRate = method_exists($employee, 'get_CR') ? $employee->get_CR() : '-';
                $earnings = $employee->earnings();

                // Format and print each row (adjust width to include company name)
                printf(
                    "| %-4s | %-16s | %-28s | %-3s | %-17s | %-14s | %-14s | %-10s | %-15s | %-10s |\n", 
                    $displayNumber, 
                    $employee->get_name(), 
                    $employee->get_address(), 
                    $employee->get_age(), 
                    'CommissionEmployee', 
                    $employee->get_CN(),  // Display the company name
                    $regularSalary,
                    $itemsSold,
                    $commissionRate,
                    $earnings
                );
            }
        }

        if (!$hasEmployees) {
            echo "| No Commission employees found in the roster.                                                                                       |\n";
        }

        // Footer
        echo str_repeat("-", 130) . "\n";
    }

    public function displayHE() {
        echo "-- Hourly Employees --\n";
        $this->displayHourlyEmployees($this->roster);
    }

    private function displayHourlyEmployees($employeeArray) {
        // Header
        echo str_repeat("-", 130) . "\n";
        echo "| #   | Name             | Address                       | Age | Type              | Company Name   | Hourly Rate  | Earnings   |\n";
        echo str_repeat("-", 130) . "\n";

        $hasEmployees = false;

        foreach ($employeeArray as $index => $employee) {
            if ($employee instanceof HourlyEmployee) {
                $hasEmployees = true;
                $displayNumber = $index + 1; // Employee number starts at 1
                $hourlyRate = method_exists($employee, 'get_rate') ? $employee->get_rate() : '-';
                $earnings = $employee->earnings();

                // Format and print each row (adjust width to include company name)
                printf(
                    "| %-4s | %-16s | %-28s | %-3s | %-17s | %-14s | %-12s | %-10s |\n", 
                    $displayNumber, 
                    $employee->get_name(), 
                    $employee->get_address(), 
                    $employee->get_age(), 
                    'HourlyEmployee', 
                    $employee->get_CN(),  // Display the company name
                    $hourlyRate,
                    $earnings
                );
            }
        }

        if (!$hasEmployees) {
            echo "| No Hourly employees found in the roster.                                                                                         |\n";
        }

        // Footer
        echo str_repeat("-", 130) . "\n";
    }

    public function displayPE() {
        echo "-- Piece Workers --\n";
        $this->displayPieceWorkers($this->roster);
    }

    private function displayPieceWorkers($employeeArray) {
        // Header
        echo str_repeat("-", 130) . "\n";
        echo "| #   | Name             | Address                       | Age | Type              | Company Name   | Wage per Item | Earnings   |\n";
        echo str_repeat("-", 130) . "\n";

        $hasEmployees = false;

        foreach ($employeeArray as $index => $employee) {
            if ($employee instanceof PieceWorker) {
                $hasEmployees = true;
                $displayNumber = $index + 1; // Employee number starts at 1
                $wagePerItem = method_exists($employee, 'get_WPI') ? $employee->get_WPI() : '-';
                $earnings = $employee->earnings();

                // Format and print each row (adjust width to include company name)
                printf(
                    "| %-4s | %-16s | %-28s | %-3s | %-17s | %-14s | %-13s | %-10s |\n", 
                    $displayNumber, 
                    $employee->get_name(), 
                    $employee->get_address(), 
                    $employee->get_age(), 
                    'PieceWorker', 
                    $employee->get_CN(),  // Display the company name
                    $wagePerItem,
                    $earnings
                );
            }
        }

        if (!$hasEmployees) {
            echo "| No Piece Workers found in the roster.                                                                                           |\n";
        }

        // Footer
        echo str_repeat("-", 130) . "\n";
    }

    public function payroll() {
        echo "-----------------\nPayroll\n-----------------\n";
        $employeeNumber = 1;

        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                echo "Employee #{$employeeNumber}\n";
                echo "Name       : " . $employee->get_name() . "\n";
                echo "Address    : " . $employee->get_address() . "\n";
                echo "Age        : " . $employee->get_age() . "\n";
                echo "Company    : " . $employee->get_CN() . "\n";  // Display company name

                if (method_exists($employee, 'get_RS')) {
                    echo "Regular Salary: " . $employee->get_RS() . "\n";
                    echo "Items Sold    : " . $employee->get_IS() . "\n";
                    echo "Commission Rate: " . $employee->get_CR() . "\n";
                }
                if (method_exists($employee, 'get_rate')) {
                    echo "Hourly Rate    : " . $employee->get_rate() . "\n";
                }
                if (method_exists($employee, 'get_WPI')) {
                    echo "Wage per Item  : " . $employee->get_WPI() . "\n";
                }

                echo "Earnings      : " . $employee->earnings() . "\n\n";
            }
            $employeeNumber++;
        }
    }
}
?>
