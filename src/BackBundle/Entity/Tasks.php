<?php

namespace App\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tasks
 *
 * @ORM\Table(name="tasks", indexes={@ORM\Index(name="fk_tasks_users_idx", columns={"user_id"})})
 * @ORM\Entity
 */
class Tasks
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="status", type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \App\BackBundle\Entity\Users
     *
     * @ORM\ManyToOne(targetEntity="App\BackBundle\Entity\Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    function getTitle() {
        return $this->title;
    }

    function getDescription() {
        return $this->description;
    }

    function getStatus() {
        return $this->status;
    }

    function getCreatedAt(): \DateTime {
        return $this->createdAt;
    }

    function getUpdatedAt(): \DateTime {
        return $this->updatedAt;
    }

    function getId() {
        return $this->id;
    }

    function getUser(): \App\BackBundle\Entity\Users {
        return $this->user;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCreatedAt(\DateTime $createdAt) {
        $this->createdAt = $createdAt;
    }

    function setUpdatedAt(\DateTime $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUser(\App\BackBundle\Entity\Users $user) {
        $this->user = $user;
    }


}
