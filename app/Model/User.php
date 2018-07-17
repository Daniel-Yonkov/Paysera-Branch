<?php
namespace Paysera\Branch\Model;

class User implements Model {
    
    protected $data;
    
    public function hasTypeDate($type, $date) : bool
    {
            return isset($this->data[$type][$date]);
    }
    
    public function setTypeDate($type, $date) 
    {
            $this->data[$type][$date]['number_of_transactions'] = 0;
            $this->data[$type][$date]['amount_in_euro'] = 0;
            $this->data[$type][$date]['total'] = 0;
            return $this;
    }
    
    public function newTypeTransaction($type, $date, $amount_in_euro)
    {
            !$this->hasTypeDate($type, $date) ? $this->setTypeDate($type, $date) : "";
            $this->data[$type][$date]['number_of_transactions']++;
            $this->data[$type][$date]['amount_in_euro'] = $amount_in_euro;
            return $this;
    }
        
    /**
     * amount of transactions for the specific user & date combination
     * @param int|string $user_id 
     * @param string $date 
     * @return int
     */
    public function getTypedNumberOfTransactions($type, $date)
    {
            return $this->data[$type][$date]['number_of_transactions'];
    }

    /**
     * amount for the current transaction in EUR for the specific user & date combination
     * @param int|string $user_id 
     * @param string $date 
     * @return int
     */
    public function getTypeAmountInEuro($type, $date) 
    {
            !$this->hasTypeDate($type, $date) ? $this->setTypeDate($type,$date) : "";
            return $this->data[$type][$date]['amount_in_euro'];
    }

    public function getTypeTotal($type, $date)
    {
            return $this->data[$type][$date]['total'];
    }

    public function addTypeTotal($type, $date, $amount)
    {
        if(!isset($this->data[$type][$date]['total'])){
                $this->data[$type][$date]['total'] = 0;
        }
        $this->data[$type][$date]['total'] += $amount;
        return $this;
    }
    
}