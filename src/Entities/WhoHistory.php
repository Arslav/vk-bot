<?php


namespace Bot\Entities;

use Bot\Entities\Traits\TimestampTrait;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class WhoHistory
{
    use TimestampTrait;
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="integer", length=255, nullable=false) */
    protected $user_id;

    /** @Column(type="string", length=255, nullable=false) */
    protected $name;


    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}