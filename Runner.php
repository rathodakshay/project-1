<?php

require_once 'ProductParser.php';

class Run extends ProductParser{
    public function __construct($options){
  
      if (!isset($options['f'])) {
        echo "Please specify a file using -f\n";
        exit(1);
      }
      if (!isset($options['r'])) {
          echo "Please specify a file name to create -r\n";
          exit(1);
        }
      $filename = $options['f'];
      $fileToCreate = "./examples/".$options['r'];
      try {
        ProductParser::parse_csv($filename, $fileToCreate);
      } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
      }
    }
  }
  $shortopts  = "";
  $shortopts .= "f:";  // Required value
  $shortopts .= "r:"; // Optional value
  
  $longopts  = array(
      "required:",     // Required value
      "optional:",    // Optional value
      "option",        // No value
  );
  $options = getopt($shortopts, $longopts);
  
  new Run($options);