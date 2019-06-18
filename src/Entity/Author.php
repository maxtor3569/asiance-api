<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Post;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 * @Vich\Uploadable
 */
class Author
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
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $role = [];

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $avatar;

	/**
	 * @Vich\UploadableField(mapping="author_avatars", fileNameProperty="avatar")
	 * @var File
	 */
	private $avatarFile;


	/**
	 * @ORM\Column(type="string", length=500, nullable=true)
	 */
	private $location;

	/**
	 * Des User ont des activités
	 * @ORM\OneToMany(targetEntity=Post::class, mappedBy="author")
	 *
	 */
	private $posts;

	/**
	 * Author constructor.
	 */
	public function __construct()
	{
		$this->posts = new ArrayCollection();
		$this->createdAt = new \DateTime('now');
		$this->updatedAt = new \DateTime('now');
	}




	public function __toString()
	{
		return $this->name;
	}

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getRole(): ?array
    {
        return $this->role;
    }

    public function setRole(array $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * @param mixed $location
	 */
	public function setLocation($location): void
	{
		$this->location = $location;
	}

	/**
	 * @return mixed
	 */
	public function getPosts()
	{
		return $this->posts;
	}

	/**
	 * @param mixed $posts
	 */
	public function setPosts($posts): void
	{
		$this->posts = $posts;
	}

	/**
	 * @return File
	 */
	public function getAvatarFile(): ?File
	{
		return $this->avatarFile;
	}

	/**
	 * @param File $avatarFile
	 */
	public function setAvatarFile(?File $avatarFile): void
	{
		$this->avatarFile = $avatarFile;

		// VERY IMPORTANT:
		// It is required that at least one field changes if you are using Doctrine,
		// otherwise the event listeners won't be called and the file is lost
		if ($avatarFile) {
			// if 'updatedAt' is not defined in your entity, use another property
			$this->updatedAt = new \DateTime('now');
		}
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id): void
	{
		$this->id = $id;
	}


	public function addPost(Post $post)
	{
		if ($this->posts->contains($post)) {
			return;
		}
		$this->posts->add($post);
		$post->setAuthor($this);
	}



}
