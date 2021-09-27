<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property \Cake\I18n\Time $dob
 * @property bool $status
 * @property string $doctor_name
 * @property string $institution
 * @property \Cake\I18n\Time $date
 * @property string $employee_id
 * @property bool $is_dependant
 * @property string $primary_name
 * @property string $hero
 * @property int $user_id
 */class Log extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];
}
