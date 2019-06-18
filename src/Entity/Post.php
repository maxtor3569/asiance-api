<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use App\Entity\Author;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(attributes={"pagination_client_items_per_page"=true})
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 * @Vich\Uploadable
 */
class Post
{

	use TimestampableEntity;


	/**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

	/**
	 * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="posts")
	 * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
	 */
	protected $author;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @var string
	 */
	private $image;

	/**
	 * @Vich\UploadableField(mapping="post_images", fileNameProperty="image")
	 * @var File
	 */
	private $imageFile;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $tags;



	public function __construct()
	{
		$this->createdAt = new \DateTime('now');
		$this->updatedAt = new \DateTime('now');

	}

	public function __toString()
	{
		return $this->title;
		// TODO: Implement __toString() method.
	}


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}

	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param mixed $title
	 */
	public function setTitle($title): void
	{
		$this->title = $title;
	}

	/**
	 * @return mixed
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param mixed $body
	 */
	public function setBody($body): void
	{
		$this->body = $body;
	}

	/**
	 * @return mixed
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param mixed $author
	 */
	public function setAuthor($author): void
	{
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getImage(): ?string
	{
		return $this->image;
	}

	/**
	 * @param string $image
	 */
	public function setImage(?string $image): void
	{
		//dump($this->normalizeString($image));die;
		$this->image = $image;
	}

	/**
	 * @return File
	 */
	public function getImageFile(): ?File
	{
		return $this->imageFile;
	}

	/**
	 * @param File $imageFile
	 */
	public function setImageFile(?File $imageFile): void
	{
		$this->imageFile = $imageFile;

		// VERY IMPORTANT:
		// It is required that at least one field changes if you are using Doctrine,
		// otherwise the event listeners won't be called and the file is lost
		if ($imageFile) {
			// if 'updatedAt' is not defined in your entity, use another property
			$this->updatedAt = new \DateTime('now');
		}
	}


	/**
	 * @return mixed
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param mixed $tags
	 */
	public function setTags($tags): void
	{
		$this->tags = $tags;
	}






}
