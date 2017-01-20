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
     * @ORM\Column(name="titleFR", type="string", length=100)
     *
     * @Assert\NotBlank(message="product.titleFR")
     *
     * @Assert\Length(
     *     min = 5,
     *     max = 100,
     *     minMessage = "Votre titre doit contenir au moins {{ limit }} caractères.",
     *     maxMessage = "Votre titre ne peut pas avoir plus de {{ limit }} caractères."
     * )
     */
    private $titleFR;

    /**
     * @var string
     *
     * @ORM\Column(name="titleEN", type="string", length=100)
     *
     * @Assert\NotBlank(message="product.titleEN")
     *
     * @Assert\Length(
     *     min = 5,
     *     max = 100,
     *     minMessage = "Votre titre doit contenir au moins {{ limit }} caractères.",
     *     maxMessage = "Votre titre ne peut pas avoir plus de {{ limit }} caractères."
     * )
     */
    private $titleEN;


    /**
     * @var string
     *
     * @ORM\Column(name="descriptionFR", type="text")
     *
     * @Assert\NotBlank(message="product.descriptionFR")
     *
     * @Assert\Length(
     *     max = 300,
     *     maxMessage="Votre description ne peut pas avoir plus de {{ limit }} caractères.")
     *
     */
    private $descriptionFR;

    /**
     * @var string
     *
     * @ORM\Column(name="descriptionEN", type="text")
     *
     * @Assert\NotBlank(message="product.descriptionEN")
     *
     * @Assert\Length(
     *     max = 300,
     *     maxMessage="Votre description ne peut pas avoir plus de {{ limit }} caractères.")
     *
     */
    private $descriptionEN;


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
     * @var string
     * @ORM\Column(name="image", type="string")
     */
    private $image;



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set titleFR
     *
     * @param string $titleFR
     *
     * @return Product
     */
    public function setTitleFR($titleFR)
    {
        $this->titleFR = $titleFR;

        return $this;
    }

    /**
     * Get titleFR
     *
     * @return string
     */
    public function getTitleFR()
    {
        return $this->titleFR;
    }

    /**
     * Set titleEN
     *
     * @param string $titleEN
     *
     * @return Product
     */
    public function setTitleEN($titleEN)
    {
        $this->titleEN = $titleEN;

        return $this;
    }

    /**
     * Get titleEN
     *
     * @return string
     */
    public function getTitleEN()
    {
        return $this->titleEN;
    }

    /**
     * Set descriptionFR
     *
     * @param string $descriptionFR
     *
     * @return Product
     */
    public function setDescriptionFR($descriptionFR)
    {
        $this->descriptionFR = $descriptionFR;

        return $this;
    }

    /**
     * Get descriptionFR
     *
     * @return string
     */
    public function getDescriptionFR()
    {
        return $this->descriptionFR;
    }

    /**
     * Set descriptionEN
     *
     * @param string $descriptionEN
     *
     * @return Product
     */
    public function setDescriptionEN($descriptionEN)
    {
        $this->descriptionEN = $descriptionEN;

        return $this;
    }

    /**
     * Get descriptionEN
     *
     * @return string
     */
    public function getDescriptionEN()
    {
        return $this->descriptionEN;
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
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
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

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
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
}
