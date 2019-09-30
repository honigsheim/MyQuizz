<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 */
class Categorie
{
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
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="categorie",cascade={"remove"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $questions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quiz", mappedBy="categorie")
     */
    private $quizzes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="categorie")
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="categorie")
     */
    private $quest;

 

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->quizzes = new ArrayCollection();
        $this->quest = new ArrayCollection();
       
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

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setCategorie($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getCategorie() === $this) {
                $question->setCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Quiz[]
     */
    public function getQuizzes(): Collection
    {
        return $this->quizzes;
    }

    public function addQuiz(Quiz $quiz): self
    {
        if (!$this->quizzes->contains($quiz)) {
            $this->quizzes[] = $quiz;
            $quiz->setCategorie($this);
        }

        return $this;
    }

    public function removeQuiz(Quiz $quiz): self
    {
        if ($this->quizzes->contains($quiz)) {
            $this->quizzes->removeElement($quiz);
            // set the owning side to null (unless already changed)
            if ($quiz->getCategorie() === $this) {
                $quiz->setCategorie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestion(): Collection
    {
        return $this->question;
    }

 


    /**
     * @return Collection|Question[]
     */
    public function getQuest(): Collection
    {
        return $this->quest;
    }

    public function addQuest(Question $quest): self
    {
        if (!$this->quest->contains($quest)) {
            $this->quest[] = $quest;
            $quest->setCategorie($this);
        }

        return $this;
    }

    public function removeQuest(Question $quest): self
    {
        if ($this->quest->contains($quest)) {
            $this->quest->removeElement($quest);
            // set the owning side to null (unless already changed)
            if ($quest->getCategorie() === $this) {
                $quest->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

}
