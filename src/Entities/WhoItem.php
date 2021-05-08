<?php


namespace Bot\Entities;

/** @Entity */
class WhoItem
{
    public const GENUS_MALE = 0;
    public const GENUS_FEMALE = 1;

    public const TYPE_NOUN = 0;
    public const TYPE_ADJECTIVE =1;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="integer", nullable=false) */
    protected $genus;

    /** @Column(type="integer", nullable=false) */
    protected $type;

    /** @Column(type="string", length=255, nullable=false) */
    protected $word;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getWord()
    {
        return $this->word;
    }
}