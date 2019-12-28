<?php
    function getData($api_url){
      $jsonContent = file_get_contents($api_url);
      $mydata = json_decode($jsonContent, true);
      $properties = $mydata['data'];
      if(isset($mydata['next_page_url']) && $mydata['next_page_url'] !== null){
          $properties = $mydata['data'];
          $properties = array_merge($properties,(getData($mydata['next_page_url'])));
      }
      return $properties;
    }

?>