<?php
declare(strict_types=1);


namespace Lukasz93P\dddPackage\infrastructure\persistence;


use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass()
 */
abstract class VersionedDoctrineEntityWithLifecycleTimestamps
{
    /**
     * @var DateTime $created
     *
     * @ORM\Column(type="datetime")
     */
    protected ?DateTime $created = null;

    /**
     * @var DateTime $updated
     *
     * @ORM\Column(type="datetime", nullable = true)
     */
    protected ?DateTime $updated = null;

    /**
     * @var int $version
     *
     * @ORM\Column(type="integer", nullable = false, options={"default":1})
     * @ORM\Version()
     */
    protected int $version = 1;

    /**
     * Gets triggered only on insert
     * @ORM\PrePersist
     */
    public function onPrePersist(): void
    {
        $this->created = new DateTime();
    }

    /**
     * Gets triggered every time on update
     * @ORM\PreUpdate
     */
    public function onPreUpdate(): void
    {
        $this->updated = new DateTime();
    }

}