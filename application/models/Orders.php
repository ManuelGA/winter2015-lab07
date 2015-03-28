<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Orders extends CI_Model
{
    
        protected $xml = null;
        // Constructor
        public function __construct() {
            parent::__construct();
        }

        function getBurgers($file)
        {
            $this->xml = simplexml_load_file(DATAPATH.$file.'.xml');
            $burgers = array();
            
            foreach ($this->xml->burger as $burger)
            {
                $burgercontent = array();

                $burgercontent['patty'] = $burger->patty['type'];
                $burgercontent['top-cheese'] = $burger->cheeses['top'];
                $burgercontent['bottom-cheese'] = $burger->cheeses['bottom'];

                $burgercontent['topping'] = array();
                
                foreach ($burger->topping as $topping)
                {
                    $burgercontent['topping'][] = $topping['type'];
                }

                $burgercontent['sauce'] = array();
                foreach ($burger->sauce as $sauce)
                {
                    $burgercontent['sauce'][] = $sauce['type'];
                }

                $burgercontent['instructions'] = $burger->instructions;
                $burgercontent['name'] = $burger->name;
                
                
               $burgers[] = $burgercontent;
            }
            
            return $burgers;

        }
        
         function getBurgerPrice($burgercontent)
        {
            $price = 0;
            
            $spatty = $this->menu->getPatty($burgercontent['patty']);
            $price += $spatty['price'];
        
            if (isset($burgercontent['top-cheese']))
            {
                $stcheese = $this->menu->getCheese($burgercontent['top-cheese']);
                $price += $stcheese['price'];
            }
            
            if (isset($burgercontent['bottom-cheese']))
            {
                $sbcheese = $this->menu->getCheese($burgercontent['bottom-cheese']);
                $price += $sbcheese['price'];
            }

            foreach ($burgercontent['topping'] as $topping)
            {
                $stopping = $this->menu->getTopping($topping);
                $price += $stopping['price'];
            }

            foreach ($burgercontent['sauce'] as $sauce)
            {
                $ssauce = $this->menu->getSauce($sauce);
                $price += $ssauce['price'];
            }
        
            return $price;
        }
        
        function getOrderData($file)
        {
            $this->xml = simplexml_load_file(DATAPATH.$file.'.xml');
            
            $orderdata = array();
            
            $orderdata['customer'] = $this->xml->customer;
            $orderdata['ordernum'] = $file;
            $orderdata['order-type'] = $this->xml['type'];
            $orderdata['special'] = $this->xml->special;
            
            return $orderdata;
        }
        
       
}