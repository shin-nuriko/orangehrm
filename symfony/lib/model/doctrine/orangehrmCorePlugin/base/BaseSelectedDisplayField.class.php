<?php

/**
 * BaseSelectedDisplayField
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $displayFieldId
 * @property integer $reportId
 * @property Report $Report
 * @property DisplayField $DisplayField
 * 
 * @method integer              getId()             Returns the current record's "id" value
 * @method integer              getDisplayFieldId() Returns the current record's "displayFieldId" value
 * @method integer              getReportId()       Returns the current record's "reportId" value
 * @method Report               getReport()         Returns the current record's "Report" value
 * @method DisplayField         getDisplayField()   Returns the current record's "DisplayField" value
 * @method SelectedDisplayField setId()             Sets the current record's "id" value
 * @method SelectedDisplayField setDisplayFieldId() Sets the current record's "displayFieldId" value
 * @method SelectedDisplayField setReportId()       Sets the current record's "reportId" value
 * @method SelectedDisplayField setReport()         Sets the current record's "Report" value
 * @method SelectedDisplayField setDisplayField()   Sets the current record's "DisplayField" value
 * 
 * @package    orangehrm
 * @subpackage model\core\base
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSelectedDisplayField extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('ohrm_selected_display_field');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('display_field_id as displayFieldId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('report_id as reportId', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Report', array(
             'local' => 'report_id',
             'foreign' => 'reportId',
             'onDelete' => 'cascade'));

        $this->hasOne('DisplayField', array(
             'local' => 'display_field_id',
             'foreign' => 'displayFieldId',
             'onDelete' => 'cascade'));
    }
}