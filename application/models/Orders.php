<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$files = directory_map(DATAPATH);        
        
        foreach ($files as $file)
        {
            
           $extension = '.xml';
           
            if(substr_compare($file,$extension,strlen($file)-strlen($extension),
                 strlen($extension)) === 0 && $file !== 'menu.xml')
             {
                 // prepare the order file name minus extension
                 $order_file = $file;
                 $order_file = substr($order_file,0,strlen($order_file)-4);
                 // add the order to array of orders
                 $order_files[] = $order_file;
             }
         }
 
         // build a list of orders
         $orders = array();
         foreach($order_files as $order_file)
         {
             // build the order
             $order = new stdclass();
             $order->name = $order_file;
             $order->path   = 'welcome/order/'.$order_file;
 
             // add the order to array of orders
             $orders[] = $order;
         }
         
         $this->data['orders'] = $orders;

	// Present the list to choose from
	$this->data['pagebody'] = 'homepage';
	$this->render();