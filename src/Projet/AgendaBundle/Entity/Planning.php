<?php

namespace Projet\AgendaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planning
 */
class Planning
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $iduser;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $idact;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     * @return Planning
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return integer 
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Planning
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set idact
     *
     * @param integer $idact
     * @return Planning
     */
    public function setIdact($idact)
    {
        $this->idact = $idact;

        return $this;
    }

    /**
     * Get idact
     *
     * @return integer 
     */
    public function getIdact()
    {
        return $this->idact;
    }
}
