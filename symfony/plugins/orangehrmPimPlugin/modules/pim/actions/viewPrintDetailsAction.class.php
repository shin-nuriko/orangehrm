<?php
/**
 * OrangeHRM is a comprehensive Human Resource Management (HRM) System that captures
 * all the essential functionalities required for any enterprise.
 * Copyright (C) 2006 OrangeHRM Inc., http://www.orangehrm.com
 *
 * OrangeHRM is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 2 of the License, or (at your option) any later version.
 *
 * OrangeHRM is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor,
 * Boston, MA  02110-1301, USA
 */
/**
 * printDetailsAction
 *
 */
class viewPrintDetailsAction extends basePimAction {
    private $employee;
  
    public function getJobTitleService() {
        if (is_null($this->jobTitleService)) {
            $this->jobTitleService = new JobTitleService();
            $this->jobTitleService->setJobTitleDao(new JobTitleDao());
        }
        return $this->jobTitleService;
    }

    private function _getJobTitle($jobTitleId) {
        $jobTitle = '';
        $jobTitleList = $this->getJobTitleService()->getJobTitleList("", "", false);

        foreach ($jobTitleList as $job) {
            if ($job->getId() == $jobTitleId) {
                $jobTitle = $job->getJobTitleName();
            }
        }
        return $jobTitle;
    }

    private function _getEmpStatus($empStatusId) {
        $empStatusService = new EmploymentStatusService();
        $statuses = $empStatusService->getEmploymentStatusList();

        foreach ($statuses as $status) {
            if ($status->getId() == $empStatusId) { 
                return $status->getName();
            }
        }
        return;
    }

    private function _getGender($genderId) {
        switch ($genderId) {
            case '1':
                return 'Male';
                break;
            case '2':
                return 'Female';
                break;
        }
        return;
    }

    public function getNationalityService() {
        if (is_null($this->nationalityService)) {
            $this->nationalityService = new NationalityService();
        }
        return $this->nationalityService;
    }

    private function _getNationality($nationalityId) {
        $nationalityService = $this->getNationalityService();
        $nationalities = $nationalityService->getNationalityList();

        foreach ($nationalities as $nationality) {
            if ($nationality->getId() == $nationalityId) {
                return $nationality->getName();
            }
        }
        return;
    }

    private function _getAge($birthday) {
        list($Y, $m, $d) = explode("-", $birthday);
        $years = date("Y") - $Y;

        if (date("md") < $m . $d) {
            $years--;
        }
        return $years;
    }

    public function getJobDetails($employee) {
        $data = array();
        $jobTitleId = $employee->job_title_code;
        $empTerminatedId = $employee->termination_id;
        $jobTitle = $this->_getJobTitle($jobTitleId);
        $data['Employee ID'] = $employee->employeeId;
        $data['Designation'] = $jobTitle;
        $data['Employee Status'] = $this->_getEmpStatus($employee->emp_status);
        $data['Date Employed'] = $employee->getJoinedDate();
        $data['Years of Service'] = $employee->getYearOfService();
        return $data;
    }

    public function getPersonalDetails($employee) {
        $data = array();
        $data['Gender'] = $this->_getGender($employee->emp_gender);
        $data['Citizenship'] = $this->_getNationality($employee->nation_code);
        $data['Civil Status'] = $employee->emp_marital_status;
        $data['Religion'] = '';
        $data['Birth Date'] = $employee->emp_birthday;
        $data['Age'] = $this->_getAge($employee->emp_birthday);
        $data['SSS No.'] = '';
        $data['TIN No.'] = '';
        $data['Pag-ibig No.'] = '';
        $data['Philhealth No.'] = '';

        return $data;
    }

    public function getContactDetails($employee) {
        $data = array();
        $data['Current Address'] = $employee->street1 
                           . ' ' . $employee->street2
                           . ', '. $employee->city
                           . ', '. $employee->province
                           . ', '. $employee->country
                           . ' '. $employee->emp_zipcode;
        $data['Provincial Address'] = '';
        $data['Work No.'] = $employee->emp_work_telephone;
        $data['Mobile No.'] = $employee->emp_mobile;
        $data['Home No.'] = $employee->emp_hm_telephone;
        $data['Work Email'] = $employee->emp_work_email;
        $data['Other Email'] = $employee->emp_oth_email;
        return $data;
    }

    public function execute($request) {
        $this->$personal_details;
        $loggedInEmpNum = $this->getUser()->getEmployeeNumber();

        $personal = $request->getParameter('personal');
        $empNumber = (isset($personal['txtEmpID']))?$personal['txtEmpID']:$request->getParameter('empNumber');
        $this->empNumber = $empNumber;

        $this->personalInformationPermission = $this->getDataGroupPermissions('personal_information', $empNumber);


        if (!$this->IsActionAccessible($empNumber)) {
            $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
        }

        if ($this->personalInformationPermission->canUpdate()){
                $this->employee = $this->getEmployeeService()->getEmployee($empNumber);
                $this->fullName = $this->employee->getFullName();
                $this->personal_details = $this->getPersonalDetails($this->employee);
                $this->job_details = $this->getJobDetails($this->employee);
                $this->contact_details = $this->getContactDetails($this->employee);
                        var_dump($this->contact_details);
        }

    }

}
