<?php


namespace Bot\Entities;

use Bot\Entities\Traits\TimestampTrait;

/**
 * @Entity
 * @HasLifecycleCallbacks
 */
class WowSpecTop
{
    use TimestampTrait;
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="WowSpec")
     * @JoinColumn(name="spec_id", referencedColumnName="id")
     */
    protected $spec;

    /** @Column(type="integer", nullable=false) */
    protected $rank;

    /**
     * @return WowSpec
     */
    public function getSpec() : WowSpec
    {
        return $this->spec;
    }

    /**
     * @param WowSpec $spec
     */
    public function setSpec(WowSpec $spec): void
    {
        $this->spec = $spec;
    }

    /**
     * @return int
     */
    public function getRank(): int
    {
        return $this->rank;
    }

    /**
     * @param int $rank
     */
    public function setRank(int $rank): void
    {
        $this->rank = $rank;
    }
}