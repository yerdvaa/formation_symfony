<?php

namespace adminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="adminBundle\Repository\ProductRepository")
 * @ORM\EntityListeners({"adminBundle\Listener\ProductListener"})
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     *
     * @Assert\Length(
     *     min = 5,
     *     max = 100,
     *     minMessage = "Votre titre doit contenir au moins {{ limit }} caractères.",
     *     maxMessage = "Votre titre ne peut pas avoir plus de {{ limit }} caractères."
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     *
     * @Assert\Length(
     *     max = 300,
     *     maxMessage="Votre description ne peut pas avoir plus de {{ limit }} caractères.")
     *
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     *
     * @Assert\GreaterThan(0)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     *
     * @Assert\NotBlank(message="Champ obligatoire")
     *
     */
    private $quantity;


    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="id_brand", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank(message="Veuillez sélectionner une marque.")
     */
    private $marque;

    /**
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="Product")
     * @ORM\JoinTable(name="products_categories")
     * @Assert\NotBlank(message="Veuillez sélectionner une catégorie.")
     */
    private $categories;

    /**
     * @var datetime
     * @ORM\Column(name="date_Creation", type="datetime")
     */
    private $dateCreation;

    /**
     * @var datetime
     * @ORM\Column(name="date_Modification", type="datetime")
     */
    private $dateEdit;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }




    /**
     * Set marque
     *
     * @param \adminBundle\Entity\Brand $marque
     *
     * @return Product
     */
    public function setMarque(\adminBundle\Entity\Brand $marque)
    {
        $this->marque = $marque;

        return $this;
    }

    /**
     * Get marque
     *
     * @return \adminBundle\Entity\Brand
     */
    public function getMarque()
    {
        return $this->marque;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add category
     *
     * @param \adminBundle\Entity\Categorie $category
     *
     * @return Product
     */
    public function addCategory(\adminBundle\Entity\Categorie $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \adminBundle\Entity\Categorie $category
     */
    public function removeCategory(\adminBundle\Entity\Categorie $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Product
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * Set dateEdit
     *
     * @param \DateTime $dateEdit
     *
     * @return Product
     */
    public function setDateEdit($dateEdit)
    {
        $this->dateEdit = $dateEdit;

        return $this;
    }

    /**
     * Get dateEdit
     *
     * @return \DateTime
     */
    public function getDateEdit()
    {
        return $this->dateEdit;
    }
}
