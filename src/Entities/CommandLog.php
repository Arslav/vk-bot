<?php

namespace Bot\Entities;

use Bot\Entities\Traits\TimestampTrait;
/**
 * @Entity
 */
class CommandLog
{
    use TimestampTrait;
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="integer", nullable=false) */
    protected $user_id;

    /** @Column(type="string", length=255, nullable=false) */
    protected $command;

    /**
     * @return int
     */
    public function getUserId(): int
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
    public function getCommand(): string
    {
        return $this->command;
    }

    /**
     * @param string $command
     */
    public function setCommand(string $command): void
    {
        $this->command = $command;
    }

}