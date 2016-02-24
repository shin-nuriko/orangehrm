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

    public function getCustomFieldsService() {
        if(is_null($this->customFieldsService)) {
            $this->customFieldsService = new CustomFieldConfigurationService();
        }
        return $this->customFieldsService;
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

    private function _getJobCategory($catId) {
        $jobService = new JobCategoryService();
        $categories = $jobService->getJobCategoryList();

        foreach ($categories as $category) {
            if ($category->getId() == $catId ) {
                return $category->getName();
            }
        }
        return;
    }

    public function getCompanyStructureService() {
        if (is_null($this->companyStructureService)) {
            $this->companyStructureService = new CompanyStructureService();
            $this->companyStructureService->setCompanyStructureDao(new CompanyStructureDao());
        }
        return $this->companyStructureService;
    }

    private function _getSubDivision($subUnitId) {
        $treeObject = $this->getCompanyStructureService()->getSubunitTreeObject();
        $tree = $treeObject->fetchTree();

        foreach ($tree as $node) {
            if ($node->getId() != 1) {
                if ($node->getId() == $subUnitId) {
                    return $node['name'];
                }
                $subUnitList[$node->getId()] = str_repeat('&nbsp;&nbsp;', $node['level'] - 1) . $node['name'];
            }
        }
        return;
    }

    public function getJobDetails($employee) {
        $data = array();
        $data['Employee ID'] = $employee->employeeId;
        $data['Designation'] = $this->_getJobTitle($employee->job_title_code);
        $data['Division'] = $this->_getJobCategory($employee->eeo_cat_code);
        $data['Section'] = $this->_getSubDivision($employee->work_station);
        $data['Employee Status'] = $this->_getEmpStatus($employee->emp_status);
        $data['Date Employed'] = $employee->getJoinedDate();
        $data['Years of Service'] = $employee->getYearOfService();
        return $data;
    }

    /*
    returns array("custom1"=>"fieldname","custom2"=>"fieldname")
    actual custom field values can be accessed by employee service
    ex. $employee->custom1;
    */
    private function _getCustomFields($customFieldsService, $screen) {
        $customFields = array();
        $customFieldList = $customFieldsService->getCustomFieldList($screen);
        foreach ($customFieldList as $customField) {
            $fieldId = "custom" . $customField->getId();
            $fieldName = $customField->getName();
            $customFields[$fieldId] = $fieldName;
        }
        return $customFields;
    }

    /*
    custom field names can be changed by Admin which can affect array_search() result
    */
    private function _getCustomFieldId($customFields, $customFieldName) {
        $customFieldId = array_search($customFieldName, $customFields);
        return $customFieldId;
    }

    public function getPersonalDetails($employee) {
        $data = array();
        $customPersonalDetails = $this->_getCustomFields($this->getCustomFieldsService(), CustomField::SCREEN_PERSONAL_DETAILS);
        $data['Gender'] = $this->_getGender($employee->emp_gender);
        $data['Citizenship'] = $this->_getNationality($employee->nation_code);
        $data['Civil Status'] = $employee->emp_marital_status;
        $data['Birth Date'] = $employee->emp_birthday;
        $data['Age'] = $this->_getAge($employee->emp_birthday);

        /* AAC specific custom fields, custom field name should be exact */
        $religion   = $this->_getCustomFieldId($customPersonalDetails, 'Religion');
        $sss        = $this->_getCustomFieldId($customPersonalDetails, 'SSS No.');
        $tin        = $this->_getCustomFieldId($customPersonalDetails, 'Tin No.');
        $pagibig    = $this->_getCustomFieldId($customPersonalDetails, 'Pag-ibig No.');
        $philhealth = $this->_getCustomFieldId($customPersonalDetails, 'Philhealth No.');
        $data['Religion'] = $employee->$religion; //$employee->custom5;
        $data['SSS No.'] = $employee->$sss;
        $data['TIN No.'] = $employee->$tin;
        $data['Pag-ibig No.'] = $employee->$pagibig;
        $data['Philhealth No.'] = $employee->$philhealth;

        return $data;
    }

    public function getContactDetails($employee) {
        $data = array();
        $customContactDetails = $this->_getCustomFields($this->getCustomFieldsService(), CustomField::SCREEN_CONTACT_DETAILS);
        $data['Current Address'] = $employee->street1 
                           . ' ' . $employee->street2
                           . ', '. $employee->city
                           . ', '. $employee->province
                           . ', '. $employee->country
                           . ' '. $employee->emp_zipcode;
        /* AAC specific custom fields, custom field name should be exact */
        $provincialAddress   = $this->_getCustomFieldId($customContactDetails, 'Provincial Address');
        $data['Provincial Address'] = $employee->$provincialAddress;

        $data['Work No.'] = $employee->emp_work_telephone;
        $data['Mobile No.'] = $employee->emp_mobile;
        $data['Home No.'] = $employee->emp_hm_telephone;
        $data['Work Email'] = $employee->emp_work_email;
        $data['Other Email'] = $employee->emp_oth_email;
        return $data;
    }

    private function _getEducationLevel($educationId) {
        $educationService = new EducationService();
        $educationList = $educationService->getEducationList();
        foreach($educationList as $education) {
            if ($education->getId() == $educationId) {
                return $education->getName();
            }
        }
    }

    public function getEducationDetails($employee) {
        $data = array();
        $educationList = $this->employee->getEmployeeEducation($this->empNumber);
        foreach($educationList as $education) {
            $data[] = array(
                        'Level' => $this->_getEducationLevel($education->educationId),
                        'Degree' => $education->major,
                        'Institute' => $education->institute,
                        'Start Year' => $education->startDate,
                        'End Year' => $education->endDate);
        }
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
                $this->education_details = $this->getEducationDetails($this->employee);


                //var_dump($educ);
                //$this->_getEducationList($educ);
        }

    }

}
