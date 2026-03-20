<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'full_name' => 'Juan Dela Cruz',
                'employment_type' => 'Regular',
                'designation' => 'Senior Developer',
                'basic_rate' => 50000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1200.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 500.00,
                'other_deductions' => 100.00,
            ],
            [
                'full_name' => 'Maria Clara',
                'employment_type' => 'Regular',
                'designation' => 'Project Manager',
                'basic_rate' => 60000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1500.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 600.00,
                'other_deductions' => 150.00,
            ],
            [
                'full_name' => 'Jose Rizal',
                'employment_type' => 'Non-Regular',
                'designation' => 'Researcher',
                'basic_rate' => 35000.00,
                'pay_schedule' => 'Weekly',
                'sss_amount' => 800.00,
                'hdmf_amount' => 100.00,
                'philhealth_amount' => 300.00,
                'other_deductions' => 0.00,
            ],
            [
                'full_name' => 'Andres Bonifacio',
                'employment_type' => 'Regular',
                'designation' => 'Security Analyst',
                'basic_rate' => 45000.00,
                'pay_schedule' => '10/25',
                'sss_amount' => 1000.00,
                'hdmf_amount' => 150.00,
                'philhealth_amount' => 450.00,
                'other_deductions' => 50.00,
            ],
            [
                'full_name' => 'Emilio Aguinaldo',
                'employment_type' => 'Regular',
                'designation' => 'Office Administrator',
                'basic_rate' => 30000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 700.00,
                'hdmf_amount' => 100.00,
                'philhealth_amount' => 300.00,
                'other_deductions' => 20.00,
            ],
            [
                'full_name' => 'Apolinario Mabini',
                'employment_type' => 'Non-Regular',
                'designation' => 'Legal Consultant',
                'basic_rate' => 55000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1300.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 550.00,
                'other_deductions' => 0.00,
            ],
            [
                'full_name' => 'Gabriela Silang',
                'employment_type' => 'Regular',
                'designation' => 'Team Lead',
                'basic_rate' => 52000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1250.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 520.00,
                'other_deductions' => 100.00,
            ],
            [
                'full_name' => 'Melchora Aquino',
                'employment_type' => 'Regular',
                'designation' => 'Welfare Officer',
                'basic_rate' => 32000.00,
                'pay_schedule' => 'Weekly',
                'sss_amount' => 750.00,
                'hdmf_amount' => 100.00,
                'philhealth_amount' => 320.00,
                'other_deductions' => 30.00,
            ],
            [
                'full_name' => 'Marcelo Del Pilar',
                'employment_type' => 'Regular',
                'designation' => 'Editor',
                'basic_rate' => 38000.00,
                'pay_schedule' => '10/25',
                'sss_amount' => 900.00,
                'hdmf_amount' => 150.00,
                'philhealth_amount' => 380.00,
                'other_deductions' => 45.00,
            ],
            [
                'full_name' => 'Antonio Luna',
                'employment_type' => 'Regular',
                'designation' => 'Strategy Planner',
                'basic_rate' => 48000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1100.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 480.00,
                'other_deductions' => 80.00,
            ],
            [
                'full_name' => 'Lapu-Lapu',
                'employment_type' => 'Non-Regular',
                'designation' => 'Survivalist',
                'basic_rate' => 28000.00,
                'pay_schedule' => 'Weekly',
                'sss_amount' => 650.00,
                'hdmf_amount' => 100.00,
                'philhealth_amount' => 280.00,
                'other_deductions' => 10.00,
            ],
            [
                'full_name' => 'Gregorio Del Pilar',
                'employment_type' => 'Regular',
                'designation' => 'Communications Specialist',
                'basic_rate' => 42000.00,
                'pay_schedule' => '10/25',
                'sss_amount' => 950.00,
                'hdmf_amount' => 150.00,
                'philhealth_amount' => 420.00,
                'other_deductions' => 60.00,
            ],
            [
                'full_name' => 'Teresa Magbanua',
                'employment_type' => 'Regular',
                'designation' => 'Operations Manager',
                'basic_rate' => 58000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1400.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 580.00,
                'other_deductions' => 120.00,
            ],
            [
                'full_name' => 'Ninoy Aquino',
                'employment_type' => 'Regular',
                'designation' => 'Public Relations',
                'basic_rate' => 46000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1050.00,
                'hdmf_amount' => 150.00,
                'philhealth_amount' => 460.00,
                'other_deductions' => 70.00,
            ],
            [
                'full_name' => 'Cory Aquino',
                'employment_type' => 'Regular',
                'designation' => 'Executive Director',
                'basic_rate' => 70000.00,
                'pay_schedule' => '15/30',
                'sss_amount' => 1600.00,
                'hdmf_amount' => 200.00,
                'philhealth_amount' => 700.00,
                'other_deductions' => 200.00,
            ],
        ];

        foreach ($employees as $empData) {
            Employee::create($empData);
        }
    }
}
