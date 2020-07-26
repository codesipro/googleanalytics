<?php

namespace Silverstripers\GoogleAnalytics\models;

use Silverstripe\ORM\DataObject;
use Silverstripe\Forms\TreeMultiselectField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\CMS\Model\SiteTree;


/**
 * Created by Nivanka Fonseka (nivanka@silverstripers.com).
 * User: nivankafonseka
 * Date: 2/3/15
 * Time: 4:44 PM
 * To change this template use File | Settings | File Templates.
 */

class GoogleTrackEvent extends DataObject
{
    private static $db = [
        'Target' => 'Varchar(300)',
        'EventType' => 'Enum(
                            "Click,Hover",
                            "Click"
                      )',
        'Category' => 'Varchar(100)',
        'Action' => 'Varchar(100)',
        'Label' => 'Varchar(100)'
    ];

    private static $has_one = [
        'SiteConfig' => SiteConfig::class
    ];

    private static $many_many = [
        'Pages' => SiteTree::class
    ];

    private static $summary_fields = [
        'Target',
        'EventType',
        'Category',
        'Action',
        'Label'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('SiteConfigID');
        if ($targetField = $fields->dataFieldByName('Target')) {
            $targetField->setRightTitle('ID or CSS class to find the dom element');
        }

        $fields->removeByName('Pages');
        $fields->addFieldToTab('Root.Main', TreeMultiselectField::create('Pages', 'Select Pages (leave empty for all the pages)')->setSourceObject(SiteTree::class));

        return $fields;
    }
}
