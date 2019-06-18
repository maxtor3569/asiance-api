<?php
namespace App\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Table(name="`user`")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, \Serializable {

	use TimestampableEntity;

	const ROLE_GUEST = 'ROLE_GUEST';
	const ROLE_USER  = 'ROLE_USER';
	const ROLE_ADMIN = 'ROLE_ADMIN';

	/**
	 * @ORM\Column(type="integer", length=25, options={"unsigned"=true})
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 *
	 * @var int
	 */
	private $id;


	/**
	 * @ORM\Column(type="string", nullable=true)
	 * @Assert\NotBlank()
	 * @Assert\Email(
	 * 	checkMX = false,
	 * )
	 * @var string
	 */
	private $email;

	/**
	 * @ORM\Column(type="string", length=64, nullable=true)
	 *
	 * @var string
	 */
	private $password;

	/**
	 * @ORM\Column(type="string")
	 *
	 * @var string
	 */
	private $salt;


	/**
	 * @ORM\Column(type="array")
	 * @var string[]
	 */
	private $role = [];
	/**
	 * @ORM\Column(type="array")
	 * @var string[]
	 */
	private $roles = [];

	public function __construct() {
		$this->setRoles([ self::ROLE_GUEST ]);
	}

	public function getUsername(): string {
		return $this->email;
	}

	/**
	 * @return int
	 */
	public function getId(): ?int
	{
		return $this->id;
	}


	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string[]
	 */
	public function getRoles(): array {
		return $this->roles;
	}

	public function getSalt(): ?string  {
		return $this->salt;
	}

	public function getPassword(): ?string {
		return $this->password;
	}



	/**
	 * @param string[] $roles
	 * @return User
	 */
	public function setRoles(array $roles): self {
		$this->roles = $roles;
		return $this;
	}



	//////////
	// User //
	//////////

	public function eraseCredentials() : void {
	}




	///////////
	// Roles //
	///////////

	public function addRole(string $role): self {
		$roles = $this->getRoles();
		if (!in_array($role, $roles)) {
			$roles[] = $role;
			$this->setRoles($roles);
		}
		return $this;
	}

	public function removeRole(string $role): self {
		$roles = $this->getRoles();
		if (($key = array_search($role, $roles)) !== false) {
			unset($roles[$key]);
			$this->setRoles($roles);
		}
		return $this;
	}

	public function hasRole(?string $role): bool {
		return in_array($role, $this->getRoles());
	}


	///////////////
	// Serialize //
	///////////////

	/** @see \Serializable::serialize() */
	public function serialize(): string {
		return serialize([
			$this->id,
			$this->email,
			$this->roles
		]);
	}

	/** @see \Serializable::unserialize() */
	public function unserialize($serialized): void {
		list (
			$this->id,
			$this->email,
			$this->roles
			) = unserialize($serialized);
	}


}
