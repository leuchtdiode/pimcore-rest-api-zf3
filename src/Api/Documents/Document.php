<?php
namespace PimcoreRestApi\Api\Documents;

class Document
{
	/**
	 * @var string
	 */
	private $path;

	/**
	 * @var int|null
	 */
	private $index;

	/**
	 * @var int
	 */
	private $creationDate;

	/**
	 * @var int
	 */
	private $modificationDate;

	/**
	 * @var int
	 */
	private $userModification;

	/**
	 * @var ObjectInfo[]|null
	 */
	private $childs;

	/**
	 * @var string|null
	 */
	private $name;

	/**
	 * @var string|null
	 */
	private $title;

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string|null
	 */
	private $key;

	/**
	 * @var string|null
	 */
	private $description;

	/**
	 * @var string|null
	 */
	private $keywords;

	/**
	 * @var string|null
	 */
	private $subject;

	/**
	 * @var string|null
	 */
	private $from;

	/**
	 * @var string|null
	 */
	private $to;

	/**
	 * @var string|null
	 */
	private $cc;

	/**
	 * @var string|null
	 */
	private $bcc;

	/**
	 * @var Element[]|null
	 */
	private $elements;
	
	/**
	 * @var Property[]|null
	 */
	private $properties;
	
	public function isFolder()
	{
		return $this->type == 'folder';
	}

	public function isEmail()
	{
		return $this->type == 'email';
	}

	public function getPropertyByName($name)
	{
		if($this->properties)
		{
			foreach($this->properties as $property)
			{
				if($property->getName() == $name)
				{
					return $property;
				}
			}
		}
		
		return null;
	}
	
	public function getElementByName($name)
	{
		if($this->elements)
		{
			foreach($this->elements as $element)
			{
				if($element->getName() == $name)
				{
					return $element;
				}
			}
		}
		
		return null;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * @return int|null
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * @param int|null $index
	 */
	public function setIndex($index)
	{
		$this->index = $index;
	}

	/**
	 * @return int
	 */
	public function getCreationDate()
	{
		return $this->creationDate;
	}

	/**
	 * @param int $creationDate
	 */
	public function setCreationDate($creationDate)
	{
		$this->creationDate = $creationDate;
	}

	/**
	 * @return int
	 */
	public function getModificationDate()
	{
		return $this->modificationDate;
	}

	/**
	 * @param int $modificationDate
	 */
	public function setModificationDate($modificationDate)
	{
		$this->modificationDate = $modificationDate;
	}

	/**
	 * @return int
	 */
	public function getUserModification()
	{
		return $this->userModification;
	}

	/**
	 * @param int $userModification
	 */
	public function setUserModification($userModification)
	{
		$this->userModification = $userModification;
	}

	/**
	 * @return null|ObjectInfo[]
	 */
	public function getChilds()
	{
		return $this->childs;
	}

	/**
	 * @param null|ObjectInfo[] $childs
	 */
	public function setChilds($childs)
	{
		$this->childs = $childs;
	}

	/**
	 * @return null|string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param null|string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return null|string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param null|string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param string|null $key
	 */
	public function setKey($key)
	{
		$this->key = $key;
	}

	/**
	 * @return null|string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param null|string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return null|string
	 */
	public function getKeywords()
	{
		return $this->keywords;
	}

	/**
	 * @param null|string $keywords
	 */
	public function setKeywords($keywords)
	{
		$this->keywords = $keywords;
	}

	/**
	 * @return null|Element[]
	 */
	public function getElements()
	{
		return $this->elements;
	}

	/**
	 * @param null|Element[] $elements
	 */
	public function setElements($elements)
	{
		$this->elements = $elements;
	}
	
	/**
	 * @return null|Property[]
	 */
	public function getProperties()
	{
		return $this->properties;
	}

	/**
	 * @param null|Property[] $properties
	 */
	public function setProperties($properties)
	{
		$this->properties = $properties;
	}

	/**
	 * @return null|string
	 */
	public function getSubject()
	{
		return $this->subject;
	}

	/**
	 * @param null|string $subject
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
	}

	/**
	 * @return null|string
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * @param null|string $from
	 */
	public function setFrom($from)
	{
		$this->from = $from;
	}

	/**
	 * @return null|string
	 */
	public function getTo()
	{
		return $this->to;
	}

	/**
	 * @param null|string $to
	 */
	public function setTo($to)
	{
		$this->to = $to;
	}

	/**
	 * @return null|string
	 */
	public function getCc()
	{
		return $this->cc;
	}

	/**
	 * @param null|string $cc
	 */
	public function setCc($cc)
	{
		$this->cc = $cc;
	}

	/**
	 * @return null|string
	 */
	public function getBcc()
	{
		return $this->bcc;
	}

	/**
	 * @param null|string $bcc
	 */
	public function setBcc($bcc)
	{
		$this->bcc = $bcc;
	}
}
