<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Local Entity
 *
 * @property int $id
 * @property int $local_code
 * @property int $address_id
 * @property string $local_name
 *
 * @property \App\Model\Entity\Address $address
 * @property \App\Model\Entity\Log[] $logs
 */
class Local extends Entity
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
