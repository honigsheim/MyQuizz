<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="question")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quiz", inversedBy="question")
     */
    private $quiz;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $question;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reponses", mappedBy="question",cascade={"remove"})
     *  @ORM\JoinColumn(name="question_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $reponses;

 

  
    public function __construct()
    {
        $this->reponse = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): self
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getQuestions(): ?self
    {
        return $this->questions;
    }

    public function setQuestions(?self $questions): self
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getReponse(): Collection
    {
        return $this->reponse;
    }

    public function addReponse(self $reponse): self
    {
        if (!$this->reponse->contains($reponse)) {
            $this->reponse[] = $reponse;
            $reponse->setQuestions($this);
        }

        return $this;
    }

    public function removeReponse(self $reponse): self
    {
        if ($this->reponse->contains($reponse)) {
            $this->reponse->removeElement($reponse);
            // set the owning side to null (unless already changed)
            if ($reponse->getQuestions() === $this) {
                $reponse->setQuestions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reponses[]
     */
    public function getReponses(): Collection
    {
        return $this->reponses;
    }

     public function __toString()
    {
        return $this->question;
    }

       /**
     * remove reponses
     * @param \Entity\Reponse $reponse
     */

    public function removeReponses(Reponses $reponse)
    {
        $this->reponses->removeElement($reponse);

    }

    /**
     * remove categorie
     * @param \Entity\Categorie $categorie
     */

    public function removeCategorie(Categorie $categorie)
    {
        $this->categorie->removeElement($categorie);

    }

    /**
     * remove quiz
     * @param \Entity\Quiz $Quiz
     */

    public function removeQuiz(Quiz $quiz)
    {
        $this->quiz->removeElement($quiz);

    }
}
