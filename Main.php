<?php

class Main {
    private EmployeeRoster $roster;
    private $repeat;

    public function __construct()
    {   
        // Ask user for the roster size (maximum 4)
        $size = (int) readline("Enter the size of the roster (max 4): ");
        
        // Ensure the size is no greater than 4
        if ($size > 4) {
            echo "[ERROR] Roster size cannot exceed 4.\n";
            exit; // Exits if the user enters an invalid size
        }

        // Initialize the roster with the size limit
        $this->roster = new EmployeeRoster($size);
    }

    public function start() {
        $this->clear();
        $this->repeat = true;

        echo "=====================================\n";
        echo "    Welcome to Employee Roster      \n";
        echo "=====================================\n";

        $remaining = $this->roster->remainingSlots();
        echo "\n Slots available in roster: $remaining\n";

        $this->menu();
    }

    public function menu() {
        $this->clear();

        echo "=====================================\n";
        echo "      EMPLOYEE ROSTER MENU          \n";
        echo "=====================================\n";
        echo "[1] Add Employee\n";
        echo "[2] Delete Employee\n";
        echo "[3] Other Options\n";
        echo "[0] Exit\n";

        $this->entrance();
    }

    public function entrance() {
        $choice = readline("Pick an option: ");
        
        while ($this->repeat) {
            $this->clear();

            switch ($choice) {
                case 1:
                    $this->addMenu();
                    break;
                case 2:
                    $this->deleteMenu();
                    break;
                case 3:
                    $this->otherMenu();
                    break;
                case 0:
                    echo "Exiting the application... Goodbye!\n";
                    exit;
                default:
                    echo "[ERROR] Invalid choice. Please try again.\n";
                    readline("Press \"Enter\" to continue...");
                    $this->entrance();
                    break;
            }
        }
    }

    public function addMenu() {
        $this->clear();
        echo "=====================================\n";
        echo "          Add New Employee          \n";
        echo "=====================================\n";
        
        $remaining = $this->roster->remainingSlots();
        
        if ($remaining <= 0) {
            echo "[ERROR] Roster is full. Cannot add more employees.\n";
            readline("Press \"Enter\" to return to the menu...");
            $this->menu();
            return;
        }

        // Display the remaining slots to the user
        echo "You can add $remaining more employee(s) to the roster.\n";

        $name = readline("Enter employee name: ");
        $address = readline("Enter employee address: ");
        $age = readline("Enter employee age: ");
        $cName = readline("Enter company name: ");

        $this->empType($name, $address, $age, $cName);
    }


    public function empType($name, $address, $age, $cName) {
        $this->clear();
        echo "=====================================\n";
        echo "          Employee Details          \n";
        echo "=====================================\n";
        echo "Name: $name\n";
        echo "Address: $address\n";
        echo "Age: $age\n";
        echo "Company: $cName\n";
        echo "Select Employee Type:\n";
        echo "[1] Commission Employee\n";
        echo "[2] Hourly Employee\n";
        echo "[3] Piece Worker\n";

        $type = readline("Enter type (1-3): ");

        switch ($type) {
            case 1:
                $this->addOnsCE($name, $address, $age, $cName);
                break;
            case 2:
                $this->addOnsHE($name, $address, $age, $cName);
                break;
            case 3:
                $this->addOnsPE($name, $address, $age, $cName);
                break;
            default:
                echo "[ERROR] Invalid input. Please choose a valid option.\n";
                readline("Press \"Enter\" to try again...");
                $this->empType($name, $address, $age, $cName);
                break;
        }
    }

    public function addOnsCE($name, $address, $age, $cName) {
        $regularSalary = (float) readline("Enter Regular Salary: ");
        $itemSold = (int) readline("Enter number of items sold: ");
        $commissionRate = (float) readline("Enter Commission Rate: ");

        $employee = new CommissionEmployee($name, $address, $age, $cName, $regularSalary, $itemSold, $commissionRate);

        if ($this->roster->add($employee)) {
            echo "\nEmployee Added Successfully.\n";
        } else {
            echo "\n[ERROR] Unable to add employee.\n";
        }

        // Show remaining slots after adding the employee
        $remaining = $this->roster->remainingSlots();
        echo "\n Remaining slots in roster: $remaining\n\n";
        
        $this->repeat();
    }


    public function addOnsHE($name, $address, $age, $cName) {
        echo "=====================================\n";
        echo "        Add Hourly Employee         \n";
        echo "=====================================\n";
    
        $hoursWorked = (int) readline("Enter number of hours worked: ");
        $rate = (float) readline("Enter rate per hour: ");
    
        $employee = new HourlyEmployee($name, $address, $age, $cName, $hoursWorked, $rate);            
        if ($this->roster->add($employee)) {
            echo "\nHourly Employee Added.\n";
        } else {
            echo "\n[ERROR] Unable to add employee.\n";
        }
        $this->repeat();
    }

    public function addOnsPE($name, $address, $age, $cName) {
        echo "=====================================\n";
        echo "         Add Piece Worker           \n";
        echo "=====================================\n";
    
        $numberItems = (int) readline("Enter number of pieces completed: ");
        $wagePerItem = (float) readline("Enter rate per piece: ");
    
        $employee = new PieceWorker($name, $address, $age, $cName, $numberItems, $wagePerItem);
        if ($this->roster->add($employee)) {
            echo "\nPiece Worker Added.\n";
        } else {
            echo "\n[ERROR] Unable to add employee.\n";
        }
        $this->repeat();
    }

    public function deleteMenu() {
        $this->clear();
        echo "=====================================\n";
        echo "          List of Employees         \n";
        echo "=====================================\n";
        
        // Display the list of employees with their index starting from 1
        $this->roster->displayEmployees($this->roster->getRoster()); 
        
        $empNumber = (int) readline("Enter the employee number to delete: ");
        
        // Adjust the input by subtracting 1 to match the zero-based index
        $indexToDelete = $empNumber - 1;  // Adjust for 1-based user input

        // Now call remove with the adjusted index
        if ($this->roster->remove($indexToDelete)) {
            echo "\nEmployee #$empNumber removed successfully.\n";
        } else {
            echo "\n[ERROR] Invalid employee number.\n";
        }

        readline("Press \"Enter\" to return to menu...");
        $this->menu();
    }


    public function otherMenu() {
        $this->clear();
        echo "=====================================\n";
        echo "            Other Options           \n";
        echo "=====================================\n";
        echo "[1] Display All Employees\n";
        echo "[2] Count Employees\n";
        echo "[3] Payroll\n";
        echo "[0] Return to Main Menu\n";
        $choice = readline("Choose an option: ");

        switch ($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->roster->payroll();
                break;
            case 0:
                $this->menu();
                break;
            default:
                echo "[ERROR] Invalid input. Please try again.\n";
                readline("Press \"Enter\" to continue...");
                $this->otherMenu();
                break;
        }
    }

    public function displayMenu() {
        $this->clear();
        echo "=====================================\n";
        echo "          Display Employees         \n";
        echo "=====================================\n";
        echo "[1] Display All Employees\n";
        echo "[2] Display Commission Employees\n";
        echo "[3] Display Hourly Employees\n";
        echo "[4] Display Piece Workers\n";
        echo "[0] Return to Menu\n";
        
        $choice = readline("Select option: ");

        switch ($choice) {
            case 1:
                $this->roster->display();
                break;
            case 2:
                $this->roster->displayCE();
                break;
            case 3:
                $this->roster->displayHE();
                break;
            case 4:
                $this->roster->displayPE();
                break;
            case 0:
                break;
            default:
                echo "[ERROR] Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" to continue...");
        $this->menu();
    }

    public function countMenu() {
        $this->clear();
        echo "=====================================\n";
        echo "           Employee Count           \n";
        echo "=====================================\n";
        echo "[1] Count All Employees\n";
        echo "[2] Count Commission Employees\n";
        echo "[3] Count Hourly Employees\n";
        echo "[4] Count Piece Workers\n";
        echo "[0] Return to Menu\n";

        $choice = readline("Select option: ");

        switch ($choice) {
            case 1:
                echo "Total Employees: " . $this->roster->count() . "\n";
                break;
            case 2:
                echo "Commission Employees: " . $this->roster->countCE() . "\n";
                break;
            case 3:
                echo "Hourly Employees: " . $this->roster->countHE() . "\n";
                break;
            case 4:
                echo "Piece Workers: " . $this->roster->countPE() . "\n";
                break;
            case 0:
                break;
            default:
                echo "[ERROR] Invalid Input!\n";
                break;
        }

        readline("\nPress \"Enter\" to continue...");
        $this->menu();
    }

    public function clear() {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }

    public function repeat() {
        // Ask if the user wants to add another employee
        $choice = readline("Do you want to add another employee? (y/n): ");
        if (strtolower($choice) === 'y') {
            $this->addMenu();
        } else {
            echo "Returning to menu...\n";
            $this->menu();
        }
    }
}
