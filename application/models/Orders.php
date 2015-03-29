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

        //get burgers form the order
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
        
        //get price for a burger
        function getBurgerPrice($burgercontent)
        {
            $price = 0;
            
            if (isset($burgercontent['patty']))
            {
                $price += $this->menu->getPatty($burgercontent['patty'])->price;
            }
        
            if (isset($burgercontent['top-cheese']))
            {
                $price += $this->menu->getCheese($burgercontent['top-cheese'])->price;
            }
            
            if (isset($burgercontent['bottom-cheese']))
            {
                $price += $this->menu->getCheese($burgercontent['bottom-cheese'])->price;
            }
            
            if (isset($burgercontent['topping']))
            {
                foreach ($burgercontent['topping'] as $topping)
                {
                    $price += $this->menu->getTopping($topping)->price;
                }
            }
            
            if (isset($burgercontent['sauce']))
            {
                foreach ($burgercontent['sauce'] as $sauce)
                {
                    $price += $this->menu->getSauce($sauce)->price;
                }
            }
        
            return $price;
        }
        
        //get extra order info
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