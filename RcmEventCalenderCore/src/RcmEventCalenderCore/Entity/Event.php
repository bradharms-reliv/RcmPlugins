<?php

namespace RcmEventCalenderCore\Entity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection,
    \RcmEventCalenderCore\Exception\InvalidArgumentException
;

/**
 *
 * @ORM\Entity
 * @ORM\Table(name="rcm_event_calender_event")
 */

class Event
{
    /**
     * @var int Auto-Incremented Primary Key
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $eventId;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="Category",
     *     inversedBy="days"
     * )
     * @ORM\JoinColumn(name="categoryId", referencedColumnName="categoryId")
     **/
    protected $category;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="string")
     */
    protected $text;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $endDate;

    /**
     * @ORM\Column(type="string")
     */
    protected $mapAddress;

    function __construct(){
        $this->days = new ArrayCollection();
    }

    /**
     * PHP calls this during json_encode()
     * @return array
     */
    public function jsonSerialize()
    {
        return array(
            'eventId' => $this->eventId,
            'title'=> $this->title,
            'text' => $this->text,
            'startDate' => $this->startDate->format('Y-m-d'),
            'endDate' => $this->endDate->format('Y-m-d'),
        );
    }

    function getDaysText($dateFormat="F d"){
        if(
            $this->startDate==$this->endDate
        ) {
            return $this->startDate->format($dateFormat);
        }else{
            return $this->startDate->format($dateFormat)
                . ' - ' . $this->endDate->format($dateFormat);
        }
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setDays($days)
    {
        $this->days = $days;
    }

    public function getDays()
    {
        return $this->days;
    }

    public function setEvent($event)
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Sets the EventId property
     *
     * @param int $eventId
     *
     * @return null
     *
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * Gets the EventId property
     *
     * @return int EventId
     *
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    public function setMapAddress($mapAddress)
    {
        if(!$mapAddress){
            throw new InvalidArgumentException('Invalid mapAddress');
        }
        $this->mapAddress = $mapAddress;
    }

    public function getMapAddress()
    {
        return $this->mapAddress;
    }

    public function setText($text)
    {
        if(!$text){
            throw new InvalidArgumentException('Invalid text');
        }
        $this->text = $text;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setTitle($title)
    {
        if(!$title){
            throw new InvalidArgumentException('Invalid title');
        }
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;
    }

    public function setStartDateFromString($date){
        $dateTime = \DateTime::CreateFromFormat('Y-m-d', $date);
        if(!$dateTime){
            throw new InvalidArgumentException('Invalid startDate');
        }
        $this->setStartDate($dateTime);
    }

    public function setEndDateFromString($date){
        $dateTime = \DateTime::CreateFromFormat('Y-m-d', $date);
        if(!$dateTime){
            throw new InvalidArgumentException('Invalid endDate');
        }
        $this->setEndDate($dateTime);
    }

    public function getFirstDay()
    {
        return $this->startDate;
    }

    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;
    }

    public function getLastDay()
    {
        return $this->endDate;
    }
}
