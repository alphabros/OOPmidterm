<?php

class EmployeeRoster {
    private array $roster = [];  // Declare $roster as an array
    private int $maxSize;

    public function __construct(int $maxSize) {
        $this->maxSize = $maxSize;  // Set the maximum number of employees allowed
    }
    
    public function remainingSlots() {
        return $this->maxSize - count($this->roster);
    }

    public function add(Employee $employee): bool {
        if (count($this->roster) < $this->maxSize) {
            $this->roster[] = $employee;
            return true;
        } else {
            return false; // Cannot add more employees, roster is full
        }
    }

    public function isFull(): bool {
        return count($this->roster) >= $this->maxSize;  // Check the roster size
    }

    public function remove(int $index): bool {
        if (isset($this->roster[$index])) {
            unset($this->roster[$index]);  // Remove the employee at that index
            $this->roster = array_values($this->roster);  // Re-index the array to prevent gaps
            return true;
        }
        return false;  // If the index doesn't exist, return false
    }

    public function getRoster() {
        return $this->roster;  // Return the roster
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

     public function countCE(): int {
        $count = 0;
        foreach ($this->roster as $employee) {
            if ($employee instanceof CommissionEmployee) {
                $count++;
            }
        }
        return $count;
    }

    // Method to count Hourly Employees
    public function countHE(): int {
        $count = 0;
        foreach ($this->roster as $employee) {
            if ($employee instanceof HourlyEmployee) {
                $count++;
            }
        }
        return $count;
    }

    // Method to count Piece Workers
    public function countPE(): int {
        $count = 0;
        foreach ($this->roster as $employee) {
            if ($employee instanceof PieceWorker) {
                $count++;
            }
        }
        return $count;
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
        echo str_repeat("-", 155) . "\n";
        echo "| #   | Name             | Address                       | Age | Company Name  | RS        | IS        | CR          | HR        | WPI      | Earnings    |\n";
        echo str_repeat("-", 155) . "\n";

        $employeeNumber = 1; // Start numbering employees from 1
        $hasEmployees = false;

        foreach ($this->roster as $employee) {
            if ($employee !== null) {
                $hasEmployees = true;

                // Gather employee data
                $name = str_pad($employee->get_name(), 16, ' ');
                $address = str_pad($employee->get_address(), 28, ' ');
                $age = str_pad($employee->get_age(), 3, ' ');
                $companyName = str_pad($employee->get_CN(), 13, ' ');
                $regularSalary = str_pad(method_exists($employee, 'get_RS') ? $employee->get_RS() : '-', 9, ' ');
                $itemsSold = str_pad(method_exists($employee, 'get_IS') ? $employee->get_IS() : '-', 10, ' ');
                $commissionRate = str_pad(method_exists($employee, 'get_CR') ? $employee->get_CR() : '-', 11, ' ');
                $hourlyRate = str_pad(method_exists($employee, 'get_rate') ? $employee->get_rate() : '-', 10, ' ');
                $wagePerItem = str_pad(method_exists($employee, 'get_WPI') ? $employee->get_WPI() : '-', 8, ' ');
                $earnings = str_pad($employee->earnings(), 12, ' ');

                // Print each row with improved alignment
                printf(
                    "| %-3d | %-16s | %-28s | %-3s | %-14s | %-9s | %-8s | %-10s | %-10s | %-8s | %-10s |\n", 
                    $employeeNumber, 
                    $name, 
                    $address, 
                    $age, 
                    $companyName, 
                    $regularSalary, 
                    $itemsSold, 
                    $commissionRate, 
                    $hourlyRate, 
                    $wagePerItem,
                    $earnings
                );

                $employeeNumber++;
            }
        }

        if (!$hasEmployees) {
            echo "| No employees found in the roster.                                                                                                       |\n";
        }

        // Footer
        echo str_repeat("-", 155) . "\n";
    }


}
?>
